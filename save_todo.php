<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    // DB接続
    $host = 'localhost';
    $user = 'j341nono';
    $password = '';
    $dbname = 'j341nono9';
    $db = new mysqli($host, $user, $password, $dbname);

    // 接続エラーチェック
    if ($db->connect_error) {
        echo $mysqli->connect_error;
        exit();
    }
    $db->set_charset("utf8");
    // SQLの準備
    $stmt = $db->prepare("SELECT * FROM UserTask WHERE userID = ?");
    $userID = 1224;
    $stmt->bind_param("i", $userID);

    // クエリの実行
    $stmt->execute();
    $result = $stmt->get_result();

    // 結果の取得
    $todo = [];
    while ($row = $result->fetch_assoc()) {
        $todo[] = $row;
    }

    // JSONとして出力
    echo json_encode($todo);

    // 接続を閉じる
    $stmt->close();
    $db->close();
} catch (Exception $e) {
    // エラー時のレスポンス
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>