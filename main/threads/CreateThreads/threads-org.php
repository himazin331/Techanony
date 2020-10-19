<!-- スレッドページ  -->

<html>
    <head>
        <meta charset="utf-8">
        <title>Techanony | エンジニア向け匿名掲示板</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <!-- ページ共通SS  -->
        <link rel="stylesheet" type="text/css" href="../share-style.css">
        <!-- スレッドページ用SS  -->
        <link rel="stylesheet" type="text/css" href="./CreateThreads/threads-style.css">
        <!-- SimpleMDE SS  -->
        <link rel="stylesheet" href="./MDE/simplemde.min.css">
        <!-- SimpleMDE  -->
        <script src="./MDE/simplemde.min.js"></script>
        <!-- Marked  -->
        <script src="./Post/marked/marked.js"></script>
    </head>
    
    <body>
        <!-- jQuery  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- モーダルウィンドウ  -->
        <script type="text/javascript" src="../modal.js"></script>

        <!-- ヘッダー  -->
        <div class="header">
            <!-- ロゴ  -->
            <div class="logo-div">
                <a class="logo-a" href="../index.php">
                    <img class="logo-img" src="../img/logo.png" alt="Techanony" width="150" height="60">
                </a>
            </div>

            <!-- 検索フォーム  -->
            <form class="search-form" name="search_threads" method="POST" action="../keyword-search/keyword-search.php">
                <input class="search-input" id="search_input" name="search_input" type="search" placeholder="キーワードを入力">
                <input class="search-submit" id="search_submit" type="image" value="検索" src="../img/searchbutton.png">
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
                        <a class="navi-link" href="../index.php">ホーム</a>
                    </li>
                    <!-- お問い合わせ  -->
                    <li class="navi-item">
                        <a class="navi-link" href="../contact/contact.php">お問い合わせ</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- コンテナー  -->
        <div class="container">
            <!-- メイン  -->
            <div class="main">
                <div class="content">
                    <!-- スレッド情報取得  -->
                    <script type="text/javascript">
                        // スレッドID取得
                        var url = location.href;
                        url = url.match(/thread-\d+/)[0];
                        var thread_id = url.match(/\d+/)[0];

                        // スレッド情報取得
                        $.ajax({
                            type: "POST",
                            url: "./CreateThreads/GetThreadsBK.php",
                            data: {
                                'thread_id': thread_id,
                            }
                        })
                        .done(function(data){ // 通信成功
                            // スレッドタイトル書き換え
                            $("#thread_title").text(data.title);
                            // 作成者書き換え
                            $("#author").text("作成者: "+data.author);
                            // 作成日時書き換え
                            $("#created_at").text("作成日時: "+data.created_at);
                            // ジャンル書き換え
                            $("#genret").text("ジャンル: "+data.genre);
                            // タグ
                            $("#tags").text("タグ: "+data.tags);
                            // スレッド説明
                            $("#exp").text(data.exp);
                        })
                    </script>

                    <!-- スレッド情報  -->
                    <div>
                        <h1 id="thread_title"></h1>
                        <h3 class="author" id="author"></h3>
                        <h3 class="created_at" id="created_at"></h3>
                        <h3 class="genre" id="genret"></h3>
                        <h3 class="tags" id="tags"></h3>
                        <h2>説明:</h2>
                        <p class="exp" id="exp"></p>
                    </div>

                    <a href="#bottom">ページ最下部へ</a>

                    <!-- ポスト情報取得  -->
                    <script type="text/javascript">
                        $.ajax({
                            type: "POST",
                            url: "./Post/GetPostBK.php",
                            data: {
                                'thread_id': thread_id,
                            }
                        })
                        .done(function(data){
                            if (data[0])
                            {
                                for(let i = 0; i < data.length; i++)
                                {
                                    var sentence = marked(data[i].text);
                                    $("#posts_div").append("\
                                                        <div class='post'>\
                                                            <div class='post-author-div'>\
                                                                <h4 class='post-author'> 投稿者: "+data[i].name+"　ID: "+data[i].id+
                                                                    "　投稿時間: "+data[i].created_at+"</h4>\
                                                            </div>\
                                                            <div class='post-sentence-div'>"+sentence+"</div>\
                                                        </div>\
                                                        ");
                                }

                                // ポスト数が1000に達していたら投稿フォーム非表示
                                if (data.length == 1001)
                                {
                                    $("#send_post_form").css("display","none");
                                    $("#send_post").append("<h3>ポスト数が1,000を達したため投稿できません。</h3");
                                }
                            } else {
                                $("#posts_div").append("<div class='post'>ポストはまだありません。</div>");
                            }
                        })
                    </script>

                    <!-- ポスト情報  -->
                    <div class="posts-div" id="posts_div"></div>

                    <!-- ポスト投稿フォーム  -->
                    <div class="send-post" id="send_post">
                        <form class="send-post-form" id="send_post_form">
                            <!-- 投稿者名入力フォーム  -->
                            <p class="form-text">投稿者 :</p>
                            <input class="post-input" id="post_author" type="text" placeholder="" maxlength="15" value="その辺のエンジニア">
                            <!-- 投稿内容  -->
                            <p class="form-text">投稿内容 :</p>
                            <textarea class="post-input-area" id="post_sentence" type="text" placeholder="マークダウンで入力"></textarea>
                            
                            <input class="send-post-btn" id="send_post_btn" type="button" value="送信">
                            <span class="posterr" id="posterr"></span>
                        </form>

                        <!-- 投稿内容入力フォーム  -->
                        <script>
                            var simplemde = new SimpleMDE({ element: $("post_sentence")[0],
                                                            toolbar: ["bold", "italic", "strikethrough", "heading-1", "|", "code", "quote",
                                                                        "unordered-list", "ordered-list", "|", "link", "image", "table", "|",
                                                                        "preview", "|", "guide"],
                                                            forceSync: true,
                                                            spellChecker: false
                            });
                        </script>

                        <!-- ポスト投稿  -->
                        <script type="text/javascript">
                            $('#send_post_btn').on('click',function(){
                                if ($("#post_sentence").val() != "")
                                {
                                    var post_author = $("#post_author").val();
                                    var post_sentence = $("#post_sentence").val();
                                    $.ajax({
                                        type: "POST",
                                        url: "./Post/CreatePostBK.php",
                                        data: {
                                            "thread_id": thread_id,
                                            "post_author": post_author,
                                            "post_sentence": post_sentence,
                                        }
                                    })
                                    .done(function(data){
                                        
                                        $("body").append("<div id='send_post_done_or'></div>")
                                        $("#send_post_done_or, #send_post_done").fadeIn(800).delay(1000).fadeOut(800);
                                        setTimeout(function(){location.reload();}, 3100);
                                    })
                                } else {
                                    $('#posterr').text("内容を入力してください。");
                                }
                            });
                        </script>
                    </div>

                    <!-- ポスト投稿完了モーダル  -->
                    <div id="send_post_done">
                        <div class="send-success">
                            <h1>投稿が完了しました！！</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- サイドバー  -->
            <div class="sidebar">
                <div class="sidebar-items">
                    <!-- ジャンルリスト  -->
                    <h3 class="sidebar-item">ジャンル</h3>
                    <div class="genre-list">
                        <form name="genre_threads" method="POST" action="../threads-by-genre/threads-by-genre.php">
                            <input id="genre_id" name="genre_id" type="hidden">
                            <ul>
                                <li><a class="genre-item" href="javascript:g(1);">OS</a>
                                <li><a class="genre-item" href="javascript:g(2);">プログラミング</a>
                                <li><a class="genre-item" href="javascript:g(3);">アプリ開発</a>
                                <li><a class="genre-item" href="javascript:g(4);">データベース</a>
                                <li><a class="genre-item" href="javascript:g(5);">ネットワーク技術</a>
                                <li><a class="genre-item" href="javascript:g(6);">セキュリティ</a>
                                <li><a class="genre-item" href="javascript:g(7);">AI・機械学習</a>
                                <li><a class="genre-item" href="javascript:g(8);">IoT技術</a>
                                <li><a class="genre-item" href="javascript:g(9);">PC</a>
                                <li><a class="genre-item" href="javascript:g(10);">モバイル端末</a>
                                <li><a class="genre-item" href="javascript:g(11);">雑談・その他</a>
                            </ul>
                        </form>
                    </div>

                    <!-- ジャンルID submit  -->
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
                        <form name="tag_threads" method="POST" action="../threads-by-tags/threads-by-tags.php">
                            <input id="tag_id" name="tag_id" type="hidden">
                            <ul id="tags_list"></ul>
                        </form>
                    </div>

                    <!-- タグ取得  -->
                    <script type="text/javascript">
                        $.ajax({
                            type: "POST",
                            url: "../threads-by-tags/TagsListBK.php",
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
                <form class="create-thread-form" name="create_thread" method="POST" action="./CreateThreads/CreateThreadsBK.php">
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

        <a name="bottom"></a>

        <!-- フッター  -->
        <div class="footer">
            <img class="footer-logo" src="../img/logo-big.png">

            <!-- ページ最上部へ  -->
            <a class="to-top" href="#top">ページ最上部へ</a>

            <div class="copyright">
                <span>Copyright © 2020 Club-Papillon All Rights Reserved.</span>
            </div>
        </div>

    </body>
</html>
