<?php echo $this->Html->css(array("login")); ?>
<div id="titlebar">
    <div id="campchamplinks">
        <a href="#" target="_blank">Champlain.edu</a>
        <a href="#" target="_blank">My Champlain</a>
        <a href="#" target="_blank">Web Advisor</a>
        <a href="#" target="_blank">Angel</a>
        <a href="#" target="_blank">Library</a>
    </div>
    <div style="clear: both;"></div>
</div>

<img id="biglogo" src="<?php echo $this->webroot; ?>img/champlain_logo.jpg" />
<h2 id="subtitle">Department of Residential Life</h2>
<h1 id="maintitle">Online Housing Selection</h1>

<?= $this->Session->flash(); ?>

<!--<form id="login" method="post" action="<?= $this->webroot ?>users/login">
    <p id="welcometext">Welcome! Please sign in with your Champlain College username and password below to get started:</p>
    <p><input type="text" id="username" class="large" name="username" placeholder="Username" /><span class="inputlabel">@mymail.champlain.edu</span></p>
    <p><input type="password" id="password" class="large" name="password" placeholder="Password" /></p>
    <p><input type="submit" /></p>
</form>-->

<?php

echo $form->create('User', array('action' => 'login')); // creating user form with 2 fields email and password
echo $form->input('email');
echo $form->input('password');
echo $form->end('Login');

?>