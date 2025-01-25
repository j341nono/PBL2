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

    // ユーザーの現在のgoldとitem3を取得
    $sql = 'SELECT gold, item3 FROM status2 WHERE userID = :userID';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // gold -200, item3 +1
        if($result['gold']<200){
            print 'ゴールドが不足しています。<br/>';
            print '<a href="../shop/shop.php">ショップページへ</a>';
        } else if ($result['item3'] > 98){
            print 'もう買えません。<br/>';
            print '<a href="../shop/shop.php">ショップページへ</a>';
        }
        else{
        $newGold = $result['gold'] - 200;
        $newItem3 = $result['item3'] + 1;

        // 更新処理
        $sql = 'UPDATE status2 SET gold = :gold, item3 = :item3 WHERE userID = :userID';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':gold', $newGold, PDO::PARAM_INT);
        $stmt->bindValue(':item3', $newItem3, PDO::PARAM_INT);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        print 'item3を購入しました<br/>';
        print "所持金: $newGold<br/>";
        print "item3: $newItem3<br/>";
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