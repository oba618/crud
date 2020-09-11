<?php
$file = '/home/jdlife/tomohiro.site/public_html/crud/trend_archive.php';
$current = file_get_contents($file);
$text = '';
$i = 0;
require 'twitter_trend/twitter_connect.php';
foreach($trend[0] -> trends as $data)
{
	if ($i >= 5)
	{
		break;
	}
	$text .= $data -> name.':'.$data -> tweet_volume.'<br>';
	$i++;
}
date_default_timezone_set('Asia/Tokyo');
$current = '<h2>'.date("Y-m-d H:i:s").'</h2>'."\n".$text.'<br>'."\n".$current; 
file_put_contents($file, $current);
