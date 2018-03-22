<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
header('Access-Control-Allow-Origin: *');

class TripsController extends AppController {

    public $components = array('Session', 'Flash', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_tripadd', 'api_upcomingtrip', 'admin_edit', 'api_singletrip', 'admin_tripgallery', 'admin_view', 'admin_deleteimage', 'api_edittrip', 'api_tripimage', 'api_pasttrip', 'api_tripcount', 'api_step1', 'api_step2', 'api_step3', 'api_writefile', 'api_recenttravelfrd', 'admin_pasttrip', 'api_addanotherlocation', 'admin_tripvideo');
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
        $this->request->data['Trip']['trip_startdate1'] = $this->request->data['trip_startdate1'];
        $this->request->data['Trip']['trip_enddate1'] = $this->request->data['trip_enddate1'];
        $this->request->data['Trip']['start_location1'] = $this->request->data['start_location1'];
        $this->request->data['Trip']['end_location1'] = $this->request->data['end_location1'];
        $this->request->data['Trip']['latitude1'] = $this->request->data['start_lat1'];
        $this->request->data['Trip']['longitude1'] = $this->request->data['start_long1'];
        $this->request->data['Trip']['end_lat1'] = $this->request->data['end_lat1'];
        $this->request->data['Trip']['end_long1'] = $this->request->data['end_long1'];
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

    public function api_addanotherlocation() {
        $this->loadModel('Another_location');
        $this->request->data['Another_location']['user_id'] = $this->request->data['user_id']; //userid
        $this->request->data['Another_location']['trip_id'] = $this->request->data['trip_id'];
        $this->request->data['Another_location']['trip_startdate'] = $this->request->data['trip_startdate'];
        $this->request->data['Another_location']['trip_enddate'] = $this->request->data['trip_enddate'];
        $this->request->data['Another_location']['start_location'] = $this->request->data['start_location'];
        $this->request->data['Another_location']['end_location'] = $this->request->data['end_location'];

        if ($this->request->is('post')) {

            if (!empty($this->request->data['user_id'])) {
                $this->Another_location->create();
                $savedata = $this->Another_location->save($this->request->data);
                $trip = $this->Another_location->getInsertID();
                $trip_data = $this->Another_location->find('first', array('conditions' => array('Another_location.id' => $trip)));
                $response['data'] = $trip_data;
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
        if ($this->request->is('post')) {

            $id = $this->request->data['id']; //userid
            $trip_startdate = $this->request->data['trip_startdate'];
            $trip_enddate = $this->request->data['trip_enddate'];
            $start_location = $this->request->data['start_location'];
            $end_location = $this->request->data['end_location'];
            $latitude = $this->request->data['start_lat'];
            $longitude = $this->request->data['start_long'];
            $end_lat = $this->request->data['end_lat'];
            $end_long = $this->request->data['end_long'];
            // print_r($this->request->data);die;
            if ($id) {
                $data = $this->Trip->updateAll(array('Trip.trip_startdate' => "' $trip_startdate'", 'Trip.trip_enddate' => "'$trip_enddate'", 'Trip.start_location' => "' $start_location'",
                    'Trip.end_location' => "'$end_location'", 'Trip.latitude' => "'$latitude'", 'Trip.longitude' => "'$longitude'", 'Trip.end_lat' => "'$end_lat'", 'Trip.end_long' => "'$end_long'"), array('Trip.id' => $id));
                $updatedata = $this->Trip->find('first', array('conditions' => array('Trip.id' => $id)));

                if ($updatedata) {
                    $response['data'] = $updatedata;
                    $response['status'] = 0;
                    $response['msg'] = 'Trip Updated Successfully';
                } else {
                    $response['status'] = 1;
                    $response['msg'] = 'No Data Available';
                }
            } else {
                $response['status'] = 1;
                $response['msg'] = 'No Data Available';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something going wronge';
        }

        echo json_encode($response);
        exit;
    }

    public function admin_trip() {
        $currentdate = date('Y-m-d');
        $trips = $this->Trip->find('all', array('conditions' => array('Trip.status' => '0')));
        $tripdata = array();
        foreach ($trips as $trip) {
            if ((strtotime($trip['Trip']['trip_enddate'])) >= (strtotime($currentdate))) {
                $tripdata[] = $trip;
            }
        }
        // echo '<pre>';print_r($tripdata);die;
        $this->set('trip', $tripdata);
        //debug($trip);die;
    }

    public function admin_pasttrip() {
        $currentdate = date('Y-m-d');
        $trips = $this->Trip->find('all', array('conditions' => array('Trip.status' => '0')));
        $tripdata = array();
        foreach ($trips as $trip) {
            if ((strtotime($trip['Trip']['trip_enddate'])) <= (strtotime($currentdate))) {
                $tripdata[] = $trip;
            }
        }
        // echo '<pre>';print_r($tripdata);die;
        $this->set('trip', $tripdata);
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

            if ($tripdetail['Trip']['image'] == null) {
                $tripdetail['Trip']['image'] = null;
            } else {
                $tripdetail['Trip']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" . $tripdetail['Trip']['image'];
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
        $this->set('gallery', $gallery);
    }

    public function admin_tripvideo($trip_id = null) {
        $this->loadModel('Video');
        $gallery = $this->Video->find('all', array('conditions' => array('Video.trip_id' => $trip_id)));
        $this->set('gallery', $gallery);
    }

    public function admin_view($id = null) {
        $trip = $this->Trip->find('first', array('conditions' => array('Trip.id' => $id), 'recursive' => 2));
        //echo '<pre>';  print_r($trip);die;
        $this->set('trip', $trip);
    }

    public function admin_deleteimage($id = null, $trip = null) {

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
            return $this->redirect(array('action' => 'tripgallery', $trip));
        }
        $this->Session->setFlash('Something went wrong');
        return $this->redirect(array('action' => 'tripgallery', $trip));
    }

    public function api_tripimage() {
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
        $id = $this->request->data['id']; // logged in user
        //$id = 47;
        $status = 0;
        $currentdate = date("Y/m/d");
        $tripdata = array();
        $this->loadModel("Invite");
        if ($this->request->is('post')) {

            $this->Invite->recursive = 2;
            //$trip = $this->Invite->find('all', array('conditions' => array('AND'=>array('OR' => array('Invite.user_id' => $id, 'Invite.frd_id' => $id),'OR'=>array())),'group' => 'Invite.trip_id'));
            // print_r($trip);die;
            $trip = $this->Invite->query('SELECT * FROM invites invite RIGHT JOIN trips trip ON (invite.trip_id = trip.id) WHERE trip.user_id = ' . $id . ' OR invite.user_id = ' . $id . ' OR invite.frd_id = ' . $id . ' GROUP BY trip.id');
            //print_r($trip);die;
            $gallery_items = array();


            foreach ($trip as $gallery) {
                if (strtotime($gallery['trip']['trip_enddate']) >= strtotime($currentdate)) {

                    if ($gallery['trip']['image'] == null) {
                        $gallery['trip']['image'] = null;
                    } else {
                        $gallery['trip']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" . $gallery['trip']['image'];
                    }

                    $gallery_items[] = $gallery;
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

    public function api_pasttrip() {
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            if ($user_id) {
                $data = $this->Trip->query('SELECT * FROM invites invite RIGHT JOIN trips trip ON (invite.trip_id = trip.id) WHERE trip.user_id = ' . $user_id . ' OR invite.user_id = ' . $user_id . ' OR invite.frd_id = ' . $user_id . ' GROUP BY trip.id');

                $currentdate = date("Y/m/d");
                $trips = array();
                foreach ($data as $pasttrip) {
                    // $pasttrip['trip']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" .$pasttrip['trip']['image'];
                    if (strtotime($pasttrip['trip']['trip_enddate']) < strtotime($currentdate)) {
                        if ($pasttrip['trip']['image'] == null) {
                            $pasttrip['trip']['image'] = null;
                        } else {
                            $pasttrip['trip']['image'] = FULL_BASE_URL . $this->webroot . "files/usergallery/" . $pasttrip['trip']['image'];
                        }

                        array_push($trips, $pasttrip);
                    }
                }

                if ($trips) {
                    $response['status'] = 0;
                    $response['data'] = $trips;
                } else {
                    $response['status'] = 1;
                    $response['msg'] = 'Sorry,there is no data';
                }
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Something went wrong';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something went wrong';
        }
        echo json_encode($response);
        exit;
    }

    public function api_tripcount() {
        $this->loadModel("Invite");
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            if ($user_id) {
                $count = $this->Trip->find('count', array('conditions' => array('Trip.user_id' => $user_id)));
                $data = $this->Invite->find('count', array('conditions' => array('Invite.frd_id' => $user_id, 'Invite.status' => 1)));
                //print_r($data);die;
                $totaltrip = $count + $data;
                $response['status'] = 0;
                $response['data'] = $totaltrip;
                $response['msg'] = 'User trip count';
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Something went wrong';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something went wrong';
        }
        echo json_encode($response);
        exit;
    }

    public function api_step1() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://sandbox.dwolla.com/oauth/v2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "client_id=6F2klb8i6egtpWjgPgML40qJdgZDHuvqzKiCYtylV9UwyF9u2G&client_secret=DIcDgl8WCx7RjROLMZOVwN7LEYyBKivLuP5yWS6QcD80VMFepg&grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: 1b3aee4f-2a5d-f132-a393-91a55c6f2ba0"
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
        exit;
    }

    public function api_step2() {//create customer

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-sandbox.dwolla.com/customers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n\"firstName\" : \"Isha\"\r\n  \"lastName\" : \"Doe\"\r\n  \"email\" : \"rahulsharma@nomail.net\"\r\n  \"type\" : \"personal\"\r\n  \"address1\" : \"99-99 33rd St\"\r\n  \"city\" : \"Some City\"\r\n  \"state\" : \"NY\"\r\n  \"postalCode\" : 11101,\r\n  \"dateOfBirth\" : \"1970-01-01\"\r\n  \"ssn\" : 1234\r\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.dwolla.v1.hal+json",
                "authorization: bearer lxu8Ru4ARMbe34F193vEqGpyAVWxELgtmeVlOEqTOY4tjMmamT",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 860fa353-bba7-55bf-fb1b-d493f9a1e49c"
            ),
        ));

        $response = curl_exec($curl);
        print_r($response);die;
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
        exit;
    }
    
    public function api_step3(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-sandbox.dwolla.com/customers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.dwolla.v1.hal+json",
                "authorization: bearer lxu8Ru4ARMbe34F193vEqGpyAVWxELgtmeVlOEqTOY4tjMmamT",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 00ca4f3a-be42-3f81-b0d7-c371f219650b"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
            
        }
        exit;
    }

    public function api_recenttravelfrd() {
        $this->loadModel("Invite");
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];

            if ($user_id) {
                // $data = $this->Invite->find('all',array('conditions'=>array('Invite.user_id'=>$user_id)));
                // $trip = $this->Invite->query('SELECT * FROM invites invite RIGHT JOIN trips trip ON (invite.trip_id = trip.id) WHERE trip.user_id = '.$id.' OR invite.user_id = '.$id.' OR invite.frd_id = '.$id.' GROUP BY trip.id');   
                $data = $this->Invite->query('SELECT * FROM invites invite RIGHT JOIN users user ON (invite.frd_id = user.id)WHERE invite.user_id = ' . $user_id . '');
                $image = array();
                foreach ($data as $dataa) {
                    if ($dataa['user']['image'] == null) {
                        $dataa['user']['image'] = null;
                    } else if (filter_var($dataa['user']['image'], FILTER_VALIDATE_URL)) {
                        
                    } else {
                        $dataa['user']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $dataa['user']['image'];
                    }

                    $image[] = $dataa;
                }


                $response['status'] = 0;
                $response['data'] = $image;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Something went wrong!!';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'No data available';
        }


        echo json_encode($response);

        exit;
    }

}
