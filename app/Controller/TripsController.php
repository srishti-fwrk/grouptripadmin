<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
header('Access-Control-Allow-Origin: *');

class TripsController extends AppController {

    public $components = array('Session', 'Flash', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_tripadd', 'api_upcomingtrip', 'admin_edit', 'api_singletrip', 'admin_tripgallery','admin_view','admin_deleteimage',
                'api_edittrip','api_tripimage','api_pasttrip','api_tripcount','api_step1','api_step2','api_step3','api_step4','api_step5','api_step6','api_writefile','api_recenttravelfrd');
    }

    public function api_tripadd() {

        $this->request->data['Trip']['user_id'] = $this->request->data['user_id']; //userid
        $this->request->data['Trip']['trip_startdate'] = $this->request->data['trip_startdate'];
        $this->request->data['Trip']['trip_enddate'] = $this->request->data['trip_enddate'];
        $this->request->data['Trip']['start_location'] = $this->request->data['start_location'];
        $this->request->data['Trip']['end_location'] = $this->request->data['end_location'];
        $this->request->data['Trip']['latitude'] = $this->request->data['start_lat'];
        $this->request->data['Trip']['longitude'] = $this->request->data['start_long'];
        $this->request->data['Trip']['end_lat'] = $this->request->data['end_lat'];
        $this->request->data['Trip']['end_long'] = $this->request->data['end_long'];
        if ($this->request->is('post')) {

            if (!empty($this->request->data['user_id'])) {
                $this->Trip->create();
                $savedata = $this->Trip->save($this->request->data);
//                $trip = $this->Trip->getInsertID();
//                $trip_data = $this->Trip->find('first', array('conditions' => array('Trip.user_id' => $this->request->data['user_id'])));
                $response['data'] = $savedata;
                $response['msg'] = 'Trip added successfully';
                $response['status'] = 0;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'something going wrongg';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something going wrong';
        }

        echo json_encode($response);
        exit;
    }
    
    
        public function api_edittrip() {
        configure::write('debug', 0);
        if($this->request->is('post')){
          
            $id = $this->request->data['id']; //userid
            $trip_startdate = $this->request->data['trip_startdate'];
            $trip_enddate = $this->request->data['trip_enddate'];
            $start_location = $this->request->data['start_location'];
            $end_location = $this->request->data['end_location'];
            $latitude = $this->request->data['start_lat'];
            $longitude= $this->request->data['start_long'];
            $end_lat = $this->request->data['end_lat'];
            $end_long = $this->request->data['end_long'];
           // print_r($this->request->data);die;
        if($id){
           $data = $this->Trip->updateAll(array('Trip.trip_startdate' => "' $trip_startdate'", 'Trip.trip_enddate' => "'$trip_enddate'",'Trip.start_location' => "' $start_location'",
            'Trip.end_location' => "'$end_location'",'Trip.latitude' => "'$latitude'",'Trip.longitude' => "'$longitude'",'Trip.end_lat' => "'$end_lat'",'Trip.end_long' => "'$end_long'"), array('Trip.id' =>  $id ));
          $updatedata = $this->Trip->find('first', array('conditions' => array('Trip.id' => $id)));
          
        if ($updatedata) {
            $response['data'] =  $updatedata;
            $response['status'] = 0;
            $response['msg'] = 'Trip Updated Successfully';
        }
        else{
            $response['status'] = 1;
            $response['msg'] = 'No Data Available';
         
        }   
        }else{
            $response['status'] = 1;
            $response['msg'] = 'No Data Available';
          
        }
        
        }else{
            $response['status'] = 1;
            $response['msg'] = 'Something going wronge';
           
        }
              
        echo json_encode($response);
        exit;
    }


    public function admin_trip() {
        $trip = $this->Trip->find('all', array('conditions' => array('Trip.status' => '0')));
        $this->set('trip', $trip);
        //debug($trip);die;
    }

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Trip->id = $id;
        if (!$this->Trip->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->Trip->delete()) {
            $this->Session->setFlash('Deleted');
            return $this->redirect(array('action' => 'trip'));
        }
        $this->Session->setFlash('Something went going wrong');
        return $this->redirect(array('action' => 'trip'));
    }

    public function admin_edit($id = NULL) {

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Trip']['modified'] = date('Y-m-d H:i:s');
            $this->Trip->id = $id;

            if ($this->Trip->save($this->request->data)) {
                $this->Session->setFlash('The booking  has been saved');
                return $this->redirect(array('action' => 'trip'));
            } else {
                $this->Session->setFlash('There is some error saving booking');
                return $this->redirect(array('action' => 'trip'));
            }
        } else {
            $options = array('conditions' => array('Trip.' . $this->Trip->primaryKey => $id));
            $this->request->data = $this->Trip->find('first', $options);
            $users = $this->Trip->User->find('list');
            $this->set('username', $users);
            //debug($users);die;
        }
    }

    public function api_singletrip() {
       
        if ($this->request->is('post')) {
            $id = $_POST['user_id'];
            $tripid = $_POST['tripid'];
        $tripdetail = $this->Trip->find('first', array('conditions' => array('Trip.id' => $tripid)));
        
          if($tripdetail['Trip']['image'] == null){
                     $tripdetail['Trip']['image'] = null; 
                }else{
                      $tripdetail['Trip']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" .$tripdetail['Trip']['image'];
                }
        
     
      
            if ($tripdetail) {
                $response['status'] = 0;
                $response['data'] = $tripdetail;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'No data available';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something going wrong!';
        }
        echo json_encode($response);
        exit;
    }

    public function admin_tripgallery($trip_id = null) {
        $this->loadModel('Gallery');
        $gallery = $this->Gallery->find('all', array('conditions' => array('Gallery.trip_id' => $trip_id)));
        $this->set('gallery',$gallery);
    
      
    }
    
     public function admin_view($id = null) {
     $trip = $this->Trip->find('first', array('conditions' => array('Trip.id' => $id),'recursive' => 2));
    //echo '<pre>';  print_r($trip);die;
        $this->set('trip', $trip);
    }
    
    
    public function admin_deleteimage($id = null,$trip = null){
       
         $this->loadModel('Gallery');
       
     
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Gallery->id = $id;
        if (!$this->Gallery->exists()) {
            throw new NotFoundException('Invalid image');
        }
        if ($this->Gallery->delete()) {
            $this->Session->setFlash('Image deleted');
            return $this->redirect(array('action' => 'tripgallery',$trip));
        }
        $this->Session->setFlash('Something went wrong');
        return $this->redirect(array('action' => 'tripgallery',$trip));
        
        
    }
    
    public function api_tripimage(){
           Configure::write('debug', 0);
        $one = $_POST['img'];
        $img = base64_decode($one);
       // echo $img;
        $im = imagecreatefromstring($img);
        if ($im !== false) {
            $image = "1" . time() . ".png";
            imagepng($im, WWW_ROOT . "files" . DS . "usergallery" . DS . $image);
            imagedestroy($im);
            $response['msg'] = "image is uploaded";
            $this->Trip->recursive = 2;
            $trip_id = $_POST['trip_id'];
            $img = FULL_BASE_URL . $this->webroot . "files/usergallery/" . $image;
            //echo 'image name' . $image;
            $data = $this->Trip->updateAll(array('image' => "'$image'"), array('Trip.id' => $trip_id));
            if ($data) {
                $response['img'] = $img;
                $response['data'] = $data;
                $response['error'] = 0;
                $response['isSucess'] = 'true';
            }
        } else {
            $response['isSucess'] = 'false';
            $response['msg'] = 'Image did not create';
        }
        //$this->layout = "ajax";
        //if (!empty($redata)) {
        //}
        echo json_encode($response);
        exit;
        
    }
   
    public function api_upcomingtrip() {
        $id = $this->request->data['id'];// logged in user
        //$id = 47;
        $status = 0;
        $currentdate = date("Y/m/d");
        $tripdata = array();
        $this->loadModel("Invite");
        if ($this->request->is('post')) {
            
            $this->Invite->recursive = 2;
            //$trip = $this->Invite->find('all', array('conditions' => array('AND'=>array('OR' => array('Invite.user_id' => $id, 'Invite.frd_id' => $id),'OR'=>array())),'group' => 'Invite.trip_id'));
           // print_r($trip);die;
           $trip = $this->Invite->query('SELECT * FROM invites invite RIGHT JOIN trips trip ON (invite.trip_id = trip.id) WHERE trip.user_id = '.$id.' OR invite.user_id = '.$id.' OR invite.frd_id = '.$id.' GROUP BY trip.id');
           //print_r($trip);die;
          $gallery_items = array();
         
          
            foreach ($trip as $gallery){
                if(strtotime($gallery['trip']['trip_enddate']) >= strtotime($currentdate)){
                 
                  if($gallery['trip']['image'] == null){
                       $gallery['trip']['image'] = null; 
                  }else{
                      $gallery['trip']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" .$gallery['trip']['image']; 
                  }

                  $gallery_items[]=  $gallery;
                }    
              }
          
            if ($gallery_items) {

                $response['status'] = 0;
                $response['data'] = $gallery_items;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'No trips added';
            }
        } else {
            $response['msg'] = 'Some thing going wrong';
            $response['status'] = 1;
        }
        
        //echo 'SELECT * FROM invites invite RIGHT JOIN trips trip ON (invite.trip_id = trip.id) WHERE trip.user_id = '.$id.' OR invite.user_id = '.$id.' OR invite.frd_id = '.$id.' GROUP BY trip.id LIMIT 0,10';
        echo json_encode($response);
        exit;
    } 
public function api_pasttrip(){
    if($this->request->is('post')){
        $user_id = $this->request->data['user_id'];
        if($user_id){
          $data = $this->Trip->query('SELECT * FROM invites invite RIGHT JOIN trips trip ON (invite.trip_id = trip.id) WHERE trip.user_id = '.$user_id.' OR invite.user_id = '.$user_id.' OR invite.frd_id = '.$user_id.' GROUP BY trip.id');
          
          $currentdate = date("Y/m/d");
          $trips = array();
          foreach($data as $pasttrip){
             // $pasttrip['trip']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" .$pasttrip['trip']['image'];
               if(strtotime($pasttrip['trip']['trip_enddate']) < strtotime($currentdate)){
                   if($pasttrip['trip']['image'] == null){
                       $pasttrip['trip']['image'] = null; 
                  }else{
                     $pasttrip['trip']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" .$pasttrip['trip']['image'];
                  }
                   
                 array_push($trips,$pasttrip);
             }
              
          }
         
        if($trips){
            $response['status'] = 0;
            $response['data'] = $trips; 
          }else{
             $response['status'] = 1;
            $response['msg'] = 'Sorry,there is no data'; 
          }
        }else{
            $response['status'] = 1;
            $response['msg'] = 'Something went wrong';
        }
    }else{
         $response['status'] = 1;
         $response['msg'] = 'Something went wrong';
    }
    echo json_encode($response);
        exit;
}
public function api_tripcount(){
    $this->loadModel("Invite");
    if($this->request->is('post')){
        $user_id = $this->request->data['user_id'];
        if($user_id){
            $count = $this->Trip->find('count',array('conditions'=>array('Trip.user_id'=>$user_id)));
            $data = $this->Invite->find('count',array('conditions'=>array('Invite.frd_id'=>$user_id,'Invite.status'=>1)));
            //print_r($data);die;
            $totaltrip = $count+$data;
            $response['status'] = 0;
            $response['data'] = $totaltrip;
            $response['msg'] = 'User trip count';
            
        }else{
             $response['status'] = 1;
             $response['msg'] = 'Something went wrong';
        }
    }else{
         $response['status'] = 1;
         $response['msg'] = 'Something went wrong';
    }
      echo json_encode($response);
        exit;
}


public function api_step1(){
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://shared-sandbox-api.marqeta.com/v3/cardproducts");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"start_date\": \"2016-01-01\",\n  \"name\": \"Example Card Product\",\n  \"config\": {\n    \"fulfillment\": {\n      \"payment_instrument\":\"VIRTUAL_PAN\"\n     },\n    \"poi\": {\n      \"ecommerce\": true\n    },\n    \"card_life_cycle\": {\n      \"activate_upon_issue\": true\n    }\n  }\n}");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD,  "user27811519650593" . ":" . "e3d323d1-0903-468c-aa1e-f62caf288ba1");

    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    print_r($result);die;
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
}

public function api_step2(){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://shared-sandbox-api.marqeta.com/v3/fundingsources/program");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"name\": \"Program Funding\" }");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "user27811519650593" . ":" . "e3d323d1-0903-468c-aa1e-f62caf288ba1");

    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    print_r($result);die;
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
}

public function api_step3(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://shared-sandbox-api.marqeta.com/v3/users");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"first_name\": \"Leonie\", \"last_name\": \"Crooks\", \"active\": true }");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "user27811519650593" . ":" . "e3d323d1-0903-468c-aa1e-f62caf288ba1");
    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    print_r($result);die;
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
    
       echo json_encode($response);
        exit;
}

public function api_step4(){
$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://shared-sandbox-api.marqeta.com/v3/cards?show_cvv_number=true&show_pan=true");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"user_token\": \"bfe98e29-33d3-4d3b-b1b3-0241506df607\",\"card_product_token\": \"beb89e28-7970-4a97-84ad-bd019dd54fd4\"}");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "user27811519650593" . ":" . "e3d323d1-0903-468c-aa1e-f62caf288ba1");

    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    print_r($result);die;
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
curl_close ($ch);
     echo json_encode($response);
        exit;
}
public function api_step5(){
  $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://shared-sandbox-api.marqeta.com/v3/gpaorders");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"user_token\": \"bfe98e29-33d3-4d3b-b1b3-0241506df607\",\"amount\": \"1000\", \"currency_code\": \"USD\",\"funding_source_token\": \"94976c40-ced4-4da1-bcac-2ad7b1c93fde\" }");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "user27811519650593" . ":" . "e3d323d1-0903-468c-aa1e-f62caf288ba1");

    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 
    $result = curl_exec($ch);
    print_r($result);die;
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);  
}

