<?php
App::uses('AppModel', 'Model');
class User extends AppModel {
     public function beforeSave($options = array()) {
        if(isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
      public $hasMany = array(
        'Gallery' => array(
            'className' => 'Gallery',
            'foreignKey' => 'user_id'
            
        )
    );
}