<?php
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
require 'pass.php';

$apiKey 		= $pass['apiKey'];
$apiSecret 		= $pass['apiSecret'];
$accessToken 	= $pass['accessToken'];
$accessSecret	= $pass['accessSecret'];

$connection = new TwitterOAuth($apiKey, $apiSecret, $accessToken, $accessSecret);

$tokyo = '23424856';
$trend = $connection -> get("trends/place", ['id' => $tokyo]);

foreach($trend[0] -> trends as $data)
{
	foreach((array)$data -> name as $d)
	{
		echo $d, PHP_EOL;
	}
}
