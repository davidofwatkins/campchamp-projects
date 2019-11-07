<?php
App::uses('AppModel', 'Model');
/**
 * Room Model
 *
 * @property Floor $Floor
 * @property User $User
 */
class Room extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Floor' => array(
			'className' => 'Floor',
			'foreignKey' => 'floor_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Floor.floor_num ASC'
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'room_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
