<?php

    if (!$_REQUEST["html"]) {
        
        echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';
        echo '<p>Enter some html below:</p>';
        echo '<textarea name="html" style="width: 500px; height: 500px;"><script type="text/javascript" src="script.js"></script></textarea><br />';
        echo '<input type="submit" />';
        echo '</form>';
    }
    
    else {
        
        echo '<h1>Escaped HTML:</h1>';
        echo '<code>' . htmlspecialchars($_REQUEST["html"]) . '</code>';
    }

?>