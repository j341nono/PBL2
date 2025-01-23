<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認</title>
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
        }

        /* ヘッダー */
        h2 {
            text-align: center;
            color: #5f370e; /* 落ち着いたブラウン */
            margin-bottom: 20px;
        }

        /* メッセージ */
        .message {
            font-weight: bold;
            color: #5f370e; /* メッセージの文字色 */
            margin-bottom: 20px;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* ボタン */
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        input[type="button"], 
        input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #ae642f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="button"]:hover, 
        input[type="submit"]:hover {
            background-color: #944e25;
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            h2 {
                font-size: 20px;
            }

            input[type="button"], 
            input[type="submit"] {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>登録確認</h2>

        <?php
        $user_name = $_POST['name'];
        $user_pass = $_POST['pass'];
        $user_pass2 = $_POST['pass2'];

        $hasError = false;

        if ($user_name == '') {
            echo '<p class="error">ユーザー名が入力されていません</p>';
            $hasError = true;
        } else {
            echo '<p class="message">ユーザー名: ' . htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8') . '</p>';
        }

        if ($user_pass == '') {
            echo '<p class="error">パスワードが入力されていません</p>';
            $hasError = true;
        }

        if ($user_pass != $user_pass2) {
            echo '<p class="error">パスワードが一致しません</p>';
            $hasError = true;
        }

        if ($hasError) {
            echo '<div class="button-group">';
            echo '<input type="button" onclick="history.back()" value="戻る">';
            echo '</div>';
        } else {
            echo '<form method="post" action="user_add_done.php">';
            echo '<input type="hidden" name="name" value="' . htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8') . '">';
            echo '<input type="hidden" name="pass" value="' . htmlspecialchars($user_pass, ENT_QUOTES, 'UTF-8') . '">';
            echo '<div class="button-group">';
            echo '<input type="button" onclick="history.back()" value="戻る">';
            echo '<input type="submit" value="OK">';
            echo '</div>';
            echo '</form>';
        }
        ?>
    </div>
</body>
</html>
