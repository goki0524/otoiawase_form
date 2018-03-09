<!DOCTYPE html>
<html lang="ja">
<head>
  <title>検索ページ</title>
  <meta charset="utf-8">
</head>
<body>
  <form action="" method="post">
  <p>検索したいnicknameを入力してください。</p>
  <input type="text" name="nickname">
  <input type="submit" value="検索">
</form>
<!-- ここからPHPコードを記述する -->
<?php
  // １．データベースに接続する
  $dsn = 'mysql:dbname=phpkiso;host=localhost';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8');

  // POSTでデータが送信された時のみSQLを実行する
  if (!empty($_POST)) {
    // ２．SQL文を実行する
    $sql = 'SELECT * FROM `inquiries` WHERE `nickname` = ' . $_POST['nickname'];
    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // データを取得する
    while (1) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($rec == false) {
        break;
      }
      echo $rec['nickname'] . '<br>';
      echo $rec['email'] . '<br>';
      echo $rec['content'] . '<br>';
      echo '<hr>';
    }
  }

  // ３．データベースを切断する
  $dbh = null;
?>



</body>
</html>