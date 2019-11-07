<?php

class HallsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $layout = "resbrowser";  
    
    public function index() {
        
        $this->set("hallList", $this->Hall->find("list", array(
            "fields" => array("id_name", "name")
        )));
        
        $this->set("hallDetails", $this->Hall->find("all", array(
            "recursive" => 0
        )));
    }
    
    public function view($id = null) {
            
        $this->set("hallList", $this->Hall->find("list", array(
            "fields" => array("id_name", "name")
        )));

        $this->set("halldata", $this->Hall->find("threaded", array(
            "conditions" => array("id_name" => $id),
            "recursive" => 3
        )));
    }
    
    public function details($hall_id = null, $room_id = null) {
        $this->layout = "default";
        
        $this->set("halldata", $this->Hall->find("all", array(
            "conditions" => array("Hall.id_name" => $hall_id),
            "recursive" => 1
        )));
        
        $this->loadModel('Room');
        $this->set("roomdata", $this->Room->find("all", array(
            "conditions" => array("Room.id" => $room_id),
            "recursive" => 1
        )));
        
        $this->loadModel("User");
        $this->set("allusers", $this->User->find("all"));
    }
    
    public function beforeFilter() {
        
        //debug($this->getCurrentUser());
        
        $current = $this->getCurrentUser();
        $rmid = $current["room_id"];
        
        if (isset($rmid)) {
        
            $this->loadModel('Room');
            $roomDetails = $this->Room->find("threaded", array(
                "conditions" => array("Room.id" => $rmid),
                "recursive" => 2
            ));

            $rmNum = $roomDetails[0]["Room"]["room_num"];
            $hallName = $roomDetails[0]["Floor"]["Hall"]["name"];

            //debug($roomDetails);

            //$this->set("user", $this->getCurrentUser());

            $this->set("currentRoomDetails", array(
                "room_num" => $rmNum,
                "hall_name" => $hallName
            ));
        }
    }
}
?>