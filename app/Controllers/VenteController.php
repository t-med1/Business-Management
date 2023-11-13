<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Commande;
use App\Models\DetailsCommandeModel;
use App\Models\DetailsVenteModel;
use App\Models\DevisModel;
use App\Models\Facture;
use App\Models\Paiment;
use App\Models\Vente;
use App\Models\Client;
use App\Models\Employee;
use App\Models\ServiceModel;

class VenteController extends BaseController
{
    public function index()
{
    $venteModel = new Vente();
    $debut = date("Y-m")."-01";
    $fin = date("Y-m-t");
    if(session()->has('role')){
        $ventes = $venteModel
                    ->select('vente.*, employee.nom , employee.prenom ,employee.role , service.titre, client.societe')
                    ->join('client', 'client.id_client = vente.id_client')
                    ->join('employee', 'employee.id_emp = client.id_emp')
                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                    ->join('service', 'service.id_service = details_vente.id_service')
                    ->groupBy('vente.id_vente')
                    ->get()
                    ->getResultArray();
        // print_r($ventes);die();
        return view('pages/ventes/liste', ['ventes' => $ventes , 'debut' => $debut , 'fin' => $fin]);
    }else {
        $session = session();
        $session->setFlashdata('error', "tu n'est pas connécté(e) !");
        return redirect()->to('/login');
    }
}
    public function create($id_commande)
    {
        if(session()->has('role')){
            $clients = new Client();
            $modelCommande = new Commande();
            $services = new ServiceModel();
        // print_r($id_commande);die();
            $modelVente = new Vente;
            if($id_commande == 0){
                $commande = $modelCommande->find($id_commande);
                $venteCode = $this->generateVenteCode($modelVente);
                return view('pages/ventes/ajouter', ['venteCode' => $venteCode, 'clients' => $clients->findAll(),'services' => $services->findAll() , 'commande'=>$commande] );
            }else{
                $serviceModel = new ServiceModel();
                $employeeModel = new Employee();
                $detailsCommandeModel = new DetailsCommandeModel();
                $modelVente = new Vente;
                
                $commande = $modelCommande->find($id_commande);

                if (!$commande) {
                    return redirect()->to('/commande')->with('error', 'La commande n\'existe pas.');
                }
                $client = $clients->find($commande['id_client']);
                $employee = $employeeModel->find($client['id_emp']);
                $detailsCommande = $detailsCommandeModel->where('id_commande', $id_commande)->findAll();
                $services = [];
            
                foreach ($detailsCommande as $detail) {
                    $service = $serviceModel->find($detail['id_service']);
                    if ($service) {
                        $services[] = $service;
                    }
                }
                    $modelCommande->find($id_commande);
                    $venteCode = $this->generateVenteCode($modelVente);
                    // print_r($services);die();
                    return view('pages/ventes/creeVente', ['venteCode' => $venteCode, 'client' => $client,'services' => $services , 'employee' => $employee, 'clients' => $clients->findAll(),'commande'=>$commande] );
                }
        }else {
                $session = session();
                $session->setFlashdata('error', "tu n'est pas connécté(e) !");
                return redirect()->to('/login');
        }
    }

    private function generateVenteCode($modelVente)
    {
        $year = date('y');
        $newVenteCount = $modelVente->countAllResults() + 1;
        return "V-{$year}-" . str_pad($newVenteCount, 4, '0', STR_PAD_LEFT);
    }

