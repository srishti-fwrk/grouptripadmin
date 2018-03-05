<?php
App::uses('AppController', 'Controller');
class DashboardsController extends AppController {
       public function beforeFilter() {
        parent::beforeFilter();
           $this->Auth->allow('admin_index','admin_dashboardview');
        // $this->Auth->allow('admin_index');
    }

    public function admin_dashboard() {
//        Configure::write("debug", 2);
//        $this->loadModel('Dashboard');
//        $data=$this->Dashboard->find('all',array('limit'=>30, 'order' => array(
//                'Dashboard.id' => 'desc'
//            )));
//        $this->set('data',$data);
    }
    public function admin_dashboardview($id=NULL) {
        Configure::write("debug", 2);
        $this->loadModel('Dashboard');
        $data=$this->Dashboard->find('all',array('conditions'=>array('Dashboard.id'=>$id)),array('limit'=>30, 'order' => array(
                'Dashboard.id' => 'desc'
            )));
        $this->set('data',$data);
    }

    public function admin_index($id=NULL) {
        Configure::write("debug",0);
        //$this->layout = "admin2";
        $this->loadModel('User');
          $this->loadModel('Trip');
        $trip = $this->Trip->find('all', array('conditions' => array('Trip.status' => '0')));
        $this->set('trip', $trip);
        $users = $this->User->find('all', array('conditions' => array('User.role'=>'customer')));
 
        $admin = $this->User->find('all', array('conditions' => array('User.role'=>'admin')));
        $this->set(array('user' => $users,'admin'=>$admin));
    }
}