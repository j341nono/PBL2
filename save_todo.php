<?php
// save_todo.php
header('Content-Type: text/plain');

try {
    // DB接続
    $host = 'localhost';
    $user = 'j341nono';
    $password = '';
    $dbname = 'j341nono9';
    $db = new mysqli($host, $user, $password, $dbname);

    // 接続エラーチェック
    if ($db->connect_error) {
        echo $db->connect_error;
        exit();
    }

    // POSTデータの受け取り
    // $type = $db->real_escape_string($_POST['type'] ?? '');

    # 以下、missionとcontentがdbになく、代わりにtodolistがdbにあるため保留
    # $mission = $db->real_escape_string($_POST['mission'] ?? '');
    # $content = $db->real_escape_string($_POST['content'] ?? '');
    $todolist = $db->real_escape_string($_POST['mission'] ?? '');
    $amount = $db->real_escape_string($_POST['amount'] ?? '');
    $startdate = $db->real_escape_string($_POST['startdate'] ?? '');
    $enddate = $db->real_escape_string($_POST['enddate'] ?? '');
    // バリデーション
    if (empty($todolist) || empty($amount)) {
        throw new Exception('必須項目が不足しています');
    }

    // SQLセット
    // $stmt = $db->prepare("INSERT INTO UserTask (userID, todolist, addgold, startdate, enddate, type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt = $db->prepare("INSERT INTO UserTask (userID, todolist, addgold, startdate, enddate) VALUES (?, ?, ?, ?, ?)");

    // 値のセット
    $userID = 1224;
    // $stmt->bind_param("issssss", $userID, $mission, $amount, $startdate, $enddate, $type);
    $stmt->bind_param("issss", $userID, $todolist, $amount, $startdate, $enddate);

    // 実行
    $res = $stmt->execute();
    if ($res) {
        echo "登録しました";
    } else {
        throw new Exception('データベースへの保存に失敗しました: ' . $stmt->error);
    }

    // ステートメントと接続を閉じる
    $stmt->close();
    $db->close();
} catch (Exception $e) {
    echo "エラー: " . $e->getMessage();
}
?>