<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Browse - <?php echo $title_for_layout; ?></title>
	<?php

		//echo $this->Html->css('cake.generic');
                echo $this->Html->css(array("style", "admin"));
                echo $this->Html->script(array("jquery.min"));
	?>
</head>
<body>
    
    <?php echo $this->element("titlebar"); ?>
        
    <div id="admin-navbar">
        <a class="admin-navitem <?php if ($this->action == "halls") echo "active"; ?>" href="<?= $this->webroot ?>admin/halls"><div>Manage Residence Halls</div></a><a
        class="admin-navitem <?php if ($this->action == "edit") echo "active"; ?>" href="<?= $this->webroot ?>admin/edit"><div>Add Residence Hall</div></a><a
        class="admin-navitem <?php if ($this->action == "users") echo "active"; ?>" href="<?= $this->webroot ?>admin/users"><div>Manage Users</div></a><a
        class="admin-navitem <?php if ($this->action == "overrides") echo "active"; ?>" href="<?= $this->webroot ?>admin/overrides"><div>Housing Overrides</div></a>
    </div>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?>
        
</body>
</html>
