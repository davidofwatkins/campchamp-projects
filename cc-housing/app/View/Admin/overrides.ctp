<?php
    echo $this->Html->css(array("admin-manage-housing"));
?>
<div class="info-box">
    <form id="register-user" method="post" action="#">
        <h1>Register Housing for User</h1>
        <p id="override-statement">
            Register <input type="text" id="username" name="username" placeholder="Resident" /> in 
            <select id="hall" name="hall">
                <?php
                
                    foreach ($halls as $hall) {
                        echo '<optgroup label="' . $hall["Hall"]["name"] . '">';
                        foreach ($hall["Floor"] as $floor) {
                            foreach ($floor["Room"] as $room) {
                                echo '<option value="' . $room["id"] . '">Room ' . $room["room_num"] . '</option>';
                            }
                        }
                        echo '</optgroup>';
                    }
                
                ?>
                <!--<option value="cushing">Cushing Hall</option>
                <option value="spinner">Spinner Place</option>
                <option value="sanders">Sanders Hall</option>
                <option value="whiting">Whiting Hall</option>
            </select>
            room 
            <select id="room" name="room">
                <option value="101">101</option>
                <option value="102">102</option>
                <option value="103">103</option>
                <option value="104">104</option>
            </select>-->
        </p>
        <input type="submit" />
    </form>
</div>

<div class="info-box">
    <form id="register-swap" method="post" action="#">
        <h1>Swap Residence</h1>

        <div class="leftright">
            <p><label for="firstuser">First Resident:</label></p>
            <input type="text" id="firstuser" name="firstuser" />
        </div>
        <div class="leftright">
            <img id="swap-icon" src="<?php echo $this->webroot; ?>img/switcher.png" />
        </div>
        <div class="leftright">
            <p><label for="seconduser">Second Resident:</label></p>
            <input type="text" id="seconduser" name="seconduser" />
        </div>
        <input type="submit" value="Swap Residences"/>
    </form>
</div>