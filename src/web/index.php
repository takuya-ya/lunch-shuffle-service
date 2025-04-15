<?php

// 初期化処理をまとめたファイル。ファイルに記述しても問題ないが、処理をまとめる為に別ファイルへ
  // ファイルを読み込んだ時点でファイルが実行され、インスタンス作成とメソッドが実行される
require '../bootStrap.php';
require '../Application.php';

$app = new Application();
$app->run();
