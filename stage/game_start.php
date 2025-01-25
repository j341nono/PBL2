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

    echo "<input id='userID' value='$userID' hidden>";
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
            margin-top: 35px;
            margin-left: auto;
            margin-right: auto;
            font-size: 30px;
            font-weight: bold;
        }

        img {
            position: absolute;
            top: 130px;
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
            top: 100px;
            left: 380px;
            font-size: 19px;
        }

        .ranking {
            position: absolute;
            top: 130px;
            left: 300px;
            width: 280px;
            height: 250px;
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
        $con = mysqli_connect('localhost','j341nono','') or die("接続失敗");
         mysqli_select_db($con, 'j341nonoP') or die("選択失敗");
         mysqli_query($con, 'SET NAMES utf8');
        $sql = 'SELECT * FROM ranking_st'.$stage_num.' ORDER BY score DESC LIMIT 5';
        $res = mysqli_query($con, $sql) or die("エラー");

        //-----ステージ番号
        echo '<div class="tytle">St'.$stage_num.'</div>';
        
        //-----遷移ボタン
        echo '<form id="'.$stage_num.'" action="../game/shooting.php" method="POST"><input type="hidden" name="stage_num" value="'.$stage_num.'">';
        echo '<a href="stage_select.php" class="close-btn">x</a>';
        echo '<div class="img"><button type="submit" form="'.$stage_num.'"><img src="'.$stage_name[$stage_num - 1].'"></button></form>';

        //-----ランキング表示
        echo '<div class="ranking-text">ランキングTop5</div>';
        echo '<div class="ranking">';
        echo '<table>';
        $int = 1;
        while ($db = mysqli_fetch_assoc($res)) {
            if(isset($db['score']) && isset($db['name'])){
                echo '<tr><td>'.$int.'&emsp;</td><td>'.$db['score'].'&emsp;</td><td>'.$db['name'].'</td></tr>';
            }
            $int++;
        }
        if($int == 1){
            echo 'データがありません';
        }
        echo '</table>';
        echo '</div>';
        ?>

    </div>
</body>
</html>