    public function generatedServis($service_id)
    {
        $serviceModel = new ServiceModel();
        $service = $serviceModel->find($service_id);
        if ($service) {
            $serviceDetails = [
                'id_service' => $service['id_service'],
                'code_service' => $service['code_service'],
                'prix_unitaire' => $service['prix_unitaire'],
                'titre' => $service['titre'],
            ];
            return $this->response->setJSON($serviceDetails);
        } else {
            return $this->response->setJSON([]);

        }
    }
    public function generatedClient($client_id)
    {
        $clientModel = new Client();
        $client = $clientModel->find($client_id);
        if ($client) {
            $clientserviceDetails = [
                'code_client' => $client['code_client'],
                'societe' => $client['societe'],
                'ice' => $client['ICE'],
                'numero_telephone' => $client['numero_telephone'],
                'email_client' => $client['email_client'],
                'ville' => $client['ville'],
                'source' => $client['source'],
            ];
            return $this->response->setJSON($clientserviceDetails);
        } else {
            return $this->response->setJSON([]);

        }
    }
    public function generatedAvance($id_client){
        $clientModel = new Client();
    
        // Fetch data for espece payment
        $clientEspece = $clientModel
            ->join('avance', 'avance.id_client = client.id_client')
            ->join('details_avance d', 'd.id_avance = avance.id_avance')
            ->where('avance.mode_pay', 'espece')
            ->where('d.id_client', $id_client)
            ->first();
    
        // Fetch data for cheque payment
        $clientCheque = $clientModel
            ->join('avance', 'avance.id_client = client.id_client')
            ->join('details_avance d', 'd.id_avance = avance.id_avance')
            ->where('avance.mode_pay', 'cheque')
            ->where('d.id_client', $id_client)
            ->first();
    
        // Fetch data for virement payment
        $clientVirement = $clientModel
            ->join('avance', 'avance.id_client = client.id_client')
            ->join('details_avance d', 'd.id_avance = avance.id_avance')
            ->where('avance.mode_pay', 'virement')
            ->where('d.id_client', $id_client)
            ->first();
    
        // Initialize default values as 0.00
        $totalEspece = 0.00;
        $totalCheque = 0.00;
        $totalVirement = 0.00;
    
        // Check if data exists and set values accordingly
        if (!empty($clientEspece)) {
            $totalEspece = $clientEspece['montantAvance'];
        }
    
        if (!empty($clientCheque)) {
            $totalCheque = $clientCheque['montantAvance'];
        }
    
        if (!empty($clientVirement)) {
            $totalVirement = $clientVirement['montantAvance'];
        }
    
        // Create an array with the totals
        $clientserviceDetails = [
            'total_espece' => number_format($totalEspece, 2),
            'total_cheque' => number_format($totalCheque, 2),
            'total_virement' => number_format($totalVirement, 2)
        ];
    
        return $this->response->setJSON($clientserviceDetails);
    }
    
    public function updateReste($id_vente){
        $venteModel = new Vente();
        $paiementModel = new Paiment();
        $factureModel = new Facture();
        $reste = $this->request->getPost('motant_rest');
        $existsFacture = $factureModel->select('facture.id_facture')
            ->join('client' , 'client.id_client = facture.id_client')
                                    ->join('vente' , 'vente.id_client = client.id_client')
                                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                                    ->join('service', 'service.id_service = details_vente.id_service')
                                    ->where('vente.id_vente' , $id_vente)
                                    ->first();
        $data = [
            'id_vente' => $id_vente,
            // 'rest' => $this->request->getPost('motant_rest'),
            'id_facture' => $existsFacture['id_facture'] ? $existsFacture['id_facture'] : null,
            'date_dernier_paiment' => $this->request->getPost('date_dernier_paiment'),
            'montant_pay' => $this->request->getPost('montant_pay')
        ];
        // print_r($data);die();
        $venteModel->set('montant_rest' , $reste)->where('id_vente' , $id_vente)->update();

        $paiementModel->insert($data);
        return redirect()->back();
    }

