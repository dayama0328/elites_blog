<?php

session_start();

require_once('config.php');
require_once('functions.php');

if (empty($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

$id = $_GET['id'];

$dbh = connectDatabase();
$sql = "select * from posts where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$row = $stmt->fetch();

if (!$row) {
  header('Location: index.php');
  exit;
}

?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ELITES Blog</title>
  <link type="text/css" rel="stylesheet" href="reset.css">
  <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
<div id="wrapper">
<nav>
  <ul>
    <li class="on"><a href="index.php">ホーム</a></li>
    <li class="on"><a href="list.php">日記一覧</a></li>
    <li class="on"><a href="add.php">日記追加</a></li>
    <li class="on"><a href="logout.php">ログアウト</a></li>
  </ul>
</nav>
<h1>ELITES Blog</h1>
<h2>ELITES 公式開発ブログ</h2>
<h3>日記編集ページ</h3>

<form action="" method="post">
<h4>タイトル：<?php echo h($row['title']) ?></h4>
<p>作成日：<?php echo h($row['updated_at']) ?><span>｜作成者：<?php echo h($row['name']) ?></span></p>
<p>本文<br>
<?php echo h($row['content']) ?></p>
</form>

<footer>
  <p><a href="http://nowall.co.jp">株式会社 NOWALL</a></p>
  <small>2015 NOWALL,Inc. All Right Reserved.</small>
</footer>
</div>
</body>
</html>