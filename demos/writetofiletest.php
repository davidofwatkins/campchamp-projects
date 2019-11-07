<?php

if(!is_writeable("autoimport_log.txt")) echo "Not writable";
		
if (!$fp = fopen("autoimport_log.txt", "w")) die("Cannot open file");

if (fwrite($fp, "Finished auto import at " . date('Y-m-d H:i:s') . "\n") === FALSE) die("Can't write");
fclose($fp);

echo "Wrote file";

?>