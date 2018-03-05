<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
header('Access-Control-Allow-Origin: *');

class GalleriesController extends AppController {

    public $components = array('Session', 'Flash', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_uploadimage', 'api_uploadgallery', 'admin_deleteimage', 'api_viewimage', 'api_creategroup', 'api_addtofavourite', 'api_favouriteslist', 'api_commentonimage', 'api_gallerylocation', 'api_setimagestatus',
                'api_removeimage', 'api_videoupload', 'api_commentlist','api_itinerary','api_additinerary','api_videolisting');
    }

    public function api_uploadgallery() {

        Configure::write('debug', 0);
//         $gallery = array('iVBORw0KGgoAAAANSUhEUgAAAAUA
//          AAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO
//          9TXL0Y4OHwAAAABJRU5ErkJggg==','iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO9TXL0Y4OHwAAAABJRU5ErkJggg==');
//          $user_id=55; 
//          $trip_id =42;



        if ($this->request->is('post')) {
            $user_id = $_POST['user_id']; //=55;
            $tripid = $_POST['trip_id']; //=42;
            $gallery = $_POST['img']; // = 'iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO9TXL0Y4OHwAAAABJRU5ErkJggg==,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO9TXL0Y4OHwAAAABJRU5ErkJggg=='; //indexed array

            $images = array();
            $gallery = explode(",", $gallery);


            foreach ($gallery as $imgdata) {

                $img = base64_decode($imgdata);
                $im = imagecreatefromstring($img);
                if ($im !== false) {
                    $digits = 3;
                    $random_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                    $image = $random_number . "1" . time() . ".png";
                    imagepng($im, WWW_ROOT . "files" . DS . "usergallery" . DS . $image);
                    imagedestroy($im);


                    $gallery_data['image'] = $image;
                    $gallery_data['user_id'] = $user_id;
                    $gallery_data['trip_id'] = $tripid;
                    $this->Gallery->create();

                    $this->Gallery->save($gallery_data);
                    $img = FULL_BASE_URL . $this->webroot . "files/usergallery/" . $gallery_data['image'];
                    array_push($images, $img);
                } else {
                    // do nothing
                }
            }

            $response['status'] = 0;
            $response['image'] = $images;
            $response['data'] = $gallery_data;
            $response['msg'] = "Images Save Successfully";
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something went going wrong';
        }


        echo json_encode($response);
        exit;
    }

    public function api_saveimgfolder() {
        if ($_POST['gallery'] == '') {
            $response['error'] = 1;
            $response['msg'] = 'No data Post';
        } else {
            $resimg = array();
            $this->load->model('user/post_model');
            $gallery = $_POST['gallery'];
            $imagedata = explode("harman", $gallery);
//            $fileindex = $_POST['fileindex'];
//            unset($imagedata[$fileindex]);
//            $i = 1;
            foreach ($imagedata as $images) {

                $img = base64_decode($images);
                $im = imagecreatefromstring($img);

                if ($im !== false) {
                    $image = time() . $i . ".jpg";
                    $filepath = "./uploads/post_photos/" . $image;
                    //echo $filepath;
                    if (file_exists($filepath)) {
                        unlink($filepath);
                    }
                    imagepng($im, $filepath);
                    imagedestroy($im);
                }
                $resimg[] = base_url() . 'uploads/post_photos/' . $image;
                $i++;
            }

            $response['error'] = 0;
            $response['data'] = $resimg;
            $response['msg'] = "Images Save Successfully";
        }
        echo json_encode($response);
        exit();
    }

    public function admin_index() {
        $image = $this->Gallery->find('all');
        $this->set('image', $image);
        //debug($image);die;
    }

    public function admin_view($id = null) {

        $this->Gallery->id = $id;
        if (!$this->Gallery->exists()) {
            throw new NotFoundException('Invalid Gallery');
        }
        $this->set('gallery', $this->Gallery->read(null, $id));
    }

    public function api_viewimage() {

        if ($this->request->is('post')) {
            $user_id = $_POST['user_id'];
            $tripid = $_POST['trip_id'];
            if ($tripid) {
                $data = $this->Gallery->find('all', array('conditions' => array('Gallery.user_id' => $user_id)));
                $gallery_items = array();
                foreach ($data as $gallery) {
                    $gallery['Gallery']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" . $gallery['Gallery']['image'];
                    $gallery['Gallery']['created'] = date('Y-m-d', strtotime($gallery['Gallery']['created']));
                    //  print_r($gallery['Gallery']['created']);die;
                    $gallery_items[] = $gallery;
                }

                $response['status'] = 0;
                $response['data'] = $gallery_items;
                //print_r($gallery_items);die;
            } else {
                $response['msg'] = 'Id not received';
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = 'Sorry There are no data';
            $response['status'] = 1;
        }

        // print_r($data);die;

        echo json_encode($response);
        exit;
    }

    public function api_creategroup() {

        $this->loadModel('Creategroup');
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            $group_name = $this->request->data['group_name'];
            if ($user_id) {
                //  print_r($this->request->data);die;
                $this->Creategroup->create();
                $savedata = $this->Creategroup->save($this->request->data);
                $data = $this->Creategroup->find('first', array('conditions' => array('Creategroup.user_id' => $user_id)));
                $response['msg'] = 'Group create successfully';
                $response['data'] = $data;
                $response['status'] = 0;
            } else {

                $response['msg'] = 'Id not get';
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = 'Sorry Something went going wrong';
            $response['status'] = 1;
        }

        echo json_encode($response);
        exit;
    }

    public function api_createoigrroup() {

        configure::write('debug', 0);

        $this->loadModel("Fitting");
        $this->loadModel("Accept");
        $this->request->data['Accept']['userid'] = $_POST['userid'];
        $this->request->data['Accept']['name'] = $_POST['name'];
        $this->request->data['Accept']['username'] = $_POST['username'];
        $this->request->data['Accept']['groupid'] = $_POST['groupid'];
        $grpname = $_POST['name'];
        $one = $_POST['image'];

        $img = base64_decode($one);

        $im = imagecreatefromstring($img);


        if ($im !== false) {

            $image = "1" . time() . ".png";

            imagepng($im, WWW_ROOT . "files" . DS . "profile_pic" . DS . $image);

            imagedestroy($im);

            $img = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $image;
        } else {

            $img = FULL_BASE_URL . $this->webroot . "files/profile_pic/avatar[4].jpg";
        }

        if ($_POST) {

            $groupid = $_POST['groupid'];
            $grpid = explode(",", $groupid);
            foreach ($grpid as $key => $value) {

                $tokenid = $this->User->find('first', array('conditions' => array('User.id' => $value)));
                $token = $tokenid['User']['tokenid'];

                $this->sendNewnotificationPush($grpname, $token, $grpname . ' invites you to join the Fitting Room', $value);
            }
            $this->request->data['Fitting']['image'] = $img;
            $this->Fitting->create();
            $this->Fitting->save($this->request->data);
            $lastid = $this->Fitting->getLastInsertId();

            $fitting = $this->Fitting->find('first', array('conditions' => array('Fitting.id' => $lastid)));

            $data['Accept']['userid'] = $fitting['Fitting']['userid'];
            $data['Accept']['groupid'] = $lastid;
            $data['Accept']['status'] = '0';
            $data['Accept']['isgroup'] = '1';
            $this->Accept->create();
            $this->Accept->save($data);
            if ($_POST['bit'] == '1') {
                $groups = explode(',', $fitting['Fitting']['groupid']);
                foreach ($groups as $key => $value) {

                    $data['Accept']['userid'] = $value;
                    $data['Accept']['groupid'] = $lastid;
                    $data['Accept']['status'] = '0';
                    $data['Accept']['isgroup'] = '1';
                    $this->Accept->create();
                    $this->Accept->save($data);
                }
            } else {
                $data['Accept']['userid'] = $fitting['Fitting']['groupid'];
                $data['Accept']['groupid'] = $lastid;
                $data['Accept']['status'] = '0';
                $data['Accept']['isgroup'] = '1';
                $this->Accept->create();
                $this->Accept->save($data);
            }
            $response['status'] = 0;
            $response['data'] = $lastid;
            $response['msg'] = 'Group created successfully.';
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something went wrong.';
        }

        echo json_encode($response);
        exit;
    }

    public function api_addtofavourite() {
        configure::write('debug', 0);
        $this->loadModel("Favourite");
        $user_id = $this->request->data['user_id'];
        $image = $this->request->data['image'];
        $trip_id = $this->request->data['trip_id'];

        $images = $this->Favourite->find('first', array('conditions' => array('Favourite.user_id' => $user_id, 'Favourite.image' => $image)));
        //  print_r($images);die;

        if ($images) {

            $id = $images['Favourite']['id'];
            $this->Favourite->delete($id);
            $update = $this->Gallery->updateAll(array('Gallery.status' => 0), array('Gallery.id' => $image));
            $response['status'] = 0;
            $response['bit'] = 0;
            $response['msg'] = 'Item successfully removed from My Favorites';
        } else {
            $this->request->data['Favourite']['user_id'] = $user_id;
            $this->request->data['Favourite']['image'] = $image;
            $this->request->data['Favourite']['trip_id'] = $trip_id;

            $this->Favourite->create();
            $savedata = $this->Favourite->save($this->request->data);
            $update = $this->Gallery->updateAll(array('Gallery.status' => 1), array('Gallery.id' => $image));
            $images = $this->Gallery->find('first', array('conditions' => array('Gallery.id' => $image)));
            $response['status'] = 0;
            $response['bit'] = 1;
            $response['data'] = $images;
            $response['msg'] = 'Item successfully added to My Favorites';
        }

        echo json_encode($response);
        exit;
    }

    public function api_favouriteslist() {
        $this->loadModel("Favourite");
        $user_id = $this->request->data['user_id'];
        $users = $this->Gallery->find('all', array('conditions' => array('Gallery.user_id' => $user_id, 'Gallery.status' => 1)));

        $gallery_items = array();
        foreach ($users as $data) {
            $data['Gallery']['image'] = FULL_BASE_URL . $this->webroot . 'files/usergallery/' . $data['Gallery']['image'];
            $gallery_items[] = $data;
        }

        if ($users) {
            $response['status'] = 0;
            $response['data'] = $gallery_items;
        } else {
            $response['status'] = 1;
            $response['msg'] = 'No liked images';
        }

        echo json_encode($response);
        exit;
    }

    public function api_commentonimage() {
        if ($this->request->is('post')) {
            $this->loadModel("Comment");
            $comment = $this->request->data['comment'];
            $image_id = $this->request->data['image_id'];
            $trip_id = $this->request->data['trip_id'];
            $user_id = $this->request->data['user_id'];
            
            
            
            if ($image_id) {
                $this->Comment->create();
                $this->Comment->save($this->request->data);
                $users = $this->Comment->find('all', array('conditions' => array('Comment.image_id' => $image_id)));
                $response['status'] = 0;
                $response['msg'] = "Your comment is posted";
                $response['data'] = $users;
            } else {
                $response['status'] = 1;
                $response['msg'] = "Something going wronge";
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = "Something going wronge";
        }


        echo json_encode($response);
        exit;
    }

    public function api_editimage() {
        if ($this->request->is('post')) {
            $imageid = $this->request->data['id'];
            $user_id = $this->request->data['user_id'];
            $trip_id = $this->request->data['$trip_id'];
            $status = 1;
            if ($user_id) {
                $data = $this->Gallery->updateAll(array('Gallery.image' => "'$image'"), array('Fitting.status' => $status));
                $response['data'] = $data;
                $response['status'] = 0;
                $response['msg'] = 'edit image';
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Something going wronge';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something going wronge';
        }
        echo json_encode($response);
        exit;
    }

    public function api_gallerylocation() {
        if ($this->request->is('post')) {
            $image_id = $this->request->data['image_id'];
            $trip_id = $this->request->data['trip_id'];
            $location = $this->request->data['location'];

            if ($image_id) {
                $update = $this->Gallery->updateAll(array('Gallery.location' => "'" . $location . "'"), array('Gallery.id' => $image_id));
                $users = $this->Gallery->find('all', array('conditions' => array('Gallery.id' => $image_id)));
                $gallery_items = array();
                foreach ($users as $data) {
                    $data['Gallery']['image'] = FULL_BASE_URL . $this->webroot . 'files/usergallery/' . $data['Gallery']['image'];
                }
                $gallery_items[] = $data;

                $response['status'] = 0;
                $response['msg'] = 'Add location';
                $response['data'] = $data;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Something going wrong';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something going wrong';
        }
        echo json_encode($response);
        exit;
    }

    public function api_setimagestatus() {
        if ($this->request->is('post')) {
            $imageid = $this->request->data['imageid'];
            $trip_id = $this->request->data['trip_id'];
            $status = $this->request->data['status'];

            if ($imageid) {

                $update = $this->Gallery->updateAll(array('Gallery.imagestatus' => $status), array('Gallery.id' => $imageid));
                $users = $this->Gallery->find('first', array('conditions' => array('Gallery.id' => $imageid)));
                // print_r($users);die;
                $response['status'] = 0;
                $response['msg'] = 'Update';
                $response['data'] = $users;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Something going wrong8';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something going wrong';
        }
        echo json_encode($response);
        exit;
    }

    public function api_removeimage() {
        $this->Gallery->id = $_POST['image_id'];   // booking id
        $deletedata = $this->Gallery->delete();
        if ($deletedata) {
            $response['status'] = 0;
            $response['msg'] = 'Image successfully deleted';
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Sorry There are no data';
        }


        echo json_encode($response);
        exit;
    }

    public function api_videoupload() {
        $this->loadModel('Video');
        $user_id = $this->request->data['user_id'];
        $trip_id = $this->request->data['trip_id'];
        $currentdate = date("Y/m/d");
        $target_path = "uservideo/";
        if ($_FILES["file"]["error"] > 0) {
            $response['error'] = 1;
            $response['msg'] = "Please upload file";
        } else {
            $path = WWW_ROOT . '/files/';
            $name = $_FILES['file']['name'];
            $data = explode(".", $name);
            $extension = array_pop($data);
         
            if ($_FILES["file"]) {
                if($_FILES['file']['name'] == null && $_FILES['file']['size'] > 0){
                    $_FILES['file']['name'] = time().".".$extension;
                    
                   // print_r($_FILES['file']['name']);die;
                }else if($_FILES['file']['size'] > 0){
                    $_FILES['file']['name'] = time().".".$extension;
                }else{
                    $_FILES['file']['name'] ='';
                }
        // find extension & create dynamic name
                
                // if name is null but size is greater than 0, create name and upload it
                
//                if($_FILES['file']['size'] > 0){
//                    $_FILES['file']['name'] = "dfhdfh.mov";
//                }
                if(!empty($_FILES['file']['name'])){
                    $name = $_FILES['file']['name'];
                    
                    $this->request->data['Video']['video'] = $_FILES['file']['name']; 
                    $this->request->data['Video']['user_id'] = $user_id;
                    $this->request->data['Video']['trip_id'] = $trip_id;
                    
                    $uploadFolder = "uservideo";
                    $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
                    $file_loc = $uploadPath . DS . $_FILES["file"]["name"];
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $file_loc)){
                       $this->Video->create();
                       $savedata = $this->Video->save($this->request->data);
                       $response['status'] = 0;
                       $response['msg'] = "Uploaded Successfully";
               
                    }else{
                        $response['status'] = 1;
                        $response['msg'] = "Not Uploaded Successfully";
                    }
                   

                }else{
                    $response['status'] = 1;
                    $response['msg'] = "Not Uploaded Successfully";
                }
              } else {
                $response['status'] = 1;
                $response['msg'] = "File not uploaded";
               
            }  
           
        }
        echo json_encode($response);
        exit;

    }
    
    public function api_videolisting(){
        $this->loadModel('Video');
        if($this->request->is('post')){
            $trip_id = $this->request->data['trip_id'];
            $user_id = $this->request->data['user_id'];
            if($trip_id){
                $data = $this->Video->find('all',array('conditions'=>array('Video.trip_id'=>$trip_id)));
                $video = array();
                foreach($data as $videodata){
                    $videodata['Video']['video'] = FULL_BASE_URL . $this->webroot . "files/uservideo/" . $videodata['Video']['video'];
                    $video[] = $videodata;       
                }
                if(!empty($video)){
                   $response['status'] = 0;
                   $response['data'] = $video;
                   $response['msg'] = 'Success'; 
                }else{
                    $response['status'] = 1;
                    $response['msg'] = 'Sorry,Data not available!!';
                }
              
            }else{
                $response['status'] = 1;
                $response['msg'] = 'Data not posted';
            }
        }else{
            $response['status'] = 1;
            $response['msg'] = 'Somthing going wrong!!';
        }
        
         echo json_encode($response);
        exit;
    }
   public function api_commentlist() {
         $this->loadModel('Comment');
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            $image_id = $this->request->data['image_id'];
            
            if ($user_id) {
                $data = $this->Comment->find('all', array('conditions' => array('Comment.user_id' => $user_id,'Comment.image_id' => $image_id)));
                $gallery_items = array();
                foreach ($data as $gallery) {
                    if($gallery['User']['image'] == null){
                        $gallery['User']['image'] = null;
                        
                    }else{
                        $gallery['User']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" . $gallery['User']['image'];
                    }
                    
                
                    $gallery_items[] = $gallery;
                }
                if ($gallery_items) {
                    $response['status'] = 0;
                    $response['data'] = $gallery_items;
                } else {
                    $response['status'] = 1;
                    $response['msg'] = 'Sorry There are no data';
                }
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Error';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Sorry There are no data';
        }
        echo json_encode($response);
        exit;
    }
    
    
    public function api_itinerary(){
        $this->loadModel('Itinerary');
      if($this->request->is('post')){
          $location = $this->request->data['location'];
         
          if($location){
              $data = $this->Gallery->find('all',array('conditions'=>array('Gallery.location'=>$location)));
            if ($data['User']['image']) {
                    if (filter_var($data['User']['image'], FILTER_VALIDATE_URL)) {
                        
                    } else {
                        $data['User']['image'] = FULL_BASE_URL . '/grouptrip/files/profile_pic/' . $data['User']['image'];
                    }
                }  
              if($data){
                   $response['status'] = 0;
                   $response['data'] = $data;
              }else{
                   $response['status'] = 1;
                   $response['msg'] = 'Sorry There are no data';
              }
          }else{
                $response['status'] = 2;
                $response['msg'] = 'Sorry There are no data';
          }
          
      }else{
           $response['status'] = 1;
           $response['msg'] = 'Something going wrong!!';
      }
       echo json_encode($response);
        exit;
    }
    
    public function api_additinerary(){
        $this->loadModel('Itinerary');
        if($this->request->is('post')){
            $user_id = $this->request->data['user_id'];
            $comment = $this->request->data['comment'];
            $rating = $this->request->data['rating'];
            $location = $this->request->data['location'];
            if($user_id){
                $this->Itinerary->create();
                $this->Itinerary->save($this->request->data);
                $this->Itinerary->getLastInsertId();
                $data = $this->Itinerary->find('first',array('conditions'=>array('Itinerary.user_id'=>user_id)));
                if($data){
                      $response['status'] = 0;
                      $response['data'] = $data;
                }else{
                    $response['status'] = 1;
                    $response['msg'] = 'No data available!!';
                }
            }else{
                $response['status'] = 1;
                $response['msg'] = 'Something going wrong!!';
            }
            
        }else{
            $response['status'] = 1;
            $response['msg'] = 'Something going wrong!!';
        }
         echo json_encode($response);
        exit;
    }
    
    
    
   
}
