<?php
// ここは、index.php、submitの移動先です。
// 二重submit防止
// conect.phpで生成されたtokenとsession_tokenを比較して同じならcreate
// その後、index.phpにリダイレクト
session_start();
$token = isset($_POST['token']) ? $_POST['token'] : '';
$session_token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
unset($_SESSION['token']);

if ($_POST['send'] !== '' && $token === $session_token)
{
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
		// formデータを代入、名前とコメントを確認
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		// 文字数制限の確認
		if (strlen($name) > 20)
		{
			$_SESSION['msg'] = '=== 名前が長すぎます ===';
			header ('Location: index.php');
		}
		if (strlen($comment) >= 180)
		{
			$_SESSION['msg'] = '=== コメントが長すぎます ===';
			header ('Location: index.php');
		}
		$date = date("Y-m-d H:i:s");
		if ($name !== '' && $comment !== '')
		{
			// create機能
			$prepare = $dbh -> prepare('INSERT INTO posts VALUES (NULL, :name, :comment, :date)');
			if ($prepare !== false)
			{
				$prepare -> bindValue(':name', $name);
				$prepare -> bindValue(':comment', $comment);
				$prepare -> bindValue(':date', $date);
				$prepare -> execute();
				$_SESSION['msg'] = '=== 書き込みに成功しました ===';
			}
			else
				$_SESSION['msg'] = '=== 書き込み失敗しました ===';
		}
		else
			$_SESSION['msg'] = '=== 名前とコメントを記入してください ===';
	}
	catch (PDOException $e)
	{
		$error = $e -> getMessage();
	}
}
else
	$_SESSION['msg'] = '=== creat_error ===';
header ('Location: index.php');
exit;
