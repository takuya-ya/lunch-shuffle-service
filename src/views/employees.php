<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社員登録ページ</title>
</head>

<body>
    <div>
        <a href="./index.php">シャッフルランチサービス</a>
    </div>

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
        <label for="name">社員名</label>
        <input type="text" name="name">
        <!-- <input type="submit" value="登録する">の書き方もありだが、シンプルな実装なので装飾出来る下記が主流-->
        <button type="submit">登録する</button>
    </form>

    <div>
        <p>社員一覧</p>
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
