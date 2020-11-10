<?php
session_start();

$word = htmlspecialchars($_POST['word']);
$search_date = htmlspecialchars($_POST['date']);
$month = (int)substr($search_date, -2);

if (!$word){
	$_SESSION['month'] = $search_date;
	header ('Location: show_twitter_trend.php');
	exit;
}

$_SESSION['check'] = true;
$total = 0;
$file_name = './twitter_data/' . $search_date . '.php';
$fp = fopen($file_name, 'r');
$days = array();
for($a=1; $a<=31; $a++){
	$re = array($a => 0);
	$days = array_replace($days, $re);
}
$int = 0;

while($text = fgets($fp))
{
	if (!strpos($text, 'h2'))
	{
		$array = explode('<br>', $text);
		foreach($array as $a)
		{
			if (strpos($a, $_POST['word']))
			{
				$string =  mb_strstr($a , ':');
				$int = (int)substr($string, 1);
				$total = $total + $int;
				$search[] = $h2;
				$search[] = htmlspecialchars($a). '<br>';
				if ($h2_day === $h2_day_check){
					$add_int = $days[$h2_day] + $int;
					$replace = array($h2_day => $add_int);
					$days = array_replace($days, $replace);
				} else {
				$replace = array($h2_day => $int);
				$days = array_replace($days, $replace);
				$h2_day_check = $h2_day;
				}
			}
		}
	}
	else
	{
		$h2 = $text;
		$h2_day = (int)substr($h2, 12, 2);
	}
}
$last = '<div class="search_answer">「'.$_POST['word'].'」のボリューム合計：'.number_format($total). '</div>' ;
array_unshift($search, $last);
$_SESSION['search'] = $search;
$_SESSION['days'] = $days;
$_SESSION['word'] = $_POST['word'] . '：' . $month . '月';
header ('Location: show_twitter_trend.php');
exit;
