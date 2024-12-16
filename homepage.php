<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    print 'ログインされていません<br/>';
    print '<a href="login.html">ログイン画面へ</a>';
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
<html>
<head>
<meta charset="UTF-8">
</head>
<body>

<br><br>
<button onclick="location.href='logout.php'">ログアウト</button>
<button onclick="location.href='index.php'">インデックス</button>
<button onclick="location.href='todo_tasks.php'">todoリスト</button>
</body>
<html>
