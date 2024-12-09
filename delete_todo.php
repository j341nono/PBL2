<?php
// delete_todo.php
header('Content-Type: text/plain');

try {
    // DB接続
    $db = new mysqli('localhost', 'nonomura', '1224', 'j341nono9');

    // 接続エラーチェック
    if ($db->connect_error) {
        throw new Exception("データベース接続エラー: " . $db->connect_error);
    }

    // IDの取得
    $id = $db->real_escape_string($_GET['id'] ?? null);

if ($id === null) {
        throw new Exception('IDが指定されていません');
    }

    // SQLの準備とパラメータのバインド
    $stmt = $db->prepare("DELETE FROM UserTask WHERE taskID = ?AND userID = ?");
    $userID = 1224;
    $stmt->bind_param("ii", $id, $userID);

    // 実行
    $res = $stmt->execute();

    if ($res) {
        echo "削除しました";
    } else {
        throw new Exception('削除に失敗しました: ' . $stmt->error);
    }

    // 接続を閉じる
    $stmt->close();
    $db->close();
} catch (Exception $e) {
    echo "エラー: " . $e->getMessage();
}
?>