<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SouTache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SouTacheController extends BaseController
{


    public function store($id)
    {
        if (session('role') !== 'admin') {
            $modelSouTache = new SouTache;

            $data = [

                'description' => $this->request->getVar('description'),
                'date_debut' => $this->request->getVar('date_debut'),
                'date_fin' => $this->request->getVar('date_fin'),
                'status' => 'en attente',
                'id_tache' => $this->request->getVar('id_tache'),

            ];

            $modelSouTache->insert($data);
            $session = session();
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été ajouter une sous Tâche');
            $session->setFlashdata('success', 'Sou_tache ajouté avec succè.');
            return redirect()->to('taches/details/'.$id);
        }else{
            session()->setFlashdata('error' , "Tu n'est pas Le droit D'ajouter une sous Tâche");
            return redirect()->back();
        }
    }

    public function delete($id_sou_tache)
    {
        if (session('role') !== 'admin') {
            $modelSouTache = new SouTache;
            $modelSouTache->where('id_sou_tache', $id_sou_tache)->delete();
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été supprimer une sous Tâche');
            return redirect()->back()->with('success', 'Employé supprimé avec succès et ses tâches et congés associés.');
        }else{
            session()->setFlashdata('error' , "Tu n'est pas Le droit D'ajouter une sous Tâche");
            return redirect()->back();
        }
    }
    public function updateStatut($soutacheId, $id_tache)
    {
        $modelSouTache = new SouTache;
        $soutache = $modelSouTache->where("id_sou_tache", $soutacheId)->get()->getRowArray();

        if ($soutache['statut'] == 'en attente') {
            $data = array('statut' => 'en cours');
            $modelSouTache->update($soutacheId, $data);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, "a été modifier l'état d'une sous Tâche");
        }
        if ($soutache['statut'] == 'en cours') {
            $data = array('statut' => 'terminee');
            $modelSouTache->update($soutacheId, $data);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, "a été modifier l'état d'une sous Tâche");
        }
        $currentDate = strtotime(date('Y-m-d'));
        $tacheDateFin = strtotime($soutache['date_fin']);

        if ($tacheDateFin < $currentDate) {
            $data = array('statut' => 'en retard');
            $modelSouTache->update($soutacheId, $data);
        }

        return redirect()->to("taches/details/" . $id_tache);
    }

    public function exportToExcel()
    {
        $modelSouTache = new SouTache;
        $listes_souT = $modelSouTache->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->setCellValue('A1', 'Num Sous Tâche');
        $sheet->setCellValue('B1', 'Date Début');
        $sheet->setCellValue('C1', 'Date Fin');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Etat');

        $row = 2;
        foreach ($listes_souT as $souTache) {
            $sheet->setCellValue('A' . $row, $souTache['id_sou_tache']);
            $sheet->setCellValue('B' . $row, $souTache['date_debut']);
            $sheet->setCellValue('C' . $row, $souTache['date_fin']);
            $sheet->setCellValue('D' . $row, $souTache['description']);
            $sheet->setCellValue('E' . $row, $souTache['statut']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'liste_employes.xlsx';
        $path = WRITEPATH . 'uploads/' . $filename;
        $writer->save($path);

        return $this->response->download($path, null)->setFileName($filename);
    }
}