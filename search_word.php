<!-- ここからPHPコードを記述する -->
<?php
//POST送信が行われたらDB接続し、データを取得
if(isset($_POST) && !empty($_POST['content'])){
  // １．データベースに接続する
  $dsn = 'mysql:dbname=phpkiso;host=localhost';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8');

  // ２．SQL文を実行する
  // $sql = 'SELECT * FROM `inquiries` WHERE `content` = '. $_POST['content'];
  $word = $_POST['content'];
  $sql = "SELECT * FROM `inquiries` WHERE `content` LIKE '%{$word}%'";
  
  // SQLを実行
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $line = array();
  // データを取得する
  while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
      break;
    }
    $line[] = $rec;
  } 
    
    
  // ３．データベースを切断する
  $dbh = null;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>検索ページ</title>
  <meta charset="utf-8">
</head>
<body>
  <form action="" method="post">
  <p>検索したいワードを入力してください。</p>
  <input type="text" name="content">
  <input type="submit" value="検索">
</form>
<?php 
   foreach ($line as $v) {
  // echo $v;
   echo "<hr>";
   echo $v["id"]."<br>";
   echo $v["nickname"]."<br>";
   echo $v["email"]."<br>";
   echo $v["content"]."<br>";
  }  
  echo "<hr>";
 ?>
</body>
</html>