public function api_step6(){  //step4 token
  $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://shared-sandbox-api.marqeta.com/v3/simulate/authorization");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{     \"amount\": \"10\",     \"mid\": \"123456890\",     \"card_token\": \"32a414db-2be6-4618-9000-2cdef1567f7b\",     \"webhook\": {       \"endpoint\": \"http://rakesh.crystalbiltech.com/grouptrip/api/trips/writefile\",       \"username\": \"user27811519650593\",       \"password\": \"e3d323d1-0903-468c-aa1e-f62caf288ba1\"     } }");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "user27811519650593" . ":" . "e3d323d1-0903-468c-aa1e-f62caf288ba1");

    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    print_r($result);die;
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
}
public function api_writefile(){
    $data = $_REQUEST;
    $path = $_SERVER['DOCUMENT_ROOT'] . '/gurpreet.txt';
    $f = fopen($path, "a+");
    fwrite($f, print_r($data, TRUE));
    fclose($f);
    chmod($path, 0777);
    exit;
}
 public function api_recenttravelfrd(){
     $this->loadModel("Invite");
     if($this->request->is('post')){
        $user_id = $this->request->data['user_id'];
       
       if($user_id){
        // $data = $this->Invite->find('all',array('conditions'=>array('Invite.user_id'=>$user_id)));
        // $trip = $this->Invite->query('SELECT * FROM invites invite RIGHT JOIN trips trip ON (invite.trip_id = trip.id) WHERE trip.user_id = '.$id.' OR invite.user_id = '.$id.' OR invite.frd_id = '.$id.' GROUP BY trip.id');   
         $data = $this->Invite->query('SELECT * FROM invites invite RIGHT JOIN users user ON (invite.frd_id = user.id)WHERE invite.user_id = '.$user_id.'');
          $image = array();
            foreach($data as $dataa){
                 if($dataa['user']['image'] == null){
                       $dataa['user']['image'] = null; 
                  }else if (filter_var($dataa['user']['image'], FILTER_VALIDATE_URL)) {
                        
                    }else{
                      $dataa['user']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" .$dataa['user']['image']; 
                  }
                   
                $image[]=  $dataa;
            }
         
        
         $response['status'] = 0;
         $response['data'] = $image;
        
     }else{
          $response['status'] = 1;
          $response['msg'] = 'Something went wrong!!';
     }
     }else{
          $response['status'] = 1;
          $response['msg'] = 'No data available';
     }
   
   
      echo json_encode($response);

        exit; 
 }
}
 