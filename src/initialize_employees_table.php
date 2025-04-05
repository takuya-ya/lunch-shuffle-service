<?php

// DBに接続
$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
// 接続エラーのバリデーション
// connect_error 接続エラーの内容（文字列）を返すプロパティ
if ($mysqli->connect_error) {
  // PHP組み込み例外クラス:「実行時に予期せぬ問題が発生」を表示
  throw new RuntimeException('mysqli接続エラー: ' . $mysqli->connect_error);
}

// どのタイミングで実行？
$mysqli->query("DROP TABLE IF EXISTS employees");

$createTableSql = <<<EOL
    CREATE TABLE IF NOT EXISTS employees (
        id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4
EOL;

$mysqli->query($createTableSql);
$mysqli->close();
