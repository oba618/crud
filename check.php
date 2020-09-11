<?php
$id = htmlspecialchars($_POST['id']);
$name = htmlspecialchars($_POST['name']);
$comment = htmlspecialchars($_POST['comment']);

require 'header.php'; ?>
	<div class="content">
		<h2 class="content_title">編集する</h2>
		<p>
	<?php 
		echo 'No, '.$id.'<br>';
		echo 'Name, '.$name.'<br>';
		echo 'Comment: '.$comment.'<br>';
		echo 'Date: '.$_POST['date'].'<br>';
	?>
		</p>
		<form method="post" action="update.php">
			<p>名前（20文字まで）<br>
			<input class="input_name" type="text" name="name" value="<?php echo $name; ?>" /></p>
			<p>コメント（180文字まで）<br>
			<textarea class="input_text" name="comment" rows="4" cols="40"><?php echo $comment; ?></textarea></p>
			<p>パスワード<br>
			<input class="input_name" type="text" name="password" value="" /></p>
			<input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
			<input class="button button_update" type="submit" name="update" value="編集" />
		</form>
	</div>
	<div class="content">
		<h2 class="content_title">削除する</h2>
		<form method="post" action="delete.php">
			<p>パスワード<br><input class="input_name" type="text" name="password" value="" /></p>
			<input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
			<input class="button button_delete" type="submit" name="delete" value="削除" />
		</form>
	</div>
<?php 'footer.php' ?>
