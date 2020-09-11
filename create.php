<?php
session_start();
$token = isset($_POST['token']) ? $_POST['token'] : '';
$session_token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
unset($_SESSION['token']);

if ($_POST['send'] !== '' && $token === $session_token)
{
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
		$name = $_POST['name'];
		$name_len = mb_strlen($name);
		$comment = $_POST['comment'];
		$comment_len = mb_strlen($comment);
		$date = date("Y-m-d H:i:s");
		$key = password_hash($_POST['key'], PASSWORD_DEFAULT);
		$key_len = mb_strlen($_POST['key']);
		if ($name_len >= 20)
		{
			$_SESSION['msg'] = '=== 名前が長すぎます ===';
			header ('Location: index.php');
			exit;
		}
		if ($comment_len >= 180)
		{
			$_SESSION['msg'] = '=== コメントが長すぎます ===';
			header ('Location: index.php');
			exit;
		}
		if ($key_len >= 20)
		{
			$_SESSION['msg'] = '=== パスワードが長すぎます ===';
			header ('Location: index.php');
			exit;
		}
		if ($key === '')
		{
			$_SESSION['msg'] = '=== パスワードが必要です ===';
			header ('Location: index.php');
			exit;
		}
		if ($name !== '' && $comment !== '')
		{
			$prepare = $dbh -> prepare('INSERT INTO posts VALUES (NULL, :name, :comment, :date, :key)');
			if ($prepare !== false)
			{
				$prepare -> bindValue(':name', $name);
				$prepare -> bindValue(':comment', $comment);
				$prepare -> bindValue(':date', $date);
				$prepare -> bindValue(':key', $key);
				$prepare -> execute();
				$_SESSION['msg'] = '=== 書き込みに成功しました ===';
			}
		}
		else
			$_SESSION['msg'] = '=== 名前とコメントを記入してください ===';
	}
	catch (PDOException $e)
	{
		$error = $e -> getMessage();
		$_SESSION['msg'] = $error;
	}
}
header ('Location: index.php');
exit;
