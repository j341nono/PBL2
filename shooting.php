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

// データベース接続情報

session_start();
$con = mysqli_connect('localhost','j024ishi','') or die("接続失敗");
 mysqli_select_db($con, 'j024ishi5') or die("選択失敗");
 mysqli_query($con, 'SET NAMES utf8');

$sql = "SELECT * FROM status where userID=$userID";
$res = mysqli_query($con, $sql) or die("エラー");

while ($db = mysqli_fetch_assoc($res)) {
    $id=$userID;
    $name=$name;
    $money=$db['gold'];

    $HP=$db['hp'];
    $attack=$db['power'];
    $point=$db['point'];
    $hpp=$db['hppoint'];
    $pp=$db['powerpoint'];

echo "<input id='userid' value='$id' hidden>";
echo "<input id='name' value='$name' hidden>";
echo "<input id='money' value='$money' hidden>";

echo "<input id='HP' value='$HP' hidden>";
echo "<input id='attack' value='$attack' hidden>";
echo "<input id='point' value='$point' hidden>";
echo "<input id='hppoint' value='$hpp' hidden>";
echo "<input id='powerpoint' value='$pp' hidden>";

}

$stage_select = $_POST['stage_num'];

?>
