<?php

class AdminController extends AppController {

    public $helpers = array('Html', 'Form');
    public $layout = "administration";
    
    //BeforeFilter() is applied to every view for this controller
    public function beforeFilter() {
        if (!$this->isAdmin()) {
            $this->redirect("/users/login");
        }
    }
    
    public function index() {
        
        //$this->set('posts', $this->Post->find('all')); //$this->Post refers to the model
        //$this->set("browser_layout", "Browser Layout");
        //$this->layout = "administration";
    }
    
    public function users() {
        //$this->set("browser_layout", "Browser Layout");
        //$this->layout = "administration";
        
        $this->loadModel('User');
        $this->set("userdata", $this->User->find("threaded", array(
            "contain" => array("Hall"),
            "recursive" => 3
        )));
    }
    
    public function halls() {
        $this->loadModel('Hall');
        //$this->set("halls", $this->Hall->find("all"));
        $this->set("halls", $this->Hall->find("all", array(
            //"conditions" => array("id_name" => $id),
            "recursive" => 3
        )));
    }
    
    public function edit($hall_idname = null) {
        
        $this->loadModel('Hall');
        if (isset($hall_idname)) {
            $this->set("halldata", $this->Hall->find("all", array(
                "conditions" => array("id_name" => $hall_idname),
                "recursive" => 2
            )));
        }
    }
    
    public function overrides() {
        $this->loadModel('Hall');
        $this->set("halls", $this->Hall->find("all", array(
            "recursive" => 2
        )));
    }
    
    public function submitRes() {
        
        $floorsData = stripslashes($_POST["floorsdata"]);
        $floorsData = json_decode($floorsData, true);
        
        //-----echo "<h1>Data sent in JSON format:</h1>";
        //-----debug($floorsData);
        
        //Calculate the distance to campus
        if (isset($_POST["mapcoords"])) {
            $resLoc = $_POST["mapcoords"];
            $resLatLong = split(",", $resLoc);
            $distance = $this->getDistance($resLatLong[0], $resLatLong[1], 44.47334717045448, -73.20396423339844);
            $newHallData["campus_distance"] = round($distance, 1);
        }
        
        //Create new data fields
        if (isset($_POST["editing"])) $newHallData["id"] = $_POST["editing"];
        $newHallData["name"] = $_POST["dormname"];
        $newHallData["id_name"] = $_POST["id_name"];
        $newHallData["living_type"] = $_POST["arrangement"];
        $newHallData["foursquare_id"] = $_POST["foursquareid"];
        $newHallData["map_coords"] = $_POST["mapcoords"];
        $newHallData["description"] = $_POST["description"];

        $i = 0;
        foreach ($floorsData as $floor) {

            if ($floor["isNew"] == "false") {
                $newHallData["Floor"][$i]["id"] = $floor["id"];
            }
            else {
                $newHallData["Floor"][$i]["floorplan_img_uri"] = $this->saveImage($_FILES[$floor["name"]], WWW_ROOT . "img/resfloorplans/");
            }
            
            $newHallData["Floor"][$i]["floor_num"] = $floor["floornum"];

            $j = 0;
            foreach ($floor["rooms"] as $room) {
                if (isset($room["rmid"])) $newHallData["Floor"][$i]["Room"][$j]["id"] = $room["rmid"];
                $newHallData["Floor"][$i]["Room"][$j]["room_num"] = $room["rmnum"];
                $newHallData["Floor"][$i]["Room"][$j]["floorplan_coords"] = $room["rmcoords"];
                $newHallData["Floor"][$i]["Room"][$j]["gender_restriction"] = $room["rmgender"];
                $newHallData["Floor"][$i]["Room"][$j]["max_occupancy"] = $room["rmcapacity"];
                $newHallData["Floor"][$i]["Room"][$j]["sqft"] = $room["rmsize"];
                $newHallData["Floor"][$i]["Room"][$j]["year_restriction"] = $room["rmyear"];
                $newHallData["Floor"][$i]["Room"][$j]["is_active"] = 1;
                $j++;
            }

            $i++;
        }

        //Check for image uploads and deal with them
        $i = 1;
        foreach ($_FILES as $key => $upload) {
            
            $lastKeyChar = substr($key, -1);
            
            if ($key == "picture" . $lastKeyChar && isset($_POST["cropcoords" . $lastKeyChar]) && $_POST["cropcoords" . $lastKeyChar] != "") {
                
                $coords = split(",", $_POST["cropcoords" . $lastKeyChar]);
                $coordsAssoc = array(
                    "x" => $coords[0],
                    "y" => $coords[1],
                    "x2" => $coords[2],
                    "y2" => $coords[3],
                    "w" => $coords[4],
                    "h" => $coords[5]
                );
                
                $newImage = $this->saveImage($upload, WWW_ROOT . "img/resimages/", $coordsAssoc);
                if (isset($newImage) && $newImage != false) $newHallData["HallImage"][$i]["img_uri"] = $newImage;
                $i++;
            }
        }

        //----echo "<h1>The following data will be sent to the databse:</h1>";
        //----debug($newHallData);
        
        $this->loadModel('Hall');
        $this->Hall->saveAssociated($newHallData, array('deep' => true));

        //-----echo "<h1>Data written to db!</h1>";
        
        //If everything worked, redirect!
        if (isset($_POST["editing"]))
            $this->Session->setFlash(__('Residence Hall Updated'));
        else
            $this->Session->setFlash(__('Residence Hall Added'));
        $this->redirect('/admin/halls');

        //$log = $this->Hall->getDataSource()->getLog(false, false);
        //debug($log);
    }
    
