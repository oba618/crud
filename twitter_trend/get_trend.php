<?ph
//require 'twitter_connect.php';

require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
require 'pass.php';

$apiKey 		= $pass['apiKey'];
$apiSecret 		= $pass['apiSecret'];
$accessToken 	= $pass['accessToken'];
$accessSecret	= $pass['accessSecret'];

$connection = new TwitterOAuth($apiKey, $apiSecret, $accessToken, $accessSecret);

$tokyo = '23424856';
$trend = $connection -> get("trends/place", ['id' => $tokyo]);
