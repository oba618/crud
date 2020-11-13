<?php
$open_file = './202011.php';
$write_file = './test.json';
$fp = fopen($open_file, 'r');
$wp = fopen($write_file, 'w');
$write_start = '['.PHP_EOL;
fwrite($wp, $write_start);
while($text = fgets($fp)){
    if (!strpos($text, 'h2')){
        $array = explode('<br>', $text);
        foreach($array as $data){
            if ($data !== ""){
                $string = mb_strstr($data, ':');
                $t = strpos($data, ':');
                $key = substr($data, 0 ,$t);
                $value = (int)substr($string, 1);
                if ($key && $value) {
                    $tojson = '{"word":"'. $key . '","count":'. $value .'},' . PHP_EOL;
                    fwrite($wp, $tojson);
                }
            }
        }
    }
}
fclose($wp);
fclose($fp);

$fh = fopen($write_file, 'r+');
$stat = fstat($fh);
ftruncate($fh, $stat["size"]-2);
fclose($fh);

$wp = fopen($write_file, 'a');
$write_goal = ']';
fwrite($wp, $write_goal);
fclose($wp);

readfile($write_file);