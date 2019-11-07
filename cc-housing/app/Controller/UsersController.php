<?php

class UsersController extends AppController {

    public $helpers = array('Html', 'Form');
    public $layout = "default";
    
    public function index() {
        $this->redirect("/users/login");
    }
    
    public function login() {
        
        //If login information is being sent to the page...
        if ($this->request->is('post')) {
            
            //If the user is authenticated...
            if ($this->Auth->login()) {
                
                if ($this->isAdmin()) $this->redirect("/admin/halls");
                else $this->redirect("/halls");
            }
            else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
    }
    
    /*public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }*/
    
    public function registerRoom() {
        
        //debug($this->request->data);
        
        $targetRoomID = $this->request->data["room_id"];
        
        $this->loadModel('Room');
        $roomdata = $this->Room->find("all", array(
            "conditions" => array("Room.id" => $targetRoomID),
            "recursive" => 1
        ));
        
        $roomdata = $roomdata[0];
        $currentUser = $this->getCurrentUser();
        $regWindow = new DateTime($currentUser["window_open"]);
        $currentTime = new DateTime();
        
        //If there's not enough room for a new resident, deny
        if (sizeof($roomdata["User"]) >= $roomdata["Room"]["max_occupancy"]) {
            $this->error("Sorry, this room is currently full.");
        }
        
        //If this room is "not active", deny
        else if ($roomdata["Room"]["is_active"] != 1) {
            $this->error("Sorry, this room is not available right now.");
        }
        
        //If the current user does not match the gender requirements for this room, deny
        else if (($roomdata["Room"]["gender_restriction"] != "any" || !isset($roomdata["Room"]["gender_restriction"])) && $roomdata["Room"]["gender_restriction"] != $currentUser["gender"]) {
            $this->error("Sorry, you must be " . $roomdata["Room"]["gender_restriction"] . " to live here.");
        }
        
        //If the grad years don't match, deny
        else if (($roomdata["Room"]["year_restriction"] != "any" || !isset($roomdata["Room"]["year_restriction"])) && $roomdata["Room"]["year_restriction"] != $currentUser["grad_year"]) {
            $this->error("Sorry, this room is restricted to the class of " . $roomdata["Room"]["year_restriction"] . ".");
        }
        
        //If the user's registration window isn't open yet, deny
        else if ($regWindow > $currentTime) {
            $this->error("Sorry, your registration window hasn't openedd yet.");
        }
        
        //We're good; register the user!
        else {
            $this->User->read(null, $currentUser["id"]);
            $this->User->set(array(
                "room_id" => $roomdata["Room"]["id"],
                "room_confirmed" => 1
            ));
            $this->User->save();
            
            //echo "<b>Arrangement Saved!</b>";
            
            $this->redirect("/users/confirmed");
        }
        //debug($currentUser);
        //debug($roomdata);
   }
   
   public function confirmed() {
       
       $this->set("userdata", $this->User->find("all", array(
           "conditions" => array("User.id" => CakeSession::read("Auth.User.id")),
           "recursive" => 3
       )));
   }
}
?>