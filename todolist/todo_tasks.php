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

    // ソート条件を取得
    $orderBy = "taskID"; // デフォルトのソートはtaskID
    if (isset($_GET['sort']) && in_array($_GET['sort'], ['taskID', 'startdate', 'enddate', 'period'])) {
        $orderBy = $_GET['sort'];
    }

    // 表示するperiodを取得（デフォルトはdaily）
    $currentPeriod = isset($_GET['period']) ? $_GET['period'] : 'daily';

    // ユーザーのタスクリストを取得（ソート条件とperiod付き）
    $sql = "SELECT taskID, todolist, addgold, startdate, enddate, period
            FROM UserTasks2
            WHERE userID = :userID AND period = :period
            ORDER BY $orderBy";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':period', $currentPeriod);
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
    <title>Corporate Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .dashboard-container {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 30px;
            margin-top: 30px;
        }
        .task-header {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .nav-tabs .nav-link {
            color: #2c3e50;
            font-weight: bold;
        }
        .nav-tabs .nav-link.active {
            background-color: #3498db;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }
        .btn-action {
            margin-right: 10px;
        }
        .task-action-icons {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <div class="task-header text-center">
            <h1>Task Management Dashboard　<img id="animatedImage" src="./../game/hero_left.PNG" style="width: 100px; height: 100px;"></h1>
            <!-- <h3>Welcome, <?php echo htmlspecialchars($name); ?></h3> -->
        </div>

        <!-- Period Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a href="?period=daily" class="nav-link <?php echo $currentPeriod === 'daily' ? 'active' : ''; ?>">Daily Tasks</a>
            </li>
            <li class="nav-item">
                <a href="?period=weekly" class="nav-link <?php echo $currentPeriod === 'weekly' ? 'active' : ''; ?>">Weekly Tasks</a>
            </li>
            <li class="nav-item">
                <a href="?period=monthly" class="nav-link <?php echo $currentPeriod === 'monthly' ? 'active' : ''; ?>">Monthly Tasks</a>
            </li>
        </ul>

        <!-- Sort Form -->
        <form method="get" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="period" value="<?php echo htmlspecialchars($currentPeriod); ?>">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="taskID" <?php if ($orderBy === 'taskID') echo 'selected'; ?>>Sort by Task ID</option>
                        <option value="startdate" <?php if ($orderBy === 'startdate') echo 'selected'; ?>>Sort by Start Date</option>
                        <option value="enddate" <?php if ($orderBy === 'enddate') echo 'selected'; ?>>Sort by End Date</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Task Table -->
        <?php if (count($tasks) > 0): ?>
            <form method="post" id="taskForm">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th>Task Description</th>
                                <th>Gold Reward</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><input type="checkbox" name="taskIDs[]" value="<?php echo htmlspecialchars($task['taskID']); ?>" class="form-check-input"></td>
                                    <td><?php echo htmlspecialchars($task['todolist']); ?></td>
                                    <td><?php echo htmlspecialchars($task['addgold']); ?></td>
                                    <td><?php echo htmlspecialchars($task['startdate']); ?></td>
                                    <td><?php echo htmlspecialchars($task['enddate']); ?></td>
                                    <td class="task-action-icons">
                                        <button type="button" data-action="delete" data-task-id="<?php echo htmlspecialchars($task['taskID']); ?>" class="btn btn-sm btn-danger btn-action task-action" title="Delete Task">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button type="button" data-action="complete" data-task-id="<?php echo htmlspecialchars($task['taskID']); ?>" class="btn btn-sm btn-success btn-action task-action" title="Complete Task">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-info">No tasks found for this period.</div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="mt-4 text-center">
            <a href="add_task.php" class="btn btn-primary me-2">
                <i class="fas fa-plus-circle me-2"></i>Add New Task
            </a>
            <a href="../homepage/homepage.php" class="btn btn-secondary">
                <i class="fas fa-home me-2"></i>Back to Home
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="animation.js" defer></script>
    <script>
        // New script to handle action buttons
        document.querySelectorAll('.task-action').forEach(function(button) {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                const action = this.getAttribute('data-action');
                const checkbox = this.closest('tr').querySelector('input[type="checkbox"]');
                
                // Check the checkbox for this specific task
                checkbox.checked = true;
                
                // Set the form action based on the button clicked
                const form = document.getElementById('taskForm');
                form.action = action === 'delete' ? 'delete_task.php' : 'add_gold.php';
                
                // Submit the form
                form.submit();
            });
        });
    </script>
</body>
</html>