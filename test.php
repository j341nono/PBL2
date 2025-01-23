<?php
//ここに記載している内容はゲーム画面（恐らくshooting.php）に追加してほしい内容です
$userID = 1;//遷移する際に渡す値はココ
$progress = 2;//"stage"タプルに保存してある値
$stage_num = 2;//遷移する際に渡す値はココ
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <style>
    </style>
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
                    window.location.href = 'HP.html';//画面遷移先の指定はココ
                }
            }
            xhr.open('POST', 'save_score.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');//転送の形式を色々と設定可
            //送信データの内容はここ
            var send_data = 'userID=' + userID + '&score=' + score + '&item1=' + item1 + '&item2=' + item2 + '&item3=' + item3 + '&stage=' + stage + '&stage_progress=' + stage_progress;
            //データ送信のリクエストを送信
            xhr.send(send_data);
        }

        //sendGameData(1, 2, 2, 2, 2, true);
    </script>
</body>
</html>