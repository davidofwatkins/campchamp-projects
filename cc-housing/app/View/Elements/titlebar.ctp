<div id="titlebar">
    <img id="expand-dormlist-button" src="<?php echo $this->webroot; ?>img/show-sidebar.png" />
    <h1><?php
        if (isset($halldata) && $this->params['controller'] != "admin"  && $this->params['action'] != "details") {
            echo $halldata[0]["Hall"]["name"];
        }
    ?></h1>
    <div id="campchamplinks">
        <?php
            //if (isAdmin())
            //echo '<a href="' . $this->webroot . 'admin/halls" target="_blank">Admin</a> |';
        ?>
        <a href="http://www.champlain.edu/" target="_blank">Champlain.edu</a> |
        <a href="http://www.champlain.edu/current-students" target="_blank">Current Students</a> |
        <a href="https://my.champlain.edu/login/webadvisor" target="_blank">Web Advisor</a>
    </div>
    <?php
        if (isset($currentRoomDetails["room_num"])) {
            echo '<div id="user-room-summary">Your new room is <b>' . $currentRoomDetails["hall_name"] . " " . $currentRoomDetails["room_num"] . '</b>.</div>';
        }
    ?>
    <div style="clear: both;"></div>
</div>