<?php

session_start();

require_once('config.php');
require_once('functions.php');

if (empty($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

$dbh = connectDatabase();
$sql = "select * from posts";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<h3>投稿されたブログ一覧</h3>
<?php if (count($posts)) : ?>
  <?php foreach($posts as $post) : ?>
  <ul>
    <li class="link"><a href="detail.php"><?php echo h($post['title'])?>（作成日：<?php echo h($post['updated_at'])?>）</a>｜[<a href="edit.php?id=<?php echo h($post['id'])?>">編集</a>]｜[<a href="delete.php?id=<?php echo h($post['id'])?>">削除</a>]</li>
  </ul>
  <?php endforeach ?>
<?php else : ?>
  投稿された日記はありません。
<?php endif ?>

<footer>
  <p><a href="http://nowall.co.jp">株式会社 NOWALL</a></p>
  <small>2015 NOWALL,Inc. All Right Reserved.</small>
</footer>
</div>
</body>
</html>