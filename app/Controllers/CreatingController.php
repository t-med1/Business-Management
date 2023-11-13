<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailsVenteModel;
use App\Models\ServiceModel;
use App\Models\Paiment;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Vente;


class CreatingController extends BaseController
{
    public function createData()
    {
        $factureModel = new Facture();
        $paimentModel = new Paiment();
        $id_vente = $this->request->getPost('id_vente');
            $factureData = [
                'code_facture' => $this->request->getPost('code_facture'),
                'id_client' => $this->request->getPost('id_client'),
                'id_vente' => $id_vente,
                'date_saisie' => $this->request->getPost('date_saisie'),
                'date_emission' => $this->request->getPost('date_emission'),
            ];
            $factureModel->insert($factureData);
            $insertefactureID = $factureModel->insertID();
            $paimentData = [
                'id_facture' => $insertefactureID,
                'id_vente' => $id_vente,
                'date_dernier_paiment' => $this->request->getPost('date_dernier_paiment'),
                'status_litige' => $this->request->getPost('status_litige'),
                'montant_pay' => $this->request->getPost('montant_paye'),
            ];
            $paimentModel->insert($paimentData);
    
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été ajouter une Facture');
            // Stocke un message de succès dans la session
            $session = session();
            $session->setFlashdata('success', 'Données ajoutées avec succès.');
    
            // Redirige vers la page de liste des factures
            return redirect()->to('/vente/details/'.$id_vente);
    }

    public function delete_row($id_facture) {
        // Créer des objets de modèle
        $factureModel = new Facture();
        $paiementModel = new Paiment();
    
        // Supprimer les paiements associés à la facture
        $paiements = $paiementModel->where('id_facture', $id_facture)->findAll();
        foreach ($paiements as $paiement) {
            $paiementModel->delete($paiement['id_paiment']);
        }
        $factureModel->delete($id_facture);
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été supprimer une Facture');
        // Stocker le message dans la session
        $session = session();
        $session->setFlashdata('success', 'Facture supprimée avec succès.');
        return redirect()->to('/facture');
    }
    

    private function generateFactureCode($modelFacture)
    {
        $year = date('y');
        $newFactureCount = $modelFacture->countAllResults() + 1;
        return "F-{$year}-" . str_pad($newFactureCount, 4, '0', STR_PAD_LEFT);
    }

    public function create($id)
    {
        if(session()->has('role')){
            if($id == 0){
                $db = db_connect();
                $query = $db->query('SELECT client.*,devis.* FROM client inner join devis on client.id_client = devis.id_client where devis.total_ttc!=0');
                $dataDevis = $query->getResultArray();
                return view('pages/factures/ajouter', ['dataDevis'=>$dataDevis]);
            }else{
                $db = db_connect();
                $factureModel = new Facture();
                $clientModel = new Client();
                $detailsVenteModel = new DetailsVenteModel();
                $serviceModel = new ServiceModel();
                $venteModel = new Vente();
                $montant_paye = $venteModel->select('paiment.montant_pay')
                ->join('paiment' , 'paiment.id_vente = vente.id_vente')
                ->groupBy('paiment.id_vente' , "DESC")
                ->first();
                $query = $db->query('SELECT client.*,devis.* FROM client inner join devis on client.id_client = devis.id_client where devis.total_ttc!=0');
                $dataDevis = $query->getResultArray();
                $codeFacture = $this->generateFactureCode($factureModel);

                $vente = $venteModel->find($id);
                // print_r($vente);die();
                $client = $clientModel->find($vente['id_client']);
                $detailsCommande = $detailsVenteModel->where('id_vente', $id)->findAll();
                $services = [];
                $Allservices = $serviceModel->findAll();
                foreach ($detailsCommande as $detail) {
                    $service = $serviceModel->find($detail['id_service']);
                    if ($service) {
                        $services[] = $service;
                    }
                }
                return view('pages/factures/createFacture', [
                    'dataDevis'=>$dataDevis,
                    'codeFacture' => $codeFacture,
                    'clients' => $clientModel->findAll(),
                    'services' => $services,
                    'client' => $client,
                    'vente' => $vente,
                    'montant_paye' => $montant_paye,
                    'Allservices' => $Allservices
                ]);
                
            }
        }else{
            session()->setFlashdata('error' , "Tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }
        
    }
    public function generatedId($date_saisie) {
        $model = new Facture();
        $id_facture = $model->generate_id_facture($date_saisie);
        return $this->response->setJSON(['id_facture' => $id_facture])->setContentType('application/json');
    }
    public function generatedDevis($devis_id)
    {
        // Récupération des informations du devis dans la base de données
        $clientModel = new Client();
        $devis_info = $clientModel
        ->join('devis','devis.id_client = client.id_client')
        ->select('client.*,devis.*')
        ->where('devis.id_devis',$devis_id)
        ->get()->getResultArray();
        // Envoi des informations du devis au formulaire sous forme de JSON
        $response = [];
        foreach ($devis_info as $row) {
            $response[] = [
                "id_client" => $row['id_client'],
                "societe" => $row['societe'],
                "ICE" => $row['ICE'],
                'adresse' => $row['adresse'],
                "email_client" => $row['email_client'],
                "numero_telephone" => $row['numero_telephone'],
                "ville" => $row['ville'],
                "total_ht" => $row['total_ht'],
                "total_ttc" => $row['total_ttc'],
                
            ];
        }
    
        return $this->response->setJSON($response)->setContentType('application/json');
    }
    
}