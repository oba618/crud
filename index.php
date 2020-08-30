<?php
$db_host = getenv('CRUD_HOST');;
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
				$err_msg = '=== 書き込み失敗しました ===';
		}
		else
			$err_msg = '=== 名前とコメントを記入してください ===';
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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SECRET_BOARD</title>
	<link rel="stylesheet" href="CRUD.css">
</head>
<body>
	<div class="header">
		<h1>SECRET_BOARD</h1>
		<p>Ver2.0</p>
	</div>
	<p>更新情報</p>
	<ul>
		<li>8/30 セキュリティ強化</li>
		<li>8/29 Create機能追加</li>
	</ul>
	<h2>入力フォーム</h2>
	<form method="post" action="">
		<p>名前<br><input type="text" name="name" value="" /></p>
		<p>コメント</br><textarea name="comment" rows="4" cols="40"></textarea></p>
		<input type="submit" name="send" value="投稿" />
	</form>
<?php
if ($msg !== '')
	echo '<p>'.$msg.'</p>';
if ($err_msg !== '')
	echo '<p>'.$err_msg.'</p>';
foreach($data as $key =>$val)
	echo $val["id"].' ',$val["name"].' '.htmlspecialchars($val["comment"]).' '.$val["date"].'<br>';
?>

</body>
</html>
