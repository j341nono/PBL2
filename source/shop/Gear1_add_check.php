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
    $dsn = 'mysql:host=localhost;dbname=j431miyoP;charset=utf8';
    $user = 'j431miyo';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ユーザーの現在のgoldとGear1を取得
    $sql = 'SELECT gold, Gear1 FROM status2 WHERE userID = :userID';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // gold -200, Gear1 +1
        if($result['gold']<200){
            print 'ゴールドが不足しています。<br/>';
            print '<a href="../shop/shop.php">ショップページへ</a>';
        } else if ($result['Gear1'] > 0){
            print 'もう買えません。<br/>';
            print '<a href="../shop/shop.php">ショップページへ</a>';
        }
        else{
        $newGold = $result['gold'] - 200;
        $newGear1 = $result['Gear1'] + 1;

        // 更新処理
        $sql = 'UPDATE status2 SET gold = :gold, Gear1 = :Gear1 WHERE userID = :userID';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':gold', $newGold, PDO::PARAM_INT);
        $stmt->bindValue(':Gear1', $newGear1, PDO::PARAM_INT);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        print 'Gear1を購入しました<br/>';
        print "所持金: $newGold<br/>";
        print "Gear1: $newGear1<br/>";
        print '<a href="../shop/shop.php">ショップページへ</a>';
        }
    } else {
        print '該当するユーザーが見つかりません<br/>';
        print '<a href="../login/login.html">ログインページへ</a>';
    }
} catch (Exception $e) {
    print 'ただいま障害が発生しております。<br/>';
    print $e->getMessage();
    exit();
}

?>