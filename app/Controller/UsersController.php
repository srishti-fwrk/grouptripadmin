<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
header('Access-Control-Allow-Origin: *');

class UsersController extends AppController {

    public $components = array('Session', 'Flash', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_registration', 'forgetpwd', 'reset', 'api_login', 'api_fblogin', 'admin_add', 'admin_delete',
                'api_changepassword', 'api_forgetpwd', 'resetpassword', 'api_googlelogin', 'api_editprofile', 'api_user', 'api_resetpassword', 
                'api_saveimage', 'admin_login', 'registration', 'admin_view', 'api_userlisting', 'api_namesearch', 'api_airportcode', 'api_countrycode',
                'api_countrysearch', 'api_currencycode', 'api_country','api_phone_code','api_phonecode');
    }

    public function api_registration() {
        configure::write('debug', 0);
        if ($_POST) {
            $this->request->data['User']['name'] = $this->request->data['name'];
            $this->request->data['User']['email'] = $this->request->data['email'];
            $this->request->data['User']['password'] = $this->request->data['password'];
            $this->request->data['User']['tokenid'] = $this->request->data['tokenid'];
            $this->request->data['User']['role'] = 'customer';
            $this->request->data['User']['status'] = 1;

            if ($this->User->hasAny(array('User.email' => $this->request->data['User']['email']))) {
                $response['msg'] = 'Email already exist';
                $response['status'] = 1;
            } else {
                $this->User->create();
                $savedata = $this->User->save($this->request->data);
                $updates = $this->User->getInsertID();
                $usr_data = $this->User->find('first', array('conditions' => array('User.id' => $updates)));
                $response['data'] = $this->request->data;
                $response['msg'] = 'User successfully registered';
                $response['status'] = 0;
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something went going wrong!';
        }
        echo json_encode($response);
        exit;
    }

    public function registration() {
        configure::write('debug', 0);
        //if ($_POST) {
        $this->request->data['User']['name'] = 'srishti';
        $this->request->data['User']['email'] = 'srishti@avainfotech.com';
        $this->request->data['User']['password'] = 'future@123';
        $this->request->data['User']['role'] = 'admin';
        if ($this->User->hasAny(array('User.email' => $this->request->data['User']['email']))) {
            $response['msg'] = 'Email already exist';
            $response['status'] = 1;
        } else {
            $this->User->create();
            $savedata = $this->User->save($this->request->data);
            $updates = $this->User->getInsertID();
            $usr_data = $this->User->find('first', array('conditions' => array('User.id' => $updates)));
            //print_r($usr_data);die;
            $response['data'] = $usr_data;
            $response['msg'] = 'User successfully registered';
            $response['status'] = 0;
        }

        echo json_encode($response);
        exit;
    }

    public function api_login() {
        Configure::write("debug", 0);

        $this->request->data['User']['email'] = $this->request->data['email'];
        $pass = $this->request->data['password'];
        $this->request->data['User']['tokenid'] = $this->request->data['tokenid'];
        if ($this->request->is('post')) {
            $this->request->data['User']['password'] = $pass;
            $tokenid = $this->request->data['tokenid'];
            $password = AuthComponent::password($pass);
            $check = $this->User->find('first', array('conditions' => array('User.password' => $password, 'User.email' => $this->request->data['User']['email'])));
            $id = $check['User']['id'];
            // print_r($check);die;

            if ($check) {
                $this->User->updateAll(array('User.tokenid' => "'$tokenid'"), array('User.id' => $id));
                $response['msg'] = 'User successfully logged in';
                $response['data'] = $check;
                $response['status'] = 0;
            } else {
                $response['msg'] = 'Invalid credentials';
                $response['status'] = 1;
            }
        } else {
            $response['msg'] = 'Sorry something went wrong!';
            $response['status'] = 1;
        }
        echo json_encode($response);
        exit;
    }

    public function api_fblogin() {
        Configure::write('debug', 0);

        if ($this->request->is('post')) {
            $this->request->data['User']['first_name'] = $this->request->data['first_name'];
            $this->request->data['User']['last_name'] = $this->request->data['last_name'];
            $this->request->data['User']['name'] = $this->request->data['first_name'] . ' ' . $this->request->data['last_name'];
            $this->request->data['User']['email'] = $this->request->data['email'];
            $this->request->data['User']['fb_id'] = $this->request->data['fb_id'];
            $this->request->data['User']['phone'] = $this->request->data['phone'];
            $this->request->data['User']['dob'] = $this->request->data['dob'];
            $this->request->data['User']['image'] = $this->request->data['image'];
            $this->request->data['User']['address'] = $this->request->data['address'];
            $this->request->data['User']['gender'] = $this->request->data['gender'];
            $this->request->data['User']['tokenid'] = $this->request->data['tokenid'];
            $this->request->data['User']['role'] = 'customer';
            $this->request->data['User']['status'] = 1;

            if ($this->request->data['dob'] != "") {
                $this->request->data['User']['dob'] = date("Y-m-d", strtotime($this->request->data['dob']));
            } else {
                $this->request->data['User']['dob'] = "0000-00-00";
            }
            if ($this->User->hasAny(array('User.fb_id' => $this->request->data['User']['fb_id']))) {
                $userdata = $this->request->data['User']['fb_id'];
                $users = $this->User->find('first', array('conditions' => array('User.fb_id' => $userdata)));
                $response['data'] = $users;
                $response['status'] = 0;
                $response['msg'] = 'User successfully registered';
            } else {
                $this->User->create();
                $savedata = $this->User->save($this->request->data);
                if ($savedata) {
                    $response['data'] = $savedata;
                    $response['msg'] = 'User successfully registered';
                    $response['status'] = 0;
                } else {
                    $response['msg'] = 'Something went going wrong!!';
                    $response['status'] = 1;
                }
                $response['status'] = 0;
                $response['msg'] = 'User successfully registered';
            }
        } else {
            $response['msg'] = 'Something went going wrong!!';
            $response['status'] = 1;
        }

        //$this->set('response', $response);
        echo json_encode($response);
        exit;
    }

    public function api_googlelogin() {
        configure::write('debug', 0);

        if ($this->request->is('post')) {
            $this->request->data['User']['name'] = $this->request->data['name'];
            $this->request->data['User']['email'] = $this->request->data['email'];
            //$this->request->data['User']['name'] = $this->request->data['first_name'] . ' ' . $this->request->data['last_name'];
            $this->request->data['User']['google_id'] = $this->request->data['google_id'];
            $this->request->data['User']['image'] = $this->request->data['image'];
            $this->request->data['User']['role'] = 'customer';
            $this->request->data['User']['status'] = 1;
            $this->request->data['User']['tokenid'] = $this->request->data['tokenid'];
            //print_r($this->request->data);die;

            if ($this->User->hasAny(array('User.google_id' => $this->request->data['User']['google_id']))) {
                $userdata = $this->request->data['User']['google_id'];
                $users = $this->User->find('first', array('conditions' => array('User.google_id' => $userdata)));
                $response['status'] = 0;
                $response['status'] = $users;
                $response['msg'] = 'User successfully registered';
            } else {

                $this->User->create();
                $savedata = $this->User->save($this->request->data);
                if ($savedata) {
                    $response['data'] = $savedata;
                    $response['msg'] = 'User successfully registered';
                    $response['status'] = 0;
                } else {
                    $response['msg'] = 'Somthing went going wrong';
                    $response['status'] = 1;
                }
            }
        } else {
            $response['msg'] = 'Somthing went going wrong!';
            $response['status'] = 2;
        }
        echo json_encode($response);
        exit;
    }

    public function api_changepassword() {
        configure::write('debug', 0);

        if ($_POST) {
            $password = AuthComponent::password($_POST['old_password']);
            $em = $_POST['email'];
            $pass = $this->User->find('first', array('conditions' => array('AND' => array('User.password' => $password, 'User.email' => $em))));
            if ($pass) {
                $this->User->data['User']['password'] = $_POST['new_password'];
                $this->User->id = $pass['User']['id'];
                if ($this->User->exists()) {
                    $pass['User']['password'] = $_POST['new_password'];
                    if ($this->User->save()) {
                        $response['status'] = 1;
                        $response['msg'] = "Your password has been updated";
                    }
                }
            } else {
                $response['status'] = 0;
                $response['msg'] = "Your old password do not match";
            }
        }
        echo json_encode($response);
        exit;
    }

    public function api_forgetpwd() {
        Configure::write('debug', 0);
        $email = $_POST['email'];
        $fu = $this->User->find('first', array('conditions' => array('email' => $email)));

        if ($fu['User']['email']) {
            $key = Security::hash(CakeText::uuid(), 'sha512', true);
            $hash = sha1($fu['User']['email'] . rand(0, 100));
            $url = Router::url(array('controller' => 'users', 'action' => 'resetpassword', 'api' => false), true) . '/' . $key . '#' . $hash;
            $ms = '<body><table width="500" border="0" cellpadding="10" cellspacing="0" style="margin: 0px auto; background: #f0f0f0; text-align: center"><tr style="background: #f0f0f0"><td style="text-align: center; padding-top: 20px; padding-bottom: 20px"> <img alt="img" style="height: 97px;"/></td> </tr><tr><td> <h2>Welcome to Grouptrip </h2> <p>Click on button to reset your password.</p> <p><a href="' . $url . '" style="background: #cb202d; padding:15px 20px; text-transform:uppercase; display:inline-block; color:#fff; border-radius: 4px; text-decoration:none; font-weight:500;" >Reset your password</a></p> <h3>Thank you</h2> </td> </tr></table> </body>';
            // $ms='<body><h2>hjik</h2></body>';
            $fu['User']['reset_url'] = $key;
            $this->User->id = $fu['User']['id'];
            if ($this->User->saveField('reset_url', $fu['User']['reset_url'])) {
                $l = new CakeEmail('default');
                $l->emailFormat('html')->template('default', 'default')->subject('Reset Your Password')->from(array('info@rakesh.crystalbiltech.com' => 'Group Trip'))->to($fu['User']['email'])->send($ms);
                $response['isSucess'] = 'true';
                $response['msg'] = 'Check your email to reset your password';
            } else {
                $response['sucess'] = 'false';
                $response['msg'] = 'Error generating reset link';
            }
        } else {
            $response['sucess'] = 'false';
            $response['msg'] = 'E-mail ID does not exist';
        }
        echo json_encode($response);
        exit;
    }

    public function resetpassword($token = null) {
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findByreset_url($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    $this->request->data['User']['password'] = $this->request->data['User']['password1'];
                    if ($this->request->data['User']['password'] != $this->request->data['User']['password_confirm']) {
                        $this->Session->setFlash("Both the passwords are not matching...");
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['email'] = $u['User']['email'];
                    //$this->User->data['User']['username'] = $u['User']['email'];
                    $this->User->data['User']['reset_url'] = "ddd";
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        if ($this->User->save($this->User->data)) {
                            $this->Session->setFlash('Your new password is saved. Pls login with ' . $u["User"]["email"] . ' and your newpassword.');
                            return;
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                    $this->set('myuser', $u);
                }
                $this->set('myuser', $u);
            } else {
                $this->Session->setFlash('Token Corrupted, Please Retry.the reset link 
            <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none;
            background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") 
            repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;"
            name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
                $this->set('myuser', $u);
            }
            $this->set('myuser', $u);
        } else {
            $this->Session->setFlash('Pls try again...');
            $this->set('myuser', $u);
        }
    }

    public function api_editprofile() {
        if ($this->request->is('post')) {
            $id = $this->request->data['id']; // userid
            $name = $this->request->data['name'];
            $phone = $this->request->data['phone'];
            $email = $this->request->data['email'];
            //  print_r($this->request->data);die;
            if ($id != "") {
                $data = $this->User->updateAll(array('User.email' => "'" . $email . "'", 'User.phone' => "'" . $phone . "'", 'User.name' => "'" . $name . "'",), array('User.id' => $id));
            }
            $usr_data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            //  print_r($usr_data);

            if ($data) {
                $response['data'] = $usr_data;
                $response['sucess'] = 0;
                $response['msg'] = 'User profile change successfully';
            } else {
                $response['sucess'] = 1;
                $response['msg'] = 'Something went going wrong';
            }
        } else {
            $response['sucess'] = 1;
            $response['msg'] = 'Something went going wrong';
        }

        echo json_encode($response);
        exit;
    }

    public function api_user() {
        configure::write('debug', 0);
        if ($this->request->is('post')) {
            $id = $this->request->data['id'];
            $data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            if ($data) {
                if ($data['User']['image']) {
                    if (filter_var($data['User']['image'], FILTER_VALIDATE_URL)) {
                        // do nothing
                    } else {
                        $data['User']['image'] = FULL_BASE_URL . '/grouptrip/files/profile_pic/' . $data['User']['image'];
                    }
                }
                $response['data'] = $data;
                $response['status'] = 0;
            } else {
                $response['msg'] = 'Sorry There are no data';
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

    public function api_resetpassword() {
        configure::write('debug', 0);

        if ($this->request->is('post')) {
            $password = AuthComponent::password($_POST['old_password']);
            $em = $_POST['email'];
            $pass = $this->User->find('first', array('conditions' => array('AND' => array('User.password' => $password, 'User.email' => $em))));
            //print_r($pass);die;
            if ($pass) {
                $this->User->data['User']['password'] = $_POST['new_password'];
                $this->User->id = $pass['User']['id'];
                if ($this->User->exists()) {
                    $pass['User']['password'] = $_POST['new_password'];
                    if ($this->User->save()) {
                        $response['status'] = 0;
                        $response['msg'] = "Your password has been reset";
                    }
                }
            } else {
                $response['status'] = 1;
                $response['msg'] = "Your old password do not match";
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something went going wrong!!';
        }
        echo json_encode($response);
        exit;
    }

    public function api_saveimage() {
        Configure::write('debug', 0);
        $one = $_POST['img'];
        $img = base64_decode($one);
        $im = imagecreatefromstring($img);
        if ($im !== false) {
            $image = "1" . time() . ".png";
            imagepng($im, WWW_ROOT . "files" . DS . "profile_pic" . DS . $image);
            imagedestroy($im);
            $response['msg'] = "image is uploaded";
            $this->User->recursive = 2;
            $id = $_POST['id'];
            $img = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $image;
            $data = $this->User->updateAll(array('User.image' => "'$image'"), array('User.id' => $id));
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

    public function admin_login() {

        $this->layout = "admin2";
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect(array(
                            'controller' => 'dashboards',
                            'action' => 'index',
                            'admin' => true
                ));
            } else {
                $this->Flash->error(__('Invalid Credentials!'));
            }
        }
    }

    public function admin_index() {

        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
        //$this->set(compact(array('users')));
    }

    public function admin_view($id = null) {
        configure::write("debug", 0);
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->request->data['User']['role'] = 'customer';
            $image = $this->request->data['User']['image'];

            $uploadFolder = "profile_pic";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['User']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
            } else {
                $this->request->data['User']['image'] = '';
            }
            if ($this->User->hasAny(array('User.email' => $this->request->data['User']['email']))) {
                $this->Session->setFlash(__('Email already exist in Database!!!'));
                return $this->redirect(array('action' => 'add'));
            } else {
                $this->request->data['User']['email'] = $this->request->data['User']['email'];
                $email = $this->request->data['User']['email'];
                if ($this->request->data['User']['status'] == 'active') {
                    $this->request->data['User']['status'] = '1';
                } else {
                    $this->request->data['User']['status'] = '0';
                }
                $this->User->create();
            }

            if ($this->User->save($this->request->data)) {
                $updates = $this->User->getInsertID();
                $this->Session->setFlash('The user has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.');
            }
        } else {
            $this->Session->setFlash('Something going wrong');
        }
    }

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->User->delete()) {
            $this->Session->setFlash('User deleted');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Something went wrong');
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_edit($id = NULL) {
        Configure::write("debug", 0);
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['User']['modified'] = date('Y-m-d H:i:s');
            $this->User->id = $id;
            $image = $this->request->data['User']['image'];
            $uploadFolder = "profile_pic";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['User']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
            } else {
                $this->request->data['User']['image'] = $this->request->data['User']['pic'];
            }
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('User has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('There is some error saving plan');
                return $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->request->data = $editusr = $this->User->read(null, $id);
            $this->set(compact("editusr"));
        }
    }

    public function admin_logout() {

        $this->Session->setFlash('Good-Bye');

        $this->redirect($this->Auth->logout());
    }

    public function admin_changepassword() {

        if ($this->request->is('post')) {
            $password = AuthComponent::password($this->data['User']['old_password']);
            $em = $this->Auth->user('email');
            $pass = $this->User->find('first', array('conditions' => array('AND' => array('User.password' => $password, 'User.email' => $em))));
            if ($pass) {
                if ($this->data['User']['new_password'] != $this->data['User']['cpassword']) {
                    // $this->Flash->error('New password and Confirm password field do not match.', array( 'key' => 'positive'));
                    $this->Session->setFlash('New password and Confirm password field do not match.', 'default', array('class' => 'success-message'), 'success');
                } else {
                    $this->User->data['User']['password'] = $this->data['User']['new_password'];
                    $this->User->id = $pass['User']['id'];
                    if ($this->User->exists()) {
                        $pass['User']['password'] = $this->data['User']['new_password'];
                        if ($this->User->save()) {
                            //$this->Flash->success('Password Updated.', array( 'key' => 'positive'));
                            $this->Session->setFlash('Password Updated.', 'default', array('class' => 'success-message'), 'success');
                            $this->redirect(array('controller' => 'Users', 'action' => 'index'));
                        }
                    }
                }
            } else {
                $this->Session->setFlash('Your old password did not match.', 'default', array('class' => 'success-message'), 'success');
                // $this->Flash->error('Your old password did not match.', array( 'key' => 'positive'));
            }
        }
    }

    /*     * Forget Password */

    public function forgetpwd() {
        // Configure::write('debug', 2); 
        $this->layout = "admin2";
        $this->User->recursive = -1;
        if (!empty($this->data)) {
            if (empty($this->data['User']['email'])) {
                $this->Session->setFlash('Please provide the email you used to sign up');
            } else {
                $username = $this->data['User']['email'];
                $fu = $this->User->find('first', array('conditions' => array('User.email' => $username)));
                if ($fu['User']['email']) {
                    $key = Security::hash(CakeText::uuid(), 'sha512', true);
                    $hash = sha1($fu['User']['email'] . rand(0, 100));
                    $url = Router::url(array('controller' => 'Users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
                    $ms = "<p>Click the Link below to reset your password.</p><br /> " . $url;
                    $fu['User']['tokenhash'] = $key;
                    $this->User->id = $fu['User']['id'];
                    if ($this->User->saveField('tokenhash', $fu['User']['tokenhash'])) {
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Reset Your Password')->to($fu['User']['email'])->send($ms);
                        $this->set('smtp_errors', "none");
                        $this->Flash->success('Check Your Email To Reset your password.', array('key' => 'positive'));
                    } else {
                        $this->Flash->error('Error Generating Reset link.', array('key' => 'positive'));
                    }
                } else {
                    $this->Flash->error('This Email does not exist!', array('key' => 'positive'));
                }
            }
        }
    }

    public function reset($token = null) {
        $this->layout = "admin2";
        configure::write('debug', 2);
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytokenhash($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                        $this->Flash->error('Both the passwords are not matching...', array('key' => 'positive'));
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['email'] = $u['User']['email'];
                    $new_hash = sha1($u['User']['email'] . rand(0, 100));
                    //created token 
                    $this->User->data['User']['tokenhash'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        if ($this->User->save($this->User->data)) {
                            $this->Flash->success('Password Has been Updated', array('key' => 'positive'));
                            $this->redirect(array('controller' => 'users', 'action' => 'login'));
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else {
                $this->Flash->error('Token Corrupted, Please Retry.the reset link work only for once.', array('key' => 'positive'));
            }
        } else {
            $this->Flash->error('Pls try again...', array('key' => 'positive'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function api_userlisting() {
        $userlisting = $this->User->find('all', array('conditions' => array('User.role' => 'customer')));
        $user_listing = array();
        foreach ($userlisting as $list) {

            $list['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $list['User']['image'];
            $user_listing[] = $list;
        }
        //  print_r($user_listing);die;
        if ($user_listing) {
            $response['status'] = 0;
            $response['msg'] = 'User Listing';
            $response['data'] = $user_listing;
        } else {
            $response['status'] = 1;
            $response['data'] = 'Data not available';
        }

        echo json_encode($response);
        exit;
    }

    public function api_namesearch() {
        if ($this->request->is('post')) {
            $code = $_POST['code'];
            $user_id = $_POST['user_id'];
            $search = $this->User->find("all", array('conditions' => array('AND' => array('User.name LIKE' => "$code%", 'User.id !=' => $user_id))));
            $image = array();
            foreach ($search as $data) {
                if ($data['User']['image'] == null) {
                    $data['User']['image'] = null;
                } else if (filter_var($data['User']['image'], FILTER_VALIDATE_URL)) {
                    
                } else {
                    $data['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $data['User']['image'];
                }

                $image[] = $data;
            }

            if ($image) {
                $response['status'] = 0;
                $response['data'] = $image;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'No data available';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'No data available';
        }
        echo json_encode($response);

        exit;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    public function api_airportcode() {
        $this->loadModel('Airportcode');
        if ($this->request->is('post')) {
            $city = $this->request->data['city'];  //send city name


            if ($city) {
                $cityname = $this->Airportcode->find("all", array('conditions' => array('Airportcode.city LIKE' => "$city%")));
                if (!empty($cityname)) {
                    $response['status'] = 0;
                    $response['data'] = $cityname;
                } else {
                    $response['status'] = 1;
                    $response['msg'] = 'Something going wronge';
                }
            } else {
                $response['status'] = 1;
                $response['msg'] = 'Something missing';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'No data available';
        }

        echo json_encode($response);
        exit;
    }

    public function api_countrycode() {  ////////// full data
        $this->loadModel('Countrycode');
        $country = $this->Countrycode->find('all');
        if ($country) {
            $response['status'] = 0;
            $response['data'] = $country;
        } else {
            $response['status'] = 1;
            $response['msg'] = 'No data available';
        }
        echo json_encode($response);
        exit;
    }

    ///////////////////////// get country name /////////////////////////////////////////////////////////////////////// 
    public function api_countrysearch() {       ////////country name
        $this->loadModel('Countrycode');
        if ($this->request->is('post')) {
            $code = $_POST['code'];

            $search = $this->Countrycode->find("all", array('conditions' => array('Countrycode.name LIKE' => "$code%")));


            if ($search) {
                $response['status'] = 0;
                $response['data'] = $search;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'No data available';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'No data available';
        }
        echo json_encode($response);

        exit;
    }

    ///////////////////////// get currency code ///////////////////////////////////////////////////////////////////////
    public function api_currencycode() {
        Configure::write("debug", 0);
        $this->loadModel('Currencycode');
        if ($this->request->is('post')) {
            $code = $_POST['code']; //search with country name

            $search = $this->Currencycode->find("all", array('conditions' => array('Currencycode.country_name LIKE' => "$code%")));
            if ($search) {
                $response['status'] = 0;
                $response['data'] = $search;
            } else {
                $response['status'] = 1;
                $response['msg'] = 'No data available';
            }
        } else {
            $response['status'] = 1;
            $response['msg'] = 'No data available';
        }
        echo json_encode($response);

        exit;
    }

    public function api_country() {
        $this->loadModel('Country');
        $country = $this->Country->find("all");
        if ($country) {
            $response['data'] = $country;
            $response['status'] = 0;
            $response['msg'] = "Counrty listing";
        } else {
            $response['status'] = 1;
            $response['msg'] = "No data available";
        }
        echo json_encode($response);

        exit;
    }

    public function api_phone_code() {
        $this->loadModel('Phonecode');
        $country = $this->Phonecode->find("all");
        if ($country) {
            $response['data'] = $country;
            $response['status'] = 0;
            $response['msg'] = "Counrty listing";
        } else {
            $response['status'] = 1;
            $response['msg'] = "No data available";
        }
        echo json_encode($response);

        exit;
    }
    
    public function api_phonecode(){
          $this->loadModel('Phonecode');
       if($this->request->is('post')){
           $code = $this->request->data['code'];
           if($code){
               $data = $this->Phonecode->find("first", array('conditions' => array('Phonecode.nicename' => $code)));
               if($data){
                    $response['data'] = $data;
                    $response['status'] = 0;
                    $response['msg'] = "Phone code";
               }else{
                     $response['status'] = 1;
                     $response['msg'] = "No data available";
               }
           }
            
        }else{
             $response['status'] = 1;
             $response['msg'] = "Something going wrong";
        }
           echo json_encode($response);

        exit;
    }

}

?>