<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>

<?php

$user_name=$_POST['name'];
$user_pass=$_POST['pass'];
$user_pass2=$_POST['pass2'];

if($user_name=='')
{
    print'ユーザー名が入力されていません<br/>';
}
else
{
    print'ユーザー名:';
    print $user_name;
    print'<br/>';
}

if($user_pass=='')
{
    print'パスワードが入力されていません<br/>';
}

if($user_pass!=$user_pass2)
{
    print'パスワードが一致しません<br/>';
}

if($user_name==''||$user_pass==''||$user_pass!=$user_pass2)
{
    print'<form>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'</form>';
}
else
{
    print'<form method="post" action="user_add_done.php">';
    print'<input type="hidden" name="name" value="'.$user_name.'">';
    print'<input type="hidden" name="pass" value="'.$user_pass.'">';
    print'<br/>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'<input type="submit" value="OK">';
    print'</form>';
}

?>

</body>
<html>
