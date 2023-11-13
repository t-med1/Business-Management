<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Employee;
use App\Models\ServiceModel;
use App\Models\Tache;
use App\Models\Vente;

class ChartController extends BaseController
{
    private $emp_id;

    public function __construct()
    {
        $this->emp_id = session('id_employe');
    }
    public function index()
    {
        if (session()->has('role')) {
            $employeModel = new Employee;
            $tacheModel = new Tache();
            $clientMOdel = new Client();
            $commandeModel = new Commande();
            $serviceModel = new ServiceModel();
            $today = date('Y-m-d');
            $venteModel = new Vente();
            $ventes = $venteModel->findAll();
            
            // admin session
            if(session('role') == 'admin'){
                $chiffreAffairesTTC = 0;
                $chiffreAffairesHT = 0;
                foreach ($ventes as $vente) {
                    $chiffreAffairesTTC += $vente['total_ttc'];
                    $chiffreAffairesHT += $vente['total_ht'];
                }

                $tva = $chiffreAffairesTTC - $chiffreAffairesHT;

                $totalVentes = count($ventes);
                $totalClient = $clientMOdel->countAllResults();
                $totalCommandes = $commandeModel->countAllResults();
                $totalTachesAujourdhui = $tacheModel->where('date_debutT', $today)->countAllResults();
                $totalEmployees = $employeModel->countAll();
                if(session('role') == 'gestionnaire'){
                    $totalClient = $clientMOdel->join('employee' , 'employee.id_emp = client.id_emp')
                                        ->where('employee.id_emp' , session('id_employe'))
                                        ->countAllResults();
                    $totalCommandes = $commandeModel
                                    ->join('client' , 'client.id_client = commande.id_commande')
                                    ->join('employee' , 'employee.id_emp = client.id_emp')
                                    ->countAllResults();
                    $totalTachesAujourdhui = $tacheModel->where('date_debutT', $today)
                                        ->where('tache.id_emp' , session('id_employe'))
                                        ->countAllResults();
                }
                // Récupérez les ventes par mois
                $ventesParMois = $venteModel->select('MONTH(date_vente) as mois, COUNT(*) as nombre_ventes')
                    ->groupBy('mois')
                    ->orderBy('mois')
                    ->findAll();

                // Créez un tableau de données au format requis par Morris.js, en initialisant tous les mois à zéro ventes
                $ventesData = [];
                for ($mois = 1; $mois <= 12; $mois++) {
                    $moisNom = date('M', mktime(0, 0, 0, $mois, 1));
                    $nombreVentes = 0;

                    // Recherchez le mois correspondant dans les données réelles
                    foreach ($ventesParMois as $vente) {
                        if ($vente['mois'] == $mois) {
                            $nombreVentes = $vente['nombre_ventes'];
                            break;
                        }
                    }

                    $ventesData[] = ['y' => $moisNom, 'nombre_ventes' => $nombreVentes];
                }
                // ------------------------------------------------------------------------
                $moisDeLAnnee = [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ];

                // Récupérez également le total des ventes par mois
                $ventesTotalParMois = $venteModel->select('MONTH(date_vente) as mois, SUM(total_ttc) as total_ventes')
                    ->groupBy('mois')
                    ->orderBy('mois')
                    ->findAll();

                // Créez un tableau de données pour le total des ventes par mois
                $ventesTotalData = [];

                foreach ($moisDeLAnnee as $mois) {
                    $totalVentes = 0;

                    foreach ($ventesTotalParMois as $venteTotal) {
                        $moisVente = date('M', mktime(0, 0, 0, $venteTotal['mois'], 1));
                        if ($mois === $moisVente) {
                            $totalVentes = $venteTotal['total_ventes'];
                            break;
                        }
                    }

                    $ventesTotalData[] = ['y' => $mois, 'total_ventes' => $totalVentes];
                }
                $services = $serviceModel->findAll();

                // Récupérez les ventes par mois et par service
                $ventesParMoisEtService = $venteModel->select('MONTH(date_vente) as mois, service.titre AS nom_service, SUM(total_ttc) as total_ventes')
                    ->join('details_vente', 'vente.id_vente = details_vente.id_vente')
                    ->join('service', 'details_vente.id_service = service.id_service')
                    ->groupBy('mois, nom_service')
                    ->orderBy('mois, nom_service')
                    ->findAll();

                $ventesParMoisEtServiceData = [];

                if (!empty($serviceModel) && !empty($ventesParMoisEtService)) { // Vérifiez si les tableaux sont non vides
                    foreach ($moisDeLAnnee as $mois) {
                        $ventesParMoisData = [];

                        foreach ($serviceModel as $service) { // Utilisez $serviceModel au lieu de $services
                            $totalVentes = 0;

                            foreach ($ventesParMoisEtService as $vente) {
                                if (isset($vente['mois'])) {
                                    $moisVente = date('M', mktime(0, 0, 0, $vente['mois'], 1));
                                    if ($mois === $moisVente && isset($service['nom_service']) && $service['nom_service'] === $vente['nom_service']) {
                                        $totalVentes = $vente['total_ventes'];
                                        break;
                                    }
                                }
                            }

                            $ventesParMoisData[] = $totalVentes;
                        }
                        $ventesParMoisEtServiceData[] = ['y' => $mois, 'data' => $ventesParMoisData];
                    }
                }
                
                $data = [
                    'totalCommandes' => $totalCommandes,
                    'totalClient' => $totalClient,
                    'totalTachesAujourdhui' => $totalTachesAujourdhui,
                    'chiffreAffairesHT' => $chiffreAffairesHT,
                    'ventesData' => $ventesData,
                    'ventesTotalData' => $ventesTotalData,
                    'ventesParMoisEtServiceData' => $ventesParMoisEtServiceData,
                    'moisDeLAnnee' => $moisDeLAnnee,
                    'services' => $services,
                    // Assurez-vous d'ajouter cette ligne
                ];
                return view('index', $data);
            }
            // fin admin session

            // session for not the admin
            else{
                $chiffreAffairesTTC = 0;
                $chiffreAffairesHT = 0;
                foreach ($ventes as $vente) {
                    $chiffreAffairesTTC += $vente['total_ttc'];
                    $chiffreAffairesHT += $vente['total_ht'];
                }

                $tva = $chiffreAffairesTTC - $chiffreAffairesHT;

                $totalVentes = count($ventes);
                $totalEmployees = $employeModel->countAll();
                $totalClient = $clientMOdel->join('employee' , 'employee.id_emp = client.id_emp')
                                        ->where('employee.id_emp' , session('id_employe'))
                                        ->countAllResults();
                $totalCommandes = $commandeModel
                                    ->join('client' , 'client.id_client = commande.id_commande')
                                    ->join('employee' , 'employee.id_emp = client.id_emp')
                                    ->where('employee.id_emp' , session('id_employe'))
                                    ->countAllResults();
                $totalTachesAujourdhui = $tacheModel->where('date_debutT', $today)
                                        ->where('tache.id_emp' , session('id_employe'))
                                        ->countAllResults();
                // Récupérez les ventes par mois
                $ventesParMois = $venteModel->select('MONTH(date_vente) as mois, COUNT(*) as nombre_ventes')
                    ->groupBy('mois')
                    ->orderBy('mois')
                    ->findAll();

                // Créez un tableau de données au format requis par Morris.js, en initialisant tous les mois à zéro ventes
                $ventesData = [];
                for ($mois = 1; $mois <= 12; $mois++) {
                    $moisNom = date('M', mktime(0, 0, 0, $mois, 1));
                    $nombreVentes = 0;

                    // Recherchez le mois correspondant dans les données réelles
                    foreach ($ventesParMois as $vente) {
                        if ($vente['mois'] == $mois) {
                            $nombreVentes = $vente['nombre_ventes'];
                            break;
                        }
                    }

                    $ventesData[] = ['y' => $moisNom, 'nombre_ventes' => $nombreVentes];
                }
                // ------------------------------------------------------------------------
                $moisDeLAnnee = [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ];

                // Récupérez également le total des ventes par mois
                $ventesTotalParMois = $venteModel->select('MONTH(date_vente) as mois, SUM(total_ttc) as total_ventes')
                    ->groupBy('mois')
                    ->orderBy('mois')
                    ->findAll();

                // Créez un tableau de données pour le total des ventes par mois
                $ventesTotalData = [];

                foreach ($moisDeLAnnee as $mois) {
                    $totalVentes = 0;

                    foreach ($ventesTotalParMois as $venteTotal) {
                        $moisVente = date('M', mktime(0, 0, 0, $venteTotal['mois'], 1));
                        if ($mois === $moisVente) {
                            $totalVentes = $venteTotal['total_ventes'];
                            break;
                        }
                    }

                    $ventesTotalData[] = ['y' => $mois, 'total_ventes' => $totalVentes];
                }
                $services = $serviceModel->findAll();

                // Récupérez les ventes par mois et par service
                $ventesParMoisEtService = $venteModel->select('MONTH(date_vente) as mois, service.titre AS nom_service, SUM(total_ttc) as total_ventes')
                    ->join('details_vente', 'vente.id_vente = details_vente.id_vente')
                    ->join('service', 'details_vente.id_service = service.id_service')
                    ->groupBy('mois, nom_service')
                    ->orderBy('mois, nom_service')
                    ->findAll();

                $ventesParMoisEtServiceData = [];

                if (!empty($serviceModel) && !empty($ventesParMoisEtService)) { // Vérifiez si les tableaux sont non vides
                    foreach ($moisDeLAnnee as $mois) {
                        $ventesParMoisData = [];

                        foreach ($serviceModel as $service) { // Utilisez $serviceModel au lieu de $services
                            $totalVentes = 0;

                            foreach ($ventesParMoisEtService as $vente) {
                                if (isset($vente['mois'])) {
                                    $moisVente = date('M', mktime(0, 0, 0, $vente['mois'], 1));
                                    if ($mois === $moisVente && isset($service['nom_service']) && $service['nom_service'] === $vente['nom_service']) {
                                        $totalVentes = $vente['total_ventes'];
                                        break;
                                    }
                                }
                            }

                            $ventesParMoisData[] = $totalVentes;
                        }
                        $ventesParMoisEtServiceData[] = ['y' => $mois, 'data' => $ventesParMoisData];
                    }
                }
                
                $data = [
                    'totalCommandes' => $totalCommandes,
                    'totalClient' => $totalClient,
                    'totalTachesAujourdhui' => $totalTachesAujourdhui,
                    'chiffreAffairesHT' => $chiffreAffairesHT,
                    'ventesData' => $ventesData,
                    'ventesTotalData' => $ventesTotalData,
                    'ventesParMoisEtServiceData' => $ventesParMoisEtServiceData,
                    'moisDeLAnnee' => $moisDeLAnnee,
                    'services' => $services,
                    // Assurez-vous d'ajouter cette ligne
                ];
                return view('index', $data);
            }
            // session for not the admin
            
        } else {
            $session = session();
            $session->setFlashdata('error', "Tu n'est pas connecté(e) !");
            return redirect()->to('login');
        }
    }
}