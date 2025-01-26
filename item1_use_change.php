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
    </head>
    
    <body>
        
        <?php
        $stage_num = $_POST['stage_num'];
        // POSTデータが送信されている場合、変数に格納      
        session_start();
        $con = mysqli_connect('localhost','j431miyo','') or die("接続失敗");
        mysqli_select_db($con, 'j431miyoP') or die("選択失敗");
        mysqli_query($con, 'SET NAMES utf8');
        
        $sql = "SELECT * FROM status2 WHERE userID = $userID";
        $res = mysqli_query($con, $sql) or die("エラー");
        
        while ($db = mysqli_fetch_assoc($res)) {
            $item1_use=$db['item1_use'];
            echo "<input id='item1_use' value='$item1_use' hidden>";
        }
        
        ?>
        
        <br>
        <br>
        <script type="text/javascript">
        if (parseInt(document.getElementById("item1_use").value, 10) == 0) {
            document.write('薬草を使う（効果：HP+25）');
        } else {
            document.write('薬草を使わない');
        }
        </script>
        
        <form id="'.$stage_num.'" action="game_start.php" method="POST"><input type="hidden" name="stage_num" value="'.$stage_num.'">
        <button type="submit" form="'.$stage_num.'" onclick="location.href='item1_use_change_check.php'">戻る</button>
        <button type="submit" form="'.$stage_num.'" onclick="location.href='game_start.php'">戻る</button>
        </form>

    </body>
</html>