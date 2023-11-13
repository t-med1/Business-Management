<?php

namespace App\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Tache;
use App\Models\SouTache;
use App\Models\Conge;
use App\Controllers\BaseController;
use App\Models\UserLogModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class EmployeesController extends BaseController
{
    private $emp_id;

    public function __construct()
    {
        $this->emp_id = session('id_employe');
    }

    public function index()
    {
        $id_emp = session('id_employe');
        $modelEmployee = new Employee;
        if (session()->has('role')) {
            if(session('role') == 'admin'){
                $listes_emp = $modelEmployee
                    ->select('employee.*, MAX(user_log.date_log) AS last_activity, MAX(user_log.description) AS description')
                    ->join('user_log', 'user_log.id_emp = employee.id_emp', 'left')
                    ->where('employee.id_emp != '.session('id_employe'))
                    ->groupBy('employee.id_emp')
                    ->orderBy('employee.id_emp', 'asc')
                    ->findAll();
                    // print_r($listes_emp);die();
                return view('pages/employe/liste', ['listes_emp' => $listes_emp ]);
            }else{
                $listes_emp = $modelEmployee->find($id_emp);
                return view('pages/employe/liste', ['listes_emp' => $listes_emp]);
            }
        } else {
            $session = session();
            $session->setFlashdata('error', "tu n'est pas connécté");
            return redirect()->back();
        }
    }

    public function create()
    {
        if (session('role') == 'admin') {
            $modelEmployee = new Employee;
            $employeeCode = $this->generateEmployeeCode($modelEmployee);
            return view('pages/employe/ajouter', ['employeeCode' => $employeeCode]);
        } else {
            $session = session();
            $session->setFlashdata('error', "tu n'est pas le droit de créer un nouveau Employé");
            return redirect()->back();
        }
    }

    public function store()
    {
        $modelEmployee = new Employee;

        $data = [
            'code_emp' => $this->generateEmployeeCode($modelEmployee),
            'nom' => $this->request->getVar('nom'),
            'prenom' => $this->request->getVar('prenom'),
            'telephone' => $this->request->getVar('telephone'),
            'email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
            'date_debut' => $this->request->getVar('date_debut'),
        ];
        // print_r($data);die();
        if ($data) {
            $modelEmployee->insert($data);
            $session = session();
            $session->setFlashdata('success', 'Employee a été ajouté avec succès.');
            return redirect()->to('Commeciale');
        } else {
            $session = session();
            $session->setFlashdata('error', 'Employee non ajouté !');
            return view('pages/employe/ajouter');
        }
    }

    private function generateEmployeeCode($modelEmployee)
    {
        $year = date('y');
        $newEmployeeCount = $modelEmployee->countAllResults() + 1;
        return "E-{$year}-" . str_pad($newEmployeeCount, 4, '0', STR_PAD_LEFT);
    }

    public function edit($id)
    {
        if ( session('role') == 'admin' || session('id_employe') == $id ) {
            $modelEmployee = new Employee;
            $data['employee'] = $modelEmployee->find($id);
            return view('pages/employe/modifier', $data);
        } else {
            $session = session();
            $session->setFlashdata('error', "tu n'est pas le droit d'editer cet employé(e)");
            return redirect()->back();
        }
    }
    public function update($id)
    {

        $modelEmployee = new Employee;
        $data = [
            'nom' => $this->request->getVar('nom'),
            'prenom' => $this->request->getVar('prenom'),
            'telephone' => $this->request->getVar('telephone'),
            'email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
            'date_debut' => $this->request->getVar('date_debut'),
        ];
        $modelEmployee->update($id, $data);
        if(session('role') !== 'admin'){
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été modifier ce Commerciale');
        }
        $session = session();
        $session->setFlashdata('success' , 'Employee modifié avec ssuccès.');
        return redirect()->to('Commeciale'        );
    }
    

    public function delete($id_emp)
    {
        $modelEmployee = new Employee();
        $modelTache = new Tache();
        $modelSouTache = new SouTache();
        $modelConge = new Conge();
        $modelClient = new Client();
        if(session('role') == 'admin'){
            $employee = $modelEmployee->find($id_emp);
            if (!$employee) {
                return redirect()->back()->with('error', 'Employé non trouvé.');
            }
            $modelConge->where('id_emp', $id_emp)->delete();
            $taches = $modelTache->where('id_emp', $id_emp)->findAll();
            foreach ($taches as $tache) {
                $sousTaches = $modelSouTache->where('id_tache', $tache['id_tache'])->findAll();
                foreach ($sousTaches as $souTache) {
                    $modelSouTache->delete($souTache['id_sou_tache']);
                }
                $modelTache->delete($tache['id_tache']);
            }
            // Supprimer les clients associés à l'employé
            $clients = $modelClient->where('id_emp', $id_emp)->findAll();
            foreach ($clients as $client) {
                $modelClient->delete($client['id_client']);
            }
            $modelEmployee->delete($id_emp);
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, 'a été supprimer Un Commerciale');
            return redirect()->back()->with('success', 'Employé supprimé avec succès et ses tâches, congés et clients associés.');
        }else{
            $session = session();
            $session->setFlashdata('error', "Tu n'est pas le droit de supprimer cet employé(e)");
            return redirect()->back();
        }
        
    }

    public function profile($id){
        if( session('id_employe') == $id){
            $modelEmployee = new Employee;
            $listes_emp = $modelEmployee->where('id_emp' , $id)->first();
            $ipAddress = $this->request->getIPAddress();
            log_activity($id, $ipAddress, 'a été entrer dans ce profil');
            return view('pages/profiles/information', ['listes_emp' => $listes_emp]);
        }else{
            $session = session();
            $session->setFlashdata('error', "Tu n'est pas Le droit d'entrer et de voir les informations de ce Profile");
            return redirect()->back();
        }
    }
    public function updateProfile($id)
    {
        if(session('id_employe') == $id){
            $modelEmployee = new Employee;
            $data = [
                'nom' => $this->request->getVar('nom'),
                'prenom' => $this->request->getVar('prenom'),
                'telephone' => $this->request->getVar('telephone'),
                'email' => $this->request->getVar('email'),
                'role' => $this->request->getVar('role'),
                'date_debut' => $this->request->getVar('date_debut'),
            ];
            $modelEmployee->update($id, $data);
            $ipAddress = $this->request->getIPAddress();
            log_activity($id, $ipAddress, 'a été modifier ce profil');
            $session = session();
            $session->setFlashdata('success', 'Tu es modifié avec ssuccès.');
            return redirect()->to('profile/'.$id);
        }else {
            $session = session();
            $session->setFlashdata('error', "tu n'est pas Le Droit !");
            return redirect()->back('/login');
        }
    }
    public function getEmployeeInfo($code_emp)
    {
        $modelEmployee = new Employee;
        $employeeInfo = $modelEmployee->where('code_emp', $code_emp)->first();

        return $this->response->setJSON($employeeInfo)->setContentType('application/json');
    }

    public function show($id)
    {
        if ( session('role') == 'admin') {
            $modelEmployee = new Employee;
            $modelTache = new Tache;
            $logsModel = new UserLogModel();

            $data['employee'] = $modelEmployee->find($id);
            $data['taches'] = $modelTache->where('id_emp', $id)->findAll();
            $data['logs'] = $logsModel
                ->select('user_log.*, employee.nom, employee.prenom')
                ->join('employee', 'employee.id_emp = user_log.id_emp')
                ->where('user_log.id_emp', $id)
                ->orderBy('user_log.date_log', 'DESC')
                ->limit(10)
                ->get()
                ->getResultArray();
                
            // print_r($data['logs']);die();
        
        // print_r($data['logs']);die();
            $ipAddress = $this->request->getIPAddress();
            log_activity(session('id_employe'), $ipAddress, "a été afficher les informations d'un commerciale ");
            return view('pages/employe/details', $data);
        }else{
            $session = session();
            $session->setFlashdata('error', "Tu n'est pas le droit d'afficher les données de ce client");
            return redirect()->to('Commeciale');
        }
    }

    public function exportToExcel()
    {

        $modelEmployee = new Employee;
        $listes_emp = $modelEmployee->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->setCellValue('A1', 'Code Employé');
        $sheet->setCellValue('B1', 'Nom et Prénom');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Téléphone');
        $sheet->setCellValue('E1', 'Role');

        $row = 2;
        foreach ($listes_emp as $employee) {
            $sheet->setCellValue('A' . $row, $employee['code_emp']);
            $sheet->setCellValue('B' . $row, $employee['prenom'] . ' ' . $employee['nom']);
            $sheet->setCellValue('C' . $row, $employee['email']);
            $sheet->setCellValue('D' . $row, $employee['telephone']);
            $sheet->setCellValue('E' . $row, $employee['role']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'liste_employes.xlsx';
        $path = WRITEPATH . 'uploads/' . $filename;
        $writer->save($path);

        return $this->response->download($path, null)->setFileName($filename);
    }
    public function permission($id_emp){
        if ( session('role') == 'admin') {
            $modelEmployee = new Employee;

            $data['employee'] = $modelEmployee->find($id_emp);
            return view('pages/employe/permission' , $data);
        }else{
            session()->setFlashdata('error' , "Tu n'est pas connécté(e) !");
            return redirect()->to('/login');
        }
    }
}