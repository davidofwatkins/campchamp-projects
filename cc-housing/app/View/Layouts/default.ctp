<!DOCTYPE html>
<html>
    <head>
        <title>Champlain College Housing | Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--<link type="text/css" rel="stylesheet" href="common/css/style.css" />
        <link type="text/css" rel="stylesheet" href="common/css/login.css" />-->
        <?php
            echo $this->Html->css(array("style"));
            echo $this->Html->script(array("jquery.min"));
        ?>
        
    </head>
    <body>
        <?php echo $this->element("titlebar"); ?>
        <?php echo $this->fetch('content'); ?>
    </body>
</html>