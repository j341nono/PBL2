<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショップ</title>
    <style>
        .square {
            width: 600px;
            height: 400px;
            border: 4px solid rgb(174, 100, 47);
            display: flex; /* flexboxを使用 */
            margin-top: 80px;
            margin-left: auto;
            margin-right: auto;
            position: relative; /* 子要素の位置を相対的に配置 */
        }

        .example {
            /*親div*/
            position: relative; /*相対配置*/
        }

        .example p,.isagi {
            position: absolute;
            color: black;
            left: 10%;
            width: 100%;              /* 画像と同じ幅 */
            height: 100%;             /* 画像と同じ高さ */
            display: flex;
            justify-content: center;  /* 水平方向に中央寄せ */
            align-items: center;      /* 垂直方向に中央寄せ */
            white-space: nowrap;      /* 改行しないように設定 */

        }

        .example p {
            top: -72%;            /* 画像の上端に配置 */
        }

        .isagi {
            top: 55%;
        }

        .text1 {
            position: absolute;
            top: 5px;
            left: 5px;
            font-size: 30px;
            font-weight: bold;
        }

        .text2 {
            position: absolute;
            top: 12px;
            left: 300px;
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
            line-height: 40px; /* 高さに合わせて文字を中央に */
            border: 2px solid black;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .close-btn:hover {
            background-color: rgb(230, 230, 230);
        }

        .buy-btn1,.buy-btn2,.buy-btn3,.buy-btn4,.buy-btn5,.buy-btn6,.buy-btn7 {
            position: absolute;
            width: 60px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            color: black;
            font-size: 15px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: rgb(230, 230, 230);
        }

        .buy-btn1 {
            top: 200px;
            left: 122px;
        }

        .buy-btn2 {
            top: 200px;
            left: 267px;
        }

        .buy-btn3 {
            top: 200px;
            left: 412px;
        }

        .buy-btn4 {
            top: 368px;
            left: 60px;
        }

        .buy-btn5 {
            top: 368px;
            left: 200px;
        }

        .buy-btn6 {
            top: 368px;
            left: 340px;
        }

        .buy-btn7 {
            top: 368px;
            left: 478px;
        }

        .image-container1 {
            display: flex;           /* 横並びに画像を配置 */
            gap: 20px;               /* 画像の間隔を20pxに設定 */
            justify-content: center; /* 中央揃え */
            position: absolute;
            top: 70px;
            left: 80px;
        }

        .image-container2 {
            display: flex;
            gap: 15px;
            justify-content: center;
            position: absolute;
            top: 240px;
            left: 15px;
        }

        img {
            border: 2px solid black;
            margin-left: 20px;
        }

        a {
            text-decoration: none;
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

$sql = "SELECT * FROM shop";
//$sql = "SELECT * FROM shop WHERE id is not null";
$res = mysqli_query($con, $sql) or die("エラー");

while ($db = mysqli_fetch_assoc($res)) {
    $id=$db['id'];
    $money=$db['money'];

    $item1=$db['item1'];
    $item2=$db['item2'];
    $item3=$db['item3'];

    $Gear1=$db['Gear1'];
    $Gear2=$db['Gear2'];
    $Gear3=$db['Gear3'];
    $Gear4=$db['Gear4'];

echo "<input id='id' value='$id' hidden>";
echo "<input id='money' value='$money' hidden>";

echo "<input id='item1' value='$item1' hidden>";
echo "<input id='item2' value='$item2' hidden>";
echo "<input id='item3' value='$item3' hidden>";

echo "<input id='Gear1' value='$Gear1' hidden>";
echo "<input id='Gear2' value='$Gear2' hidden>";
echo "<input id='Gear3' value='$Gear3' hidden>";
echo "<input id='Gear4' value='$Gear4' hidden>";
}

?>

<div class="square">
  <div class="text1">ショップ</div>
  <div class="text2" id="batira"></div>
  <a href="HP.html" class="close-btn">×</a>

  <div class="image-container1">

    <div class="example">
      <img src="薬草.jpg">
      <p>薬草</p>
      <div class="isagi" id="batira1"></div>
    </div>

    <div class="example">
      <img src="上薬草.jpg">
      <p>上薬草</p>
      <div class="isagi" id="batira2"></div>
    </div>

    <div class="example">
      <img src="ポーション.jpg">
      <p>ポーション</p>
      <div class="isagi" id="batira3"></div>
    </div>

  </div>

  <button class="buy-btn1" onclick="buy(1,20)">購入1</button>
    <button class="buy-btn2" onclick="buy(2,80)">購入2</button>
    <button class="buy-btn3" onclick="buy(3,200)">購入3</button>

  <div class="image-container2">

  <div class="example">
      <script type="text/javascript">
        if (document.getElementById("Gear1").value == 0) {
            document.write('<img src="貫通.jpg">');
        } else {
            document.write('<img src="売却貫通.jpg">');
        }
        </script>
      <p>貫通</p>
      <div class="isagi">200G</div>
    </div>

    <div class="example">
      <script type="text/javascript">
        if (document.getElementById("Gear2").value == 0) {
            document.write('<img src="シールド.jpg">');
        } else {
            document.write('<img src="売却シールド.jpg">');
        }
        </script>
      <p>シールド</p>
      <div class="isagi">200G</div>
    </div>

    <div class="example">
      <script type="text/javascript">
        if (document.getElementById("Gear3").value == 0) {
            document.write('<img src="弾数UP.jpg">');
        } else {
            document.write('<img src="売却弾数UP.jpg">');
        }
        </script>
      <p>弾数UP</p>
      <div class="isagi">200G</div>
    </div>

    <div class="example">
      <script type="text/javascript">
        if (document.getElementById("Gear4").value == 0) {
            document.write('<img src="無敵.jpg">');
        } else {
            document.write('<img src="売却無敵.jpg">');
        }
        </script>
      <p>無敵</p>
      <div class="isagi">200G</div>
    </div>

  </div>

  <button class="buy-btn4" onclick="buy(4,200)">購入4</button>
  <button class="buy-btn5" onclick="buy(5,200)">購入5</button>
  <button class="buy-btn6" onclick="buy(6,200)">購入6</button>
  <button class="buy-btn7" onclick="buy(7,200)">購入7</button>

  </div>

<script type="text/javascript">
    var money = parseInt(document.getElementById("money").value, 10);
  var item1 = parseInt(document.getElementById("item1").value, 10);
  var item2 = parseInt(document.getElementById("item2").value, 10);
  var item3 = parseInt(document.getElementById("item3").value, 10);
  var Gear1 = parseInt(document.getElementById("Gear1").value, 10);
  var Gear2 = parseInt(document.getElementById("Gear2").value, 10);
  var Gear3 = parseInt(document.getElementById("Gear3").value, 10);
  var Gear4 = parseInt(document.getElementById("Gear4").value, 10);

  document.getElementById("batira").innerHTML = "所持金：" + money + "G";
  document.getElementById("batira1").innerHTML = "20G、所持" + item1;
  document.getElementById("batira2").innerHTML = "80G、所持" + item2;
  document.getElementById("batira3").innerHTML = "200G、所持" + item3;

  /*
    function buy(n,cost) {
      cost += n;
      alert(cost);
    }
    */

    function buy(n,cost) {
      if(cost <= money) {
          money -= cost;
          var chr = "";

          if(n == 1 && item1 < 99) {
              item1++;
              chr = "item1";
          }
          else if(n == 2 && item2 < 99) {
              item2++;
              chr = "item2";
          }
          else if(n == 3 && item3 < 99) {
              item3++;
              chr = "item3";
          }
          else if(n == 4 && Gear1 == 0) {
              Gear1 = 1;
              chr = "Gear1";
          }
          else if(n == 5 && Gear2 == 0) {
              Gear2 = 1;
              chr = "Gear2";
          }
          else if(n == 6 && Gear3 == 0) {
              Gear3 = 1;
              chr = "Gear3";
          }
          else if(n == 7 && Gear4 == 0) {
              Gear4 = 1;
              chr = "Gear4";
          }
          else {
              alert('もう買えません');
          }
      }
      else {
          alert('G不足');
      }
      var request = new XMLHttpRequest();
        request.open('GET', 'https://sshg.cs.ehime-u.ac.jp/~j431miyo/PBL2/shop_php.php?str=' + cost + '&chr=' + chr, tru\
e);
      request.responseType = 'json';
      request.addEventListener('load', function (response) {
    var data = <?="this.response"?>;
    console.log("ans1", data.ans1);
    console.log("ans2", data.ans2);
  });
      request.send();
  }
</script>

</body>

</html>