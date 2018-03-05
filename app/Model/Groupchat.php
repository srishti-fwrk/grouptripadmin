<?php
App::uses('AppModel', 'Model');
class Groupchat extends AppModel {
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id'
        )
    );
   
}