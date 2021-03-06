<!-- ホーム  -->
<html>
    <head>
        <meta charset="utf-8">
        <title>Techanony | エンジニア向け匿名掲示板</title>
        <link rel="icon" type="image/x-icon" href="./favicon.ico">
        <!-- 共通SS  -->
        <link rel="stylesheet" type="text/css" href="./share-style.css">
        <!-- ホーム用SS  -->
        <link rel="stylesheet" type="text/css" href="./index-style.css">
    </head>

    <body>
        <!-- 共通部 BG  -->

        <!-- jQuery  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- モーダルウィンドウjs  -->
        <script type="text/javascript" src="./modal.js"></script>

        <!-- トップ移動  -->
        <a name="top"></a>

        <!-- ヘッダー  -->
        <div class="header">
            <!-- ロゴ  -->
            <div class="logo-div">
                <a class="logo-a" href="./index.php">
                    <img class="logo-img" src="./img/logo.png" alt="Techanony" width="150" height="60">
                </a>
            </div>

            <!-- 検索フォーム  -->
            <form class="search-form" name="search_threads" method="POST" action="./keyword-search/keyword-search.php">
                <input class="search-input" id="search_input" name="search_input" type="search" placeholder="キーワードを入力">
                <input class="search-submit" id="search_submit" type="image" value="検索" src="./img/searchbutton.png">
            </form>

            <!-- ナビゲーション  -->
            <div class="navi-div">
                <ul class="navi-table">
                    <!-- スレッド作成  -->
                    <li class="navi-item-thread">
                        <a class="navi-create-thread" id="open_thread_modal">スレッド作成</a>
                    </li>
                    <!-- ホーム  -->
                    <li class="navi-item">
                        <a class="navi-link" href="./index.php">ホーム</a>
                    </li>
                    <!-- お問い合わせ  -->
                    <li class="navi-item">
                        <a class="navi-link" href="./contact/contact.php">お問い合わせ</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 共通部 EN  -->

        <!-- コンテナー  -->
        <div class="container">
            <!-- メイン  -->
            <div class="main">
                <div class="content">
                    <!-- サイト説明  -->
                    <div class="top">
                        <div class="top-div">
                            <img class="top-img" src="./img/logo-big.png">
                            <div class="top-text">
                                <h1 class="top-h1">Techanonyとは</h1>
                                <p>Techanony(テックアノニー)はITエンジニア向けの匿名掲示板サイトです。</p>
                                <p>ITに関するホットな話題やあまり知られていない話題、個人が持つナレッジなどを共有することができます。</p>
                                <p>またMarkdown記述で投稿できるので、見やすく情報伝達がしやすいことも強みです。</p>
                            </div>
                        </div>
                    </div>
                    <div class="top-text">
                        <h3>匿名である意味</h3>
                        <p>ユーザアカウントという概念を実装するのは技術的にも時間的にも厳しいので、<br>
                        匿名でコミュニケーションを取らざる負えない掲示板サイトとなりました。</p>
                    </div>
                    <div class="top-text">
                        <h3>既視感のあるデザイン</h3>
                        <p>デザインのセンスがないので、某エンジニア向けQ&Aサイトを参考にデザインしました。</p>
                    </div>
                    
                    <!-- 人気スレッドリスト  -->
                    <div class="hot-thread-list">
                        <h2>人気スレッド</h2>
                        <ul id="hot_thread_table"></ul>
                    </div>

                    <!-- 人気スレッド取得  -->
                    <script type="text/javascript">
                        $.ajax({
                            type: "POST",
                            url: "./HotThreadsListBK.php",
                        })
                        .done(function(data){
                            if (data[0])
                            {
                                for (let i = 0; i < data.length; i++)
                                {
                                    h = "<div class='thread'>\
                                            <li><a class='thread-url' href='./threads/thread-"+data[i].id+".php'>"+data[i].title+
                                                "　　ポスト数: "+data[i].post_num+"</a>\
                                            </li>\
                                        </div>";
                                    $("#hot_thread_table").append(h);
                                }
                            } else {
                                $("#hot_thread_table").append("<li>スレッドが存在しません。</li>");
                            }
                        })
                    </script>

                    <!-- 新規スレッドリスト  -->
                    <div class="new-thread-list">
                        <h2>新規スレッド</h2>
                        <ul id="new_thread_table"></ul>
                    </div>

                    <!-- 新規スレッド取得  -->
                    <script type="text/javascript">
                        $.ajax({
                            type: "POST",
                            url: "./NewThreadsListBK.php",
                        })
                        .done(function(data){
                            if (data[0])
                            {
                                for (let i = 0; i < data.length; i++)
                                {
                                    h = "<div class='thread'>\
                                            <li><a class='thread-url' href='./threads/thread-"+data[i].id+".php'>"+data[i].title+
                                                "　　作成日時: "+data[i].created_at+"</a>\
                                            </li>\
                                        </div>";
                                    $("#new_thread_table").append(h);
                                }
                            } else {
                                $("#new_thread_table").append("<li>スレッドが存在しません。</li>");
                            }
                        })
                    </script>

                    <!-- お知らせ  -->
                    <div class="notice">
                        <h2>お知らせ</h2>
                        <dl class="notice-table">
                            <dt>2020.10.05</dt><dd>製作課題「Techanony」提出</dd>
                            <dt>2020.09.22</dt><dd>「Techanony」開発開始</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- 共通部 BG  -->

            <!-- サイドバー  -->
            <div class="sidebar">
                <div class="sidebar-items">
                    <!-- ジャンルリスト  -->
                    <h3 class="sidebar-item">ジャンル</h3>
                    <div class="genre-list">
                        <form name="genre_threads" method="POST" action="./threads-by-genre/threads-by-genre.php">
                            <input id="genre_id" name="genre_id" type="hidden">
                            <ul>
                                <li><a class="genre-item" href="javascript:g(1);">OS</a></li>
                                <li><a class="genre-item" href="javascript:g(2);">プログラミング</a></li>
                                <li><a class="genre-item" href="javascript:g(3);">アプリ開発</a></li>
                                <li><a class="genre-item" href="javascript:g(4);">データベース</a></li>
                                <li><a class="genre-item" href="javascript:g(5);">ネットワーク技術</a></li>
                                <li><a class="genre-item" href="javascript:g(6);">セキュリティ</a></li>
                                <li><a class="genre-item" href="javascript:g(7);">AI・機械学習</a></li>
                                <li><a class="genre-item" href="javascript:g(8);">IoT技術</a></li>
                                <li><a class="genre-item" href="javascript:g(9);">PC</a></li>
                                <li><a class="genre-item" href="javascript:g(10);">モバイル端末</a></li>
                                <li><a class="genre-item" href="javascript:g(11);">雑談・その他</a></li>
                            </ul>
                        </form>
                    </div>

                    <!-- ジャンルID送信  -->
                    <script type="text/javascript">
                        function g(id){
                            $("#genre_id").val(id);
                            genre_threads.submit();
                            return false;
                        }
                    </script>

                    <!-- タグリスト  -->
                    <h3 class="sidebar-item">タグ</h3>
                    <div class="tags-list">
                        <form name="tag_threads" method="POST" action="./threads-by-tags/threads-by-tags.php">
                            <input id="tag_id" name="tag_id" type="hidden">
                            <ul id="tags_list"></ul>
                        </form>
                    </div>

                    <!-- タグ取得  -->
                    <script type="text/javascript">
                        $.ajax({
                            type: "POST",
                            url: "./threads-by-tags/TagsListBK.php",
                        })
                        .done(function(data){
                            if (data[0])
                            {
                                for (let i = 0; i < data.length; i++)
                                {
                                    h = "<li>\
                                            <a class='tag-item' href='javascript:t("+data[i].id+");'>"+
                                                data[i].tag+
                                            "</a>\
                                        </li>";
                                    $("#tags_list").append(h);
                                }
                            } 
                        })
                    </script>

                    <!-- タグID送信  -->
                    <script type="text/javascript">
                        function t(id){
                            $("#tag_id").val(id);
                            tag_threads.submit();
                            return false;
                        }
                    </script>
                </div>
            </div>
        </div>

        <!-- スレッド作成モーダル  -->
        <div id="create_thread_modal">
            <a id="back_modal">✕</a>
            <div class="create-thread">
                <h2>スレッドを作成する</h2>
                <form class="create-thread-form" name="create_thread" method="POST" action="./threads/CreateThreads/CreateThreadsBK.php">
                    <!-- スレッドタイトル  -->
                    <p>スレッドタイトル<span>必須</span>:</p>
                    <input class="thread-input" id="title" name="title_name" type="text" maxlength="30" placeholder="スレッドタイトル">
                    <span id="titlelmt" style="color:#666">30</span>
                    <span id="titleerr"></span>

                    <!-- ジャンル  -->
                    <p>ジャンル<span>必須</span>:</p>
                    <select class="thread-input" id="genre" name="genre_id" action="/">
                        <option value="0">(未選択)</option>
                        <option value="1">OS</option>
                        <option value="2">プログラミング</option>
                        <option value="3">アプリ開発</option>
                        <option value="4">データベース</option>
                        <option value="5">ネットワーク技術</option>
                        <option value="6">セキュリティ</option>
                        <option value="7">AI・機械学習</option>
                        <option value="8">IoT技術</option>
                        <option value="9">PC</option>
                        <option value="10">モバイル端末</option>
                        <option value="11">雑談・その他</option>
                    </select>
                    <span id="genreerr"></span>

                    <!-- タグ  -->
                    <p>タグ<span>必須</span>:</p>
                    <input class="thread-input" id="tags" name="tags_name" type="text" placeholder="タグ"><span style="color:#666">(スペース区切り, 最大3つまで)</span>
                    <span id="tagserr"></span>

                    <!-- 作成者  -->
                    <p>作成者 :</p>
                    <input class="thread-input" id="author" name="author_name" type="text" placeholder="" maxlength="15" value="その辺のエンジニア">
                    <span id="actlmt" style="color:#666">6</span>
                    

                    <!-- 説明  -->
                    <p>説明 :</p>
                    <textarea class="thread-input-area" id="exp" name="exp_txt" type="text"  maxlength="100" placeholder="説明"></textarea>
                    <span id="explmt" style="color:#666">100</span><br>

                    <!-- 規約同意承諾  -->
                    <input class="agree-chb" type="checkbox" id="agree" value="ok">
                    <p class="agree">私は<a href="">利用規約</a>に同意します。</p>
                    <span id="agreeerr"></span>

                    <a id="thread_submit">作成</a>
                </form>

                <!-- 入力チェック  -->
                <script type="text/javascript">
                    $('#thread_submit').on('click',function()
                    {
                        // タグの個数
                        var tags_t = $('input[id="tags"]').val();
                        var tags = tags_t.split(" ");
                        var tag_len = tags.length;

                        // submit
                        if ($('input[id="title"]').val() != "" && $('select[id="genre"]').val() != "0"
                                && $('input[id="tags"]').val() != "" && $('input[id="agree"]').prop('checked'))
                        {
                            if (tag_len <= 3)
                            {
                                create_thread.submit();
                                return false;
                            }
                        }

                        // タイトル
                        if ($('input[id="title"]').val() == "")
                        {
                            $("#titleerr").text("タイトルを入力してください。");
                        } else {
                            $("#titleerr").text("");
                        }

                        // ジャンル
                        if ($('select[id="genre"]').val() == "0")
                        {
                            $("#genreerr").text("ジャンルを選択してください。");
                        } else {
                            $("#genreerr").text("");
                        }

                        // タグ
                        if ($('input[id="tags"]').val() == "")
                        {
                            $("#tagserr").text("最低１つ、タグを入力してください。");
                        } else {
                            if (tag_len <= 3)
                            {
                                $("#tagserr").text("");
                            } else {
                                $("#tagserr").text("指定できるタグ数は最大3つまでです。");
                            }
                        }

                        // 規約同意承諾
                        if ($('input[id="agree"]').prop('checked') == false)
                        {
                            $("#agreeerr").text("利用規約に同意してください。");
                        } else {
                            $("#agreeerr").text("");
                        }
                    });
                </script>

                <!-- 文字数制限表示  -->
                <script type="text/javascript">
                    $(function ()
                    {
                        // タイトル
                        $('input[id="title"]').keyup(function()
                        {
                            var length = $(this).val().length;
                            var txtcount = 30 - length;

                            $("#titlelmt").text(txtcount);
                            if(txtcount <= 5)
                            {
                                $("#titlelmt").css("color","#ff0000");
                            } else {
                                $("#titlelmt").css("color","#666");
                            }
                        });

                        // 作成者
                        $('input[id="author"]').keyup(function()
                        {
                            var length = $(this).val().length;
                            var txtcount = 15 - length;

                            $("#actlmt").text(txtcount);
                            if(txtcount <= 5)
                            {
                                $("#actlmt").css("color","#ff0000");
                            } else {
                                $("#actlmt").css("color","#666");
                            }
                        });

                        // 説明文
                        $('textarea[id="exp"]').keyup(function()
                        {
                            var length = $(this).val().length;
                            var txtcount = 100 - length;

                            $("#explmt").text(txtcount);
                            if(txtcount <= 5)
                            {
                                $("#explmt").css("color","#ff0000");
                            } else {
                                $("#explmt").css("color","#666");
                            }
                        });
                    });                  
                </script>
            </div>
        </div>

        <!-- フッター  -->
        <div class="footer">
            <img class="footer-logo" src="./img/logo-big.png">

            <!-- ページ最上部へ  -->
            <a class="to-top" href="#top">ページ最上部へ</a>

            <div class="copyright">
                <span>Copyright © 2020 Club-Papillon All Rights Reserved.</span>
            </div>
        </div>

        <!-- 共通部 EN  -->

    </body>
</html>
