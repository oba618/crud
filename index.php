<?php
$db_host = getenv('CRUD_HOST');
$db_name = getenv('CRUD_DB');
$db_user = getenv('CRUD_USER');
$db_pass = getenv('CRUD_PASS');
try
{
	$dbh = new PDO('mysql:host='.$db_host.'; dbname='.$db_name.'; charset=utf8mb4',
		''.$db_user.'',
		''.$db_pass.'',
		array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_EMULATE_PREPARES => false
		)
	);

	$msg = '';
	if (isset ($_POST['send']) === true)
	{
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$date = date("Y-m-d H:i:s");
		if ($name !== '' && $comment !== '')
		{
			$prepare = $dbh -> prepare('INSERT INTO posts VALUES (NULL, :name, :comment, :date)');
			if ($prepare !== false)
			{
				$prepare -> bindValue(':name', $name);
				$prepare -> bindValue(':comment', $comment);
				$prepare -> bindValue(':date', $date);
				$prepare -> execute();
				$msg = '=== 書き込みに成功しました ===';
			}
			else
				$msg = '=== 書き込み失敗しました ===';
		}
		else
			$msg = '=== 名前とコメントを記入してください ===';
	}
	$prepare = $dbh -> prepare('SELECT * FROM posts');
	$prepare -> execute();
	$data = $prepare ->fetchAll(PDO::FETCH_ASSOC);
	arsort($data);
	$dbh = null;
}
catch (PDOException $e)
{
	$error = $e -> getMessage();
}
?>

<html lang="ja">
<head>
	<meta charset ="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
	<title>SECRET_BOARD</title>
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="header">
		<h1 class="header_title">SECRET_BOARD</h1>
		<p class="header_ver">Ver2.1</p>
	</div>
	<div class="content">
	<h2>更新情報</h2>
	<ul class="content_info">
		<li>8/30 セキュリティ強化</li>
		<li>8/29 Create機能追加</li>
	</ul>
	</div>
	<div class="content">
	<h2>入力フォーム</h2>
	<form method="post" action="">
		<p>名前<br><input class="input_name" type="text" name="name" value="" /></p>
		<p>コメント</br><textarea class="input_text" name="comment" rows="4" cols="40"></textarea></p>
		<input type="submit" name="send" value="投稿" />
	</form>
	<?php if ($msg !== '') echo '<p>'.$msg.'</p>'; ?>
	</div>
	<div class="content">
<?php
foreach($data as $key =>$val)
	echo '<p>'.$val["id"].' '
	,htmlspecialchars($val["name"]).'<br>'
	.htmlspecialchars($val["comment"]).'<br>
	<span class="small-font">'.$val["date"].'</span></p>';
?>
	</div>
	<div class="footer">
	© tobata
	</div>
</body>
</html>
