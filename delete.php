<?php
session_start();
$id = $_POST['id'];
$pass = $_POST['password'];

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
	$prepare = $dbh -> prepare('SELECT * FROM `posts` WHERE `posts`.`id` = :id');
	if ($prepare !== false)
	{
		$prepare -> bindValue(':id', $id);
		$prepare -> execute();
		$data = $prepare ->fetchAll(PDO::FETCH_ASSOC);
		foreach($data as $key => $val)
		if (password_verify($pass, $val['password']))
		{
			$prepare = $dbh -> prepare('DELETE FROM `posts` WHERE `posts`.`id` = :id');
			if ($prepare !== false)
			{
				$prepare -> bindValue(':id', $id);
				$prepare -> execute();
				$_SESSION['msg'] = '=== 削除に成功しました ===';
			}
		}
		else
		{
			$_SESSION['msg'] = '=== パスワードが違います ===';
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
