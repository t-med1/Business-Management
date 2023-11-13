<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Facture;
use App\Models\Client;
use App\Models\DevisModel;
use App\Models\LigneCommandeModel;
use App\Models\Paiment;
use App\Models\Relancement;
use App\Models\ServiceModel;
use App\Models\Vente;
use Dompdf\Dompdf;


class FactureController extends BaseController
{
    public function updateJoursAutomatically()
    {
        $currentDate = date('Y-m-d');
        $factureModel = new Facture();

        $factures = $factureModel->findAll();

        foreach ($factures as $facture) {
            $dateEmission = $facture['date_emission'];
            $joursApresEmission = $this->calculateDaysDifference($dateEmission, $currentDate);
            $factureModel->update($facture['id_facture'], ['jours_apres_emission' => $joursApresEmission]);
        }

        return "Jours après émission mis à jour automatiquement.";
    }
    private function calculateDaysDifference($date1, $date2)
    {
        $date1 = new \DateTime($date1);
        $date2 = new \DateTime($date2);
        $interval = $date1->diff($date2);

        return $interval->days;
    }

    // Methode pour afficher les donnees du tableau facture
    public function index()
    {
        if (session()->has('role')) {
            $serviceModel = new ServiceModel();
            $factureModel = new Facture;
            $debut = date("Y-m") . "-01";
            $fin = date("Y-m-t");
            $this->updateJoursAutomatically();
            $submit_date_debut = $this->request->getGet("date_debut");
            $submit_date_fin = $this->request->getGet("date_fin");
    
            if (!empty($submit_date_debut) && !empty($submit_date_fin)) {
                $debut = date("Y-m-d", strtotime($submit_date_debut));
                $fin = date("Y-m-d", strtotime($submit_date_fin));
                $factures = $factureModel
                    ->select('facture.*, client.* , vente.* , employee.* , GROUP_CONCAT(details_vente.id_service) as services')
                    ->join('vente', 'vente.id_vente = facture.id_vente')
                    ->join('client', 'client.id_client = facture.id_client')
                    ->join('employee', 'employee.id_emp = client.id_emp')
                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente', 'left')
                    ->where('facture.date_saisie BETWEEN '.$debut.' AND '.$fin)
                    ->groupBy('facture.id_facture') // Groupe par ID de facture pour éviter les doublons
                    ->findAll();
                    return view('pages/factures/liste', [
                        'factures' => $factures,
                        'fin' => $fin,
                        'debut' => $debut
                    ]);
            } else {
                $factures = $factureModel
                    ->select('facture.*, client.* , vente.* , employee.* , GROUP_CONCAT(details_vente.id_service) as services')
                    ->join('vente', 'vente.id_vente = facture.id_vente')
                    ->join('client', 'client.id_client = facture.id_client')
                    ->join('employee', 'employee.id_emp = client.id_emp')
                    ->join('details_vente', 'details_vente.id_vente = vente.id_vente', 'left')
                    ->groupBy('facture.id_facture') // Groupe par ID de facture pour éviter les doublons
                    ->findAll();
                    return view('pages/factures/liste', [
                        'factures' => $factures,
                        'fin' => $fin,
                        'debut' => $debut,
                        'serviceModel' => $serviceModel 
                    ]);
            }
        } else {
            $session = session();
            $session->setFlashdata('error', "Tu n'es pas connecté(e) !");
            return redirect()->to('/login');
        }
    }
    

    public function editFacture($id_client , $id_devis){
        if(session()->has("role")){
            $modelClient = new Client();
            $facture_model = new Facture();
            $paimet_model = new Paiment();
            $modelDevis = new DevisModel;
            $modelservice = new ServiceModel;
            $ligneCommande = new LigneCommandeModel;
            
    
            $client = $modelClient->find($id_client);
            $facture = $facture_model->where('id_client',$id_client)->first();
            $paiment = $paimet_model->join('facture','facture.id_facture = paiment.id_facture')->where('facture.id_client', $id_client)->first();
            $devis = $modelDevis->find($id_devis);
            $service = $modelservice->join('lignecommande', 'lignecommande.id_service = service.id_service')->where('lignecommande.id_devis', $id_devis)->first();
            $commande = $ligneCommande->where('id_devis', $id_devis)->first();
            $data = [
                'client' => $client,
                'facture' => $facture,
                'paiment' => $paiment,
                'devis' => $devis,
                'service' => $service,
                'commande' => $commande
            ];
            return view('pages/factures/modifier',$data);
        }else{
            session()->setFlashdata('error' , "Tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }
    }
    public function updateFacture($id_facture){
        
        $facture_model = new Facture();
        $paimet_model = new Paiment();
        $facture_model->set('date_emission', $this->request->getVar('emission'))
            ->set('date_echeance', $this->request->getVar('echeance'))
            ->where('id_facture', $id_facture)
            ->update();
        $paimet_model->set('montant_paye', $this->request->getVar('montant'))
            ->set('montant_rest', $this->request->getVar('montantRest'))
            ->set('date_dernier_paiment', $this->request->getVar('datePaiment'))
            ->set('status', $this->request->getPost('status'))
            ->set('status_litige', $this->request->getVar('litige'))
            ->set('status_paiment', $this->request->getVar('status_paiment'))
            ->where('id_facture', $id_facture)
            ->update();
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été modifier une Facture');
        $session = session();
        $session->setFlashdata('success', 'Données Modifiées avec succès.');
        return redirect()->to('/facture');
    }
    public function generatedId($date_saisie){
        $model = new Facture();
        $id_facture = $model->generate_id_facture($date_saisie);
        return $this->response->setJSON(['id_facture' => $id_facture])->setContentType('application/json');
    }

    public function generatePdfForFacture($id_devis){
        $devismodel = new DevisModel();
        $modelservice = new ServiceModel();
        $modelClient = new Client();
        $ligneCommande = new LigneCommandeModel();
        $factureModel = new Facture();

        $devis = $devismodel->find($id_devis);
        $service = $modelservice->join('lignecommande', 'lignecommande.id_service = service.id_service')->where('lignecommande.id_devis', $id_devis)->first();
        $client = $modelClient->find($devis['id_client']);
        $facture = $factureModel->join('client' , 'client.id_client = facture.id_client')->join('devis' , 'devis.id_client = client.id_client')->where('devis.id_devis',$id_devis)->first();
        $commande = $ligneCommande->where('id_devis', $id_devis)->first();
        $data = [
            'devis' => $devis,
            'service' => $service,
            'client' => $client,
            'commande' => $commande,
            'facture' => $facture
        ];

        // Load the dompdf library
        $pdf = new Dompdf();
        // Generate the HTML for the PDF
        $html = view('facture_pdf', $data);

        // Generate the PDF
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        // Output the PDF to the browser
        $pdf->stream('facture.pdf', ['Attachment' => false]);
    }
}