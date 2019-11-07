<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Browse - <?php echo $title_for_layout; ?></title>
	<?php

		//echo $this->Html->css('cake.generic');
                echo $this->Html->css(array("style", "browser", "browser-welcome"));
                echo $this->Html->script(array("jquery.min", "browser-responsive", "dormsearch"));
	?>
</head>
<body>
    <div id="dormlist-container">
        <input type="text" id="dormsearch" placeholder="Search" />
        <img id="searchicon" src="<?php echo $this->webroot; ?>img/searchicon_black.png" />
        <ul id="dormlist">
            <?php
                foreach ($hallList as $hallid => $hallname) {
                    
                    echo '<a href="' . $this->Html->url("/", true) . 'halls/view/' . $hallid . '"><li';
                    if (isset($halldata) && $hallid == $halldata[0]["Hall"]["id_name"]) {
                        
                        echo ' class="active" ';
                    }
                    echo '>' . $hallname . '</li></a>';
                }
            ?>
            
            <?php /*<a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Adirondack Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Bader Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Bankus Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Carriage House</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Cushing Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Hill Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Jensen Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Juniper Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Lakeview Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Lyman Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Main Street Suites</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>McDonald Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>North House</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Pearl Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Quarry Hill</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Rowell Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Sanders Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Schillhammer Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>South House</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Spinner Place</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Summit Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>Whiting Hall</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>308 Maple</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>371 Main Street</li></a>
            <a href="<?php echo $this->Html->url( '/', true ); ?>halls/view/hallname"><li>396 Main Street</li></a>
             */ ?>
        </ul>
    </div>
    <div id="details">
        <?php echo $this->element("titlebar"); ?>
        <?php echo $this->fetch('content'); ?>
    </div>
</body>
</body>
</html>
