<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServiceModel;


class ServiceController extends BaseController
{
    public function liste(){
        if(session()->has('role')){
            $modelService = new ServiceModel ;
            return view('pages/services/liste', ['liste' =>$modelService ->findAll()]);
        }else{
            $session = session();
            $session->setFlashdata('error', "Tu n'est pas connéctée");
            return redirect() ->to('/login');
        }
    }
    private function generatedServiceCode($modelservice)
    {
        $year = date('y');
        $newserviceCount = $modelservice->countAllResults() + 1;
        return "S-{$year}-" . str_pad($newserviceCount, 4, '0', STR_PAD_LEFT);
    }
    public function index()
    {
        if(session('role') == 'assistante commerciale ' || session('role') == 'admin'){
            $modelService = new ServiceModel();
            $serviceCode = $this->generatedServiceCode($modelService);
            // print_r($serviceCode);die();
            return view('pages/services/ajouter', ['serviceCode' => $serviceCode]);
        }else{
            $session = session();
            $session->setFlashdata('error', "Tu n'est Le droit d'ajouter un nouveau service");
            return redirect()->back();
        }
    }

    public function store()
    {
        $modelService =new ServiceModel ;
        $data =[
            'code_service'=> $this->request->getVar('code_service'),
            'titre'=> $this->request->getVar('titre'),
            'prix_unitaire'=> $this->request->getVar('prix_unitaire'),
       ];
       $modelService->insert($data);
        $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été ajouter un service');
        $session = session();
        $session->setFlashdata('success', 'Service Ajouté avec succès.');
        return redirect()->to('/service');
    }

    

    public function edit($id)
    {
        if(session('role') == 'admin' || session('role') == 'assistante commerciale'){
            $modelService = new ServiceModel;
            $data['service'] = $modelService->find($id);
            return view('pages/services/modifier', $data);
        }else{
            $session = session();
            $session->setFlashdata('error', "tu n'est pas le droit d'editer ce service! ");
            return redirect()->back();
        }
    }

    public function update($id )
    {
        $modelService = new ServiceModel;
        $data =[
            'id_client'=> $this->request->getVar('id_client'),
            'titre'=> $this->request->getVar('titre'),
            'prix_unitaire'=> $this->request->getVar('prix_unitaire'),
       ];
       $modelService->update($id , $data);
       $ipAddress = $this->request->getIPAddress();
        log_activity(session('id_employe'), $ipAddress, 'a été modifier un service');
       $session = session();
       $session->setFlashdata('success', 'Données Modifiées avec succès.');
       return redirect()->to('/service');
    }
}
