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
    <title>ショップ</title>
    <style>
        .square {
            width: 600px;
            height: 400px;
            border: 4px solid rgb(174, 100, 47);
            display: flex;
            margin-top: 80px;
            margin-left: auto;
            margin-right: auto;
            position: relative; /* 子要素の位置を相対的に配置 */
        }

        .example {
            /*親div*/
            position: relative; /*相対配置*/
        }

        .example p,.item_top {
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

        .item_top {
            top: 62%;
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

$sql = "SELECT * FROM status2 WHERE userID = '$userID'";
$res = mysqli_query($con, $sql) or die("エラー");

while ($db = mysqli_fetch_assoc($res)) {
    $gold=$db['gold'];

    $item1=$db['item1'];
    $item2=$db['item2'];
    $item3=$db['item3'];

    $Gear1=$db['Gear1'];
    $Gear2=$db['Gear2'];
    $Gear3=$db['Gear3'];
    $Gear4=$db['Gear4'];

echo "<input id='gold' value='$gold' hidden>";

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
  <div class="text2" id="gold_display"></div>
  <a href="../homepage/homepage.php" class="close-btn">×</a>

  <div class="image-container1">

<div class="example">
      <img src="薬草.jpg">
      <p>薬草</p>
      <div class="item_top" id="item1_display"></div>
    </div>

    <div class="example">
      <img src="上薬草.jpg">
      <p>上薬草</p>
      <div class="item_top" id="item2_display"></div>
    </div>

    <div class="example">
      <img src="ポーション.jpg">
      <p>ポーション</p>
      <div class="item_top" id="item3_display"></div>
    </div>

  </div>

    <button class="buy-btn1" onclick="location.href='item1_add.php'">購入1</button>
    <button class="buy-btn2" onclick="location.href='item2_add.php'">購入2</button>
    <button class="buy-btn3" onclick="location.href='item3_add.php'">購入3</button>

  <div class="image-container2">

    <div class="example">
      <script type="text/javascript">
        if (parseInt(document.getElementById("Gear1").value, 10) == 0) {
            document.write('<img src="貫通.jpg">');
        } else {
            document.write('<img src="売却貫通.jpg">');
        }
        </script>
      <p>貫通</p>
      <div class="item_top">200G</div>
    </div>

    <div class="example">
      <script type="text/javascript">
        if (parseInt(document.getElementById("Gear2").value, 10) == 0) {
            document.write('<img src="シールド.jpg">');
        } else {
            document.write('<img src="売却シールド.jpg">');
        }
        </script>
      <p>シールド</p>
      <div class="item_top">200G</div>
    </div>

    <div class="example">
      <script type="text/javascript">
        if (parseInt(document.getElementById("Gear3").value, 10) == 0) {
            document.write('<img src="弾数UP.jpg">');
        } else {
            document.write('<img src="売却弾数UP.jpg">');
        }
        </script>
      <p>弾数UP</p>
      <div class="item_top">200G</div>
    </div>

    <div class="example">
      <script type="text/javascript">
        if (parseInt(document.getElementById("Gear4").value, 10) == 0) {
            document.write('<img src="無敵.jpg">');
        } else {
            document.write('<img src="売却無敵.jpg">');
        }
        </script>
      <p>無敵</p>
      <div class="item_top">200G</div>
    </div>

  </div>

  <button class="buy-btn4" onclick="location.href='Gear1_add.php'">購入4</button>
  <button class="buy-btn5" onclick="location.href='Gear2_add.php'">購入5</button>
  <button class="buy-btn6">購入6</button>
  <button class="buy-btn7">購入7</button>

</div>

<script type="text/javascript">
  var gold = parseInt(document.getElementById("gold").value, 10);
  var item1 = parseInt(document.getElementById("item1").value, 10);
  var item2 = parseInt(document.getElementById("item2").value, 10);
  var item3 = parseInt(document.getElementById("item3").value, 10);
  var Gear1 = parseInt(document.getElementById("Gear1").value, 10);
  var Gear2 = parseInt(document.getElementById("Gear2").value, 10);
  var Gear3 = parseInt(document.getElementById("Gear3").value, 10);
  var Gear4 = parseInt(document.getElementById("Gear4").value, 10);

  document.getElementById("gold_display").innerHTML = "所持金：" + gold + "G";
  document.getElementById("item1_display").innerHTML = "20G、所持" + item1;
  document.getElementById("item2_display").innerHTML = "80G、所持" + item2;
  document.getElementById("item3_display").innerHTML = "200G、所持" + item3;

  function buy(n, cost) {
    // 必要な条件を先にチェック
    if (cost > gold) {
        alert('G不足');
        return; // お金が足りない場合、処理を終了
    }

    let chr = ''; // 初期化

    // アイテムまたは装備が購入可能かどうかを判定
    if (n == 1 && item1 < 99) {
        chr = "item1";
    } else if (n == 2 && item2 < 99) {
        chr = "item2";
    } else if (n == 3 && item3 < 99) {
        chr = "item3";
    } else if (n == 4 && Gear1 == 0) {  // Gear1が0の場合
        chr = "Gear1";
    } else if (n == 5 && Gear2 == 0) {  // Gear2が0の場合
        chr = "Gear2";
    } else if (n == 6 && Gear3 == 0) {  // Gear3が0の場合
        chr = "Gear3";
    } else if (n == 7 && Gear4 == 0) {  // Gear4が0の場合
        chr = "Gear4";
    } else {
        alert('もう買えません');  // どれも該当しない場合
        return;
    }

    // アイテムが選ばれていない場合はリクエストしない
    if (chr === '') {
        alert('購入アイテムが選ばれていません');
        return;
    }

    // XMLHttpRequestでサーバーにリクエストを送る
    var request = new XMLHttpRequest();
    request.open('GET', 'https://sshg.cs.ehime-u.ac.jp/~j431miyo/pbl2/shop/DB_write.php?str=' + cost + '&chr=' + chr, true);
    request.responseType = 'json';

    // リクエストを送信
    request.send();
}
</script>

</body>

</html>