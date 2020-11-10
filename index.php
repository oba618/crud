<?php
require 'conect.php';
require 'header.php';
?>
	<div class="content">
		<h2 class="content_title toggle_menu">更新情報<span class="toggle_menu_try">▼</span></h2>
		<ul class="content_info">
			<li>11/5 BOARDページをトグルメニュー化</li>
			<li>9/9 TREND機能追加</li>
			<li>9/2 Update機能追加</li>
			<li>9/1 Delete機能追加</li>
			<li>8/30 セキュリティ強化</li>
			<li>8/29 Create Read機能追加</li>
		</ul>
	</div>
	<div class="content">
		<h2 id="input_menu" class="content_title">入力フォーム<span class="input_try">▼</span></h2>
		<div class="input_wrapper">
		<form method="post" action="create.php">
			<p>名前（20文字まで）<br>
			<input class="input_name" type="text" name="name" value="" /></p>
			<p>コメント（180文字まで）</br>
			<textarea class="input_text" name="comment" rows="4" cols="40"></textarea></p>
			<p>編集用パスワード（20文字まで）<br>
			<input class="input_name" type="text" name="key" value="" /></p>
			<input type="hidden" name="token" value="<?php echo $token;?>">
			<input class="button button_create" type="submit" name="send" value="投稿" />
<?php
if (isset($_SESSION['msg']))
{
	echo '<p>'. $_SESSION['msg'] .'</p>';
	unset($_SESSION['msg']);
}
?>
		</form>
		</div>
	</div>
	<div class="content">
	<h2 id="comment_toggle" class="content_title">コメント<span class="comment_try">▼</span></h2>
	<div class="comment_wrapper">
<?php
foreach($data as $key =>$val)
{
	$id = htmlspecialchars($val["id"], ENT_QUOTES, 'UTF-8');
	$name = htmlspecialchars($val["name"], ENT_QUOTES, 'UTF-8');
	$comment = htmlspecialchars($val["comment"], ENT_QUOTES, 'UTF-8');
	$date = htmlspecialchars($val["date"], ENT_QUOTES, 'UTF-8');
	$password = htmlspecialchars($val["password"], ENT_QUOTES, 'UTF-8');
	echo
		'<div class="post">
			<p>'.$id.' '.$name.'<br>'.
				$comment.'<br>'.
				'<span class="small-font">'.$date.'</span>'.
			'</p>
			<div class="post_button">
				<form method="post" action="check.php">
				<input type="hidden" name="id" value=" '.$id.' ">
					<input type="hidden" name="name" value=" '.$name.' ">
					<input type="hidden" name="comment" value=" '.$comment.' ">
					<input type="hidden" name="date" value=" '.$date.' ">
					<input type="hidden" name="key" value=" '.$password.' ">
					<input class="button button_check" type="submit" name="delete" value=">>">
				</form>
			</div><!-- /.post_button -->
		</div>',PHP_EOL;
}
?>
	</div>
	</div>
<?php require 'footer.php'; ?>
