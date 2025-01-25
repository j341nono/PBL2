<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません<br/>';
    print '<a href="../login/login.html">ログイン画面へ</a>';
    exit();
} else {
    $userID = $_SESSION['userID'];
    $name = $_SESSION['name'];
}


// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=j341nonoP;charset=utf8';
$db_user = 'j341nono';
$db_password = '';

try {
    // データベース接続
    $pdo = new PDO($dsn, $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_POST['taskIDs'])) {
        print '完了選択されたタスクがありません。<br/>';
        print '<a href="todo_tasks.php">戻る</a>';
        exit();
    }

    // 完了選択されたタスクIDを取得
    $completedTaskIDs = $_POST['taskIDs'];

    // トランザクション開始
    $pdo->beginTransaction();
      // ユーザーの現在のゴールドを取得
    $sql = "SELECT gold FROM status2 WHERE userID = :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $status = $stmt->fetch(PDO::FETCH_ASSOC);

    // 完了タスクのゴールドを計算
    $totalGold = 0;
    $sql = "SELECT addgold FROM UserTasks2 WHERE userID = :userID AND taskID = :taskID";
    $stmt = $pdo->prepare($sql);

    foreach ($completedTaskIDs as $taskID) {
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':taskID', $taskID, PDO::PARAM_INT);
        $stmt->execute();
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($task) {
            $totalGold += $task['addgold'];
        }
    }
    // ゴールドを更新
    $newGold = $status['gold'] + $totalGold;
    $sql = "UPDATE status2 SET gold = :gold WHERE userID = :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':gold', $newGold, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    // 完了したタスクを削除
    $sql = "DELETE FROM UserTasks2 WHERE userID = :userID AND taskID = :taskID";
    $stmt = $pdo->prepare($sql);
    foreach ($completedTaskIDs as $taskID) {
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':taskID', $taskID, PDO::PARAM_INT);
        $stmt->execute();
    }

    // トランザクション確定
    $pdo->commit();

    print "完了したタスクのゴールド($totalGold)を追加しました！<br/>";
    print '<a href="todo_tasks.php">タスクリストに戻る</a>';

} catch (Exception $e) {
    // エラー時にロールバック
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "エラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit();
}
?>
