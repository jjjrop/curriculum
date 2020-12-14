<?php

class DBController
{
  /**
   * データベースに接続
   */
  public static function DBConnect() {
    $server = "mysql10030.xserver.jp";
    $userName = "nanablog1114_db";
    $password = "sibrin103";
    $dbName = "nanablog1114_db";

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
    $dsn = 'mysql:dbname=nanablog1114_db;host=mysql10030.xserver.jp';
    $userName = "nanablog1114_db";
    $password = "sibrin103";
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
    $dsn = 'mysql:dbname=nanablog1114_db;host=mysql10030.xserver.jp';
    $userName = "nanablog1114_db";
    $password = "sibrin103";
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
    $dsn = 'mysql:dbname=nanablog1114_db;host=mysql10030.xserver.jp';
    $userName = "nanablog1114_db";
    $password = "sibrin103";
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
    $dsn = 'mysql:dbname=nanablog1114_db;host=mysql10030.xserver.jp';
    $userName = "nanablog1114_db";
    $password = "sibrin103";
    $dbh= new PDO($dsn, $userName, $password);

    // クエリの実行
    $stmt = $dbh->query($command);
  }
}







