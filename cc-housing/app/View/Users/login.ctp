<?php echo $this->Html->css(array("login")); ?>

<img id="biglogo" src="<?php echo $this->webroot; ?>img/champlain_logo.jpg" />
<h2 id="subtitle">Department of Residential Life</h2>
<h1 id="maintitle">Online Housing Selection</h1>

<?= $this->Session->flash(); ?>

<form id="login" method="post" action="<?= $this->webroot ?>users/login">
    <p id="welcometext">Welcome! Please sign in with your Champlain College username and password below to get started:</p>
    <p><input type="text" id="username" class="large" name="data[User][username]" placeholder="Username" /><span class="inputlabel">@mymail.champlain.edu</span></p>
    <p><input type="password" id="password" class="large" name="data[User][password]" placeholder="Password" /></p>
    <p><input type="submit" /></p>
</form>

<?php

/*echo $this->Form->create('User', array('action' => 'login'));
echo $this->Form->input('username', array("label" => false));
echo $this->Form->input('password', array("label" => false));
echo $this->Form->end('Login');*/

?>