<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
header('Access-Control-Allow-Origin: *');

class InvitesController extends AppController {

    public $components = array('Session', 'Flash', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_groupchat', 'api_chatview', 'api_invitefrd', 'api_accpect', 'api_reject', 'api_addtofavourite', 'api_attendese');
    }

    public function api_invitefrd() {
        $this->loadModel('Trip');
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            $frd_id = $this->request->data['frd_id'];
            $trip_id = $this->request->data['trip_id'];
            $id = $this->User->find('first', array('conditions' => array('User.id' => $frd_id)));

            if ($id['User']['tokenid']) {
                //$userss = $this->User->find('first', array('conditions' => array('User.id' => $frd_id)));
                $trip = $this->Trip->find('first', array('conditions' => array('Trip.id' => $trip_id)));
                $title = 'Invitation For Trip';
                $token = $id['User']['tokenid'];
                $message = 'You have invitation for a trip.';
                //$body = 'Start date: ' . $trip['Trip']['trip_startdate'] . ', End date: ' . $trip['Trip']['trip_enddate'] . ',Start location: ' . $trip['Trip']['start_location']. ',End location: ' . $trip['Trip']['end_location']. ',Trip_id: ' . $trip_id;
                $body = "You have invitation for a trip.";
                $this->sendNewnotificationPush($token, $message, $body, $title, $trip_id);
                $this->Invite->create();
                $savedata = $this->Invite->save($this->request->data);
                $response['status'] = '0';
                $response['msg'] = 'Invite has been sent';
            } else {
                $response['msg'] = 'Invite has not been sent';
                $response['status'] = '1';
            }
        } else {
            $response['msg'] = 'Something going wrong';
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function sendNewnotificationPush($token, $message, $body, $title, $trip_id) {

        Configure::write("debug", 0);

        $ch = curl_init("https://fcm.googleapis.com/fcm/send");

        $notification = array('title' => $title, 'trip_id' => $trip_id, 'message' => $message, 'body' => $body, 'vibrate' => true, "click_action" => "FCM_PLUGIN_ACTIVITY", 'sound' => true, 'content-available' => '1', 'priority' => 'high'
        );
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => array('data' => $page, 'title' => $title, 'trip_id' => $trip_id, 'message' => $message, 'body' => $body));
        $json = json_encode($arrayToSend);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key= AIzaSyCuRTm8yNimL-qAGPLCrOXdq4qoY_DJsHI';


        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        //echo '<pre>'; print_r($ch); echo '</pre>'; die;  
        curl_close($ch);
        return "ok";
    }

    public function api_accpect() {


        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            $trip_id = $this->request->data['trip_id'];
            //$status = 1;
            // print_r($this->request->data);die;
            if ($user_id) {
                $update = $this->Invite->updateAll(array('Invite.status' => 1), array('Invite.trip_id' => $trip_id));


                $response['msg'] = 'User accepted invitation';
                $response['status'] = 0;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Error';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Some thing going wronge';
        }
        echo json_encode($response);
        exit;
    }

    public function api_reject() {

        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            $trip_id = $this->request->data['trip_id'];
            $status = 0;
            if ($user_id) {
                $update = $this->Invite->updateAll(array('Invite.status' => $status), array('Invite.trip_id' => $trip_id));
                $response['msg'] = 'User reject trip invitation';
                $response['status'] = 0;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Error';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something going wronge';
        }
        echo json_encode($response);
        exit;
    }

