<?php

require_once('config.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $errors = array();

  if ($name == '') {
    $errors['name'] = 'ユーザー名が未入力です';
  }

  if ($email == '') {
    $errors['email'] = 'メールアドレスが未入力です';
  }

  if ($password == '') {
      $errors['password'] = 'パスワードが未入力です';
    }

  if (empty($errors)) {
    $dbh = connectDatabase();
    $sql = "insert into users (name, email, created_at, password) values (:name, :email, now(), :password)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    header('Location: login.php');
    exit;
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>新規登録画面</title>
  <link type="text/css" rel="stylesheet" href="reset.css">
  <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
<nav>
  <ul>
    <li class="on"><a href="#">ホーム</a></li>
    <li class="on"><a href="#">日記一覧</a></li>
    <li class="on"><a href="#">日記追加</a></li>
    <li class="on"><a href="#">ログイン</a></li>
  </ul>
</nav>
<h1>ELITES Blog</h1>
<h2>ELITES 公式開発ブログ</h2>
<form action="" method="post">
  <table>
   <tr>
      <th>ユーザ名</th>
      <td>
      <input type="text" name="name">
      <?php if ($errors['name']) : ?>
        <?php echo h($errors['name']); ?>
      <?php endif ?>
      </td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td>
      <input type="text" name="email">
       <?php if ($errors['email']) : ?>
        <?php echo h($errors['email']); ?>
      <?php endif ?>
      </td>
    </tr>
    <tr>
      <th>パスワード</th>
      <td>
      <input type="password" name="password">
       <?php if ($errors['password']) : ?>
        <?php echo h($errors['password']); ?>
      <?php endif ?>
      </td>
    </tr>
  </table>
  <input type="submit" value="登録する">
  </form>
<a href="login.php">ログイン画面はこちら!</a>
<footer>
  <p><a href="http://nowall.co.jp">株式会社 NOWALL</a></p>
  <small>2015 NOWALL,Inc. All Right Reserved.</small>
</footer>
</body>
</html>