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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $errors = array();

  if ($title == '') {
    $errors['title'] = "タイトルが入力されておりません。";
  }

  if ($content == '') {
    $errors['content'] = "本文が入力されておりません。";
  }

  if (empty($errors)) {
    $dbh = connectDatabase();
    $sql = "update posts set title = :title, content = :content, updated_at = now() where id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":content", $content);
    $stmt->execute();

    // ホーム画面へ飛ばす
    header('Location: index.php');
    exit;
  }
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
<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th>タイトル</th>
    <td ><input type="text" name="title" value="<?php echo h($row['title']) ?>" class="box"><br>
    <?php if ($errors['title']) : ?>
         <?php echo h($errors['title']) ?>
    <?php endif ?>
    </td>
  </tr>

  <tr>
    <th>本文</th>
    <td><textarea name="content" cols="30" rows="5"><?php echo h($row['content']) ?></textarea><br>
    <?php if ($errors['content']) : ?>
         <?php echo h($errors['content']) ?>
    <?php endif ?>
    </td>
  </tr>
</table>
<p><input type="submit" name="submit" value="編集する" width="50px"></p>
</form>

<footer>
  <p><a href="http://nowall.co.jp">株式会社 NOWALL</a></p>
  <small>2015 NOWALL,Inc. All Right Reserved.</small>
</footer>
</div>
</body>
</html>