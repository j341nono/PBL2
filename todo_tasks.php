<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    print 'ログインされていません<br/>';
    print '<a href="login.html">ログイン画面へ</a>';
    exit();
}
else
{
    $userID=$_SESSION['userID'];
    $name=$_SESSION['name'];
}

// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=j024ishi5;charset=utf8';
$db_user = 'j024ishi';
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
            FROM UserTasks
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
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 15px;
            border: 3px solid #ae642f; /* 薄いブラウン */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        /* ユーザー情報カード */
        .user-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #fffaf0; /* 柔らかい背景 */
            border-radius: 10px;
            border: 2px solid #ae642f;
            margin-bottom: 20px;
            font-size: 18px;
            color: #5f370e;
            font-weight: bold;
        }

        .user-card span {
            font-size: 16px;
        }

        /* テーブルデザイン */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        th {
            background-color: #ae642f; /* 濃いブラウン */
            color: #fff;
            font-weight: bold;
        }

        td {
            background-color: #fff8ee; /* 淡いベージュ */
        }

        tr:nth-child(even) td {
            background-color: #fdf2e6; /* 少し濃いベージュ */
        }

        tr:hover td {
            background-color: #ffe7c1; /* ホバー時の背景色 */
        }

        /* ソートセレクト */
        .sort-form {
            text-align: center;
            margin-bottom: 20px;
        }
        select {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
            background-color: #f7fafc;
            color: #333;
        }

        /* ボタンデザイン */
        button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #ae642f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #944e25;
        }
        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
            }

            button {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <h2 style="text-align: center; color: #ae642f;">タスクリスト</h2>

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
            <p style="text-align: center; color: #ae642f;">現在、タスクはありません。</p>
        <?php endif; ?>
        <br>
            <button onclick="location.href='add_task.php'">タスクを追加する</button>
            <button onclick="location.href='homepage.php'">トップページへ</button>
    </div>
</body>
</html>
