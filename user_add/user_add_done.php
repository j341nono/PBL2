<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新規登録ページ</title>
</head>
<body>

<?php
try {
    // POSTデータを受け取る
    $user_name = $_POST['name'];
    $user_pass = $_POST['pass'];

    // データベース接続設定
    $dsn = 'mysql:dbname=j431miyoP;host=localhost;charset=utf8';
    $user = 'j431miyo';
    $password = '';

    // データベースに接続
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // トランザクションを開始
    $dbh->beginTransaction();

    // Usersテーブルにデータを追加
    $sql_user = 'INSERT INTO Users2 (name, password) VALUES (?, ?)';
    $stmt_user = $dbh->prepare($sql_user);

    // ユーザーデータをバインドして実行
    $stmt_user->execute([$user_name, $user_pass]);

    // 最後に挿入されたuserIDを取得
    $user_id = $dbh->lastInsertId();

    // statusテーブルにデータを追加
    $sql_status = 'INSERT INTO status2 (userID, gold, hp, power, point, hppoint, powerpoint, item1, item2, item3, Gear1, Gear2, Gear3, Gear4, stage) 
                   VALUES (?, 10000, 75, 10, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1)';
    $stmt_status = $dbh->prepare($sql_status);

    // statusデータをバインドして実行
    $stmt_status->execute([$user_id]);

    // トランザクションをコミット
    $dbh->commit();

    print 'ユーザーを追加しました<br/>';
    print 'ユーザーIDは';
    print htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8') . '<br/>';
} catch (Exception $e) {
    // エラー発生時にロールバック
    if ($dbh->inTransaction()) {
        $dbh->rollBack();
    }
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

<a href="../login/login.html">ログインページ</a>

</body>
</html>
