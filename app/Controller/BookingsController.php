<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
header('Access-Control-Allow-Origin: *');

class BookingsController extends AppController {

    public $components = array('Session', 'Flash', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_booking', 'api_flightbooking', 'admin_view', 'admin_delete', 'api_userbooking', 'api_addevent', 'admin_eventdelete', 'admin_event', 'admin_view', 'api_hotel_booking', 'api_hoteldetail', 'api_upcomingbooking', 'api_pastbooking', 'admin_hotelview');
    }

    public function api_flightbooking() {
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            $start_date = $this->request->data['start_date'];
            $last_date = $this->request->data['last_date'];
            $flight = $this->request->data['flight']; //flight number
            $airline = $this->request->data['airline'];
            $arrival_time = $this->request->data['arrival_time'];
            $departure_time = $this->request->data['departure_time'];
            $amount = $this->request->data['amount'];
            $startlocation = $this->request->data['start_location'];
            $endlocation = $this->request->data['end_location'];
            $status = $this->request->data['status'];
            $booking_id = $this->request->data['booking_id'];

            if ($user_id) {
                $this->Booking->create();
                $savedata = $this->Booking->save($this->request->data);
                $updates = $this->Booking->getInsertID();
                $usr_data = $this->Booking->find('first', array('conditions' => array('Booking.id' => $updates)));
                $response['msg'] = "Booking is succesfull";
                $response['status'] = 0;
                $response['data'] = $usr_data;
            } else {
                $response['msg'] = "something went going wronge";
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = "something went going wronge";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function api_hotel_booking() {
        $this->loadModel('Hotel_booking');
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            //$email = $this->request->data['email'];
            $price = $this->request->data['price'];
            $hname = $this->request->data['hname'];
            $from = $this->request->data['check_in'];  //checkin
            $to = $this->request->data['check_out']; //checkout
            $room = $this->request->data['rooms'];
//            $children = $this->request->data['children'];
//            $adult = $this->request->data['adult'];
            $city = $this->request->data['city'];
            $country = $this->request->data['country'];
            $status = $this->request->data['status'];
            $booking_id = $this->request->data['booking_id'];

            if ($user_id) {

                $this->Hotel_booking->create();
                $savedata = $this->Hotel_booking->save($this->request->data);
                $updates = $this->Hotel_booking->getInsertID();
                $usr_data = $this->Hotel_booking->find('first', array('conditions' => array('Hotel_booking.id' => $updates)));
                $response['msg'] = "Booking is succesfull";
                $response['status'] = 0;
                $response['data'] = $usr_data;
            } else {
                $response['msg'] = "something  going wronge";
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = "something  going wronge";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function api_upcomingbooking() {
        $this->loadModel('Hotel_booking');
        if ($this->request->is("post")) {
            $user_id = $this->request->data['user_id'];
            $currentdate = time();
            $test = array();
            if (!empty($user_id)) {
                $bookingdata = $this->Hotel_booking->find('all', array('conditions' => array('Hotel_booking.user_id' => $user_id)));
                $bookingdataa = array();
                foreach ($bookingdata as $data) {
                    if (strtotime($data['Hotel_booking']['check_in']) > $currentdate) {
                        $test['hotel'][] = $data;
                    }
                    $bookingdata = $this->Hotel_booking->find('all', array('conditions' => array('Hotel_booking.user_id' => $user_id)));
                    $bookingdataa = array();
                }
                $flightdata = $this->Booking->find('all', array('conditions' => array('Booking.user_id' => $user_id)));
                $flightdataa = array();
                foreach ($flightdata as $data) {
                    if (strtotime($data['Booking']['start_date']) > $currentdate) {
                        $test['flight'][] = $data;
                    }
                }

                if ($test) {
                    $response['data'] = $test;
                    $response['status'] = 0;
                } else {
                    $response['status'] = 1;
                    $response['msg'] = "No data available";
                }
            } else {
                $response['msg'] = "something  going wronge";
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = "something  going wronge";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function api_pastbooking() {
        $this->loadModel('Hotel_booking');
        if ($this->request->is("post")) {
            $user_id = $this->request->data['user_id'];
            $currentdate = time();
            $test = array();
            if (!empty($user_id)) {
                $bookingdata = $this->Hotel_booking->find('all', array('conditions' => array('Hotel_booking.user_id' => $user_id)));
                $bookingdataa = array();
                foreach ($bookingdata as $data) {
                    if (strtotime($data['Hotel_booking']['check_in']) < $currentdate) {
                        $test['hotel'][] = $data;
                    }
                    $bookingdata = $this->Hotel_booking->find('all', array('conditions' => array('Hotel_booking.user_id' => $user_id)));
                    $bookingdataa = array();
                }
                $flightdata = $this->Booking->find('all', array('conditions' => array('Booking.user_id' => $user_id)));
                $flightdataa = array();
                foreach ($flightdata as $data) {
                    if (strtotime($data['Booking']['start_date']) < $currentdate) {
                        $test['flight'][] = $data;
                    }
                }

                if ($test) {
                    $response['data'] = $test;
                    $response['status'] = 0;
                } else {
                    $response['status'] = 1;
                    $response['msg'] = "No data available";
                }
            } else {
                $response['msg'] = "something  going wronge";
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = "something  going wronge";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function api_hoteldetail() {
        $this->loadModel('Hotel_booking');
        if ($this->request->is('post')) {
            $id = $this->request->data['id']; //bookingid
            if (!empty($id)) {
                $data = $this->Hotel_booking->find('first', array('conditions' => array('Hotel_booking.id' => $id)));
                if ($data) {
                    $response['data'] = $data;
                    $response['status'] = 0;
                } else {
                    $response['msg'] = "No data available";
                    $response['status'] = 1;
                }
            } else {
                $response['msg'] = "No data available";
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = "something  going wronge";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function admin_booking() { //upcoming booking
        Configure::write('debug', 0);
        $this->loadModel('Hotel_booking');
        $cdate = date("Y-m-d");
        $bookingsdata = $this->Paginator->paginate('Hotel_booking');
        $bookings = array();
        foreach ($bookingsdata as $booking) {
            if (strtotime($booking['Hotel_booking']['check_in']) >= strtotime($cdate)) {
                $bookings[] = $booking;
            }
        }

        $this->set(compact('bookings'));
    }

    public function admin_pastbooking() {
        Configure::write('debug', 0);
        $this->loadModel('Hotel_booking');
        $cdate = date("Y-m-d");
        $bookingsdata = $this->Paginator->paginate('Hotel_booking');
        $bookings = array();
        foreach ($bookingsdata as $booking) {
            if (strtotime($booking['Hotel_booking']['check_in']) < strtotime($cdate)) {
                $bookings[] = $booking;
            }
        }

        $this->set(compact('bookings'));
    }

    public function admin_flightupcoming() { //upcoming booking
        $cdate = date("Y-m-d");
        $bookingsdata = $this->Paginator->paginate('Booking');
        $bookings = array();
        foreach ($bookingsdata as $booking) {
            if (strtotime($booking['Booking']['start_date']) >= strtotime($cdate)) {
                $bookings[] = $booking;
            }
        }

        $this->set(compact('bookings'));
    }

    public function admin_pastflight() {

        $cdate = date("Y-m-d");
        $bookingsdata = $this->Paginator->paginate('Booking');
        $bookings = array();
        foreach ($bookingsdata as $booking) {
            if (strtotime($booking['Booking']['start_date']) < strtotime($cdate)) {
                $bookings[] = $booking;
            }
        }

        $this->set(compact('bookings'));
    }

    public function admin_view($id = null) {
        configure::write("debug", 0);
        $this->Booking->id = $id;
        if (!$this->Booking->exists()) {
            throw new NotFoundException('Invalid user');
        }
        $this->set('user', $this->Booking->read(null, $id));
    }

    public function admin_hotelview($id = null) {
        configure::write("debug", 2);
        $this->loadModel('Hotel_booking');
        $this->Hotel_booking->id = $id;
        if (!$this->Hotel_booking->exists()) {
            throw new NotFoundException('Invalid user');
        }
        $this->set('user', $this->Hotel_booking->read(null, $id));
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

    public function api_userbooking() { // upcoming booking
        if ($this->request->is('post')) {
            $id = $this->request->data['user_id'];
            $all_boooking = $this->Booking->find('all', array('conditions' => array('Booking.user_id' => $id)));
            if ($id) {
                $response['status'] = 0;
                $response['data'] = $all_boooking;
                $response['msg'] = "Booking detail";
            } else {
                $response['status'] = 1;
                $response['msg'] = "Something went going wronge";
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = "Something went going wronge";
        }

        echo json_encode($response);
        exit;
    }

    ///////////////////////////////Events/////////////////////////////////////////////
    public function api_addevent() {
        $this->loadModel("Event");
        $this->loadModel("Attechment");
        if ($this->request->is('post')) {
            $user_id = $this->request->data['user_id'];
            $trip_id = $this->request->data['trip_id'];
            $event = $this->request->data['event'];
            $title = $this->request->data['title'];
            $d_add = $this->request->data['d_add'];
            $a_dd = $this->request->data['a_add'];
            $d_time = $this->request->data['d_time'];
            $a_time = $this->request->data['a_time'];
            $note = $this->request->data['note'];
            $file = $_FILES['file'];


            if ($user_id) {

                $this->Event->create();
                $this->Event->save($this->request->data);
                $updates = $this->Event->getInsertID();
                if ($_FILES["file"]["error"] > 0) {
                    $response['error'] = 1;
                    $response['msg'] = "Please upload file";
                } else {
                    $path = WWW_ROOT . '/files/';
                    $name = $_FILES['file']['name'];
                    $data = explode(".", $name);
                    $extension = array_pop($data);

                    if ($_FILES["file"]) {
                        if ($_FILES['file']['name'] == null && $_FILES['file']['size'] > 0) {
                            $_FILES['file']['name'] = time() . "." . $extension;
                        } else if ($_FILES['file']['size'] > 0) {
                            $_FILES['file']['name'] = time() . "." . $extension;
                        } else {
                            $_FILES['file']['name'] = '';
                        }

                        if (!empty($_FILES['file']['name'])) {
                            $name = $_FILES['file']['name'];

                            $this->request->data['Attechment']['attechment'] = $_FILES['file']['name'];
                            $this->request->data['Attechment']['user_id'] = $user_id;
                            $this->request->data['Attechment']['event_id'] = $updates;

                            $uploadFolder = "uservideo";
                            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
                            $file_loc = $uploadPath . DS . $_FILES["file"]["name"];
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_loc)) {
                                $this->Attechment->create();
                                $savedata = $this->Attechment->save($this->request->data);
                                $response['status'] = 0;
                                $response['msg'] = "Uploaded Successfully";
                            } else {
                                $response['status'] = 1;
                                $response['msg'] = "Not Uploaded Successfully";
                            }
                        } else {
                            $response['status'] = 1;
                            $response['msg'] = "Not Uploaded Successfully";
                        }
                    } else {
                        $response['status'] = 1;
                        $response['msg'] = "File not uploaded";
                    }
                }



                $data = $this->Event->find('first', array('conditions' => array('Event.id' => $updates)));
                $response['msg'] = "Event add successfully";
                $response['status'] = 0;
                $response['data'] = $data;
            } else {
                $response['msg'] = "Something going wrong!!";
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = "Something going wronge";
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function admin_event() {
        $this->loadModel('Event');
        $this->Event->recursive = 0;
        $this->set('users', $this->Paginator->paginate('Event'));

        //$this->set(compact(array('users')));
    }

    public function admin_eventdelete($id = null) {
        $this->loadModel('Event');
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Event->id = $id;
        if (!$this->Event->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->Event->delete()) {
            $this->Session->setFlash('Event deleted');
            return $this->redirect(array('action' => 'event'));
        }
        $this->Session->setFlash('Something went wrong');
        return $this->redirect(array('action' => 'event'));
    }

    public function admin_eventview($id = null) {
        configure::write("debug", 0);
        $this->Event->id = $id;
        if (!$this->Event->exists()) {
            throw new NotFoundException('Invalid user');
        }
        $this->set('user', $this->Event->read(null, $id));
    }

}
