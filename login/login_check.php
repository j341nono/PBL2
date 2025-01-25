<?php
// データベース接続設定
$host = 'localhost'; // ホスト名
$dbname = 'j431miyoP'; // データベース名
$username = 'j431miyo'; // データベースユーザー名
$password = ''; // データベースパスワード

try {
    // PDOでデータベース接続
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続エラー: " . $e->getMessage());
}

// フォームデータの取得
$userID = $_POST['userID'] ?? '';
$password_input = $_POST['password'] ?? '';

// データベースからユーザー情報を取得
$sql = "SELECT * FROM Users2 WHERE userID = :userID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && $password_input === $user['password']) {
    session_start();
    $_SESSION['login']=1;
    $_SESSION['userID']=$user['userID'];
    $_SESSION['name']=$user['name'];
    // ログイン成功時にユーザーごとのページにリダイレクト
    header("Location: ../homepage/homepage.php");
    //header("Location: homepage.php?userID=" . urlencode($userID));
    exit;
} else {
    // ログイン失敗時
    echo "<h2>ログイン失敗</h2>";
    echo "<p>ユーザーIDまたはパスワードが間違っています。</p>";
    echo '<a href="login.html">戻る</a>';
}
?>