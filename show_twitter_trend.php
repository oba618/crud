<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
$this_year = date("Y");
$this_month = date("m");
$open_file = './twitter_data/' . $this_year . $this_month . '.php';
if (isset($_SESSION['month'])){
	$open_file = './twitter_data/' . $_SESSION['month'] . '.php';
}
require 'header.php';
?>
<div class="content">
	<h1>twitter_trend_tokyo</h1>
	<h2 class="content_sort">トレンド検索</h2>
	<form action="search_trend.php" method="post">
		<p>検索ワードを入れてください<br>
		<input class="input_name" type="text" name="word"></p>
		<p>検索期間：
		<select name="date">
<?php
for($i=1; $i<=12; $i++){
	if ($i < 10){
		$i = sprintf('%02d',$i);
	}
	if (file_exists('./twitter_data/'. 2020 . $i . '.php')){
		?><option value="2020<?php echo $i; ?>">2020年<?php echo $i; ?>月</option><?php
	}
}
?>
		</select></p>
		<input class="button button_create" type="submit" name="send" value="検索">
	</form>
</div>
<div class="content">
	<h2 class="content_graph">トレンドグラフ</h2>
	<canvas id="myLineChart"></camvas>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
	<script>
	const data = {
		labels: [<?php 
			foreach($_SESSION['days'] as $days_key => $days_value){
				echo '"' . $days_key . '"' . ',';
			}
			?>],
		datasets: [{
			label: '<?php echo $_SESSION['word'] ?>',
			data: [
				<?php
					foreach($_SESSION['days'] as $v){
						echo $v . ',';
					}
				?>
			],
			borderColor: "aqua",
		}],
	};
	Chart.defaults.global.defaultFontColor = 'white';
	Chart.defaults.global.elements.rectangle.borderWidth = 2;
	var ctx = document.getElementById("myLineChart");
	var myLineChart = new Chart(ctx, {
		type: 'line',
		data: data,
		options: {
			scales: {
				yAxes: [{
					gridLines: {
						color: "rgba(255,255,255,0.3)",
					},
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}
	});
	</script>
</div>
<div class="content">
<?php
if (isset($_SESSION['check']))
{
	if ($_SESSION['search'])
	{
		foreach($_SESSION['search'] as $search)
		{
			echo $search;
		}
	}
	else
	{
		echo '見つかりませんでした。';
	}
}
else if (file_exists($open_file))
{
	//require $open_file;
	$fp = fopen($open_file, 'r');
	while($text = fgets($fp)){
		if (strpos($text, 'h2')){
			echo $text;
		} else if (strpos($text, '<br>')){
			$array = explode('<br>', $text);
			$i = 0;
			foreach($array as $a){
				if ($i >= 10 || $a === ""){
					break;
				}
				$i++;
				$string = mb_strstr($a, ':');
				$t = strpos($a , ':');
				$moji = substr($a, 0 , $t);
				$int = (int)substr($string, 1);
				switch ($int){
					case 0:
						echo '<span class="trend_0">' . $moji . ' : ' . number_format($int) . '</span><br>';
					break;
					case $int < 50000:
						echo '<span class="trend_5">' . $moji . ' : ' . number_format($int) . '</span><br>';
					break;
					case $int < 100000:
						echo '<span class="trend_10">' . $moji . ' : ' . number_format($int) . '</span><br>';
					break;
					case $int < 1000000:
						echo '<span class="trend_20">' . $moji . ' : ' . number_format($int) . '</span><br>';
					break;
					case $int >= 1000000:
						echo '<span class="trend_100">' . $moji . ' : ' . number_format($int) . '</span><br>';
					break;
					default:
						echo '<span class="trend_default">' . $moji . ' : ' . number_format($int) . '</span><br>';
				}
			}
		}
	}
}
else
{
	echo 'No data.';
}
?>
</div>

<?php
require 'footer.php';
unset($_SESSION['check']);
unset($_SESSION['search']);
unset($_SESSION['word']);
unset($_SESSION['days']);
unset($_SESSION['month']);
?>
