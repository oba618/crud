<?php
require 'twitter_trend/twitter_conect.php';
require '../header.php';
?>

<div class="content">
<?php
foreach($trend[0] -> trends as $data)
{
	foreach((array)$data -> name as $d)
	{
		echo "<p>" .$d. "</p>";
	}
}
?>
</div>

<?php require '../footer.php'; ?>
