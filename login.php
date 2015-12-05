<?php

session_start();

if (!empty($_SESSION['id'])) {
  header('Location: index.php');
  exit;
}

require_once('config.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $email = $_POST['email'];
  $password = $_POST['password'];
  $errors = array();

  if ($email == '') {
    $errors['email'] = 'メールアドレスが未入力です';
  }

  if ($password == '') {
      $errors['password'] = 'パスワードが未入力です';
    }

  if (empty($errors)) {
    $dbh = connectDatabase();
    $sql = "select * from users where email = :email and password = :password";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    $row = $stmt->fetch();
    //var_dump($row);

    if ($row) {
      $_SESSION['id'] = $row['id'];
      $_SESSION['name'] = $row['name'];
      header('Location: index.php');
      exit;
    } else {
      $errors['notmatch'] = 'メールアドレスかパスワードが間違っています';
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ログイン画面</title>
  <link type="text/css" rel="stylesheet" href="reset.css">
  <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
<nav>
  <ul>
    <li class="on"><a href="#">ホーム</a></li>
    <li class="on"><a href="#">日記一覧</a></li>
    <li class="on"><a href="#">日記追加</a></li>
    <li class="on"><a href="logout.php">ログアウト</a></li>
  </ul>
</nav>
<h1>ELITES Blog</h1>
<h2>ELITES 公式開発ブログ</h2>
<form action="" method="post">
  <table>
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
       <?php if ($errors['notmatch']) : ?>
        <?php echo h($errors['notmatch']); ?>
       <?php endif ?>
      </td>
    </tr>
  </table>
  <input type="submit" value="ログイン">
  </form>
<a href="regist.php">新規会員登録はこちら!</a>
<footer>
  <p><a href="http://nowall.co.jp">株式会社 NOWALL</a></p>
  <small>2015 NOWALL,Inc. All Right Reserved.</small>
</footer>
</body>
</html>