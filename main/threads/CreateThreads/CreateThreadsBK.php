<?php
    // DB登録
    function thread_db($id, $title, $genre_id, $tags, $tag_num, $author, $exp, $created_at)
    {
        $dsn = "mysql:dbname=********;host=localhost;port=3306;charset=utf8mb4"; // 接続情報
        $username = "********"; // ユーザネーム
        $password = "********"; // パスワード
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8mb4`"); // 文字コード設定

        // DB接続
        $dbh = new PDO($dsn, $username, $password, $options);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // エスケープ処理(SQL)
        $dbh->quote($title);
        $dbh->quote($author);
        $dbh->quote($exp);

        // タグDB登録
        for ($i = 0; $i < $tag_num; $i++)
        {
            $regist = $dbh->prepare("INSERT INTO tags_tb(tag_name) 
                                    SELECT :tag_name
                                    WHERE NOT EXISTS (
                                        SELECT id
                                        FROM tags_tb t
                                        WHERE t.tag_name = :tag_name)");
            $dbh->quote($tags[$i]);
            $regist->bindParam(":tag_name", $tags[$i]);
            $regist->execute();
        }
        
        // スレッドDB登録
        if ($tag_num == 1)
        {
            $regist = $dbh->prepare("INSERT INTO threads(id, title, genre_id, tag1_id, author, expla, created_at) 
                                    SELECT :id, :title, :genre_id, tb1.id, :author, :expla, :created_at
                                    FROM tags_tb AS tb1
                                    WHERE :tag1 = tb1.tag_name"
                                );
            $regist->bindParam(":id", $id);
            $regist->bindParam(":title", $title);
            $regist->bindParam(":genre_id", $genre_id);
            $regist->bindParam(":tag1", $tags[0]);
            $regist->bindParam(":author", $author);
            $regist->bindParam(":expla", $exp);
            $regist->bindParam(":created_at", $created_at);
            $regist->execute();
        } else if ($tag_num == 2) {
            $regist = $dbh->prepare("INSERT INTO threads(id, title, genre_id, tag1_id, tag2_id, author, expla, created_at) 
                                    SELECT :id, :title, :genre_id, tb1.id, tb2.id, :author, :expla, :created_at
                                    FROM tags_tb AS tb1, tags_tb AS tb2
                                    WHERE :tag1 = tb1.tag_name AND :tag2 = tb2.tag_name"
                                );
            $regist->bindParam(":id", $id);
            $regist->bindParam(":title", $title);
            $regist->bindParam(":genre_id", $genre_id);
            $regist->bindParam(":tag1", $tags[0]);
            $regist->bindParam(":tag2", $tags[1]);
            $regist->bindParam(":author", $author);
            $regist->bindParam(":expla", $exp);
            $regist->bindParam(":created_at", $created_at);
            $regist->execute();
        } else {
            $regist = $dbh->prepare("INSERT INTO threads(id, title, genre_id, tag1_id, tag2_id, tag3_id, author, expla, created_at) 
                                    SELECT :id, :title, :genre_id, tb1.id, tb2.id, tb3.id, :author, :expla, :created_at
                                    FROM tags_tb AS tb1, tags_tb AS tb2, tags_tb AS tb3
                                    WHERE :tag1 = tb1.tag_name AND :tag2 = tb2.tag_name AND :tag3 = tb3.tag_name"
                                );
            $regist->bindParam(":id", $id);
            $regist->bindParam(":title", $title);
            $regist->bindParam(":genre_id", $genre_id);
            $regist->bindParam(":tag1", $tags[0]);
            $regist->bindParam(":tag2", $tags[1]);
            $regist->bindParam(":tag3", $tags[2]);
            $regist->bindParam(":author", $author);
            $regist->bindParam(":expla", $exp);
            $regist->bindParam(":created_at", $created_at);
            $regist->execute();
        }
    }

    // エスケープ処理(HTML)
    function h($s) {
        return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
    }

    $id = rand(0000000, 9999999); // スレッドID
    $title = h($_POST["title_name"]);  // スレッドタイトル
    $genre_id = h($_POST["genre_id"]);    // ジャンルID
    // タグ
    $tags_a = h($_POST["tags_name"]);
    $tags = explode(" ", $tags_a);
    $tag_num = count($tags); // タグ個数
    $author = h($_POST["author_name"]);  // 作成者名
    $exp = h($_POST["exp_txt"]);       // スレッド説明
    date_default_timezone_set('Asia/Tokyo');
    $created_at = date("Y-m-d H:i:s");  // 作成日時

    try {
        // DB登録
        thread_db($id, $title, $genre_id, $tags, $tag_num, $author, $exp, $created_at); // DB登録
    } catch(PDOException $e) {
        // 再試行
        $id = rand(0000000, 9999999);
        thread_db($id, $title, $genre_id, $tags, $tag_num, $author, $exp, $created_at);
    } finally {
        // スレッドページテンプレート
        $threads_page = file_get_contents('./threads-org.php');
        $threads_page = mb_convert_encoding($threads_page, "UTF-8","AUTO"); // 文字コード設定

        $file_name = "thread-".$id.".php"; // スレッドページ名

        $handle = fopen("../".$file_name, 'w'); // ページ作成
        // ページ書き込み
        fwrite($handle, $threads_page);
        fclose($handle);
        
        header('location:../'.$file_name); // ページリダイレクト
        exit;
    }
?>
