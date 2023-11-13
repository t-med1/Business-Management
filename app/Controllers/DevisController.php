<?php

namespace App\Controllers;
use Spipu\Html2Pdf\Html2Pdf;
use Mpdf\Mpdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Controllers\BaseController;
use App\Models\Commande;
use App\Models\DevisModel;
use App\Models\ServiceModel;
use App\Models\LigneCommandeModel;
use App\Models\Client;
use App\Models\Facture;

use App\Models\Relancement;
use App\Models\Paiment;

class DevisController extends BaseController
{
    
    public function liste()
    {
        if(session()->has('role')){
            $modelService = new ServiceModel;
            $modelClient = new Client;
            $columns = array('client.*', 'devis.*');
            $devis = $modelClient
                ->join('devis', 'devis.id_client = client.id_client')
                ->select($columns)
                ->orderBy('devis.id_devis', 'DESC')
                ->get()->getResultArray();
            $liste_devis = [];
            foreach ($devis as $dv) {
                $id = $dv['id_devis'];
                $columns = array('service.*', 'lignecommande.*');
                $infos = $modelService->join('lignecommande', 'service.id_service = lignecommande.id_service')
                    ->select($columns)
                    ->where('lignecommande.id_devis', $id)->get()->getResultArray();
                $liste_devis[] = [
                    'id_devis' => $dv['id_devis'],
                    'id_client' => $dv['id_client'],
                    'code_devis' => $dv['code_devis'],
                    'date_saisie' => $dv['date_saisie'],
                    'societe' => $dv['societe'],
                    'email_client' => $dv['email_client'],
                    'numero_telephone' => $dv['numero_telephone'],
                    'ville' => $dv['ville'],
                    'total_ht' => $dv['total_ht'],
                    'total_ttc' => $dv['total_ttc'],
                    'adresse' => $dv['adresse'],
                    'ICE' => $dv['ICE'],
                    'modalite_paiement' => $dv['modalite_paiement'],
                    'infos' => $infos,
                ];
            }
            // sending data to the View home
            return view('pages/devis/liste', ['liste_devis' => $liste_devis]);
        }else{
            session()->setFlashdata('error' , "Tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }
   
    }
    public function ajouterdevis()
    {
        if(session()->has('role')){
            $clientmodel = new Client;
            $servicemodel = new ServiceModel;
            $devismodel = new DevisModel();
            $clients = $clientmodel->findAll();
            $services = $servicemodel->findAll();
            $devisCode = $this->generateDevisCode($devismodel);
    
            // print_r($services);die();
            return view('pages/devis/ajouter', ["clients" => $clients, "services" => $services,"devisCode" => $devisCode]);
        }else{
            session()->setFlashdata('error' , "Tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }
    }
    public function store()
    {
        $devismodel = new DevisModel();
        $LigneCommandeModel = new LigneCommandeModel();
        $data = [
            'id_client' => $this->request->getPost("id_client"),
            'code_devis' => $this->generateDevisCode($devismodel),
            'date_saisie' => $this->request->getPost('date_saisie'),
            //'tva' => $this->request->getPost('tva'),
            'total_ht' => $this->request->getPost('total_ht'),
            'total_ttc' => $this->request->getPost('total_ttc'),
            'modalite_paiement' => $this->request->getPost('modalite_paiement'),
            'etat' => $this->request->getPost('etat'),
            
        ];
        // print_r($data);die();
        try {
            if($data){
                $devismodel->insert($data);
            }else{
                session()->setFlashdata('error', "la la la la ");
            }
            $insertedDevisID = $devismodel->insertID();
                
                $service = $this->request->getVar('id_service');
                for ($i = 0; $i < count($service); $i++) {
                    $ligne = [
                        'id_service' => $service[$i],
                        'id_devis' => $insertedDevisID,
                    ];
                    $LigneCommandeModel->insert($ligne);
                }
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été ajouter une vente');
            session()->setFlashdata('success', "La Vente a été ajoutée avec succès !");
            return redirect()->to('devis');
        
        } catch (\Exception $e) {
            log_message('error', 'Error in store function: ' . $e->getMessage());
            session()->setFlashdata('error', "La Vente n'a pas été ajoutée !");
            return redirect()->to('devis/ajouter');
        }
    }
    
    // Fonction pour vérifier si l'id_devis existe dans la table devis
    private function devisExists($id_devis) {
        $devismodel = new DevisModel;
        return $devismodel->where('id_devis', $id_devis)->countAllResults() > 0;
    }
    
    public function showdevis($id)
    {
        $clienModel = new Client();
        $devismodel = new DevisModel();
        $ligneCommande = new LigneCommandeModel();
        $serviceModel = new ServiceModel();
        $commandeModel = new Commande();
    

        $client = $clienModel->join('devis', 'devis.id_client = client.id_client')->select('client.* , employee.nom , employee.prenom')->where('devis.id_devis', $id)->groupBy('devis.id_devis')->join('employee' , 'employee.id_emp = client.id_emp')->get()->getResultArray();
        $services = $serviceModel->join('lignecommande', 'lignecommande.id_service = service.id_service')->select('service.*')->where('lignecommande.id_devis', $id)->findAll(); // Récupérer un tableau de services
        $devis = $devismodel->find($id);
    
        $data = [
            'devis' => $devis,
            'client' => $client,
            'services' => $services, // Passer le tableau de services à la vue
        ];
        return view('pages/devis/detail', $data);
    }
    


    public function delete($id_devis)
    {
        $lignecommandeModel = new LigneCommandeModel();
        $devisModel = new DevisModel();
        $factureModel = new Facture();
        $relancementModel = new Relancement();
        $paimentModel = new Paiment();
        
        // Récupérer l'ID client associé au devis
        $devis = $devisModel->find($id_devis);
        if ($devis && array_key_exists('id_client', $devis)) {
            $id_client = $devis['id_client'];
        
            // Supprimer toutes les lignes de commande associées au devis
            $lignecommandeModel->where('id_devis', $id_devis)->delete();
            
            // Supprimer toutes les factures associées au devis
            $factures = $factureModel->where('id_client', $id_client)->findAll();
            foreach ($factures as $facture) {
                $paiments = $paimentModel->where('id_facture', $facture['id_facture'])->findAll();
                foreach ($paiments as $paiment) {
                    $paimentModel->delete($paiment['id_paiment']);
                }
                $factureModel->delete($facture['id_facture']);
            }
            $devisModel->where('id_devis', $id_devis)->delete();
        }
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été supprimer un devis');
        $session = session();
        $session->setFlashdata('success', 'Devis supprimé avec succè.');
        return redirect()->to('/devis');
    }

    public function edit($id)
    {
        if (session()->has('role')) {
           
            $serviceModel = new ServiceModel();
            $devismodel = new DevisModel();
            $LigneCommandeModel = new LigneCommandeModel();
            $clientModel = new Client();
            
            $clients = $clientModel->findAll();
            $devis = $devismodel
            ->join('client', 'client.id_client = devis.id_client')
            ->join('employee', 'employee.id_emp = client.id_emp')
            ->where('devis.id_devis', $id)
            ->select('devis.*  , employee.* , client.*')
            ->first();

            // Récupérez les détails du client en fonction de l'ID du client
            $selectedClient = $clientModel->find($devis['id_client']);
            // Get the details of services associated with this command
            $detailsCommande = $LigneCommandeModel->where('id_devis', $id)->findAll();
            $services = [];

            foreach ($detailsCommande as $detail) {
                $service = $serviceModel->find($detail['id_service']);
                if ($service) {
                    $services[] = $service;
                }
            }
            // print_r($services);die();
            return view('pages/devis/modifier', [
                'devis' => $devis,
                'services' => $services,
                'Allservices' => $serviceModel->findAll(),
                'clients' => $clients,
                'selectedClient' => $selectedClient,
            ]);
        } else {
            $session = session();
            $session->setFlashdata('error', "Tu n'es pas connecté(e) !");
            return redirect()->to('/login');
        }
    }

    

    public function update($id)
    {
        if (session()->has('role')) {
            $devismodel = new DevisModel();
            $LigneCommandeModel = new LigneCommandeModel();
            $data = [
                'date_saisie' => $this->request->getPost('date_saisie'),
                //'tva' => $this->request->getPost('tva'),
                'total_ht' => $this->request->getPost('total_ht'),
                'total_ttc' => $this->request->getPost('total_ttc'),
                'modalite_paiement' => $this->request->getPost('modalite_paiement'),
                'etat' => $this->request->getPost('etat'),
                
            ];
            $devismodel->update($id, $data);
            $services = $this->request->getVar('id_service');
            $LigneCommandeModel->where('id_devis', $id)->delete();
            if (!empty($services)) {
                foreach ($services as $serviceId) {
                   $LigneCommandeModel->insert([
                        'id_devis' => $id,
                        'id_service' => $serviceId,
                    ]);
                }
            }
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été modifier une vente');
            // Redirigez avec un message de succès
            session()->setFlashdata('success', 'Vente mise à jour avec succès.');
            return redirect()->to('/devis');
        } else {
            $session = session();
            $session->setFlashdata('error', "Tu n'es pas connecté(e) !");
            return redirect()->to('/login');
        }
    }
    public function getServiceInfo($service_id)
    {
        $service = new ServiceModel();
        $service_info = $service->find($service_id);

        // Envoi des informations du service au formulaire sous forme de JSON
        $response = [
            'description' => $service_info['description'],
            'prix_unitaire' => $service_info['prix_unitaire']
        ];
        return $this->response->setJSON($response)->setContentType('application/json');
    }

    // public function generatedIdDevis($date_saisie)
    // {
    //     $model = new DevisModel();
    //     $id_devis = $model->generate_id_devis($date_saisie);
    //     return $this->response->setJSON(['id_devis' => $id_devis])->setContentType('application/json');
    // }

    private function generateDevisCode($devismodel)
    {
        $year = date('y');
        $newDevisCount = $devismodel->countAllResults() + 1;
        return "D-{$year}-" . str_pad($newDevisCount, 4, '0', STR_PAD_LEFT);
    }

   
}