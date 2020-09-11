<?php
$prepare = $dbh -> prepare('SELECT * FROM posts');
$prepare -> execute();
$data = $prepare ->fetchAll(PDO::FETCH_ASSOC);
arsort($data);

