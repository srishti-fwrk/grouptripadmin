<?php
App::uses('AppModel', 'Model');
class Gallery extends AppModel {
     public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
         'Trip' => array(
            'className' => 'Trip',
            'foreignKey' => 'id'
        )
    );
   
}