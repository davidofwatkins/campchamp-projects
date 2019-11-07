<?php

class LoginController extends AppController {

    public $helpers = array('Html', 'Form');
    public $layout = "default";
    
    public function index() {
        
        //$this->set('posts', $this->Post->find('all')); //$this->Post refers to the model
        //$this->set("browser_layout", "Browser Layout");
        //$this->layout = "administration";
        
        /*echo "Username: " . $this->request->data["username"];
        echo "<br />Password: " . $this->request->data["password"];
        echo "<br />Hashed password: " . Security::hash($this->request->data["password"], 'blowfish');*/
    }
    
    public function beforeFilter() {
        //Users do not need to be logged into these pages:
        $this->Auth->allow('index');
    }
}
?>