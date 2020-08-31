<?php include('conect.php'); ?>

<html lang="ja">
<head>
	<meta charset ="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
	<title>SECRET_BOARD</title>
	<link rel="stylesheet" href="./css/reset.css">
	<link rel="stylesheet" href="./css/style.css">
	<link rel="stylesheet" href="./css/plugin.css">
	<script type="text/javascript" src="./js/script.js"></script>
</head>
<body>
	<div class="header">
		<h1 class="header_title">SECRET_BOARD</h1>
		<p class="header_ver small_font">Ver2.2</p>
	</div>
	<div class="content">
	<h2 class="content_title">更新情報</h2>
	<ul class="content_info">
		<li>8/30 セキュリティ強化</li>
		<li>8/29 Create機能追加</li>
	</ul>
	</div>
	<div class="content">
	<h2 class="content_title">入力フォーム</h2>
	<form method="post" action="create.php">
		<p>名前（20文字まで）<br><input class="input_name" type="text" name="name" value="" /></p>
		<p>コメント（180文字まで）</br><textarea class="input_text" name="comment" rows="4" cols="40"></textarea></p>
		<input type="hidden" name="token" value="<?php echo $token;?>">
		<input class="create_button" type="submit" name="send" value="投稿" />
<?php
if (isset($_SESSION['msg']))
{
	echo '<p>'. $_SESSION['msg'] .'</p>';
	unset($_SESSION['msg']);
}
?>
	</form>
	</div>
	<div class="content">
<?php
foreach($data as $key =>$val)
	echo '<div class="post"><p><span class="small-font">'.$val["id"].'</span> '
	,htmlspecialchars($val["name"]).'<br>'
	.htmlspecialchars($val["comment"]).'<br>
	<span class="small-font">'.$val["date"].'</span></p></div>';
?>
	</div>
	<div class="footer">
	© tobata
	</div>
</body>
</html>
