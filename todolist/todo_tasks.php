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
$dsn = 'mysql:host=localhost;dbname=j431miyoP;charset=utf8';
$db_user = 'j431miyo';
$db_password = '';

try {
    // データベース接続
    $pdo = new PDO($dsn, $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ソート条件を取得
    $orderBy = "taskID"; // デフォルトのソートはtaskID
    if (isset($_GET['sort']) && in_array($_GET['sort'], ['taskID', 'startdate', 'enddate'])) {
        $orderBy = $_GET['sort'];
    }

    // ユーザーのタスクリストを取得（ソート条件付き）
    $sql = "SELECT taskID, todolist, addgold, startdate, enddate 
            FROM UserTasks2
            WHERE userID = :userID
            ORDER BY $orderBy";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "データベース接続エラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?>さんのタスクリスト</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .sort-form {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>ようこそ ユーザーID: <?php echo htmlspecialchars($userID); ?> さん</h1>
    <p><?php echo htmlspecialchars($name); ?>さんのページです。</p>

    <h2>タスクリスト</h2>

    <!-- ソートフォーム -->
    <form method="get" class="sort-form">
        <label for="sort">ソート方法:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="taskID" <?php if ($orderBy === 'taskID') echo 'selected'; ?>>タスクID</option>
            <option value="startdate" <?php if ($orderBy === 'startdate') echo 'selected'; ?>>開始日</option>
            <option value="enddate" <?php if ($orderBy === 'enddate') echo 'selected'; ?>>終了日</option>
        </select>
    </form>

    <?php if (count($tasks) > 0): ?>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>選択</th>
                        <th>タスクID</th>
                        <th>やることリスト</th>
                        <th>追加ゴールド</th>
                        <th>開始日</th>
                        <th>終了日</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><input type="checkbox" name="taskIDs[]" value="<?php echo htmlspecialchars($task['taskID']); ?>"></td>
                            <td><?php echo htmlspecialchars($task['taskID']); ?></td>
                            <td><?php echo htmlspecialchars($task['todolist']); ?></td>
                            <td><?php echo htmlspecialchars($task['addgold']); ?></td>
                            <td><?php echo htmlspecialchars($task['startdate']); ?></td>
                            <td><?php echo htmlspecialchars($task['enddate']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <button type="submit" formaction="delete_task.php">選択したタスクを削除</button>
                <button type="submit" formaction="add_gold.php">選択したタスクを完了</button>
        </form>
    <?php else: ?>
        <p>現在、タスクはありません。</p>
    <?php endif; ?>

    <button onclick="location.href='add_task.php'">タスクを追加する</button>
    <br>
    <br>
    <button onclick="location.href='../homepage/homepage.php'">トップページへ</button>
</body>
</html>