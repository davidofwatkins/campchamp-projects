<?php
    echo $this->Html->css(array("confirm"));
    echo $this->Html->script(array("jquery-ui.min"));  
?>

<?php
    $userdata = $userdata[0];
    //debug($userdata)
?>

<style>
    body {
        text-align: center;
    }
    h1 {
        font-size: 60px;
        text-shadow: 0 0 20px gray;
    }
    h2 {
        font-size: 30px;
        font-weight: normal;
    }
    h3 {
        font-size: 25px;
        font-weight: normal;
    }
    p {
        font-size: 18px;
    }
</style>

<h1>You're Done!</h1>
<h2>We have you down for <b><?= $userdata["Room"]["Floor"]["Hall"]["name"] ?>, Room <?= $userdata["Room"]["room_num"] ?></b> next semester.</h2>
<p>If you have any questions about your room, you can email Residential Life at <a href="mailto:reslife@champlain.edu">reslife@champlain.edu</a> or call them at (802) 860-2702.</p>
<h3>We'll see you next semester, and have a great break!</h3>