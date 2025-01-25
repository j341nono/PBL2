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
    $userID = $_SESSION['userID'];
}

// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=j431miyoP;charset=utf8';
$db_user = 'j431miyo';
$db_password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taskIDs'])) {
    $taskIDs = $_POST['taskIDs'];

    try {
        // データベース接続
        $pdo = new PDO($dsn, $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 選択されたタスクを削除
        $sql = "DELETE FROM UserTasks2 WHERE userID = :userID AND taskID = :taskID";
        $stmt = $pdo->prepare($sql);

        foreach ($taskIDs as $taskID) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':taskID', $taskID, PDO::PARAM_INT);
            $stmt->execute();
        }

        echo "選択されたタスクを削除しました。<br>";
        echo '<a href="todo_tasks.php">タスクリストに戻る</a>';

    } catch (PDOException $e) {
        echo "データベース接続エラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        exit();
    }
} else {
    echo "削除するタスクが選択されていません。<br>";
    echo '<a href="todo_tasks.php">タスクリストに戻る</a>';
}
?>