<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HP</title>
    <style>
        .rectangle {
            position: relative;
            width: 600px;
            height: 400px;
            border: 4px solid rgb(174, 100, 47);
            display: flex;
            margin-top: 80px;
            margin-left: auto;
            margin-right: auto;
        }

        .rectangle2 {
            position: absolute;
            top: 40px;
            left: 80px;
            width: 200px;
            height: 45px;
            display: flex;
        }

        .rectangle2-1 {
            width: 10px;
            height: 45px;
            background-color: rgb(174, 100, 47);
        }

        .rectangle2-2 {
            margin-left: 5px;
            height: 45px;
        }

        .reset-btn {
            position: absolute;
            top: 120px;
            left: 80px;
            width: 200px;
            height: 25px;
            justify-content: center;
            align-items: center;
            background-color: white;
            color: black;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .reset-btn:hover {
            background-color: rgb(230, 230, 230);
        }

        .point {
            position: absolute;
            top: 160px;
            left: 70px;
            width: 220px;
            height: 25px;
        }

        .square-HP,
        .square-attack {
            position: absolute;
            top: 190px;
            width: 140px;
            height: 20px;
            border: 1px solid black;
            display: flex;
        }

        .square-HP {
            left: 20px;
        }

        .green-point {
            width: 20px;
            height: 20px;
            background-color: rgb(118, 223, 140);
            border-right: 1px solid black;
        }

        .square-attack {
            left: 190px;
        }

        .red-point {
            width: 20px;
            height: 20px;
            background-color: rgb(226, 137, 137);
            border-right: 1px solid black;
        }

        .HP-btn,
        .attack-btn {
            position: absolute;
            top: 220px;
            width: 110px;
            height: 25px;
            justify-content: center;
            align-items: center;
            background-color: white;
            color: black;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .HP-btn {
            left: 35px;
        }

        .HP-btn:hover {
            background-color: rgb(118, 223, 140);
        }

        .attack-btn {
            left: 205px;
        }

        .attack-btn:hover {
            background-color: rgb(226, 137, 137);
        }

        .braver-img {
            position: absolute;
            top: 40px;
            left: 360px;
            border: 1px solid black;
        }

        .shop-img,
        .mission-img,
        .stage-select-img {
            position: absolute;
            top: 280px;
            border: 1px solid black;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .shop-img:hover,
        .mission-img:hover,
        .stage-select-img:hover {
            opacity: .6;
        }

        .shop-img {
            left: 33px;
        }

        .mission-img {
            left: 224px;
        }

        .stage-select-img {
            left: 416px;
        }
    </style>

</head>

<body>

<?php
// POSTデータが送信されている場合、変数に格納
session_start();
$con = mysqli_connect('localhost','j431miyo','') or die("接続失敗");
 mysqli_select_db($con, 'j431miyoP') or die("選択失敗");
 mysqli_query($con, 'SET NAMES utf8');

$sql = "SELECT * FROM HP";
$res = mysqli_query($con, $sql) or die("エラー");

while ($db = mysqli_fetch_assoc($res)) {
    $id=$db['id'];
    $name=$db['name'];
    $money=$db['money'];

    $HP=$db['HP'];
    $attack=$db['attack'];
    $point=$db['point'];

echo "<input id='id' value='$id' hidden>";
echo "<input id='name' value='$name' hidden>";
echo "<input id='money' value='$money' hidden>";

echo "<input id='HP' value='$HP' hidden>";
echo "<input id='attack' value='$attack' hidden>";
echo "<input id='point' value='$point' hidden>";
}

?>

    <div class="rectangle">
        <div class="rectangle2">
            <div class="rectangle2-1"></div>
            <div class="rectangle2-2" id="name&money"></div>
        </div>
        <button class="reset-btn">ステータスリセット&emsp;200G</button>
        <div class="point" id="points"></div>
        <div class="square-HP">
            <script type="text/javascript">
                for (var i = 0; i < parseInt(document.getElementById("HP").value, 10); i++) {
                    document.write('<div class="green-point"></div>');
                }
            </script>
        </div>
        <div class="square-attack">
            <script type="text/javascript">
                for (var i = 0; i < parseInt(document.getElementById("attack").value, 10); i++) {
                    document.write('<div class="red-point"></div>');
                }
            </script>
        </div>
        <button class="HP-btn">HP&emsp;50G</button>
        <button class="attack-btn">攻撃&emsp;100G</button>
        <img src="勇者.jpg" class="braver-img">
        <img src="shop.jpg" class="shop-img" onclick="location.href='page1.html'">
        <img src="mission.jpg" class="mission-img" onclick="location.href='page2.html'">
        <img src="stage-select.jpg" class="stage-select-img" onclick="location.href='page3.html'">
    </div>

    <script type="text/javascript">
        var name = document.getElementById("name").value;
        var money = parseInt(document.getElementById("money").value, 10);
        var point = parseInt(document.getElementById("point").value, 10);

        document.getElementById("name&money").innerHTML = name + "<br>所持金：" + money + "G";
        document.getElementById("points").innerHTML = "残りステータスポイント：" + point;
    </script>

</body>

</html>