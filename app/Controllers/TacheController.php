<?php

namespace App\Controllers;

use App\Models\Notification;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controllers\BaseController;
use App\Models\Tache;
use App\Models\Employee;
use App\Models\SouTache;

class TacheController extends BaseController
{

    private $emp_id;

    public function __construct()
    {
        $this->emp_id = session('id_employe');
    }
    public function index()
    {
        $session = session();
        if ($session->has('role')) {
            $modelTache = new Tache;
            $this->updateStatutEnRetard();
            if (session('role') == 'admin') {
                $listes_t = $modelTache
                    ->join('employee', 'tache.id_emp = employee.id_emp')
                    ->join('notifications', 'notifications.id_tache = tache.id_tache')
                    ->orderBy('notifications.created_at', 'asc')
                    ->findAll();
                return view('pages/taches/liste', ['listes_t' => $listes_t]);

                
            } else {
                $listes_t = $modelTache->join('employee', 'tache.id_emp = employee.id_emp')
                    ->join('notifications', 'notifications.id_tache = tache.id_tache')
                    ->where('employee.id_emp', $this->emp_id)
                    ->orderBy('notifications.created_at', 'asc')
                    ->findAll();
                return view('pages/taches/liste', ['listes_t' => $listes_t]);
            }
        } else {
            $session = session();
            $session->setFlashdata('error', "tu n'est pas connécté(e) !");
            return redirect()->back('/login');
        }
    }

    public function create()
    {
        $session = session();
        if ($session->has('role')) {
            if(session('role') == 'admin'){
                $modelEmployee = new Employee();
                $employeeData = $modelEmployee->where('role !=', 'admin')->findAll();
                return view('pages/taches/ajouter', ['employeeData' => $employeeData]);
            }else{
                    $session = session();
                    $session->setFlashdata('error', "tu n'est pas le droit de créer un nouvelle tache");
                    return redirect()->back();
            }
        }else{
            $session = session();
            $session->setFlashdata('error', "tu n'est pas connécté(e) !");
            return redirect()->back('/login');
        }
    }


