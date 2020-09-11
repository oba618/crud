<?php
session_start();
$id = $_POST['id'];
$name = $_POST['name'];
$comment = $_POST['comment'];
$date = date("Y-m-d H:i:s");
$pass = $_POST['password'];


// データベースに接続
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
	// idとkeyの照合
	$prepare = $dbh -> prepare('SELECT * FROM `posts` WHERE `posts`.`id` = :id');
	if ($prepare !== false)
	{
		$prepare -> bindValue(':id', $id);
		$prepare -> execute();
		$data = $prepare ->fetchAll(PDO::FETCH_ASSOC);
		foreach($data as $key => $val)
		if (password_verify($pass, $val['password']))
		{
			$prepare = $dbh -> prepare('UPDATE `posts` SET `name` = :name, `comment` = :comment, `date` = :date WHERE `posts`.`id` = :id');
			if ($prepare !== false)
			{
				$prepare -> bindValue(':name', $name);
				$prepare -> bindValue(':comment', $comment);
				$prepare -> bindValue(':date', $date);
				$prepare -> bindValue(':id', $id);
				$prepare -> execute();
				$_SESSION['msg'] = '=== 編集に成功しました ===';
			}
			else
				$_SESSION['msg'] = '=== 編集に失敗しました ===';
		}
		else
		{
			$_SESSION['msg'] = '=== パスワードが違います!! ===';
			header ('Location: index.php');
			exit;
		}
	}
}
catch (PDOException $e)
{
	$error = $e -> getMessage();
}
header ('Location: index.php');
exit;