    ///////////////////////////////////////////////////////////////User Group Chat /////////////////////////////////////////////////////
    public function api_groupchat() {
        $this->loadModel('Groupchat');
        if ($this->request->is('post')) {
            $trip_id = $this->request->data['trip_id'];
            $sender_id = $this->request->data['sender_id']; //userid
            $message = $this->request->data['message'];
            $type = $this->request->data['type'];

            if ($trip_id) {
                if ($type == "text") {
                    $this->Groupchat->create();
                    $this->Groupchat->save($this->request->data);
                    $response['msg'] = "Message send sucessfully";
                    $response['status'] = 0;
                } else {
                    
                    $img = base64_decode($message);
                    $im = imagecreatefromstring($img);
                    if ($im !== false) {
                        $image = "1" . time() . ".png";
                        imagepng($im, WWW_ROOT . "files" . DS . "chatimage" . DS . $image);
                        imagedestroy($im);
                        $response['msg'] = "image is uploaded";
                        $message = FULL_BASE_URL . $this->webroot . "files/chatimage/" . $image;
                        //echo 'image name' . $image;
                        //$data = $this->Groupchat->updateAll(array('image' => "'$image'"), array('Groupchat.trip_id' => $trip_id));
                        $this->request->data['Groupchat']['message'] = $image;
                        $this->request->data['Groupchat']['trip_id'] = $trip_id;
                        $this->request->data['Groupchat']['type'] = $type;
                        $this->request->data['Groupchat']['sender_id'] = $sender_id;
                        $data = $this->Groupchat->find('all', array('conditions' => array('Groupchat.trip_id' => $trip_id)));
                        $gallery_items = array();
                        foreach ($data as $gallery){
                          $gallery['Groupchat']['message'] = FULL_BASE_URL . $this->webroot . "files/chatimage/" .$gallery['Groupchat']['message']; 
                          $gallery_items[]=  $gallery;
                        }
                        $this->Groupchat->create();
                        $this->Groupchat->save($this->request->data);
                        if ($data) {
                           
                            $response['data'] = $gallery;
                            $response['status'] = 0;
                            $response['isSucess'] = 'true';
                        }
                    } else {
                        $response['isSucess'] = 'false';
                        $response['msg'] = 'Image did not create';
                    }
                }
            } else {
                $response['msg'] = "something going wrong";
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = "something going wrong";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function api_chatview() {
        $this->loadModel('Groupchat');
        if ($this->request->is('post')) {
            $trip_id = $_POST['trip_id'];
            $user_id = $_POST['user_id'];
            $data = $this->Groupchat->find('all', array('conditions' => array('AND' => array('Groupchat.trip_id' => $trip_id)), 'order' => array('Groupchat.id' => 'asc')));
     
      
            
            for($i = 0; $i<count($data); $i++){
                
                if($data[$i]['Groupchat']['type'] == 'image'){
                    
                    $data[$i]['Groupchat']['message'] = FULL_BASE_URL . $this->webroot . "files/chatimage/" .$data[$i]['Groupchat']['message'];
                    $data[$i]['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" .$data[$i]['User']['image'];
                   
                    
                }
                
            }
              for($i = 0; $i<count($data); $i++){
                  if( $data[$i]['User']['image'] == null){
                     $data[$i]['User']['image'] = null ;
                  }else{
                       $data[$i]['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" .$data[$i]['User']['image'];
                  } 
                  
                  }

            if ($data) {
                $response['data'] = $data;
                $response['msg'] = "Success";
                $response['status'] = 0;
            } else {

                $response['msg'] = "User chat";
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = "Something going wrong";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function api_addtofavourite() {
        configure::write('debug', 0);
        $this->loadModel("Chat_favourite");
        $this->loadModel("Groupchat");
        $user_id = $this->request->data['user_id'];
        $msg_id = $this->request->data['msg_id'];
        //$status =  $this->request->data['status'];
        $msgs = $this->Chat_favourite->find('first', array('conditions' => array('Chat_favourite.user_id' => $userid, 'Chat_favourite.msg_id' => $msg_id)));

        if ($msgs) {

            $id = $msgs['Chat_favourite']['id'];
            $update = $this->Groupchat->updateAll(array('Groupchat.status' => 0), array('Groupchat.id' => $msg_id));
            $this->Chat_favourite->delete($id);
            $response['status'] = 0;
            $response['bit'] = 1;
            $response['msg'] = 'Item successfully removed from My Favorites';
        } else {

            $this->request->data['Chat_favourite']['msg_id'] = $msg_id;
            $this->request->data['Chat_favourite']['user_id'] = $_POST['userid'];
            $this->request->data['Chat_favourite']['status'] = $status;
            $this->Chat_favourite->create();
            $savedata = $this->Chat_favourite->save($this->request->data);
            $update = $this->Groupchat->updateAll(array('Groupchat.status' => 1), array('Groupchat.id' => $msg_id));
            $response['status'] = 0;
            $response['bit'] = 0;
            $response['data'] = $savedata;
            $response['msg'] = 'Item successfully added to My Favorites';
        }

        echo json_encode($response);
        exit;
    }

    public function api_attendese() {
        if ($this->request->is('post')) {
            $trip_id = $_POST['trip_id'];

            $invite = $this->Invite->find('all', array('conditions' => array('Invite.trip_id' => $trip_id, 'Invite.status' => 1)));
           //print_r($invite);die;
     
        $gallery_items = array();
                foreach ($invite as $gallery) {
                    if (!filter_var($gallery['User']['image'], FILTER_VALIDATE_URL) === false) {
                                $gallery['User']['image'] = $gallery['User']['image'];
                        }else{
                                if($gallery['User']['image'] != ''){
                                        $gallery['User']['image'] = FULL_BASE_URL . $this->webroot . 'files/profile_pic/' . $gallery['User']['image'];
                                }else{
                                        $gallery['User']['image'] = null;
                                }
                        }
                   
                    $gallery_items[] = $gallery;
                } 
            if ($gallery) {
                $response['data'] = $gallery_items;
                $response['msg'] = "Success";
                $response['status'] = 0;
            } else {

                $response['msg'] = "No data available";
                $response['status'] = 1;
                $response['bit'] = 0;
            }
        } else {
            $response['msg'] = "Something going wrong";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

}

?>