<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO リスト</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .todo-list {
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            min-height: 300px;
        }
        .todo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .add-todo-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 30px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        #addTodoModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
        }
        .modal-content input, .modal-content select {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
        }
        .tab {
            flex: 1;
            padding: 10px;
            text-align: center;
            background-color: #e0e0e0;
            cursor: pointer;
            border: 1px solid #ccc;
        }
        .tab.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="tabs">
        <div class="tab active" data-type="daily">デイリー</div>
        <div class="tab" data-type="weekly">ウィークリー</div>
        <div class="tab" data-type="monthly">マンスリー</div>
    </div>

    <div class="todo-list" id="todoList"></div>
    
    <button class="add-todo-btn" id="openAddTodoModal">+</button>

    <div id="addTodoModal" class="modal">
        <div class="modal-content">
            <h2>新しいTODOを追加</h2>
            <input type="text" id="todoMission" placeholder="ミッション">
            <input type="number" id="todoAmount" placeholder="金額">
            <input type="text" id="todoContent" placeholder="内容">
            <input type="date" id="todoStartDate" placeholder="開始日">
            <input type="date" id="todoEndDate" placeholder="終了日">
            <button id="saveTodo">保存</button>
            <button id="cancelTodo">キャンセル</button>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                renderTodoList(tab.dataset.type);
            });
        });

        document.getElementById('openAddTodoModal').addEventListener('click', () => {
            document.getElementById('addTodoModal').style.display = 'block';
        });

        document.getElementById('cancelTodo').addEventListener('click', () => {
            document.getElementById('addTodoModal').style.display = 'none';
        });

        document.getElementById('saveTodo').addEventListener('click', () => {
            // const type = document.getElementById('todoType').value;
            const mission = document.getElementById('todoMission').value;
            const amount = document.getElementById('todoAmount').value;
            const content = document.getElementById('todoContent').value;
            const startdate = document.getElementById('todoStartDate').value;
            const enddate = document.getElementById('todoEndDate').value;

            // mission && amount && content だったが、contentは除外
            if (mission && amount) {
                fetch('save_todo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `mission=${encodeURIComponent(mission)}&amount=${encodeURIComponent(amount)}&content=${encodeURIComponent(content)}&startdate=${encodeURIComponent(startdate)}&enddate=${encodeURIComponent(enddate)}`
                })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                    document.getElementById('addTodoModal').style.display = 'none';
                    renderTodoList();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('エラーが発生しました');
                });
            } else {
                alert('すべての項目を入力してください');
            }
        });

        // データベースにデイリー等が未実装のため、dailyを表示
        function renderTodoList() {
            fetch('get_todo.php')
            .then(response => response.json())
            .then(todo => {
                const todoList = document.getElementById('todoList');
                todoList.innerHTML = '';

            // すべてのタスクを仮にdailyとして扱う
            const todos = todo.map(item => ({ ...item, type: 'daily' }));
                if (todos.length === 0) {
                    todoList.innerHTML = '<p>TODOがありません</p>';
                    return;
                }

                todos.forEach(todo => {
                    const todoItem = document.createElement('div');
                    todoItem.classList.add('todo-item');
                    todoItem.innerHTML = `
                        <div>
                            <strong>${todo.todolist}</strong>
                            <p>金額: ${todo.addgold}円</p>
                            <p>開始日: ${todo.startdate || '未設定'}</p>
                            <p>終了日: ${todo.enddate || '未設定'}</p>
                        </div>
                        <button onclick="deleteTodo(${todo.taskID})">削除</button>
                    `;
                    todoList.appendChild(todoItem);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('TODOの読み込みに失敗しました');
            });
        }

        function deleteTodo(id) {
            fetch(`delete_todo.php?id=${id}`, {
                method: 'DELETE'
            })
            .then(response => response.text())
            .then(result => {
                alert(result);
                renderTodoList();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('TODOの削除に失敗しました');
            });
        }

        // Initial render
        renderTodoList();
    </script>
</body>
</html>