<?php
    echo $this->Html->css(array("admin-manage-users"));    
?>

<h1>Manage Users</h1>
        
<div id="table-tools">
    <p><input type="text" id="student-search" placeholder="Search..." /></p>
    <div id="table-pages">
        <div class="pagebutton">1</div>
        <div class="pagebutton">2</div>
        <div class="pagebutton">3</div>
        <div class="pagebutton">...</div>
        <div class="pagebutton">100</div>
    </div>
    <div style="clear: both"></div>
</div>

<table id="student-list">
    <tr><th>Last Name</th><th>First Name</th><th>Username</th><th>Graduation Year</th><th>Gender</th><th>Current Location</th><th>Registration Window</th></tr>
<?php
    foreach ($userdata as $userdetails) {
        $user = $userdetails["User"];
        $room = $userdetails["Room"];
        echo "<tr>";
        echo '<td>' . $user["lastname"] . "</td><td>" . $user["firstname"] . "</td><td>" . $user["username"] . "</td><td>" . $user["grad_year"] . "</td><td>" . $user["gender"] . "</td><td>";
        if (isset($room["room_num"])) {
            echo $room["Floor"]["Hall"]["name"] . " " . $room["room_num"];
        }
        echo "</td><td>" . $user["window_open"] . "</td>";
        echo "</tr>";
    }
?>
</table>