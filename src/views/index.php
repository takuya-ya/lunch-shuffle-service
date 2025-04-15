<!-- views/shuffle/index.phpへ分離により不要。動画復習用にファイルを保管する-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シャッフルランチ</title>
</head>

<body>
    <h1>
        <a href="/employee">シャッフルランチ</a>
    </h1>
    <a href="employee">社員を登録する</a>

    <form action="shuffle" method="post">
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
