<?php
    $tag_id = $_POST["tag_id"]; // タグID
    
    $dsn = "mysql:dbname=********;host=localhost;port=3306;charset=utf8mb4"; // 接続情報
    $username = "********"; // ユーザネーム
    $password = "********"; // パスワード
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8mb4`"); // 文字コード設定

    // DB接続
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $threads = array();

    // タグ名取得
    $regist = $dbh->query("SELECT tag_name FROM tags_tb WHERE id = $tag_id");
    $tag_name = $regist->fetch();
    array_push($threads, array("tag" => $tag_name["tag_name"]));

    // タグ名に一致するスレッドを取得
    $regist = $dbh->query("SELECT t.id, title, t1.tag_name AS tag_n1, t2.tag_name AS tag_n2, t3.tag_name AS tag_n3, author, expla, created_at, genre_name
                            FROM threads t
                            LEFT OUTER JOIN genre_tb
                            ON genre_tb.id = t.genre_id
                            LEFT OUTER JOIN tags_tb t1
                            ON t1.id = t.tag1_id
                            LEFT OUTER JOIN tags_tb t2
                            ON t2.id = t.tag2_id
                            LEFT OUTER JOIN tags_tb t3
                            ON t3.id = t.tag3_id
                            WHERE t.tag1_id = $tag_id OR t.tag2_id = $tag_id OR t.tag3_id = $tag_id
                            ORDER BY created_at DESC");
    $result = $regist->fetchAll();

    for ($i = 0; $i < count($result); $i++)
    {
        $tags = $result[$i]["tag_n1"];
        $tag2 = $result[$i]["tag_n2"];
        $tag3 = $result[$i]["tag_n3"];

        // タグ2が存在したら結合
        if (isset($tag2))
        {
            $tags = $tags." ".$tag2;
        
            // タグ3が存在したら結合
            if (isset($tag3))
            {
                $tags = $tags." ".$tag3;
            }
        }

        // 連想配列格納
        $thread_data = array("id" => $result[$i]["id"], "title" => $result[$i]["title"],
                            "genre" => $result[$i]["genre_name"], "tags" => $tags, 
                            "author" => $result[$i]["author"], "exp" => $result[$i]["expla"],
                            "created_at" => $result[$i]["created_at"]);

        array_push($threads, $thread_data);
    }

    // JSON形式でgenrethreads.phpに送信
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($threads, JSON_UNESCAPED_UNICODE);

    exit;
?>

