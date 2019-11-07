<?php
App::uses('AppModel', 'Model');
/**
 * Floor Model
 *
 * @property Hall $Hall
 * @property Room $Room
 */
class Floor extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Hall' => array(
			'className' => 'Hall',
			'foreignKey' => 'hall_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'floor_id',
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
