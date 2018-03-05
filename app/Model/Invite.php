<?php
App::uses('AppModel', 'Model');
class Invite extends AppModel {
  public $belongsTo = array(
        'Trip' => array(
            'className' => 'Trip',
            'foreignKey' => 'trip_id'
        ),
 
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'frd_id'
        )
      
    );
 
}