    public function store()
    {
        $modelTache = new Tache;
        $selectedCode = $this->request->getVar('code_emp');

        $modelEmployee = new Employee;
        $employeeInfo = $modelEmployee->where('code_emp', $selectedCode)->first();

        if ($employeeInfo) {
            $dateDebut = strtotime($this->request->getVar('date_debutT'));
            $dateFin = strtotime($this->request->getVar('date_fin'));

            if ($dateDebut < $dateFin) {
                $data = [
                    'description' => $this->request->getVar('description'),
                    'date_debutT' => date('Y-m-d', $dateDebut),
                    'date_fin' => date('Y-m-d', $dateFin),
                    'email' => $employeeInfo['email'],
                    'id_emp' => $employeeInfo['id_emp'],
                ];

                // Insérer la tâche dans la base de données
                $modelTache->insert($data);

                // Récupérer l'ID de la tâche nouvellement insérée
                $taskId = $modelTache->getInsertID();

                // Créer une nouvelle notification
                $notificationModel = new Notification();
                $notificationData = [
                    'id_emp' => $employeeInfo['id_emp'],
                    'id_tache' => $taskId,
                    // Utilisez l'ID de la tâche
                    'content' => 'Vous avez une nouvelle tâche : ' . $this->request->getVar('description'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $notificationModel->insert($notificationData);
                $ipAddress = $this->request->getIPAddress();
                log_activity(session('id_employe'), $ipAddress, 'a été affecter(ajouter) une Tâche');
                $session = session();
                $session->setFlashdata('success', 'Tâche ajoutée avec succès.');
                return redirect()->to('taches');
            } else {
                $session = session();
                $session->setFlashdata('error', 'La date de début doit être antérieure à la date de fin.');
                return redirect()->to('taches/add');
            }
        } else {
            $session = session();
            $session->setFlashdata('error', 'Employé non trouvé.');
            return redirect()->to('taches');
        }
    }

    public function updateStatusAutomatically()
    {
        $currentDate = date('Y-m-d');
        $tacheModel = new Tache();
        $taches = $tacheModel->where('date_fin <', $currentDate)
                            ->whereIn('statut', ['en cours', 'en attente'])
                            ->findAll();
        foreach ($taches as $tache) {
            $data = array('statut' => 'en retard');
            $tacheModel->update($tache['id_tache'], $data);
        }
    }
    public function updateStatutEnRetard()
    {
        $tacheModel = new Tache();
        $today = date('Y-m-d');
        $tachesEnRetard = $tacheModel->where('date_fin <', $today)
            ->whereNotIn('statut', ['terminée', 'en retard'])
            ->findAll();

        foreach ($tachesEnRetard as $tache) {
            $tacheModel->update($tache['id_tache'], ['statut' => 'en retard']);
        }
    }
    public function edit($id)
    {
        $session = session();
        if ($session->has('role')) {
            $modelTache = new Tache;
            $tache = $modelTache->find($id);
            $modelEmployee = new Employee;

            if(session('role') == 'admin'){
                $employee = $modelEmployee->find($tache['id_emp']);
                return view('pages/taches/modifier', ['tache' => $tache, 'employee' => $employee]);
            }else{
                $session = session();
                $session->setFlashdata('error', "tu n'est pas le droit de mofifier cette tache");
                return redirect()->back();
            }
        } else {
            $session = session();
            $session->setFlashdata('error', "tu n'est pas connécté(e) !");
            return redirect()->back('/login');
        }
    }

    public function update($id)
    {
        $modelTache = new Tache;
        $dateDebut = strtotime($this->request->getVar('date_debutT'));
        $dateFin = strtotime($this->request->getVar('date_fin'));
        if ($dateDebut < $dateFin) {
            $data = [
                'date_debutT' => $this->request->getPost('date_debutT'),
                'date_fin' => $this->request->getPost('date_fin'),
                'description' => $this->request->getPost('description'),

            ];
            $modelTache->update($id, $data);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été modfifier une Tâche');
            return redirect()->to('taches');
        } else {
            $session = session();
            $session->setFlashdata('error', 'La date de début doit être antérieure à la date de fin.');
            return redirect()->to('taches/edit/' . $id);
        }
    }

    public function show($id)
    {
        $modelTache = new Tache;
        $modelEmployee = new Employee;
        $modelSouTache = new SouTache;
        if(session()->has("role")){
            $employ = $modelTache->join('employee' , 'employee.id_emp = tache.id_emp')->where('tache.id_emp' , session('id_employe'))->first();
            if(session('role')=='admin' || session("id_employe") == $employ['id_emp']){
                $data['tache'] = $modelTache->find($id);
                $id_emp = $data['tache']['id_emp'];
                $data['employee'] = $modelEmployee->find($id_emp);
                $data['listes_souT'] = $modelSouTache->where('id_tache', $id)->findAll();
                return view('pages/taches/detail', $data);
            }else{
                $session = session();
                $session->setFlashdata('error', "tu n'est pas le droit d'afficher les infos de cette' tache");
                return redirect()->back();
            }
        }else{
            $session = session();
            $session->setFlashdata('error', "tu n'est pas le droit de creer un nouvelle tache");
            return redirect()->back();
        }
    }


    public function updateStatut($tacheId)
    {
        $tacheModel = new Tache();
        $tache = $tacheModel->where("id_tache", $tacheId)->get()->getRowArray();

        if ($tache['statut'] == 'en attente') {
            $data = array('statut' => 'en cours');
            $tacheModel->update($tacheId, $data);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, "a été modifier l'état d'une Tâche");
        }
        if ($tache['statut'] == 'en cours') {
            $data = array('statut' => 'terminee');
            $tacheModel->update($tacheId, $data);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, "a été modifier l'état d'une Tâche");
        }
        if ($tache['statut'] == 'en retard') {
            $data = array('statut' => 'terminee');
            $tacheModel->update($tacheId, $data);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, "a été modifier l'état d'une Tâche");
        }
        return redirect()->to("taches");
    }

    


    public function delete($id_tache)
    {
        $tacheModel = new Tache();
        $souTacheModel = new SouTache();
        $NotificationModel = new Notification();

        $souTacheModel->where('id_tache', $id_tache)->delete();
        $NotificationModel->where('id_tache', $id_tache)->delete();
        $tacheModel->where('id_tache', $id_tache)->delete();
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été supprimer une Tâche');
        return redirect()->to('taches');
    }

    public function exportToExcel()
    {

        $modelTache = new Tache;
        $listes_t = $modelTache->join('employee', 'tache.id_emp = employee.id_emp')->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(100);
        $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->setCellValue('A1', 'Employé');
        $sheet->setCellValue('B1', 'Date Début');
        $sheet->setCellValue('C1', 'Date Fin');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Etat');

        $row = 2;
        foreach ($listes_t as $tache) {
            $sheet->setCellValue('A' . $row, $tache['nom'] . ' ' . $tache['prenom']);
            $sheet->setCellValue('B' . $row, $tache['date_debutT']);
            $sheet->setCellValue('C' . $row, $tache['date_fin']);
            $sheet->setCellValue('D' . $row, $tache['description']);
            $sheet->setCellValue('E' . $row, $tache['statut']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'liste_employes.xlsx';
        $path = WRITEPATH . 'uploads/' . $filename;
        $writer->save($path);

        return $this->response->download($path, null)->setFileName($filename);
    }

}