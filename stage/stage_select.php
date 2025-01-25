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
    <title>ステージ選択</title>
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

        .img1,
        .img2,
        .img3,
        .img4,
        .img5,
        .img6 {
            position: absolute;
            width: 200px;
            height: 60px;
            //border: 1px solid black;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .img1:hover,
        .img2:hover,
        .img3:hover,
        .img4:hover,
        .img5:hover,
        .img6:hover {
            opacity: .6;
        }

        .img1,
        .img2,
        .img3 {
            left: 65px;
        }

        .img4,
        .img5,
        .img6 {
            left: 350px;
        }

        .img1,
        .img4 {
            top: 100px;
        }

        .img2,
        .img5 {
            top: 200px;
        }

        .img3,
        .img6 {
            top: 300px;
        }

        .img1 p,
        .img2 p,
        .img3 p,
        .img4 p,
        .img5 p,
        .img6 p {
            position: absolute;
            color: black;
            top: 0%;
            left: -20%;
            font-size: 20px;
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
      <div class="tytle">ステージ選択</div>
      <a href="../homepage/homepage.php" class="close-btn">x</a>

        <?php
        
        session_start();
        $con = mysqli_connect('localhost','j431miyo','') or die("接続失敗");
        mysqli_select_db($con, 'j431miyoP') or die("選択失敗");
        mysqli_query($con, 'SET NAMES utf8');
        $sql = "SELECT * FROM status2 WHERE userID = '$userID'";
        $res = mysqli_query($con, $sql) or die("エラー");
        
        while ($db = mysqli_fetch_assoc($res)) {
            $stage_idx=$db['stage'];
        }

        //-----ステージ画像はココで管理
        $stage_name = ['野原.jpg', '砂浜.jpg', '砂漠.jpg', '雪国.jpg', '墓地.jpg', '魔王城.jpg'];

        //$stage_idx =< 6;
        for ($i = 1; $i <= $stage_idx; $i++) {
            echo '<div class="img'.$i.'">';
            echo '<form id="'.$i.'" action="game_start.php" method="POST"><input type="hidden" name="stage" value="'.$i.'">';
            echo '<button type="submit" form="'.$i.'"><img src="'.$stage_name[$i - 1].'"></button></form>';
            echo '<p>St'.$i.'</p>';
            echo '</div>';
        }
        ?>

    </div>

</body>

</html>
