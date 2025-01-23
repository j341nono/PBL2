<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録完了</title>
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
            margin: 60px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 15px;
            border: 3px solid #ae642f; /* 薄いブラウン */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* ヘッダー */
        h2 {
            color: #5f370e; /* 落ち着いたブラウン */
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }

        /* ボタン */
        .link-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #ae642f;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .link-button:hover {
            background-color: #944e25;
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            h2 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            .link-button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>新規登録完了</h2>
        <?php
        try {
            // POSTデータを受け取る
            $user_name = $_POST['name'];
            $user_pass = $_POST['pass'];

            // データベース接続設定
            $dsn = 'mysql:dbname=j024ishi5;host=localhost;charset=utf8';
            $user = 'j024ishi';
            $password = '';

            // データベースに接続
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // トランザクションを開始
            $dbh->beginTransaction();

            // Usersテーブルにデータを追加
            $sql_user = 'INSERT INTO Users (name, password) VALUES (?, ?)';
            $stmt_user = $dbh->prepare($sql_user);

            // ユーザーデータをバインドして実行
            $stmt_user->execute([$user_name, $user_pass]);

            // 最後に挿入されたuserIDを取得
            $user_id = $dbh->lastInsertId();

            // statusテーブルにデータを追加
            $sql_status = 'INSERT INTO status (userID, gold, hp, power, point, hppoint, powerpoint, type, shield, bullets, item1, item2, item3, stage) 
                        VALUES (?, 100, 75, 10, 14, 0, 0, 1, 1, 3, 1, 2, 3, 1)';
            $stmt_status = $dbh->prepare($sql_status);

            // statusデータをバインドして実行
            $stmt_status->execute([$user_id]);

            // トランザクションをコミット
            $dbh->commit();

            echo '<p>ユーザーを追加しました。</p>';
            echo '<p>ユーザーIDは: <strong>' . htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8') . '</strong></p>';
        } catch (Exception $e) {
            // エラー発生時にロールバック
            if ($dbh->inTransaction()) {
                $dbh->rollBack();
            }
            echo '<p style="color: red;">ただいま障害により大変ご迷惑をお掛けしております。</p>';
            exit();
        }
        ?>
        <a href="login.html" class="link-button">ログインページ</a>
    </div>
</body>
</html>
