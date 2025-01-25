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

// メッセージ格納用
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todolist = $_POST['todolist'];
    $addgold = $_POST['addgold'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $period =  $_POST['period'];

    if (strtotime($enddate) <= strtotime($startdate)) {
        $message = "エラー: 終了日は開始日より後の日付である必要があります。";
        $form_data = [
            'todolist' => $todolist,
            'addgold' => $addgold,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'period' => $period
        ];
    } else {
        try {
            // データベース接続
            $pdo = new PDO($dsn, $db_user, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 最大 taskID を取得
            $sql = "SELECT IFNULL(MAX(taskID), 0) + 1 AS nextTaskID FROM UserTasks2 WHERE userID = :userID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $nextTaskID = $result['nextTaskID'];

            // 新しいタスクを挿入
            $sql = "INSERT INTO UserTasks2 (userID, taskID, todolist, addgold, startdate, enddate, period)
                    VALUES (:userID, :taskID, :todolist, :addgold, :startdate, :enddate, :period)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':taskID', $nextTaskID, PDO::PARAM_INT);
            $stmt->bindParam(':todolist', $todolist, PDO::PARAM_STR);
            $stmt->bindParam(':addgold', $addgold, PDO::PARAM_INT);
            $stmt->bindParam(':startdate', $startdate, PDO::PARAM_STR);
            $stmt->bindParam(':enddate', $enddate, PDO::PARAM_STR);
            $stmt->bindParam(':period', $period, PDO::PARAM_STR);
            $stmt->execute();

            $message = "タスクが正常に追加されました。";
        } catch (PDOException $e) {
            $message = "データベースエラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
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
        .form-label {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <div class="task-header text-center">
            <h1>Add New Task　<img id="animatedImage" src="animation/hero_left.PNG" style="width: 100px; height: 100px;"></h1>
            <!-- <p>Welcome, <?php echo htmlspecialchars($name); ?></p> -->
        </div>

        <?php if ($message): ?>
            <div class="alert <?php echo strpos($message, 'エラー') !== false ? 'alert-danger' : 'alert-success'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="add_task.php" method="post">
            <div class="mb-3">
                <label for="todolist" class="form-label">Task Description</label>
                <input type="text" class="form-control" id="todolist" name="todolist" required>
            </div>

            <div class="mb-3">
                <label for="period" class="form-label">Task Period</label>
                <select id="period" name="period" class="form-select" required>
                    <option value="daily" selected>Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="addgold" class="form-label">Gold Reward</label>
                <select id="addgold" name="addgold" class="form-select" required>
                    <option value="100" selected>100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="startdate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startdate" name="startdate" required>
                </div>
                <div class="col-md-6">
                    <label for="enddate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="enddate" name="enddate" required>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-plus-circle me-2"></i>Add Task
                </button>
                <a href="todo_tasks.php" class="btn btn-secondary">
                    <i class="fas fa-list me-2"></i>Back to Task List
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 以下はアニメーション
        const images = [
            'animation/hero_left.PNG', 
            'animation/hero_straight.PNG', 
            'animation/hero_right.PNG'
        ];
        let currentIndex = 0;
        const imageElement = document.getElementById('animatedImage');
        function changeImage() {
            currentIndex = (currentIndex + 1) % images.length;
            imageElement.src = images[currentIndex];
        }
        // Change image every 100 milliseconds (0.1 seconds)
        setInterval(changeImage, 150);
        document.getElementById('selectAll').addEventListener('change', function(e) {
            var checkboxes = document.querySelectorAll('input[name="taskIDs[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = e.target.checked;
            });
        });
        

        // 対応する金額の選択肢
        const goldOptions = {
            daily: [100, 200, 300],
            weekly: [700, 800, 900],
            monthly: [1500, 1600, 1700]
        };

        // 各要素の取得
        const periodSelect = document.getElementById('period');
        const addgoldSelect = document.getElementById('addgold');

        // 期間が変更されたとき
        periodSelect.addEventListener('change', function () {
            const selectedPeriod = periodSelect.value; // 選択された期間
            const options = goldOptions[selectedPeriod]; // 対応する選択肢を取得
            addgoldSelect.innerHTML = '';
            // 新しい選択肢を追加
            options.forEach(value => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = value;
                addgoldSelect.appendChild(option);
            });
            // デフォルトで最初の値を選択
            addgoldSelect.value = options[0];
        });
    </script>
</body>
</html>