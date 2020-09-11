<?php
$file = '/var/www/html/crud/batch_test/time.txt';
$current = file_get_contents($file);;

date_default_timezone_set('Asia/Tokyo');
$current .= date("Y-m-d H:i:s"). "\n";

file_put_contents($file, $current);
