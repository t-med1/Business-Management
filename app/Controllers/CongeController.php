<?php

namespace App\Controllers;

use App\Models\Tache;
use DateTime;
use App\Models\Conge;
use App\Models\Employee;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CongeController extends BaseController
{
    private $emp_id;

    public function __construct()
    {
        $this->emp_id = session('id_employe');
    }
    public function index()
    {
        $modelConge = new Conge;

        // if (session()->has('id_employe')) {
        //     $listes_conge = $modelConge->join('employee', 'conge.id_emp = employee.id_emp')->where('employee.id_emp', $this->emp_id)->findAll();
        //     $groupedConges = [];
        //     foreach ($listes_conge as $conge) {
        //         $employeeId = $conge['id_emp'];
        //         if (!isset($groupedConges[$employeeId])) {
        //             $groupedConges[$employeeId] = [];
        //         }
        //         $groupedConges[$employeeId][] = $conge;
        //     }
        //     return view("pages/conge/liste", ['groupedConges' => $groupedConges]);
        // } elseif (session()->has('nom_complet')) {
            $currentYear = date('Y');

            $listes_conge = $modelConge
                ->join('employee', 'conge.id_emp = employee.id_emp')
                ->where("YEAR(conge.date_fin) = $currentYear")
                ->findAll();
            $groupedConges = [];
            foreach ($listes_conge as $conge) {
                $employeeId = $conge['id_emp'];
                if (!isset($groupedConges[$employeeId])) {
                    $groupedConges[$employeeId] = [];
                }
                $groupedConges[$employeeId][] = $conge;
            }
            return view("pages/conge/liste", ['groupedConges' => $groupedConges]);
        // }
    }


    public function create()
    {
        // if (session()->has("nom_complet")) {
            $modelEmployee = new Employee;
            $employeeData = $modelEmployee->findAll();
            return view("pages/conge/ajouter", ['employeeData' => $employeeData]);
        // } else {
        //     $session = session();
        //     $session->setFlashdata('error', "tu n'est pas le droit de créer un congé");
        //     return redirect()->back();
        // }
    }

    public function store()
    {
        $modelConge = new Conge;
        $selectedCode = $this->request->getVar('nom');
        // $session = session();
        // if ($session->has('nom_complet')) {
            $modelEmployee = new Employee;
            $employeeInfo = $modelEmployee->where('nom', $selectedCode)->first();
            $dateDebut = strtotime($this->request->getVar('date_debutC'));
            $dateFin = strtotime($this->request->getVar('date_fin'));
            if ($dateDebut < $dateFin) {
                if ($employeeInfo) {
                    $data = [
                        'date_debutC' => $this->request->getVar('date_debutC'),
                        'date_fin' => $this->request->getVar('date_fin'),
                        'id_emp' => $employeeInfo['id_emp'],
                    ];
                    $modelConge->insert($data);
                    $session = session();
                    $session->setFlashdata('success', 'Conge ajoutée avec succès.');
                    return redirect()->to('conge');
                } else {
                    $session = session();
                    $session->setFlashdata('error', 'Employé non trouvé.');
                    return redirect()->to('conge');
                }
            } else {
                $session = session();
                $session->setFlashdata('error', 'La date de début doit être antérieure à la date de fin.');
                return redirect()->to('/conge/ajouter');
            }
        // } else {
        //     $data['validation'] = "tu n'est pas connecté";
        //     return view('login', $data);
        // }
    }

    public function edit($id)
    {
        // $session = session();
        // if ($session->has('nom_complet')) {
            $modelConge = new Conge;
            $conge = $modelConge->find($id);

            $modelEmployee = new Employee;
            $employee = $modelEmployee->find($conge['id_emp']);

            // Retrieve all "congés" records for the employee
            $conges = $modelConge->where('id_emp', $employee['id_emp'])->findAll();

            $data = [
                'conge' => $conge,
                'employee' => $employee,
                'conges' => $conges,
            ];

            return view('pages/conge/modifier', $data);
        // } else {
        //     $session = session();
        //     $session->setFlashdata('error', "Vous n'êtes pas autorisé à éditer un congé.");
        //     return redirect()->back();
        // }
    }


    public function update($id)
    {
        // if (session()->has("nom_complet")) {
            $modelConge = new Conge;

            $data = [
                'date_debutC' => $this->request->getPost('date_debutC'),
                'date_fin' => $this->request->getPost('date_fin'),
                'description' => $this->request->getPost('description'),

            ];

            $modelConge->update($id, $data);
            return redirect()->to('conge');
        // } else {
        //     $session = session();
        //     $session->setFlashdata('error', 'La date de début doit être antérieure à la date de fin.');
        // }
    }


    public function show($id)
    {
        $modelConge = new Conge;
        $modelEmployee = new Employee;
        // if (session()->has('nom')) {
        //     if ($this->emp_id) {
        //         $data['conge'] = $modelConge->find($id);
        //         $id_emp = $data['conge']['id_emp'];
        //         $data['employee'] = $modelEmployee->find($id_emp);
        //         $sql = "SELECT id_emp, COUNT(id_conge) AS nombre_conges FROM conge WHERE id_emp = $id_emp GROUP BY id_emp";
        //         $congesCount = $modelConge->query($sql)->getRow();

        //         $data['conges'] = $modelConge->where('id_emp', $id_emp)->findAll();
        //         $data['congesCount'] = $congesCount->nombre_conges;

        //         return view('pages/conge/detail', $data);
        //     } else {
        //         $session = session();
        //         $session->setFlashdata('error', "tu n'est pas le droit d'afficher les infos de ce congé");
        //         redirect()->back();
        //     }
        // } elseif (session()->has("nom_complet")) {
            $data['conge'] = $modelConge->find($id);
            $id_emp = $data['conge']['id_emp'];
            $data['employee'] = $modelEmployee->find($id_emp);
            $sql = "SELECT id_emp, COUNT(id_conge) AS nombre_conges FROM conge WHERE id_emp = $id_emp GROUP BY id_emp";
            $congesCount = $modelConge->query($sql)->getRow();

            $data['conges'] = $modelConge->where('id_emp', $id_emp)->findAll();
            $data['congesCount'] = $congesCount->nombre_conges;

            return view('pages/conge/detail', $data);
        // }
    }


    public function delete($id_conge)
    {
        $modelConge = new Conge;
        $modelConge->where('id_conge', $id_conge)->delete();
        return redirect()->back()->with('success', 'Conge supprimé avec succès');
    }

    public function exportToExcel()
    {

        $modelConge = new Conge;
        $listes_conge = $modelConge->join('employee', 'conge.id_emp = employee.id_emp')->findAll();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('k')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);

        $sheet->setCellValue('A1', 'Nom Employé');
        $sheet->setCellValue('B1', 'Janvier');
        $sheet->setCellValue('C1', 'Février');
        $sheet->setCellValue('D1', 'Mars');
        $sheet->setCellValue('E1', 'Avril');
        $sheet->setCellValue('F1', 'Mai');
        $sheet->setCellValue('G1', 'Juin');
        $sheet->setCellValue('H1', 'Juiellet');
        $sheet->setCellValue('I1', 'Août');
        $sheet->setCellValue('J1', 'Septembre');
        $sheet->setCellValue('K1', 'Octobre');
        $sheet->setCellValue('L1', 'Novembre');
        $sheet->setCellValue('M1', 'Décembre');

        $sheet->setCellValue('A1', 'Nom Employé');
        for ($month = 1; $month <= 12; $month++) {
            $sheet->setCellValueByColumnAndRow($month + 1, 1, date("F", mktime(0, 0, 0, $month, 1)));
        }

        $employeeConges = [];

        foreach ($listes_conge as $conge) {
            $employeeName = $conge['nom'] . ' ' . $conge['prenom'];
            $startDate = new DateTime($conge['date_fin']);
            $startMonth = $startDate->format('n');

            if (!isset($employeeConges[$employeeName])) {
                $employeeConges[$employeeName] = array_fill(1, 12, '');
            }

            $employeeConges[$employeeName][$startMonth] = '✔';
        }

        $row = 2;
        foreach ($employeeConges as $employeeName => $conges) {
            $sheet->setCellValue('A' . $row, $employeeName);
            foreach ($conges as $month => $congeSign) {
                $sheet->setCellValueByColumnAndRow($month + 1, $row, $congeSign);
            }
            $row++;
        }


        $writer = new Xlsx($spreadsheet);

        $filename = 'liste_employes.xlsx';
        $path = WRITEPATH . 'uploads/' . $filename;
        $writer->save($path);

        return $this->response->download($path, null)->setFileName($filename);
    }
}