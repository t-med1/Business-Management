<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Client;
use App\Models\Commande;
use App\Models\DetailsCommandeModel;
use App\Models\Employee;
use App\Models\ServiceModel;
use App\Models\Vente;

class CommandeController extends BaseController
{
    private function generateCommandeCode($modelVente)
    {
        $year = date('y');
        $newVenteCount = $modelVente->countAllResults() + 1;
        return "C-{$year}-" . str_pad($newVenteCount, 4, '0', STR_PAD_LEFT);
    }
    public function index()
    {
        $commandeModel = new Commande();
        $venteModel = new Vente();
    
        if (session()->has('role')) {
            $commands = $commandeModel
                    ->select('commande.code_commande, commande.id_commande , commande.date_debut AS dateCommande , commande.annuler, service.*, employee.*, client.*, GROUP_CONCAT(service.titre) AS service_titles')
                    ->join('client', 'client.id_client = commande.id_client')
                    ->join('employee', 'employee.id_emp = client.id_emp')
                    ->join('details_commande', 'details_commande.id_commande = commande.id_commande')
                    ->join('service', 'service.id_service = details_commande.id_service')
                    ->groupBy('commande.id_commande')
                    ->get()
                    ->getResultArray();
            // print_r($commands);die();
            $ventes = $venteModel->join('client', 'client.id_client = vente.id_client')
                ->join('employee', 'employee.id_emp = client.id_emp')
                ->join('commande' , 'commande.id_commande = vente.id_commande')
                ->join('details_commande', 'details_commande.id_commande = commande.id_commande')
                ->join('service', 'service.id_service = details_commande.id_service')
                ->select('vente.* , commande.*')
                ->get()
                ->getResultArray();
    
            // Group sales by command ID
            $salesByCommandId = [];
            foreach ($ventes as $vente) {
                $salesByCommandId[$vente['id_commande']] = $vente;
            }
    
            // Separate canceled and non-canceled commands
            $commandes_annulees = [];
            $commandes_non_annulees = [];
    
            foreach ($commands as $commande) {
                if ($commande['annuler'] == 1) {
                    $commandes_annulees[] = $commande;
                } else {
                    $commandes_non_annulees[] = $commande;
                }
            }
    
            $debut = date("Y-m") . "-01";
            $fin = date("Y-m-t");
    //print_r($commandes_non_annulees);die();
            return view('pages/commandes/liste', [
                'commandes_annulees' => $commandes_annulees,
                'commandes_non_annulees' => $commandes_non_annulees,
                'debut' => $debut,
                'fin' => $fin,
                'salesByCommandId' => $salesByCommandId
            ]);
        } else {
            $session = session();
            $session->setFlashdata('error', "Tu n'es pas connecté(e) !");
            return redirect()->to('/login');
        }
    }
    

    
    public function create(){
        if(session()->has('role')){
            $clients = new Client();
            $commercials = new Employee();
            $services = new ServiceModel();
            $commandeModel = new Commande();
            $data = [
                'commande_code' => $this->generateCommandeCode($commandeModel),
                'clients' => $clients->findAll(),
                'commercials' => $commercials->findAll(),
                'services' => $services->findAll(),
            ];
            return view('pages/commandes/ajouter' , $data);
        }else{
            session()->setFlashdata('error' , "Tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }

    }
    public function generatedServis($id_service){
        $serviceModel = new ServiceModel();
        $response = $serviceModel->find($id_service);
        return $this->response->setJSON($response)->setContentType('application/json');
    }
    public function store()
    {
        $commandeModel = new Commande();
        $detailsCommandeModel = new DetailsCommandeModel();
    
        // Data for the "commande" table
        $data = [
            'code_commande' => $this->generateCommandeCode($commandeModel),
            'id_client' => $this->request->getPost('id_client'),
            'prix_total' => $this->request->getPost('prix_total'),
            'date_debut' => $this->request->getPost('date_debut'),
            'remarque' => $this->request->getPost('remarque'),
            'responsable' => $this->request->getPost('responsable'),
        ];
        try {
            if($data){
                $commandeModel->insert($data);
            }
            $insertedCommandeID = $commandeModel->insertID();
            
            $quantite = $this->request->getVar('id_service');
            for ($i = 0; $i < count($quantite); $i++) {
                $ligne = [
                    'id_service' => $quantite[$i],
                    'id_commande' => $insertedCommandeID,
                ];
                $detailsCommandeModel->insert($ligne);
            }
    
            $session = session();
            $session->setFlashdata('success', "La Commande a été ajoutée avec succès !");
            return redirect()->to('/commande');
        } catch (\Exception $e) {
            log_message('error', 'Error in store function: ' . $e->getMessage());
    
            $session = session();
            $session->setFlashdata('error', "La Commande n'a pas été ajoutée !");
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        if (session()->has('role')) {
            $serviceModel = new ServiceModel();
            $commandeModel = new Commande();
            $detailsCommandeModel = new DetailsCommandeModel();
            $clientModel = new Client();
    
            $clients = $clientModel->findAll();
            $commande = $commandeModel
                ->join('client', 'client.id_client = commande.id_client')
                ->join('employee', 'employee.id_emp = client.id_emp')
                ->where('commande.id_commande', $id) // Ajout de cette condition pour filtrer par ID de commande
                ->select('commande.*, employee.*, client.*')
                ->first();
    
            if (!$commande) {
                // Gérer le cas où la commande n'existe pas
                return redirect()->to('/page_d_erreur');
            }
    
            // Récupérez les détails du client en fonction de l'ID du client
            $selectedClient = $clientModel->find($commande['id_client']);
            // Get the details of services associated with this command
            $detailsCommande = $detailsCommandeModel->where('id_commande', $id)->findAll();
            $services = [];
    
            foreach ($detailsCommande as $detail) {
                $service = $serviceModel->find($detail['id_service']);
                if ($service) {
                    $services[] = $service;
                }
            }
    
            return view('pages/commandes/modifier', [
                'commande' => $commande,
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
            $commandeModel = new Commande();
            $detailsCommandeModel = new DetailsCommandeModel();
            $data = [
                'date_debut' => $this->request->getPost('date_debut'),
                'prix_total' => $this->request->getPost('prix_total'),
                'remarque' => $this->request->getPost('remarque'),
                
            ];
            $commandeModel->update($id, $data);

            $services = $this->request->getVar('id_service');

            $detailsCommandeModel->where('id_commande', $id)->delete();
            if (!empty($services)) {
                foreach ($services as $serviceId) {



                    $detailsCommandeModel->insert([
                        'id_commande' => $id,
                        'id_service' => $serviceId,
                    ]);
                }
            }
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été modifier une vente');
            // Redirigez avec un message de succès
            session()->setFlashdata('success', 'Vente mise à jour avec succès.');
            return redirect()->to('/commande');
        } else {
            $session = session();
            $session->setFlashdata('error', "Tu n'es pas connecté(e) !");
            return redirect()->to('/login');
        }
    }
    public function show($id)
{
    $commandeModel = new Commande();
    $clientModel = new Client();
    $serviceModel = new ServiceModel();
    $employeeModel = new Employee();
    $venteModel = new Vente();
    $detailsCommandeModel = new DetailsCommandeModel();
    
    // Find the command by ID
    $commande = $commandeModel->find($id);

    // Check if the command exists
    if (!$commande) {
        return redirect()->to('/commande')->with('error', 'La commande n\'existe pas.');
    }

    // Find the related client and employee
    $client = $clientModel->find($commande['id_client']);
    $employee = $employeeModel->find($client['id_emp']);

    // Get the details of services associated with this command
    $detailsCommande = $detailsCommandeModel->where('id_commande', $id)->findAll();
    $services = [];

    foreach ($detailsCommande as $detail) {
        $service = $serviceModel->find($detail['id_service']);
        if ($service) {
            $services[] = $service;
        }
    }

    // Find the related vente for this command
    $vente = $venteModel->where('id_commande', $id)->first();

    return view('pages/commandes/details', [
        'commande' => $commande,
        'client' => $client,
        'employee' => $employee,
        'services' => $services,
        'vente' => $vente, // Include the vente data
    ]);
}


    
    public function annuler($id)
    {
        $commandeModel = new Commande();
        $venteModel = new Vente();
        $commande = $commandeModel->find($id);

        if (!$commande) {
            return redirect()->to('/commande')->with('error', 'La commande n\'existe pas.');
        }
        $ventes = $venteModel->join('client', 'client.id_client = vente.id_client')
                ->join('employee', 'employee.id_emp = client.id_emp')
                ->join('commande', 'commande.id_commande = vente.id_commande')
                ->join('details_commande', 'details_commande.id_commande = commande.id_commande')
                ->join('service', 'service.id_service = details_commande.id_service')
                ->select('vente.* , commande.*')
                ->get()
                ->getResultArray();
    
            // Group sales by command ID
            $salesByCommandId = [];
            foreach ($ventes as $vente) {
                $salesByCommandId[$vente['id_commande']] = $vente;
            }
        if (isset($salesByCommandId[$id])){
            session()->setFlashdata('error' , "Tu ne pas Le droit d'annuler Les commandes qui ont une vente");
            return redirect()->back();
        }
        $commandeModel->update($id, ['annuler' => 1]);

        return redirect()->to('/commande')->with('success', 'La commande a été annulée avec succès.');
    }
     

    public function updateAnnuler($id_commande)
    {
        $commandeModel = new Commande();
        $data = ['annuler' => 0];
        
        $commandeModel->update($id_commande, $data);

        return redirect()->to(previous_url());
    }


    


}