<?php
    $dsn = "mysql:dbname=********;host=localhost;port=3306;charset=utf8mb4"; // 接続情報
    $username = "********"; // ユーザネーム
    $password = "********"; // パスワード
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8mb4`"); // 文字コード設定

    // DB接続
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ポスト数が多い順で上位５個のスレッドを取得
    $regist = $dbh->query("SELECT t.id AS tid, title, COUNT(p.id) AS post_num
                            FROM threads t
                            INNER JOIN posts p
                            ON p.thread_id = t.id
                            GROUP BY t.id
                            HAVING COUNT(p.id) < 1000
                            ORDER BY post_num DESC LIMIT 5");
    $result_threads = $regist->fetchAll();

    $threads = array();
    for ($i = 0; $i < count($result_threads); $i++)
    {
        // 連想配列格納
        $thread_data = array("id" => $result_threads[$i]["tid"], "title" => $result_threads[$i]["title"],
                            "post_num" => $result_threads[$i]["post_num"]);
        array_push($threads, $thread_data);
    }

    // JSON形式でindex.phpに送信
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($threads, JSON_UNESCAPED_UNICODE);
?>