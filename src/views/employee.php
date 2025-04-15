<!-- views/shuffle/index.phpへ分離により不要。動画復習用にファイルを保管する-->
 <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社員登録ページ</title>
</head>

<body>
    <div>
        <a href="/shuffle">シャッフルランチサービス</a>
    </div>

    <?php if (count($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="employee/create" method="post">
        <div>
            <label for="name">社員名</label>
            <input type="text" name="name">
        </div>
            <!-- <input type="submit" value="登録する">の書き方もありだが、シンプルな実装なので装飾出来る下記が主流-->
        <button type="submit">登録する</button>
    </form>

    <h2>社員一覧</h2>
    <ul>
        <?php foreach ($employees as $employee): ?>
            <li>
                <?php echo $employee['name']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>
