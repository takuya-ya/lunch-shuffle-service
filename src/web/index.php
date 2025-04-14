<?php

// 初期化処理をまとめたファイル。ファイルに記述しても問題ないが、処理をまとめる為に別ファイルへ
require '../bootStrap.php';
require '../Application.php';

$app = new Application();
$app->run();
