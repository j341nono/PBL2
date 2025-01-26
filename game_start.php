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
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタート＆ランキング</title>
    <style>
        .square {
            position: relative;
            width: 600px;
            height: 400px;
            border: 4px solid rgb(174, 100, 47);
            display: flex;
            margin-top: 80px;
            margin-left: auto;
            margin-right: auto;
        }

        .tytle {
            margin-top: 15px;
            margin-left: auto;
            margin-right: auto;
            font-size: 30px;
            font-weight: bold;
        }

        .start-img {
            position: absolute;
            top: 100px;
            left: 50px;
            border: 1px solid black;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        img:hover {
            opacity: .6;
        }

        .ranking-text {
            position: absolute;
            top: 70px;
            left: 370px;
            font-size: 19px;
        }

        .ranking {
            position: absolute;
            top: 100px;
            left: 300px;
            width: 280px;
            height: 280px;
            border: 1px solid black;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            color: red;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            line-height: 40px;
            /* 高さに合わせて文字を中央に */
            border: 2px solid black;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .close-btn:hover {
            background-color: rgb(230, 230, 230);
        }

        a {
            text-decoration: none;
        }

        .item1-img,
        .item2-img,
        .item3-img {
            position: absolute;
            top: 330px;
            width: 50px;
            height: 50px;
            border: 1px solid black;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .item1-img:hover,
        .item2-img:hover,
        .item3-img:hover {
            opacity: .6;
        }

        .item1-img {
            left: 50px;
        }

        .item2-img {
            left: 131px;
        }

        .item3-img {
            left: 212px;
        }
    </style>

</head>

<body>
    <div class="square">
        <?php
        //-----ステージ画像はココで管理
        $stage_name = ['のはら.jpg', 'すなはま.jpg', 'さばく.jpg', 'ゆきぐに.jpg', 'ぼち.jpg', 'まおうじょう.jpg'];
        $stage_num = $_POST['stage'];

        /*$idはページ間で渡していること前提で定義*/
        //-----sql
        $con = mysqli_connect('localhost','j431miyo','') or die("接続失敗");
         mysqli_select_db($con, 'j431miyoP') or die("選択失敗");
         mysqli_query($con, 'SET NAMES utf8');
        $sql = 'SELECT * FROM ranking_st'.$stage_num.' ORDER BY score DESC LIMIT 10';
        $res = mysqli_query($con, $sql) or die("エラー");

        //-----ステージ番号
        echo '<div class="tytle">St'.$stage_num.'</div>';
        
        //-----遷移ボタン
        echo '<form id="'.$stage_num.'" action="../game/shooting.php" method="POST"><input type="hidden" name="stage_num" value="'.$stage_num.'">';
        echo '<a href="stage_select.php" class="close-btn">x</a>';
        echo '<button type="submit" class="start-img" form="'.$stage_num.'"><img src="'.$stage_name[$stage_num - 1].'"></button></form>';

        //-----ランキング表示
        echo '<div class="ranking-text">ランキングTop10</div>';
        echo '<div class="ranking">';
        echo '<table>';
        $int = 1;
        while ($db = mysqli_fetch_assoc($res)) {
            if(isset($db['score']) && isset($db['name'])){
                echo '<tr><td>'.$int.'位&emsp;</td><td>'.$db['score'].'&emsp;</td><td>'.$db['name'].'</td></tr>';
            }
            $int++;
        }
        if($int == 1){
            echo 'データがありません';
        }
        echo '</table>';
        echo '</div>';


        //-----status2からitem1_use、item2_use、item3_useを取ってくる
        $sql = "SELECT * FROM status2 where userID = $userID";
        $res = mysqli_query($con, $sql) or die("エラー");

        if ($db = mysqli_fetch_assoc($res)) {
            $item1_use = $db['item1_use'];
            $item2_use = $db['item2_use'];
            $item3_use = $db['item3_use'];
        
            echo "<input id='item1_use' value='$item1_use' hidden>";
            echo "<input id='item2_use' value='$item2_use' hidden>";
            echo "<input id='item3_use' value='$item3_use' hidden>";
        
        } else {
            // 該当するユーザーIDが見つからなかった場合
            echo "該当するユーザーのデータが見つかりませんでした。";
        }

        ?>
        
        
        <script type="text/javascript">
        if (parseInt(document.getElementById("item1_use").value, 10) == 0) {
            document.write('<img src="黒薬草.jpg" class="item1-img" onclick="location.href=\'item1_use_change.php\'">');
        } else {
            document.write('<img src="../shop/薬草.jpg" class="item1-img" onclick="location.href=\'item1_use_change.php\'">');
        }
        </script>
        
        <script type="text/javascript">
        if (parseInt(document.getElementById("item2_use").value, 10) == 0) {
            document.write('<img src="黒上薬草.jpg" class="item2-img" onclick="location.href=\'item2_use_change.php\'">');
        } else {
            document.write('<img src="../shop/上薬草.jpg" class="item2-img" onclick="location.href=\'item2_use_change.php\'">');
        }
        </script>
        
        <script type="text/javascript">
        if (parseInt(document.getElementById("item3_use").value, 10) == 0) {
            document.write('<img src="黒ポーション.jpg" class="item3-img" onclick="location.href=\'item3_use_change.php\'">');
        } else {
            document.write('<img src="../shop/ポーション.jpg" class="item3-img" onclick="location.href=\'item3_use_change.php\'">');
        }
        </script>

    </div>
    <script type="text/javascript">
    </script>
</body>
</html>