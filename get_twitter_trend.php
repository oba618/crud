<?php
date_default_timezone_set('Asia/Tokyo');
$this_year = date("Y");
$this_month = date("m");
$today = date("d");
$save_dir = __DIR__ .'/twitter_data/'; 
$file = $save_dir .$this_year . $this_month .'.php';
$this_time = date("Y-m-d H:i:s");

if (!file_exists($file)){
	file_put_contents($file, "");
}

$current = file_get_contents($file);
$text = '';
$i = 0;
require 'twitter_trend/twitter_connect.php';
foreach($trend[0] -> trends as $data)
{
	if ($i >= 10)
	{
		break;
	}
	$text .= $data -> name.':'.$data -> tweet_volume.'<br>';
	$i++;
}

$current = '<h2>'. $this_time .'</h2>'."\n".$text.'<br>'."\n".$current; 
file_put_contents($file, $current);
