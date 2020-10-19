<?php
    $dsn = "mysql:dbname=********;host=localhost;port=3306;charset=utf8mb4"; // 接続情報
    $username = "********"; // ユーザネーム
    $password = "********"; // パスワード
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8mb4`"); // 文字コード設定

    // DB接続
    $dbh = new PDO($dsn, $username, $password, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // タグ取得
    $regist = $dbh->query("SELECT tagtb.id AS tid, tagtb.tag_name AS tname, COUNT(tagtb.id) AS tcnt FROM tags_tb tagtb
                            LEFT OUTER JOIN threads t1
                            ON t1.tag1_id = tagtb.id
                            LEFT OUTER JOIN threads t2
                            ON t2.tag2_id = tagtb.id
                            LEFT OUTER JOIN threads t3
                            ON t3.tag3_id = tagtb.id
                            GROUP BY tagtb.id
                            ORDER BY tcnt DESC LIMIT 50");
    $result_tags = $regist->fetchAll();

    $tags = array();
    for ($i = 0; $i < count($result_tags); $i++)
    {
        // 連想配列格納
        $tag_data = array("id" => $result_tags[$i]["tid"], "tag" => $result_tags[$i]["tname"]);
        array_push($tags, $tag_data);
    }

    // JSON形式でindex.phpに送信
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($tags, JSON_UNESCAPED_UNICODE);
?>