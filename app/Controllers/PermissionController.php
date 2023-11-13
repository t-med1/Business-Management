<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class PermissionController extends BaseController
{
    public function updatePermission($id_emp , $nompage , $numeromethodod)
    {


        $permissionModel = new PermissionModel();
        // $id_emp = $this->request->getGet('id_emp');
        // $pageName = $this->request->getGet('pageNom');
        // $numeromethod = $this->request->getGet('numeroMethod');
        $permissionExists = $permissionModel->join('employee' , 'employee.id_emp = permissions.id_emp')
                                        ->where('permissions.nom_page' , $nompage)
                                        ->where('permissions.id_emp' , $id_emp)
                                        ->findAll();
        $ReadpersimmionExists = $permissionModel->join('employee' , 'employee.id_emp = permissions.id_emp')
                                    ->where('permissions.can_read' , 1)
                                    ->where('permissions.nom_page' , $nompage)
                                    ->where('permissions.id_emp' , $id_emp)
                                    ->findAll();
        $AddpersimmionExists = $permissionModel->join('employee' , 'employee.id_emp = permissions.id_emp')
                                    ->where('permissions.can_add' , 1)
                                    ->where('permissions.nom_page' , $nompage)
                                    ->where('permissions.id_emp' , $id_emp)
                                    ->findAll();
        $UpdatepersimmionExists = $permissionModel->join('employee' , 'employee.id_emp = permissions.id_emp')
                                    ->where('permissions.can_update' , 1)
                                    ->where('permissions.nom_page' , $nompage)
                                    ->where('permissions.id_emp' , $id_emp)
                                    ->findAll();
        $DeletepersimmionExists = $permissionModel->join('employee' , 'employee.id_emp = permissions.id_emp')
                                    ->where('permissions.can_delete' , 1)
                                    ->where('permissions.nom_page' , $nompage)
                                    ->where('permissions.id_emp' , $id_emp)
                                    ->findAll();

        switch ($numeromethodod) {
            case $numeromethodod == 1:
                if($permissionExists && $ReadpersimmionExists) {
                    $permissionModel->set('can_read' , 0)
                                    ->where('nom_page' , $nompage)
                                    ->where('id_emp' , $id_emp)
                                    ->update();
                }else{
                    $permissionModel->insert(
                        [
                            'id_emp'=>$id_emp,
                            'nom_page'=>$nompage,
                            'can_read'=>1
                        ]
                    );
                }
                break;
            case $numeromethodod == 2 :
                if($permissionExists && $AddpersimmionExists){
                        $permissionModel
                                        ->where('nom_page' , $nompage)
                                        ->where('id_emp' , $id_emp)
                                        ->set('can_add' , 0)
                                        ->update();
                }else{
                    $permissionModel->insert(
                        [
                            'id_emp'=>$id_emp,
                            'nom_page'=>$nompage,
                            'can_add'=>1
                        ]
                    );
                }
                break;
            case $numeromethodod == 3 :
                if($permissionExists){
                    $permissionModel->set('can_update' , 1)
                                    ->where('nom_page' , $nompage)
                                    ->where('id_emp' , $id_emp)
                                    ->update();
                }else{
                    $permissionModel->insert(
                        [
                            'id_emp'=>$id_emp,
                            'nom_page'=>$nompage,
                            'can_update'=>1
                        ]
                    );
                }
                break;
            case $numeromethodod == 4 :
                if($permissionExists && $DeletepersimmionExists){
                    $permissionModel->set('can_delete' , 0)
                                    ->where('nom_page' , $nompage)
                                    ->where('id_emp' , $id_emp)
                                    ->update();
                }else{
                    $permissionModel->insert(
                        [
                            'id_emp'=>$id_emp,
                            'nom_page'=>$nompage,
                            'can_delete'=>1
                        ]
                    );
                }
                break;
            default:
                echo "Waaaaaalo";
                break;
        }
            $message = "Permissions updated successfully."; // Modify this message as needed

            // Prepare a response array
            $response = [
                'success' => true, // You can set this to false if there was an error
                'message' => $message,
            ];
            return $this->response->setJSON($response);
        // print_r($pageName);die();
    }
}
