<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    print 'ログインされていません<br/>';
    print '<a href="login.html">ログイン画面へ</a>';
    exit();
}
else
{
    $userID=$_SESSION['userID'];
    $name=$_SESSION['name'];
}

try {
    $dsn = 'mysql:host=localhost;dbname=j024ishi5;charset=utf8';
    $user = 'j024ishi';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ユーザーの現在のhpとpointを取得
    $sql = 'SELECT gold, hp, point, hppoint FROM status WHERE userID = :userID';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // gold -50, hp +25, point -2, hppoint +1
        if($result['gold']<50){
            print 'ゴールドが不足しています。<br/>';
            print '<a href="homepage.php">トップページへ</a>';
        }
        else if($result['point']<2){
            print 'ステータスポイントが不足しています。<br/>';
            print '<a href="homepage.php">トップページへ</a>';
        }
        else if($result['hppoint']==5){
            print 'これ以上ステータスポイントをHPに割り振ることはできません。<br/>';
            print '<a href="homepage.php">トップページへ</a>';
        }
        else{
        $newGold = $result['gold'] - 50;
        $newHp = $result['hp'] + 25;
        $newPoint = $result['point'] - 2;
        $newHpPoint = $result['hppoint'] +1;

        // 更新処理
        $sql = 'UPDATE status SET gold = :gold, hp = :hp, point = :point, hppoint = :hppoint WHERE userID = :userID';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':gold', $newGold, PDO::PARAM_INT);
        $stmt->bindValue(':hp', $newHp, PDO::PARAM_INT);
        $stmt->bindValue(':point', $newPoint, PDO::PARAM_INT);
        $stmt->bindValue(':hppoint', $newHpPoint, PDO::PARAM_INT);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        print 'ステータスが更新されました<br/>';
        print "所持金: $newGold<br/>";
        print "HP: $newHp<br/>";
        print "ポイント: $newPoint<br/>";
        print '<a href="homepage.php">トップページへ</a>';
        }
    } else {
        print '該当するユーザーが見つかりません<br/>';
        print '<a href="homepage.php">トップページへ</a>';
    }
} catch (Exception $e) {
    print 'ただいま障害が発生しております。<br/>';
    print $e->getMessage();
    exit();
}

?>
