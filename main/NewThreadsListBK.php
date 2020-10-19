<?php
    $dsn = "mysql:dbname=********;host=localhost;port=3306;charset=utf8mb4"; // 接続情報
    $username = "********"; // ユーザネーム
    $password = "********"; // パスワード
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8mb4`"); // 文字コード設定

    // DB接続
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 最近作成された順で上位５個のスレッドを取得
    $regist = $dbh->query("SELECT id, title, created_at FROM threads
                            ORDER BY created_at DESC LIMIT 5");
    $result_threads = $regist->fetchAll();

    $threads = array();
    for ($i = 0; $i < count($result_threads); $i++)
    {
        // 連想配列格納
        $thread_data = array("id" => $result_threads[$i]["id"], "title" => $result_threads[$i]["title"],
                            "created_at" => $result_threads[$i]["created_at"]);
        array_push($threads, $thread_data);
    }

    // JSON形式でindex.phpに送信
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($threads, JSON_UNESCAPED_UNICODE);
?>
