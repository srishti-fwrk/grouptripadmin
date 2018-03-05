<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
header('Access-Control-Allow-Origin: *');

class BookingsController extends AppController {

    public $components = array('Session', 'Flash', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_booking','admin_booking','admin_view','admin_delete','api_userbooking','api_addevent');
    }
    
  
 public function api_booking(){
     if($this->request->is('post')){
         $user_id = $this->request->data['user_id'];
         $start_date = $this->request->data['start_date'];
         $last_date = $this->request->data['last_date'];
         $flight = $this->request->data['flight'];
         $children = $this->request->data['children'];
         $adult = $this->request->data['adult'];
         $hotel =$this->request->data['hotel'];
         $startlocation = $this->request->data['start_location'];
         $endlocation = $this->request->data['end_location'];
        
         if($user_id){
              
           $this->Booking->create();
           $savedata = $this->Booking->save($this->request->data);
           $updates = $this->Booking->getInsertID();        
           $usr_data = $this->Booking->find('first', array('conditions' => array('Booking.id' => $updates)));
            $response['msg']= "Booking for trip";
            $response['status']=0;
            $response['data'] = $usr_data;
             
             
         }else{
             $response['msg']="something went going wronge";
             $response['status'] = 1;
             
         }
     }else{
             $response['msg']="something went going wronge";
             $response['status'] = 1;
     }
           echo json_encode($response);
        exit;
 }
  public function admin_booking(){ //upcoming trip
         $this->Booking->recursive = 0;
        $this->set('bookings', $this->Paginator->paginate());
      
        //$this->set(compact(array('users')));
    }
    
    public function admin_view($id = null) {
        configure::write("debug", 0);
        $this->Booking->id = $id;
        if (!$this->Booking->exists()) {
            throw new NotFoundException('Invalid user');
        }
        $this->set('user', $this->Booking->read(null, $id));
    }
    public function admin_delete($id = null) {
        
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Booking->id = $id;
        if (!$this->Booking->exists()) {
            throw new NotFoundException('Invalid Booking');
        }
        if ($this->Booking->delete()) {
            $this->Session->setFlash('Booking deleted');
            return $this->redirect(array('action' => 'booking'));
        }
        $this->Session->setFlash('Something went wrong');
        return $this->redirect(array('action' => 'booking'));
    }
    
    public function api_userbooking(){ // upcoming booking
        if($this->request->is('post')){
            $id = $this->request->data['user_id']; 
            $all_boooking =  $this->Booking->find('all', array('conditions' => array('Booking.user_id' => $id)));
           if($id){
               $response['status'] =0;
               $response['data'] = $all_boooking;
               $response['msg'] = "Booking detail";
           }else{
                 $response['status'] =1;
                 $response['msg'] = "Something went going wronge";
           }
        }else{
             $response['status'] =1;
             $response['msg'] = "Something went going wronge";
        }
       
          echo json_encode($response);
        exit;
    }
    ///////////////////////////////Events/////////////////////////////////////////////
    public function api_addevent(){ 
        $this->loadModel("Event");
        if($this->request->is('post')){
            $id = $this->request->data['user_id'];
            $trip_id = $this->request->data['trip_id'];
            $event = $this->request->data['event'];
            $title = $this->request->data['title'];
            $d_add = $this->request->data['d_add'];
            $a_dd = $this->request->data['a_add'];
            $d_time = $this->request->data['d_time'];
            $a_time = $this->request->data['a_time']; 
            $note = $this->request->data['note'];
            if($id){
                $this->Event->create();
                $this->Event->save($this->request->data);
                $updates = $this->Event->getInsertID();
                $data = $this->Event->find('first', array('conditions' => array('Event.id' => $updates)));
                $response['msg'] = "Event add successfully";
                $response['status'] =0;
                $response['data'] =  $data;
                
                
            }else{
                $response['msg'] = "Something going wrong";
                 $response['status'] =1;
            }
      }else{
             $response['msg'] = "Something going wronge";
             $response['status'] =1;
        }
         echo json_encode($response);
        exit;
    }
    
    
    public function admin_event(){
        $this->Event->recursive = 0;
        $this->set('bookings', $this->Paginator->paginate());
    }
    
   

}