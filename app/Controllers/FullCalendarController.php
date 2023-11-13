<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FullCalendar;

class FullCalendarController extends BaseController
{
    private $event;

    public function __construct()
    {
        $this->event = new FullCalendar();
    }

    public function index()
    {
       
            if($this->request->isAjax()) {
                $data = $this->event->getEvent(
                    $this->request->getVar('start_event'),
                    $this->request->getVar('end_event')
                );
                return $this->respond($data);
            }
            return view('pages/calendar/Callendrier');
       
    }

    public function create()
    {
            if(session()->has('role')){
                if(session('role') == 'admin'){
                    try {
                
                        $title = $this->request->getPost('title');
                        $start = $this->request->getPost('start');
                        $end = $this->request->getPost('end');
                        $data = [
                            'titre' => $title,
                            'start_event' => $start,
                            'end_event' => $end,
                        ];
                        $this->event->insert($data);
            
                        $insertedId = $this->event->getInsertID();
            
                        $response = [
                            'id_calendar' => $insertedId,
                            'titre' => $title,
                            'start_event' => $start,
                            'end_event' => $end,
                        ];
            
                        return $this->response->setJSON($response);
                    } catch (\Exception $e) {
                        log_message('error', 'Error in create method: ' . $e->getMessage());
                        return $this->response->setStatusCode(500)->setJSON(['error' => 'Internal Server Error']);
                    }
                }else{
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => "Tu ne pas Le droit De créer Un événement , Veuillez Vous pouvez le commander auprès d'administrateur",
                    ]);
                }

            }else{
                session()->setFlashData("error", "Vous devez être connecté pour acceder à cette page");
                return redirect()->to('login');
            }

        
    }



    public function update($id)
    {
        

            $title = $this->request->getPost('title');
            $start = $this->request->getPost('start');
            $end = $this->request->getPost('end');
            var_dump(['title' => $title, 'start' => $start, 'end' => $end, 'id_calendar' => $id]);

            if ($title !== null && $start !== null && $end !== null) {
                $data = [
                    'titre' => $title,
                    'start_event' => $start,
                    'end_event' => $end,
                ];

                $updated = $this->event->update($id, $data);

                if ($updated) {
                    $session = session();
                    $session->setFlashdata('success', 'calendrier a ete modifie.'); 
                    return redirect()->to('fullcalendar'); 
                } else {
                
                    $session = session();
                    $session->setFlashdata('error', 'calendrier a non modifie.'); 
                    return redirect()->to('fullcalendar'); 
                }
            } else {
                $session = session();
                $session->setFlashdata('error', 'Employé non trouvé.'); 
                return redirect()->to('fullcalendar'); 
            }
        
    }


    

    public function delete($id_calendar)
    {
    
            $result = $this->event->delete($id_calendar);
        
            if ($result) {
                $response = ['status' => 'success'];
            } else {
                $response = ['status' => 'error'];
            }
        
            return $this->response->setJSON($response);
    
    }



    public function load()
    {
    
        $events = $this->event->findAll();
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id_calendar' => $event['id_calendar'],
                'title' => $event['titre'],
                'start' => $event['start_event'],
                'end' => $event['end_event'],
            ];
        }
        return $this->response->setJSON($data);
    }

}
