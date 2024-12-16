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
    $dsn = 'mysql:dbname=j024ishi5;host=localhost;charset=utf8';
    $user = 'j024ishi';
    $password = '';

    // データベースに接続
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の準備
    $sql = 'INSERT INTO Users (name, password, gold) VALUES (?, ?, ?)';
    $stmt = $dbh->prepare($sql);

    // データをバインドして実行
    //$data = [$user_name, password_hash($user_pass, PASSWORD_DEFAULT), 0];
    $data = [$user_name, $user_pass, 0];
    $stmt->execute($data);

    print 'ユーザーを追加しました<br/>';
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

<a href="login.html">ログインページ</a>

</body>
</html>
