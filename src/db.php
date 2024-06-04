<?php

$host = 'mysql'; // MySQLコンテナのサービス名
$dbname = getenv('MYSQL_DATABASE');
$username = 'root';
$password = getenv('MYSQL_ROOT_PASSWORD');

# 新しいPDOオブジェクトを作成し、MySQLデータベースに接続
try {
  $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  # SQL文を実行
  $stmt = $db->prepare('SELECT * FROM mytable');
  $stmt->execute();

  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($results as $result) {
    echo $result['id'] . '. ' . $result['name'] . PHP_EOL;
  }
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
}