    public function store()
{
    $venteModel = new Vente();
    $paiementModel = new Paiment();
    $detailsventeModel = new DetailsVenteModel();
    
    $modePaiement = $this->request->getPost('mode_paiement');
    
    if ($modePaiement == 'avance') {
        // Récupérez le montant total TTC de la vente
        $totalTTC = $this->request->getPost('total_ttc');
        
        // Récupérez le montant de l'avance
        $montantAvance = $this->request->getPost('montant_paye');
        
        if (floatval($totalTTC) > floatval($montantAvance)) {
                // Le montant total TTC est supérieur à l'avance
                // Mettez à jour le montant d'avance dans la base de données à zéro
                // Remarque : Vous devez remplacer 'VotreTable' par le nom de votre table d'avance
            $db      = \Config\Database::connect();
            $builder = $db->table('details_avance');
            
            $builder->where('id_client', $this->request->getPost('id_client'));
            $builder->update(['montantAvance' => 0]);
        }
    } else {
        // Le paiement n'est pas une avance, continuez avec le traitement normal
        $data = [
            'id_client' => $this->request->getPost("id_client"),
            'id_commande' => $this->request->getPost("id_commande"),
            'code_vente' => $this->generateVenteCode($venteModel),
            'date_vente' => $this->request->getPost('date_vente'),
            'tva' => $this->request->getPost('tva'),
            'total_ht' => $this->request->getPost('total_ht'),
            'total_ttc' => $this->request->getPost('total_ttc'),
            
            'montant_rest' => $this->request->getPost('montant_rest'),
            'mode_paiement' => $this->request->getPost('mode_paiement'),
            'reference_cheque' => $this->request->getPost('reference_cheque'),
            'date_cheque' => $this->request->getPost('date_cheque'),
            'frais' => $this->request->getPost('frais'),
        ];
        
        // ... (le reste de votre code pour insérer la vente dans la base de données)
        
        try {
            if ($data) {
                $venteModel->insert($data);
            } else {
                session()->setFlashdata('error', "La vente n'a pas été ajoutée.");
            }
            $insertedVenteID = $venteModel->insertID();
                
            $service = $this->request->getVar('id_service');
            for ($i = 0; $i < count($service); $i++) {
                $ligne = [
                    'id_service' => $service[$i],
                    'id_vente' => $insertedVenteID,
                ];
                $detailsventeModel->insert($ligne);
            }
            $dataPaiment = [
                'id_vente' => $insertedVenteID,
                'date_dernier_paiment' => $this->request->getPost('date_vente'),
                'montant_pay' => $this->request->getPost('montant_paye'),
            ];  
            $paiementModel->insert($dataPaiment);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a ajouté une vente.');
            session()->setFlashdata('success', "La vente a été ajoutée avec succès !");
            return redirect()->to('Vente'); 
        } catch (\Exception $e) {
            log_message('error', 'Error in store function: ' . $e->getMessage());
            session()->setFlashdata('error', "La vente n'a pas été ajoutée !");
            return redirect()->to('Vente/ajouter');
        }
    }
    
    // Reste du code pour d'autres opérations ou redirection
}

public function show($id)
    {
        if(session()->has('role')){
            $venteModel = new Vente();
            $clientModel = new Client();
            $serviceModel = new ServiceModel();
            $employeModel = new Employee();
            $factureModel = new Facture();
            $commandeModel = new Commande();
            $detailsventeModel = new DetailsVenteModel();
            $vente = $venteModel->find($id);
    
            if (!$vente) {
                return redirect()->to('/vente')->with('error', 'La vente n\'existe pas.');
            }
            $commande = $commandeModel->join('client' , 'client.id_client = commande.id_client')
                                    ->join('vente' , 'vente.id_commande = commande.id_commande')
                                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                                    ->join('service', 'service.id_service = details_vente.id_service')
                                    ->where('vente.id_vente' , $id)
                                    ->first();
            $existsFacture = $factureModel->select('facture.code_facture')
            ->join('client' , 'client.id_client = facture.id_client')
                                    ->join('vente' , 'vente.id_client = client.id_client')
                                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                                    ->join('service', 'service.id_service = details_vente.id_service')
                                    ->where('vente.id_vente' , $id)
                                    ->first();
            $ventes = $venteModel->join('client' , 'client.id_client = vente.id_client')
                                    ->join('paiment', 'paiment.id_vente = vente.id_vente')
                                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                                    ->join('service', 'service.id_service = details_vente.id_service')
                                    ->where('vente.id_vente' , $id)
                                    ->first();
            $client = $clientModel->find($ventes['id_client']);
            $services = $serviceModel->join('details_vente', 'details_vente.id_service = service.id_service')
                                    ->where('details_vente.id_vente', $vente['id_vente'])
                                    ->get()
                                    ->getResultArray();
            $montant_paye = $venteModel->select('paiment.montant_pay')
                                    ->join('paiment' , 'paiment.id_vente = vente.id_vente')
                                    ->where('vente.id_vente' , $id)
                                    ->groupBy('paiment.id_vente' , "DESC")
                                    ->first();
            $employe = $employeModel->join('client' , 'client.id_emp = employee.id_emp')
                                    ->where('client.id_client' , $vente['id_client'])
                                    ->first();
                                                       
            if (!$client || empty($services)) {
                return redirect()->to('/vente')->with('error', 'Le client ou les services sont introuvables.');
            }
            //  
            $data = [
                'ventes' => $ventes ,
                'vente' => $vente,
                'client' => $client,
                'montant_paye' => $montant_paye,
                'services' => $services ,
                'employe' => $employe,
                'commande' => $commande,
                'existsFacture' => $existsFacture
            ];
            return view('pages/ventes/detail', $data);
        }else {
            $session = session();
            $session->setFlashdata('error', "tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }
    }
    
    
    public function edit($id)
        {
            if (session()->has('role')) {
                $venteModel = new Vente();
                $serviceModel = new ServiceModel();
                $detailsventeModel = new DetailsVenteModel();
                $clientModel = new Client();
                
                $clients = $clientModel->findAll();
                $vente = $venteModel->join('client', 'client.id_client = vente.id_client')
                ->join('employee', 'employee.id_emp = client.id_emp')
                ->join('commande' , 'commande.id_commande = vente.id_commande')
                ->join('paiment', 'paiment.id_vente = vente.id_vente')
                ->join('details_commande', 'details_commande.id_commande = commande.id_commande')
                ->join('service', 'service.id_service = details_commande.id_service')
                ->select('vente.* , commande.* , employee.* , client.* , paiment.*')
                ->first();

                // Récupérez les détails du client en fonction de l'ID du client
                $selectedClient = $clientModel->find($vente['id_client']);
                // Get the details of services associated with this command
                $detailsCommande = $detailsventeModel->where('id_vente', $id)->findAll();
                $services = [];

                foreach ($detailsCommande as $detail) {
                    $service = $serviceModel->find($detail['id_service']);
                    if ($service) {
                        $services[] = $service;
                    }
                }
                // print_r($services);die();
                return view('pages/ventes/modifier', [
                    'vente' => $vente,
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
            $venteModel = new Vente();
            $paimentModel = new Paiment();
            $detailVenteModel = new DetailsVenteModel();
            $data = [
                'date_vente' => $this->request->getPost('date_vente'),
                'tva' => $this->request->getPost('tva'),
                'total_ht' => $this->request->getPost('total_ht'),
                'total_ttc' => $this->request->getPost('total_ttc'),
                'montant_rest' => $this->request->getPost('montant_rest'),
                'mode_paiement' => $this->request->getPost('mode_paiement'),
                'reference_cheque' => $this->request->getPost('reference_cheque'),
                'date_cheque' => $this->request->getPost('date_cheque'),
                'frais' => $this->request->getPost('frais'),
            ];
            $venteModel->update($id, $data);
            $dataPai = [
                'montant_pay' => $this->request->getPost('montant_pay'),
            ];
            $services = $this->request->getVar('id_service');

            $detailVenteModel->where('id_vente', $id)->delete();
            if (!empty($services)) {
                foreach ($services as $serviceId) {



                    $detailVenteModel->insert([
                        'id_vente' => $id,
                        'id_service' => $serviceId,
                    ]);
                }
            }
            $paimentModel->update($id , $dataPai);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été modifier une vente');
            // Redirigez avec un message de succès
            session()->setFlashdata('success', 'Vente mise à jour avec succès.');
            return redirect()->to('/Vente');
        } else {
            $session = session();
            $session->setFlashdata('error', "Tu n'es pas connecté(e) !");
            return redirect()->to('/login');
        }
    }
    
    public function UpdateCheque($id_vente){
        $venteModel = new Vente();
        $paiementModel = new Paiment();
        $factureModel = new Facture();
        $existsFacture = $factureModel->select('facture.id_facture')
            ->join('client' , 'client.id_client = facture.id_client')
                                    ->join('vente' , 'vente.id_client = client.id_client')
                                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                                    ->join('service', 'service.id_service = details_vente.id_service')
                                    ->where('vente.id_vente' , $id_vente)
                                    ->first();
        $vente = $venteModel->where('id_vente' , $id_vente)->first();
        $montant = $vente['montant_rest'];
        $data = [
            'id_vente' => $id_vente,
            // 'rest' => $this->request->getPost('motant_rest'),
            'id_facture' => $existsFacture['id_facture'] ? $existsFacture['id_facture'] : null,
            'date_dernier_paiment' => $this->request->getPost('date_dernier_paiment'),
            'montant_pay' => $montant
        ];
        // print_r($data);die();
        $venteModel->set('montant_rest' , 0)->where('id_vente' , $id_vente)->update();

        $paiementModel->insert($data);
        return redirect()->back();
    }
}
