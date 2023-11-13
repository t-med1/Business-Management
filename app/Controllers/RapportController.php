<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Employee;
use App\Models\ServiceModel;
use App\Models\Tache;
use App\Models\Vente;

class RapportController extends BaseController
{
    public function chiffreDaffaires()
    {
        if (session()->has('role')) {
            $venteModel = new Vente();
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, "phpVoir rapport pour le chiffre d'affaires");
            $debut = date("Y-m") . "-01";
            $fin = date("Y-m-t");
            $submit_date_debut = $this->request->getGet("date_debut");
            $submit_date_fin = $this->request->getGet("date_fin");

            if (!empty($submit_date_debut) && !empty($submit_date_fin)) {
                $debut = date("Y-m-d", strtotime($submit_date_debut));
                $fin = date("Y-m-d", strtotime($submit_date_fin));
                $ventes = $venteModel->where("created_at BETWEEN '$debut' AND '$fin'")
                    ->findAll();
    
                $chiffreAffairesTTC = 0;
                $chiffreAffairesHT = 0;
                foreach ($ventes as $vente) {
                    $chiffreAffairesTTC += $vente['total_ttc'];
                    $chiffreAffairesHT += $vente['total_ht'];
                }
    
                $tva = $chiffreAffairesTTC - $chiffreAffairesHT;
    
                $totalVentes = count($ventes);
            }else{
                $ventes = $venteModel->findAll();
    
                $chiffreAffairesTTC = 0;
                $chiffreAffairesHT = 0;
                foreach ($ventes as $vente) {
                    $chiffreAffairesTTC += $vente['total_ttc'];
                    $chiffreAffairesHT += $vente['total_ht'];
                }
    
                $tva = $chiffreAffairesTTC - $chiffreAffairesHT;
    
                $totalVentes = count($ventes);
            }


            return view('pages/rapports/chiffre_daffaires', [
                'totalVentes' => $totalVentes,
                'chiffreAffairesTTC' => $chiffreAffairesTTC,
                'chiffreAffairesHT' => $chiffreAffairesHT,
                'tva' => $tva,
                'debut' => $debut,
                'fin' => $fin,
            ]);
        } else {
            session()->getFlashdata('error', "Tu n'est pas connecté(e) !");
            return redirect()->to('/login');
        }
    }
    public function details_commerciaux()
    {
        if (session()->has('role')) {
            $venteModel = new Vente();
            $clientModel = new Client();
            $employeModel = new Employee();
            $tacheModel = new Tache();
            $commandeModel = new Commande();
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'Voir rapport du Commerciaux');
            $debut = date("Y-m") . "-01";
            $fin = date("Y-m-t");
            $submit_date_debut = $this->request->getGet("date_debut");
            $submit_date_fin = $this->request->getGet("date_fin");
            $id_emp = $this->request->getGet("id_employe");
            $employes = $employeModel->findAll();

            $totalVente = 0;
            $totalClient = 0;
            $totalTache = 0;
            $totalVentesHT = 0;
            $totalcommande = 0;
            $ventes = [];
            $commandes = [];

            if (!empty($submit_date_debut) && !empty($submit_date_fin)) {
                $debut = date("Y-m-d", strtotime($submit_date_debut));
                $fin = date("Y-m-d", strtotime($submit_date_fin));
                $totalVente = $venteModel->join('client', 'client.id_client = vente.id_client')
                    ->join('employee', 'employee.id_emp = client.id_emp')
                    ->where('client.id_emp', $id_emp)
                    ->where('vente.created_at BETWEEN "' . $debut . '" and "' . $fin . '"')
                    ->countAllResults();
                $ventes = $venteModel->join('client', 'client.id_client = vente.id_client')
                    ->join('employee', 'employee.id_emp = client.id_emp')
                    ->where('client.id_emp', $id_emp)
                    ->findAll();
                $totalcommande = $commandeModel
                        ->join('client', 'client.id_client = commande.id_client')
                        ->join('employee', 'employee.id_emp = client.id_emp')
                        ->where('client.id_emp', $id_emp)
                        ->where('commande.created_at BETWEEN "' . $debut . '" and "' . $fin . '"')
                        ->countAllResults();
                $commandes = $commandeModel
                        ->select('commande.*, service.*, employee.*, client.* , commande.date_debut AS date_D, GROUP_CONCAT(service.titre) AS service_titles')
                        ->join('client', 'client.id_client = commande.id_client')
                        ->join('employee', 'employee.id_emp = client.id_emp')
                        ->join('details_commande', 'details_commande.id_commande = commande.id_commande')
                        ->join('service', 'service.id_service = details_commande.id_service')
                        ->groupBy('details_commande.id_commande')
                        ->get()
                        ->getResultArray();
                $ventecommande = $venteModel->select('vente.code_vente , vente.id_commande')
                                    ->join('commande' , 'commande.id_commande = vente.id_commande')
                                    ->where('vente.created_at BETWEEN "' . $debut . '" and "' . $fin . '"')
                                    ->get()
                                    ->getResultArray();
                $totalClient = $clientModel->join('employee', 'employee.id_emp = client.id_emp')
                    ->where('client.id_emp', $id_emp)
                    ->where('client.created_at BETWEEN "' . $debut . '" and "' . $fin . '"')
                    ->countAllResults();
                $totalTache = $tacheModel->join('employee', 'employee.id_emp = tache.id_emp')
                    ->where('employee.id_emp', $id_emp)
                    ->where('tache.date_debutT BETWEEN "' . $debut . '" and "' . $fin . '"')
                    ->countAllResults();
                foreach ($venteModel->findAll() as $vente) {
                    $totalVentesHT += $vente['total_ht'];
                };
// print_r($commandes);die();
                $data = [
                    'debut' => $debut,
                    'fin' => $fin,
                    'employes' => $employes,
                    'totalVente' => $totalVente,
                    'totalTache' => $totalTache,
                    'totalClient' => $totalClient,
                    'totalVentesHT' => $totalVentesHT,
                    'ventes' => $ventes,
                    'totalcommande' => $totalcommande,
                    'commandes' => $commandes,
                    'ventecommande' => $ventecommande,
                ];
    
                return view('pages/rapports/details_commerciaux', $data);
            }
            $ventecommande = $venteModel->select('vente.code_vente , vente.id_commande')
                                    ->join('commande' , 'commande.id_commande = vente.id_commande')
                                    ->first();
            $data = [
                'debut' => $debut,
                'fin' => $fin,
                'employes' => $employes,
                'totalVente' => $totalVente,
                'totalTache' => $totalTache,
                'totalClient' => $totalClient,
                'totalVentesHT' => $totalVentesHT,
                'ventes' => $ventes,
                'totalcommande' => $totalcommande,
                'commandes' => $commandes,
                'ventecommande' => $ventecommande,
            ];
                        
            return view('pages/rapports/details_commerciaux', $data);
        } else {
            session()->setFlashdata('error', "Tu n'est pas connectété(e)");
        }

    }

    public function service_vendus(){
        if(session()->has('role'))
        {
            $debut = date("Y-m")."-01";
            $fin = date("Y-m-t");
            $venteModel = new Vente();
            $serviceModel = new ServiceModel();
                
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'Voir rapport du service vendus');
            // with click on the submit button hhh
            $submit_date_debut = $this->request->getGet("date_debut");
            $submit_date_fin   = $this->request->getGet("date_fin");

            if(!empty($submit_date_debut) && !empty($submit_date_fin))
            {
                $debut  = date("Y-m-d", strtotime($submit_date_debut));
                $fin    = date("Y-m-d", strtotime($submit_date_fin));
                $salesData = $venteModel
                    ->where('date_vente >=', $debut)
                    ->where('date_vente <=', $fin)
                    ->findAll();
                $totalProfit = 0;
                foreach ($salesData as $sale) {
                    $totalHT = $sale['total_ht'];
                    $frais = $sale['frais'];
                    
                    $benefit = $totalHT - $frais;
                    $totalProfit += $benefit;
                }
                $totalVente = 0;
                $ventes = $venteModel->findAll();
                foreach ($ventes as $vente) {
                    $totalVente += $vente['total_ht'];
                }
                
                $totalVente = 0;
                $ventes = $venteModel->findAll();
                foreach ($ventes as $vente) {
                    $totalVente += $vente['total_ht'];
                }
                $serviceVendus = $venteModel
                    ->select('service.id_service,vente.code_vente , vente.id_vente , service.titre, COUNT(*) as quantity_sold, SUM(total_ht) as total_ht_sold')
                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                    ->join('service', 'service.id_service = details_vente.id_service')
                    ->where('date_vente >=', $debut)
                    ->where('date_vente <=', $fin)
                    ->groupBy('service.id_service, service.titre')
                    ->findAll();
                return view('pages/rapports/service_vendus' , [
                    'fin' => $fin,
                    'debut' => $debut,
                    'totalProfit' => $totalProfit,
                    'totalVente' => $totalVente,
                    'serviceVendus' => $serviceVendus
                ]);
            }else{
                // end submit hohoh
                $salesData = $venteModel->findAll();
                $totalProfit = 0;
                foreach ($salesData as $sale) {
                    $totalHT = $sale['total_ht'];
                    $frais = $sale['frais'];
                    
                    $benefit = $totalHT - $frais;
                    $totalProfit += $benefit;
                }
                $totalVente = 0;
                $ventes = $venteModel->findAll();
                foreach ($ventes as $vente) {
                    $totalVente += $vente['total_ht'];
                }
                $serviceVendus = $venteModel
                    ->select('service.id_service, vente.code_vente , vente.id_vente , service.titre, COUNT(*) as quantity_sold, SUM(total_ht) as total_ht_sold')
                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente')
                    ->join('service', 'service.id_service = details_vente.id_service')
                    ->groupBy('service.id_service, service.titre')
                    ->findAll();
                return view('pages/rapports/service_vendus', [
                    'fin' => $fin,
                    'debut' => $debut,
                    'totalProfit' => $totalProfit,
                    'totalVente' => $totalVente,
                    'serviceVendus' => $serviceVendus
                ]);
            }
        }else{
            session()->setFlashdata('error' , "Tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }
    }
        

}