<?php
$open_file = './202011.php';
$write_file = './test.json';
$fp = fopen($open_file, 'r');
$wp = fopen($write_file, 'w');
$write_start = '['.PHP_EOL;
$allArray = array();
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
                    $allArray[] = ['name'=>$key, 'value'=>$value];
                }
            }
        }
    }
}
fclose($fp);
var_dump($allArray);
$f_total = 0;
foreach ($allArray as $data){
    if ($data['name'] === '#嵐の日'){
        $f_total += $data['value'];
    }
}
echo '嵐の日=' . $f_total;