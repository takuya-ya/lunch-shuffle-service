<?php

// 初期化処理をまとめたファイル。ファイルに記述しても問題ないが、処理をまとめる為に別ファイルへ
  // ファイルを読み込んだ時点で処理が実行され、インスタンス作成とメソッドが実行される（クラス定義ファイルの場合、自動で処理は始まらない）
require '../bootStrap.php';
require '../Application.php';

$app = new Application();
$app->run();
