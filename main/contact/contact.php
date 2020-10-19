<!-- お問い合わせページ  -->
<html>
    <head>
        <meta charset="utf-8">
        <title>Techanony | エンジニア向け匿名掲示板</title>
        <link rel="icon" type="image/x-icon" href="../favicon.ico">
        <!-- お問い合わせページ用SS  -->
        <link rel="stylesheet" type="text/css" href="./contact-style.css">
    </head>

    <body>
        <!-- 共通部 BG  -->

        <!-- jQuery  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- モーダルウィンドウjs  -->
        <script type="text/javascript" src="../modal.js"></script>

        <!-- トップ移動  -->
        <a name="top"></a>

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
                        <a class="navi-link" href="./contact.php">お問い合わせ</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 共通部 EN  -->

        <!-- コンテナー  -->
        <div class="container">
            <!-- メイン  -->
            <div class="main">
                <!-- お問い合わせフォーム  -->
                <div class="Form">
                    <h1>お問い合わせ</h1>
                    <form name="contact_us">
                        <!-- メールアドレス入力フォーム  -->
                        <div class="Form-Item">
                            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>メールアドレス</p>
                            <input class="Form-Item-Input" id="Form_Item_Input" name="mail_from" type="email" placeholder="例）example@gmail.com">
                        </div>
                        <span class="emailerr" id="emailerr"></span>

                        <!-- お問い合わせ内容入力フォーム  -->
                        <div class="Form-Item">
                            <p class="Form-Item-Label isMsg"><span class="Form-Item-Label-Required">必須</span>お問い合わせ内容</p>
                            <textarea class="Form-Item-Textarea" id="Form_Item_Textarea" name="mail_content"></textarea>
                        </div>
                        <span class="texterr" id="texterr"></span>

                        <input class="Form-Btn" id="Form_Btn" type="button" value="送信する">
                    </form>

                    <!-- 入力値チェック  -->
                    <script type="text/javascript">
                        $('#Form_Btn').on('click',function()
                        {
                            // メールアドレス正規表現
                            var reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
                            // 問題なければsubmit
                            if (reg.test($('input[id="Form_Item_Input"]').val()) &&
                                            $('textarea[id="Form_Item_Textarea"]').val() != "")
                            {
                                alert("時間的な都合によりメール関連の環境構築をしていないため送信できません。");
                            }

                            // メールアドレスが未入力または謝ったメールアドレス入力時
                            if (reg.test($('input[id="Form_Item_Input"]').val()) == false)
                            {
                                $("#emailerr").text("正しいメールアドレスを入力してください。");
                            } else {
                                $("#emailerr").text("");
                            }

                            // お問い合わせ内容が未入力時
                            if ($('textarea[id="Form_Item_Textarea"]').val() == "")
                            {
                                $("#texterr").text("お問い合わせ内容を入力してください。");
                            } else {
                                $("#texterr").text("");
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- 共通部 BG  -->

        <!-- スレッド作成モーダル  -->
        <div id="create_thread_modal">
            <a id="back_modal">✕</a>
            <div class="create-thread">
                <h2>スレッドを作成する</h2>
                <form class="create-thread-form" name="create_thread" method="POST" action="../threads/CreateThreads/CreateThreadsBK.php">
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
            <img class="footer-logo" src="../img/logo-big.png">

            <!-- ページ最上部へ  -->
            <a class="to-top" href="#top">ページ最上部へ</a>

            <div class="copyright">
                <span>Copyright © 2020 Club-Papillon All Rights Reserved.</span>
            </div>
        </div>

        <!-- 共通部 EN  -->

    </body>
</html>
