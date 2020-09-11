<?php
// creat.phpにて二重submit防止
session_start();
$token = uniqid('', true);
$_SESSION['token'] = $token;

// データベースに接続 .htaccessファイルに環境変数を設定しています。
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
	// read機能 投稿データを読み込む
	include('select.php');
	$dbh = null;
}
catch (PDOException $e)
{
	$error = $e -> getMessage();
}
