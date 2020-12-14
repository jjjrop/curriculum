<?php

require_once '/home/nanablog1114/jjjrop.com/dotenv.php';
class DBController
{
  /**
   * データベースに接続
   */
  public static function DBConnect() {
    $server = DB_SERVER;
    $userName = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbName = DB_DBNAME;

    try {
      $mysql = new mysqli($server, $userName, $password, $dbName);
    } catch (Exception $ex) {
      echo "DB接続エラー";
    }
    return $mysql;
  }

  /**
   * DBから1つのデータを値として取得
   * 
   * @param string $command mysqlコマンド
   */
  public static function selectOne($command) {
    $dsn = DB_DSN;
    $userName = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbh= new PDO($dsn, $userName, $password);

    // クエリの実行
    $stmt = $dbh->query($command);

    // 表示処理
    while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
      return $row[0];
    }
  }

  /**
   * DBからデータを配列で取得
   * 
   * @param string $command mysqlコマンド
   */
  public static function selectArray($command) {
    $dsn = DB_DSN;
    $userName = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbh= new PDO($dsn, $userName, $password);

    // クエリの実行
    $stmt = $dbh->query($command);

    // 表示処理
    while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
      return $row;
    }
  }

  /**
   * DBにデータを挿入
   * 
   * @param string $command mysqlコマンド
   */
  public static function insert($command) {
    $dsn = DB_DSN;
    $userName = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbh= new PDO($dsn, $userName, $password);

    // クエリの実行
    $stmt = $dbh->query($command);
  }



  // public static function insert($command) {
  //   mysqli_query(self::DBConnect(), $command);
  // }

  /**
   * DBのデータを更新
   * 
   * @param string $command mysqlコマンド
   */
  public static function update($command) {
    $dsn = DB_DSN;
    $userName = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbh= new PDO($dsn, $userName, $password);

    // クエリの実行
    $stmt = $dbh->query($command);
  }
}







