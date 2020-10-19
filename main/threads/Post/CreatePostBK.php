<?php
    // DB登録
    function post_db($id, $thread_id, $author, $sentence, $created_at)
    {
        $dsn = "mysql:dbname=********;host=localhost;port=3306;charset=utf8mb4"; // 接続情報
        $username = "********"; // ユーザネーム
        $password = "********"; // パスワード
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8mb4`"); // 文字コード設定

        // DB接続
        $dbh = new PDO($dsn, $username, $password, $options);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // ポスト情報登録
        $regist = $dbh->prepare("INSERT INTO posts(id, thread_id, author, sentence, created_at)
                                VALUES($id, $thread_id, :author, :sentence, :created_at)");
        $dbh->quote($author);
        $regist->bindParam(":author", $author);
        $dbh->quote($sentence);
        $regist->bindParam(":sentence", $sentence);
        $regist->bindParam(":created_at", $created_at);
        $regist->execute();
    }

    $id = rand(0000000, 9999999); // ポストID
    $thread_id = $_POST["thread_id"]; // スレッドID
    $author = htmlspecialchars($_POST["post_author"], ENT_QUOTES, "UTF-8"); // 投稿者
    $sentence = htmlspecialchars($_POST["post_sentence"], ENT_NOQUOTES, "UTF-8"); // 投稿内容
    date_default_timezone_set('Asia/Tokyo');
    $created_at = date("Y-m-d H:i:s");  // 作成日時

    try
    {
        // DB登録
        post_db($id, $thread_id, $author, $sentence, $created_at); // DB登録
    } catch (PDOException $e){
        // 再試行
        $id = rand(0000000, 9999999);
        post_db($id, $thread_id, $author, $sentence, $created_at);
    } finally {
        exit;
    }
?>
