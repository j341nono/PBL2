## 動作確認

https://sshg.cs.ehime-u.ac.jp/~j341nono/pbl2/index.php


--下のurlはtodoリストの管理をローカルストレージで実装したもの

（旧）https://sshg.cs.ehime-u.ac.jp/~j341nono/pbl2/mission.html


## ファイルの構成

index.php : メインの画面。

--以下はindex.phpから実行されるバックエンド的な

get_todo.php : dbから内容を取り出して、index.phpに渡す

save_todo.php : 新たに追加するtodoをdbに保存する

（以下は未）
delete_todo.php : todoリストの内容を削除する（予定）


## 疑問・質問

データベースには、userID, todolist, addgold, startdate, enddateが保存されている。
todolistは、タスク名と、その内容説明の２点を管理するか。或いは、dbのようにtodolistだけか。
現在は、ウェブページ上では、両方（タスク名、内容説明）を表示している。dbに保存するのはタスク名だけ。したがって、内容説明の部分は現在は何の機能もない。

todoリストからの削除はdb上のデータも削除するか。現在は保留。


## 今後

daily, manthlyなどのdbの実装。web画面のタブの表示...

削除機能 --> データベースからも削除

todolistに追加するタスクの日付のエラー処理

タスク完了ボタンの実装 --> タスクを完了したら、そのタスクの金額を個人のaddgoldに追加する


## 各種設定

$host = 'localhost';

$user = 'j341nono';

$password = '';

$dbname = 'j341nono9';



