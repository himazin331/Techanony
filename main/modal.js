// スレッド作成モーダル動作js

$(function(){
    // スレッド作成ボタン クリック
    $("#open_thread_modal").click(function(){
        // オーバーレイ 作成
        $("body").append('<div id="create_thread_or"></div>');

        // オーバーレイ・スレッド作成モーダル 表示
        $("#create_thread_or, #create_thread_modal").fadeIn("slow");

        // オーバーレイクリック -> スレッド作成モーダル 閉じる
        $("#create_thread_or, #back_modal").click(function(){
            $("#create_thread_modal, #create_thread_or").fadeOut("slow",function(){
                // create_thread_or 削除
                $('#create_thread_or').remove();

                // タイトルリセット
                $('input[id="title"]').val("");
                $("#titlelmt").text(30);
                $("#titlelmt").css("color", "#000");
                $("#titleerr").text("");

                // ジャンル・タグリセット
                $('#genre').val("0");
                $("#genreerr").text("");
                $('input[id="tags"]').val("");
                $("#tagserr").text("");

                // 作成者リセット
                $('input[id="author"]').val("その辺のエンジニア");
                $("#actlmt").text(6);
                $("#actlmt").css("color", "#666");

                // 説明文リセット
                $('textarea[id="exp"]').val("");
                $("#explmt").text(100);
                $("#explmt").css("color", "#666");

                // 承諾リセット
                $("#agree").prop("checked", false);
                $("#agreeerr").text("");
            });
        });
    });
});