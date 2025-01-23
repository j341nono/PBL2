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
    <style>
        /* 全体のスタイル */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #fdf8f2; /* 明るいベージュ系背景 */
            color: #333;
        }

        /* コンテナデザイン */
        .container {
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 15px;
            border: 3px solid #ae642f; /* 薄いブラウン */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* ヘッダー */
        h1, p {
            text-align: center;
            color: #5f370e; /* 落ち着いたブラウン */
        }

        /* メッセージ */
        .message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        /* フォーム */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #5f370e;
        }

        input[type="text"], 
        input[type="date"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
            background-color: #f7fafc; /* 明るい背景 */
            color: #333;
        }

        input[type="text"]:focus,
        input[type="date"]:focus {
            outline: none;
            border-color: #ae642f; /* フォーカス時の枠色 */
            box-shadow: 0 0 5px rgba(174, 100, 47, 0.5);
        }

        button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #ae642f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #944e25;
        }

        /* リンクボタン */
        .link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #ae642f;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .link:hover {
            color: #944e25;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ようこそ ユーザーID: <?php echo htmlspecialchars($userID); ?> さん</h1>
        <p><?php echo htmlspecialchars($name); ?>さん、タスクを追加してください。</p>

        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="add_task.php" method="post">
            <label for="todolist">やることリスト:</label>
            <input type="text" id="todolist" name="todolist" required>

            <!--<label for="addgold">追加ゴールド:</label>-->
            <input type="hidden" id="addgold" name="addgold" value="100" required>

            <label for="startdate">開始日:</label>
            <input type="date" id="startdate" name="startdate" required>

            <label for="enddate">終了日:</label>
            <input type="date" id="enddate" name="enddate" required>

            <button type="submit">タスクを追加</button>
        </form>

        <a class="link" href="todo_tasks.php">タスクリストへ戻る</a>
    </div>
</body>
</html>

