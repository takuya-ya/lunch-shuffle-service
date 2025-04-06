<?php
    $errors = [];
    $groups = [];

    // DBに接続
    $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');

    // 接続エラーのバリデーション
        // connect_error 接続エラーの内容（文字列）を返すプロパティ
    if ($mysqli->connect_error) {
        // PHP組み込み例外クラス:「実行時に予期せぬ問題が発生」を表示
        throw new RuntimeException('mysqli接続エラー: ' . $mysqli->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $mysqli->query('SELECT name FROM employees;');
        $employees = $result->fetch_all(MYSQLI_ASSOC);
        shuffle($employees);

        // 2名のグループで余る人の有無を確認
        $cnt = count($employees);
        if ($cnt % 2 === 0 ) {
            $groups =  array_chunk($employees, 2);
        } else {
            // var_dump($groups);
            $extra = array_pop($employees);
            $groups = array_chunk($employees, 2);
            array_push($groups[0], $extra);
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シャッフルランチ</title>
</head>

<body>
    <h1>
        <a href="./index.php">シャッフルランチ</a>
    </h1>
    <a href="./employees.php">社員を登録する</a>

    <form action="./index.php" method="post">
        <button type="submit">シャッフルする</button>
    </form>

    <!-- グループ毎に社員名を出力 -->
    <?php foreach ($groups as $i => $group) : ?>
        <h3>
            グループ<?php echo ($i + 1) ; ?>
        </h3>
        <?php foreach ($group as $employee) : ?>
            <?php echo $employee['name']; ?>
        <?php endforeach; ?>

    <?php endforeach; ?>

</body>

</html>
