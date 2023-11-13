<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin;
use App\Models\Employee;

class AuthController extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
        $this->session = \Config\Services::session();
    }



    public function index()
    {
        $data['csrfToken'] = csrf_token();
        return view('login', $data);
    }
    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
    
        $userEmploye = new Employee();
        $userEmp = $userEmploye->where('nom', $email)->where('prenom', $password)->get()->getRowArray();
    
        $session = session();
        if(!$userEmp){
            $session = session();
            $session->setFlashdata('error', "Le Mot De Passe Ou L'email est Invalid !");
            return redirect()->to('/login');
        }
        else{
            $ipAddress = $this->request->getIPAddress();
            $session->set('id_employe' , $userEmp['id_emp']);
            $session->set('nom' , $userEmp['nom']);
            $session->set('prenom' , $userEmp['prenom']);
            $session->set('role' , $userEmp['role']);
            log_activity($userEmp['id_emp'], $ipAddress, 'Connexion');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'Déconnéxion');
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
