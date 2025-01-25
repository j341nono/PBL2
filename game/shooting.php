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

// データベース接続情報

session_start();
$con = mysqli_connect('localhost','j431miyo','') or die("接続失敗");
 mysqli_select_db($con, 'j431miyoP') or die("選択失敗");
 mysqli_query($con, 'SET NAMES utf8');

$sql = "SELECT * FROM status2 where userID=$userID";
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

    $item1=$db['item1'];
    $item2=$db['item2'];
    $item3=$db['item3'];

    $diagonal=$db['Gear1'];
    $behind=$db['Gear2'];

    $progress=$db['stage'];

echo "<input id='userid' value='$id' hidden>";
echo "<input id='name' value='$name' hidden>";
echo "<input id='money' value='$money' hidden>";

echo "<input id='HP' value='$HP' hidden>";
echo "<input id='attack' value='$attack' hidden>";
echo "<input id='point' value='$point' hidden>";
echo "<input id='hppoint' value='$hpp' hidden>";
echo "<input id='powerpoint' value='$pp' hidden>";

echo "<input id='item1' value='$item1' hidden>";
echo "<input id='item2' value='$item2' hidden>";
echo "<input id='item3' value='$item3' hidden>";

echo "<input id='diagonal' value='$diagonal' hidden>";
echo "<input id='behind' value='$behind' hidden>";


echo "<input id='progress' value='$stage' hidden>";

}

$stage_num = $_POST['stage_num'];
echo "<input id='stage_select' value='$stage_num' hidden>";
?>

<DOCTYPE html>
<html>
    
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
    <script>
    function updateStageProgress(stage, stage_progress, stage_cleared){
            var stage_num_max = 6;//ステージ数に応じて変更。管理はココじゃないほうが良い？その時はvarで宣言お願いします。

            //進行度よりも前のステージを選択した場合は更新の必要が無い
            if(stage < stage_progress){
                return stage_progress;
            }

            //クリアで進行度の更新　ステージ数が上限
            if(stage_cleared && (stage_progress < stage_num_max)){
                stage_progress += 1;
                return stage_progress;
            }
            
            //未クリアの場合更新は不必要　クリア時でも進行度がステージ数と同じ場合更新は不必要
            return stage_progress;
        }

        //クリア時→stage_cleared = true
        //未クリア時→stage_cleared = false
        function sendGameData(score, item1, item2, item3, stage, stage_cleared){
            var userID = <?php echo $userID; ?>;
            var progress = <?php echo $progress; ?>;
            var stage_progress = updateStageProgress(stage, progress, stage_cleared);
            var xhr = new XMLHttpRequest();

            //処理の状況の変化を監視する
            xhr.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    //リクエスト処理が完了＆HTTPのステータスコードが200なら
                    console.log(this.responseText);
                    window.location.href = '../homepage/homepage.php';//画面遷移先の指定はココ
                }
            }
            xhr.open('POST', 'save_score.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');//転送の形式を色々と設定可
            //送信データの内容はここ
            console.log(stage_progress);
            var send_data = 'userID=' + userID + '&score=' + score + '&item1=' + item1 + '&item2=' + item2 + '&item3=' + item3 + '&stage=' + stage + '&stage_progress=' + stage_progress;
            //データ送信のリクエストを送信
            xhr.send(send_data);
        }

        //sendGameData(1, 2, 2, 2, 2, true);
    </script>

        <audio id="bgm" loop>
            <source src="Swords.mp3" type="audio/mpeg">    
        </audio>

        <div id="game-container">
            <canvas id="can" width="320" height="320"></canvas>
            <div id="title" style="text-align:center;"></div>
            <div id="title2" style="text-align:center;"></div>
        </div>
        <script src="constants.js"></script>

        <script src="math.js"></script>
        <script src="gameLogic.js"></script>

        
        <script src="sprite.js"></script>
        <script src="view.js"></script>
        <script src="explosion.js"></script>
        <script src="shot.js"></script>
        <script src="player.js"></script>
        <script src="monster.js"></script>

        <script src="stage1.js"></script>
        <script src="stage2.js"></script>
        <script src="stage3.js"></script>
        <script src="stage4.js"></script>
        <script src="stage5.js"></script>
        <script src="stage6.js"></script>
        <script src="stage.js"></script>

        <script src="title.js"></script>
        
        <script src="main.js"></script>
    </body>
</html>