<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません<br/>';
    print '<a href="login.html">ログイン画面へ</a>';
    exit();
} else {
    $userID = $_SESSION['userID'];
    $name = $_SESSION['name'];
}

// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=j024ishi5;charset=utf8';
$db_user = 'j024ishi';
$db_password = '';

// メッセージ格納用
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todolist = $_POST['todolist'];
    $addgold = 100;
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];

    try {
        // データベース接続
        $pdo = new PDO($dsn, $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 最大 taskID を取得
        $sql = "SELECT IFNULL(MAX(taskID), 0) + 1 AS nextTaskID FROM UserTasks WHERE userID = :userID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nextTaskID = $result['nextTaskID'];

        // 新しいタスクを挿入
        $sql = "INSERT INTO UserTasks (userID, taskID, todolist, addgold, startdate, enddate)
                VALUES (:userID, :taskID, :todolist, :addgold, :startdate, :enddate)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':taskID', $nextTaskID, PDO::PARAM_INT);
        $stmt->bindParam(':todolist', $todolist, PDO::PARAM_STR);
        $stmt->bindParam(':addgold', $addgold, PDO::PARAM_INT);
        $stmt->bindParam(':startdate', $startdate, PDO::PARAM_STR);
        $stmt->bindParam(':enddate', $enddate, PDO::PARAM_STR);
        $stmt->execute();

        $message = "タスクが正常に追加されました。";
    } catch (PDOException $e) {
        $message = "データベースエラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加</title>
</head>
<body>
    <h1>ようこそ ユーザーID: <?php echo htmlspecialchars($userID); ?> さん</h1>
    <p><?php echo htmlspecialchars($name); ?>さん、タスクを追加してください。</p>

    <?php if ($message): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="add_task.php" method="post">
        <label for="todolist">やることリスト:</label><br>
        <input type="text" id="todolist" name="todolist" required>

        <!--<label for="addgold">追加ゴールド:</label><br>-->
        <input type="hidden" id="addgold" name="addgold" value="100" required><br><br>

        <label for="startdate">開始日:</label><br>
        <input type="date" id="startdate" name="startdate" required><br><br>

        <label for="enddate">終了日:</label><br>
        <input type="date" id="enddate" name="enddate" required><br><br>

        <button type="submit">タスクを追加</button>
    </form>

    <br>
    <a href="todo_tasks.php">タスクリストへ</head></a>
</body>
</html>
