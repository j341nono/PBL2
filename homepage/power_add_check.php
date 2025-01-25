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
    $sql = 'SELECT gold, power, point, powerpoint FROM status2 WHERE userID = :userID';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // gold -50, power +1, point -1, powerpoint +1
        if($result['gold']<50){
            print 'ゴールドが不足しています。<br/>';
            print '<a href="homepage.php">トップページへ</a>';
        }
        else if($result['point']<1){
            print 'ステータスポイントが不足しています。<br/>';
            print '<a href="homepage.php">トップページへ</a>';
        }
        else if($result['powerpoint']==10){
            print 'これ以上ステータスポイントを攻撃力に割り振ることはできません。<br/>';
            print '<a href="homepage.php">トップページへ</a>';
        }
        else{
        $newGold = $result['gold'] - 50;
        $newPower = $result['power'] + 1;
        $newPoint = $result['point'] - 1;
        $newPowerPoint = $result['powerpoint'] + 1;

        // 更新処理
        $sql = 'UPDATE status2 SET gold = :gold, power = :power, point = :point, powerpoint = :powerpoint WHERE userID = :userID';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':gold', $newGold, PDO::PARAM_INT);
        $stmt->bindValue(':power', $newPower, PDO::PARAM_INT);
        $stmt->bindValue(':point', $newPoint, PDO::PARAM_INT);
        $stmt->bindValue(':powerpoint', $newPowerPoint, PDO::PARAM_INT);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        print 'ステータスが更新されました<br/>';
        print "所持金: $newGold<br/>";
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