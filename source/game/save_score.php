<?php 
 
 $con = mysqli_connect('localhost','j431miyo','') or die("接続失敗"); 
 mysqli_select_db($con, 'j431miyoP') or die("選択失敗"); 
 mysqli_query($con, 'SET NAMES utf8');
 
 //-----get data
 $id = $_POST['userID'];
 $stage_num = $_POST['stage'];
 $stage_progress = $_POST['stage_progress'];
 $score = $_POST['score'];
 $item1_num = $_POST['item1'];
 $item2_num = $_POST['item2'];
 $item3_num = $_POST['item3'];

 //-----sql文
 //---get name
 $sql = "SELECT * FROM Users2 WHERE userID = '$id'";
 $res = mysqli_query($con, $sql) or die("エラー");
 $db = mysqli_fetch_assoc($res);
 $name = $db['name'];

 //---score
 

 $sql = "SELECT * FROM ranking_st".$stage_num." WHERE userID = $id";

 //if($stage_num == 1){
 //  $sql = "SELECT * FROM ranking_st1 WHERE userID = $id";
 //}
 $res = mysqli_query($con, $sql) or die("エラー");
 $db = mysqli_fetch_assoc($res);
 
 if(!isset($db)){
    //スコアが存在しない場合は新規追加
    $sql = "insert into ranking_st".$stage_num." (userID, score, name) values ($id, '$score', '$name')";
    $res = mysqli_query($con, $sql) or die("エラー");
    //$db = mysqli_fetch_assoc($res);
 }else if($db['score'] < $score){
    //既存データが今回のスコアよりも小さい場合は更新
    $sql = "UPDATE ranking_st".$stage_num." SET score = $score, name = '$name' WHERE userID = $id";
    $res = mysqli_query($con, $sql) or die("エラー");
    //$db = mysqli_fetch_assoc($res);
 }

 //---items & progress
 
 $sql = "UPDATE status2 set item1 = $item1_num, item2 = $item2_num, item3 = $item3_num, stage = $stage_progress WHERE userID = $id";
 //$sql = "update status2 set item1 = $item1_num WHERE userID = 1";
 $res = mysqli_query($con, $sql) or die("エラー");
 //$db = mysqli_fetch_assoc($res);


 //別方法でphpに移動して行う場合はこちらでも可能そう
 //header('Location: test.php');//格納後の遷移先はココ
 //header('Location: game_start.php');//格納後の遷移先はココ
 mysqli_close($con);
 
?>