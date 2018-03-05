<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
header('Access-Control-Allow-Origin: *');

class StaticpagesController extends AppController {

    public $components = array('Session', 'Flash', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('admin_add','admin_index','admin_delete','api_staticpage');
    }
    
 
    public function admin_add() {
        if ($this->request->is('post')) {
            
            $image = $this->request->data['Staticpage']['image'];
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
                $this->request->data['Staticpage']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
            } else {
                $this->request->data['Staticpage']['image'] = '';
            }
         
            if ($this->Staticpage->save($this->request->data)) {
              
                $this->Session->setFlash('The page has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The page could not be saved. Please, try again.');
            }
        } else {
            $this->Session->setFlash('Something going wrong');
        }
    }
       public function admin_index() {

        $this->Staticpage->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
        //$this->set(compact(array('users')));
    }
    
  
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Staticpage->id = $id;
        if (!$this->Staticpage->exists()) {
            throw new NotFoundException('Invalid');
        }
        if ($this->Staticpage->delete()) {
            $this->Session->setFlash('Deleted');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Something went wrong');
        return $this->redirect(array('action' => 'index'));
    }
    
        public function admin_edit($id = NULL) {
        Configure::write("debug", 0);
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Staticpage']['modified'] = date('Y-m-d H:i:s');
            $this->Staticpage->id = $id;
            $image = $this->request->data['Staticpage']['image'];
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
                $this->request->data['Staticpage']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
            } else {
                $this->request->data['Staticpage']['image'] = $this->request->data['Staticpage']['pic'];
            }
            if ($this->Staticpage->save($this->request->data)) {
                $this->Session->setFlash('Changes has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('There is some error saving plan');
                return $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->request->data = $editusr = $this->Staticpage->read(null, $id);
            $this->set(compact("editusr"));
        }
    }
    
    public function api_staticpage(){
        if($this->request->is('post')){
           $title = $this->request->data['title'];
     $page = $this->Staticpage->find('first', array('conditions' => array('Staticpage.title' => $title)));
      if($page){
          $response['status'] = 0;
          $response['msg'] = 'Success';
          $response['data'] = $page;
      }else{
          $response['status'] = 1;
          $response['msg'] = 'Something going wrong';
      }
         
    }  else{
         $response['status'] = 1;
          $response['msg'] = 'Something going wrong';
    }
    echo json_encode($response);
        exit; 
        }
      

}