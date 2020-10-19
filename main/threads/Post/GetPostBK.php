<?php
    $thread_id = $_POST['thread_id']; // スレッドID

    $dsn = "mysql:dbname=techanony;host=localhost;port=3306;charset=utf8mb4"; // 接続情報
    $username = "app"; // ユーザネーム
    $password = "Techanony-app-wtb1118"; // パスワード
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8mb4`"); // 文字コード設定

    // DB接続
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ポスト情報取得
    $regist = $dbh->query("SELECT * FROM posts WHERE thread_id = $thread_id ORDER BY created_at ASC");
    $result = $regist->fetchAll();

    // ポスト情報格納
    $posts = array();
    for ($i = 0; $i < count($result); $i++)
    {
        $post_data = array("id" => $result[$i]["id"], "name" => $result[$i]["author"],
                            "text" => $result[$i]["sentence"], "created_at" => $result[$i]["created_at"]);
        
        array_push($posts, $post_data);
    }

    // JSON形式で.phpに送信
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($posts, JSON_UNESCAPED_UNICODE);

    exit;
?>