<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    print 'ログインされていません<br/>';
    print '<a href="../login/login.html">ログイン画面へ</a>';
    exit();
}
else
{
    $userID=$_SESSION['userID'];
    $name=$_SESSION['name'];
}


// ページ内容を表示
echo "<h1>ようこそ ユーザーID: $userID さん</h1>";
print $name;
echo "さんのページです。";

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>攻撃の追加</title>
</head>
<body>
    <br>
    <br>
<button onclick="location.href='power_add_check.php'">攻撃力を増やす</button>
<button onclick="location.href='homepage.php'">戻る</button>
</body>
</html>