<?php
session_start();

// セッション変数をすべてクリア
$_SESSION = [];

// セッションIDがクッキーに存在していれば、それを削除
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// セッションを破棄
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウトページ</title>
</head>
<body>
    <p>ログアウトしました。</p>
    <br>
    <a href="login.html">ログイン画面へ</a>
</body>
</html>