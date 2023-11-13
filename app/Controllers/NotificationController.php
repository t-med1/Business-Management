<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Notification;
use App\Models\Tache;
use CodeIgniter\Database\Exceptions\DatabaseException;

class NotificationController extends BaseController
{
    private $emp_id;

    public function __construct()
    {
        $session = session();
        if ($session->has('id_employe')) {
            $this->emp_id = $session->get('id_employe');
        }
    }

    public function index()
    {
        $session = session();
        if ($session->has('nom_complet') || $session->has('id_employe')) {
            $modelTache = new Tache;
            $notificationModel = new Notification;

            if ($session->has('id_employe')) {
                $tachesNonLues = $modelTache
                    ->select('tache.description')
                    ->join('notifications', 'tache.id_tache = notifications.id_tache')
                    ->where('tache.id_emp', $this->emp_id)
                    ->where('notifications.is_read', 0)
                    ->findAll();

                return view('votre_vue', ['tachesNonLues' => $tachesNonLues]);
            } else {
                $data['validation'] = "Tu n'es pas connecté";
                return view('login', $data);
            }
        }
    }


    public function markAsRead($notificationId)
    {
        $notificationModel = new Notification;
        $notification = $notificationModel->find($notificationId);

        if ($notification) {
            // Mettre à jour le champ is_read à 1 pour marquer la notification comme lue
            $notificationModel->update($notificationId, ['is_read' => 1]);
            return redirect()->to('notifications');
        } else {
            $session = session();
            $session->setFlashdata('error', 'La notification n\'existe pas.');
            return redirect()->to('notifications');
        }
    }
    
    public function SeenNotifications()
{
    $notificationModel = new Notification();

    try {
        // Check if there are unseen notifications
        $unseenNotificationsExist = $notificationModel->where('showin', 'unseen')->countAllResults() > 0;

        if ($unseenNotificationsExist) {
            $currentDateTime = date('Y-m-d H:i:s');

            // Build and execute the update query
            $builder = $notificationModel->builder();
            $builder->where('created_at <=', $currentDateTime);
            $builder->set('showin', 'seen');
            $builder->update();

            // Log the SQL query
            $query = $builder->getCompiledUpdate();
            log_message('debug', 'Update Query: ' . $query);
        }

        return redirect()->to('/taches');
    } catch (DatabaseException $e) {
        // Handle the exception
        log_message('error', 'DatabaseException: ' . $e->getMessage());
        return redirect()->to('/taches'); // Redirect in case of an error as well
    }
}





    


    public function markTaskAsRead($taskId)
    {
        $tacheModel = new Tache;
        $task = $tacheModel->find($taskId);

        if ($task) {
            $dataToUpdate = ['is_read' => 1];

            $tacheModel->update($taskId, $dataToUpdate);

            return redirect()->to('taches');
        } else {
            $session = session();
            $session->setFlashdata('error', 'La tâche n\'existe pas.');
            return redirect()->to('taches');
        }
    }



}
