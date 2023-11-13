<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AvanceModel;
use App\Models\Client;
use App\Models\Commande;
use App\Models\DetailsAvanceModel;
use App\Models\DetailsCommandeModel;
use App\Models\DevisModel;
use App\Models\Employee;
use App\Models\Facture;
use App\Models\LigneCommandeModel;
use App\Models\Paiment;
use App\Models\Relancement;
use App\Models\Vente;

class AddClientController extends BaseController
{
    public function liste(){
        $modelClient = new Client;
        $modelEmployee = new Employee;
        $db = db_connect();
        if(session()->has('role')){
                $result = $db->table('client')
                ->join('employee' , 'employee.id_emp = client.id_emp')
                ->select('client.* , employee.*')
                ->get()
                ->getResultArray();
                $resultRelance = $db->table('client')
                ->join('facture', 'facture.id_client = client.id_client')
                ->join('employee' , 'employee.id_emp = client.id_emp')
                ->select('client.* , employee.*, facture.id_facture, facture.relance_faite')
                ->get()
                ->getResultArray();
                $liste_client = $modelClient->findAll();

                return view('pages/clients/liste',  ['resultRelance'=>$resultRelance , 'liste_client' => $liste_client, 'modelEmployee' => $modelEmployee , 'result' => $result]);
        }else{
            $session = session();
            $session->setFlashdata('error', "Tu n'est Pas Connécté(e)");
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        $modelEmp = new Employee();
        $modelClient = new Client();
        $clientCode = $this->generateClientCode($modelClient);
        return view('pages/clients/ajouter' , ['employeeData' => $modelEmp->findAll() , 'ClientCode' => $clientCode]);
    }
    private function generateClientCode($modelClient)
    {
        $year = date('y');
        $newEmployeeCount = $modelClient->countAllResults() + 1;
        return "C-{$year}-" . str_pad($newEmployeeCount, 4, '0', STR_PAD_LEFT);
    }

    public function store()
    {
        $modelClient = new Client;
        $modelEmployee = new Employee;
        $code_emp = $this->request->getVar('id_emp');

        $employeeInfo = $modelEmployee->where('id_emp', $code_emp)->first();
        if (!$employeeInfo) {
            $session = session();
            $session->setFlashdata('error', "L'employé avec le code $code_emp n'existe pas.");
            return redirect()->back();
        }

        $data = [
            'code_client' => $this->generateClientCode($modelClient),
            'ICE' => $this->request->getVar('ICE'),
            'contact' => $this->request->getVar('contact'),
            'email_client' => $this->request->getVar('email_client'),
            'numero_telephone' => $this->request->getVar('numero_telephone'),
            'adresse' => $this->request->getVar('adresse'),
            'ville' => $this->request->getVar('ville'),
            'societe' => $this->request->getVar('societe'),
            'source' => $this->request->getVar('source'),
            'remarque' => $this->request->getVar('remarque'),
            'id_emp' => $employeeInfo['id_emp'],
        ];

        $modelClient->insert($data);
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été ajouter un client');
        $session = session();
        $session->setFlashdata('success', 'Client ajouté avec succès.');
        return redirect()->to('client');
   }
    public function edit($id)
    {
        if(session()->has('role')){
            $modelClient = new Client;
            $employemodel = new Employee;
            $client = $modelClient->find($id);
            $employes = $employemodel->findAll($id);
            $data = [
                'client' => $client,
                'employes' => $employes,
            ];
            return view('pages/clients/modifier', $data);
        }else{
            $session = session();
            $session->setFlashdata('error', "Tu n'est pas connéctée");
            return redirect()->to('/service');
        }
    }
    public function update($id)
    {
        $modelClient = new Client;
    
        // Récupérez les données du formulaire
        $data = [
            'ICE' => $this->request->getVar('ICE'),
            'nom' => $this->request->getVar('nom'),
            'email_client' => $this->request->getVar('email_client'),
            'numero_telephone' => $this->request->getVar('numero_telephone'),
            'adresse' => $this->request->getVar('adresse'),
            'ville' => $this->request->getVar('ville'),
            'pays' => $this->request->getVar('pays'),
            'societe' => $this->request->getVar('societe'),
            'source' => $this->request->getVar('source'),
            'remarque' => $this->request->getVar('remarque'),
        ];
    
        // Mettez à jour le client avec les nouvelles données
        $modelClient->update($id, $data);
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été modifer un client');
        $session = session();
        $session->setFlashdata('success', 'Client mis à jour avec succès.');
        
        // Redirigez l'utilisateur vers la liste des clients ou une autre page selon vos besoins
        return redirect()->to('client');
    }
    public function delete($id_client)
    {
        $clientModel = new Client();
        $devisModel = new DevisModel();
        $factureModel = new Facture();
        $paimentModel = new Paiment();
        $ligneCommandeModel = new LigneCommandeModel();
    
        // Récupérer tous les devis associés au client
        $devis = $devisModel->where('id_client', $id_client)->get()->getResultArray();
    
        // Parcourir tous les devis et supprimer les paiements, les factures et les lignes de commande associés
        foreach ($devis as $devi) {
            $facture = $factureModel->where('id_client', $devi['id_client'])->first();
            if ($facture) {
                // Supprimer les paiements associés à la facture
                $paimentModel->where('id_facture', $facture['id_facture'])->delete();
                // Supprimer la facture
                $factureModel->where('id_facture', $facture['id_facture'])->delete();
            }
            // Supprimer les lignes de commande associées au devis
            $ligneCommandeModel->where('id_devis', $devi['id_devis'])->delete();
        }
    
        // Supprimer les devis associés au client
        $devisModel->where('id_client', $id_client)->delete();
        // Supprimer le client
        $clientModel->where('id_client', $id_client)->delete();
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été supprimer un client');
        $session = session();
        $session->setFlashdata('success', 'Donnés supprimées avec succè.');
        return redirect()->to('client');
    }
    public function show($id_client){
        if(session()->has('role')){
            $cliemtModel = new Client();
            $venteModel = new Vente();
            $factureModel = new Facture();
            $devisModel = new DevisModel();
            $commandeModel = new Commande();
            $detailsCommandeModel = new DetailsCommandeModel();
            $employeModel = new Employee();

            $clients = $cliemtModel->find($id_client);
            $employee = $employeModel->find($clients['id_emp']);
            $ventes = $venteModel->join('client' , 'vente.id_client = client.id_client')
                                ->where('vente.id_client' , $id_client)->findAll();
            $factures = $factureModel->join('client' , 'facture.id_client = client.id_client')
                                ->join('paiment', 'paiment.id_facture = facture.id_facture')
                                ->join('vente', 'paiment.id_vente = vente.id_vente')
                                ->where('facture.id_client' , $id_client)
                                ->findAll();

                                $existsFacture = $factureModel->join('client' , 'client.id_client = facture.id_client')
                                ->join('vente' , 'vente.id_client = client.id_client')
                                ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                                ->join('service', 'service.id_service = details_vente.id_service')
                                ->where('client.id_client' , $id_client)
                                ->findAll();
                                // Fetch all the commands for the client with their associated services
                                 // Fetch all the commands for the client
                $commandes = $commandeModel
                ->join('client', 'commande.id_client = client.id_client')
                ->where('commande.id_client', $id_client)
                ->findAll();

            // Group services by command
            $commandesWithServices = [];
            foreach ($commandes as $commande) {
                $servicesForCommande = $detailsCommandeModel
                    ->where('id_commande', $commande['id_commande'])
                    ->join('service', 'service.id_service = details_commande.id_service')
                    ->findAll();

                $commandesWithServices[] = [
                    'commande' => $commande,
                    'services' => $servicesForCommande,
                ];
            }
            $data = [
                'clients' => $clients,
                'ventes' => $ventes,
                'factures' => $factures,
                'commandes' => $commandes,
                'commandesWithServices' => $commandesWithServices,
                'employee' => $employee,
                'existsFacture' => $existsFacture,
            ];
            return view('pages/clients/details' , $data);
        }else{
            session()->setFlashdata('error' , "Tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }
    }
    public function avance(){
        $avanceModel = new AvanceModel();
        $debut = date("Y-m") . "-01";
        $fin = date("Y-m-t");
        $submit_date_debut = $this->request->getGet("date_debut");
        $submit_date_fin = $this->request->getGet("date_fin");
        if (!empty($submit_date_debut) && !empty($submit_date_fin)) {
            $debut = date("Y-m-d", strtotime($submit_date_debut));
            $fin = date("Y-m-d", strtotime($submit_date_fin));
            $avances = $avanceModel->join('client' , 'client.id_client = avance.id_client')
                            ->join('employee e' , 'e.id_emp = client.id_emp')
                            ->where('date_avance BETWEEN '.$debut.' AND '.$fin)
                            ->findAll();
            $data = [
                'avances' => $avances
            ];
            return view('pages/avances/liste' , $data);
        }
        $avances = $avanceModel->join('client' , 'client.id_client = avance.id_client')
                            ->join('employee e' , 'e.id_emp = client.id_emp')
                            ->findAll();
        $data = [
            'avances' => $avances,
            'fin' => $fin,
            'debut' => $debut,
        ];
        return view('pages/avances/liste' , $data);
    }
    public function AddAvance(){
        $clientModel = new Client();
        $data = [
            'clients' => $clientModel->findAll(),
        ];
        return view('pages/avances/ajouter' , $data);
    }
    public function StoreAvance()
    {
        $avanceModel = new AvanceModel();
        $detailsModel = new DetailsAvanceModel();
    
        $id_client = $this->request->getPost('id_client');
        $status = $this->request->getPost('status');
        $montant = $this->request->getPost('montant');
    
        // Check if a 'details_avance' record exists for the client and status
        $existingRecord = $detailsModel->where('id_client', $id_client)
            ->first();
        // Insert the data into the 'avance' table
        $data = [
            'id_client' => $id_client,
            'date_avance' => $this->request->getPost('date_avance'),
            'status' => $status,
            'montant' => $montant,
            'mode_pay' => $this->request->getPost('mode_pay'),
            'reference' => $this->request->getPost('reference'),
            'date_pay' => $this->request->getPost('date_pay'),
        ];

        // print_r($existingRecord);die();
        $avanceModel->insert($data);
        $insertedAvanceID = $avanceModel->insertID();
        if ($existingRecord) {
            // If a record exists, update the 'montantAvance' field
            $currentMontantAvance = $existingRecord['montantAvance'];
            $newMontantAvance = ($status == 'avance')
                ? $currentMontantAvance + $montant
                : $currentMontantAvance - $montant;
    
            // Update 'montantAvance' in the 'details_avance' table
            $detailsModel->where('id_client', $id_client)
                ->set('montantAvance', $newMontantAvance)
                ->update();
        } else {
            // If no record exists, insert a new record
            $data = [
                'id_client' => $id_client,
                'id_avance' => $insertedAvanceID,
                'montantAvance' => $montant,
            ];
    
            // Insert the data into the 'details_avance' table
            $detailsModel->insert($data);
        }
    
        
    
        return redirect()->to('client/avance');
    }
    
    
    
    public function addAvanceRetour(){
        $clientModel = new Client();
        $data = [
            'clients' => $clientModel->findAll(),
        ];
        return view('pages/avances/r_ajout' , $data);
    }

    public function editAvance($id_avance){
        $avanceModel = new AvanceModel();
        $clientModel = new Client();
        $avance = $avanceModel->join('client' , 'client.id_client = avance.id_client')
                    ->join('employee' , 'employee.id_emp = client.id_emp')
                    ->where('avance.id_avance' , $id_avance)
                    ->first();
        return view('pages/avances/modifier' ,
            [
                'clients' => $clientModel->findAll(),
                'avance' => $avance
            ]
        );
    }
    public function UpdateAvance($id_avance){
        $avanceModel = new AvanceModel();
        $detailsAvanceModel = new DetailsAvanceModel();
        $id_client = $this->request->getPost('id_client');
        $status = $this->request->getPost('status');
        $montant = $this->request->getPost('montant');
        $data = [
            'id_client' => $id_client,
            'date_avance' => $this->request->getPost('date_avance'),
            'status' => $status,
            'montant' => $montant,
            'mode_pay' => $this->request->getPost('mode_pay'),
            'reference' => $this->request->getPost('reference'),
            'date_pay' => $this->request->getPost('date_pay'),
        ];
        $avance = $avanceModel->find($id_avance);
        $existingRecord = $detailsAvanceModel->where('id_client', $id_client)
        ->where('id_avance' , $id_avance-1)
        ->first();
        $avanceModel->update($id_avance , $data);
        if($existingRecord){
            // print_r($existingRecord);die();
            $currentMontantAvance = $existingRecord['montantAvance'];
            if($currentMontantAvance > $montant){
                $newMontantAvance = ($status == 'avance')
                    ? $currentMontantAvance + $montant
                    : $currentMontantAvance - $montant;
            }else{
                $newMontantAvance = ($status == 'avance')
                ? $currentMontantAvance + ($montant - $currentMontantAvance)
                : $montant - $currentMontantAvance;
            }
    
            $detailsAvanceModel->where('id_client', $id_client)
                ->set('montantAvance', $newMontantAvance)
                ->update();
            return redirect()->to('client/avance');
        }
    }
}