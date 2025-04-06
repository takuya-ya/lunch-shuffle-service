<?php
$errors = [];

// DBに接続
$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
// 接続エラーのバリデーション
// connect_error 接続エラーの内容（文字列）を返すプロパティ
if ($mysqli->connect_error) {
  // PHP組み込み例外クラス:「実行時に予期せぬ問題が発生」を表示
    throw new RuntimeException('mysqli接続エラー: ' . $mysqli->connect_error);
}

$result = $mysqli->query('SELECT name FROM employees;');
$employees = $result->fetch_all(MYSQLI_ASSOC);

// DBにデータ登録（METHODがPOSTの場合に実行）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $_POSTは配列なのでキー名指定が必用　指定が無いと常にfalseになる
    if ($_POST['name'] === '') {
        $errors['name'] = '社員名を入力してください';
        // $_POSTは配列なのでキー名指定が必用
    } elseif (mb_strlen($_POST['name']) > 100) {
        $errors['name'] = '100文字以内で入力してください';
    }

    // $errorsが無ければデータを登録
    if (!count($errors)) {
        $name = $_POST['name'];
        $addData = 'INSERT INTO employees (name) VALUES (?)';

        $stmt = $mysqli->prepare($addData);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();

        $mysqli->close();

        // データ追加後、即座に一覧に反映。また、POSTの重複によるデータの二重登録を防止
        // 登録ボタン推してもリロードはされない。
        header('Location: employees.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社員登録ページ</title>
</head>

<body>
    <h1>
        <a href="./index.php">シャッフルランチ</a>
    </h1>

    <?php if ($errors): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li>
                    <?php echo $error; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="./employees.php" method="post">
        <div>
            <label for="name">社員名</label>
            <input type="text" name="name">
        </div>
        <!-- <input type="submit" value="登録する">の書き方もありだが、シンプルな実装なので装飾出来る下記が主流-->
        <button type="submit">登録する</button>
    </form>

    <div>
        <h2>社員一覧</h2>
        <ul>
            <?php foreach ($employees as $employee): ?>
                <li>
                    <?php echo $employee['name']; ?>
                </li>
            <?php endforeach; ?>
        </ul>


    </div>

</body>
</html>