    //make sure the target director has rwx for global users (chmod 777 should work)
    private function saveImage($file, $directory, $cropcoords = null) {
        //return "randomstring.jpg";
        
        //Validation/upload code adapted from: 	http://www.w3schools.com/php/php_file_upload.asp
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $file["name"]));
        

        if ((($file["type"] == "image/gif") || ($file["type"] == "image/jpeg") || ($file["type"] == "image/png") || ($file["type"] == "image/jpeg")) && ($file["size"] < 5242880) && in_array($extension, $allowedExts)) {
            
            //If the file has an error, display it
            if ($file["error"] > 0) {
                    echo '<p style="color: red">Found error in file upload!</p>';
                    die("Error in Image");
            }
            //Otherwise, carry on to saving the file:
            else {
                $uniqueFilename = uniqid();
                if (move_uploaded_file($file["tmp_name"], $directory . $uniqueFilename . "." . $extension)) { //. $file["name"])) {

                    if (isset($cropcoords))
                        
                        $this->cropImage($directory . $uniqueFilename . "." . $extension, $cropcoords);
                    
                    return $uniqueFilename . "." . $extension; //$file["name"];
                }
                else {
                    die("Failed moving picture");
                }
            }
        }
        else { die("Bad filetype or file size."); }
        
    }
    
    private function cropImage($src, $coords) {

        if (pathinfo($src, PATHINFO_EXTENSION) == "jpg" || pathinfo($src, PATHINFO_EXTENSION) == "jpeg")
            $source_image = imagecreatefromjpeg($src);
        
        else if (pathinfo($src, PATHINFO_EXTENSION) == "png")
            $source_image = imagecreatefrompng($src);
        
        else if (pathinfo($src, PATHINFO_EXTENSION) == "gif")
            $source_image = imagecreatefromgif($src);
        
        else
            die("Invalid Image Format: " . $src);

        //Create virtual image
        $virtual_image = imagecreatetruecolor($coords["w"], $coords["h"]);

        //copy source image at a resized size
        //imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $width, $height, $width, $height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, $coords["x"], $coords["y"], $coords["w"], $coords["h"], $coords["w"], $coords["h"]);

        //create the physical thumbnail image to its destination
        if (pathinfo($src, PATHINFO_EXTENSION) == "jpg") {
                if (!imagejpeg($virtual_image, $src)) { die("Error: Cannot create image. Check permissions?"); }
        }
        else if (pathinfo($src, PATHINFO_EXTENSION) == "png") {
                if (!imagepng($virtual_image, $src)) { die("Error: Cannot create image. Check permissions?"); }
        }
        else if (pathinfo($src, PATHINFO_EXTENSION) == "gif") {
                if (!imagegif($virtual_image, $src)) { die("Error: Cannot create image. Check permissions?"); }
        }
    }
    
    //Found here: http://snipplr.com/view/2531/
    private function getDistance($lat1, $lng1, $lat2, $lng2, $miles = true) {
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;
 
	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;
 
	return ($miles ? ($km * 0.621371192) : $km);
    }
}
?>