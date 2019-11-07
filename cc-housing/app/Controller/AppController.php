<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $components = array(
        'Session',
        'Auth' => array( //When the user logs in/out, redirect them here:
            'loginRedirect' => array('controller' => 'halls', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home')
        )
    );
    
    public function beforeFilter() {
        //Users do not need to be logged into these pages:
        //$this->Auth->allow('login');
    }
    
    public function login() {
        /*if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }*/
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    public function isAdmin() {
        
        if (!$this->Auth->user()) return false;
        
        $this->loadModel('User');
        $userData = $this->User->find("threaded", array(
            "conditions" => array("User.id" => CakeSession::read("Auth.User.id")),
        ));
        
        $permission_level = $userData[0]["User"]["permission_level"];

        //Based on returned data, redirect to appropriate place
        if ($permission_level == 1) return true;
        else return false;
    }
    
    public function getCurrentUser() {
        
        if (CakeSession::read("Auth.User.id")) {
            $this->loadModel('User');
            $user = $this->User->find("threaded", array(
                "conditions" => array("User.id" => CakeSession::read("Auth.User.id")),
            ));

            $user = $user[0]["User"];
            return $user;
        }
        else {
            return null;
        }
    }
    
    public function error($text) {
        //Test redirect
        $this->Session->setFlash($text);
        $this->redirect($this->referer());
        die();
    }
}
