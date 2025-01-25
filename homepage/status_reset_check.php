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

try {
    $dsn = 'mysql:host=localhost;dbname=j341nonoP;charset=utf8';
    $user = 'j341nono';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ユーザーの現在のhpとpointを取得
    $sql = 'SELECT gold, hp, power, point, hppoint, powerpoint FROM status2 WHERE userID = :userID';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // gold -500, hp=75, power=10, point=14, hppoint=powerpoint=0
        if($result['gold']<500){
            print 'ゴールドが不足しています。<br/>';
            print '<a href="homepage.php">トップページへ</a>';
        }
        else{
        $newGold = $result['gold'] - 500;
        $newHp = 75;
        $newPower = 10;
        $newPoint = 14;
        $newHpPoint = 0;
        $newPowerPoint = 0;

        // 更新処理
        $sql = 'UPDATE status2 SET gold = :gold, hp = :hp, power = :power, point = :point, hppoint = :hppoint, powerpoint = :powerpoint WHERE userID = :userID';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':gold', $newGold, PDO::PARAM_INT);
        $stmt->bindValue(':power', $newPower, PDO::PARAM_INT);
        $stmt->bindValue(':hp', $newHp, PDO::PARAM_INT);
        $stmt->bindValue(':point', $newPoint, PDO::PARAM_INT);
        $stmt->bindValue(':hppoint', $newHpPoint, PDO::PARAM_INT);
        $stmt->bindValue(':powerpoint', $newPowerPoint, PDO::PARAM_INT);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        print 'ステータスが更新されました<br/>';
        print "所持金: $newGold<br/>";
        print "HP: $newHp<br/>";
        print "攻撃力: $newPower<br/>";
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