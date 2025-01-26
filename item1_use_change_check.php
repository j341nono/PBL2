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
    $stage_num = $_POST['stage_num'];

    $dsn = 'mysql:host=localhost;dbname=j431miyoP;charset=utf8';
    $user = 'j431miyo';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ユーザーの現在のitem1_useを取得
    $sql = 'SELECT item1_use FROM status2 WHERE userID = :userID';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    if ($result) {
        // item1_use +1
        if($result['item1_use'] == 0){
            $newItem1_use = 1;
        } else {
            $newItem1_use = 0;
        }
        
        // 更新処理
        $sql = 'UPDATE status2 SET item1_use = :item1_use WHERE userID = :userID';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':item1_use', $newItem1_use, PDO::PARAM_INT);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        
        print '<a href="game_start.php">ゲームスタートページへ</a>';
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