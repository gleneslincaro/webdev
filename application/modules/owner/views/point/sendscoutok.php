<script type="text/javascript">
    $(document).ready(function() {
        $('#pointcomp').click(function() {
            var strURL = baseUrl + "owner/point/checkPenalty";
            $.ajax({
                url: strURL,
                type: 'POST',
                cache: false,
                success: function(string) {
                    var data = $.parseJSON(string);
                    if (data.count_penalty == 0){
                        window.location.replace(baseUrl + "owner/index");
                    } else {
                        window.location.replace(baseUrl + "owner/index/index03");
                    }
                },
                error: function() {
                }
            });

        });
    });

</script>
<!--
<div style="float:right"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt　
    <a href="<?php echo base_url(); ?>owner/settlement/index" target="_blank">▼ポイント購入</a>
</div>
-->
TOP ＞ スカウト機能 ＞ スカウトメッセージ ＞ スカウトメール送信完了
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■スカウトメール送信完了ページ</div>

    <br >

    <center>
        <p>
            <font size="4">対象のユーザー様へ「スカウトメール」の送信が完了しました。</font>
        </p>

        <p>
            <font size="4">スカウトメールの履歴は、履歴一覧　→　スカウト履歴にて確認が可能になります。<br>
        </p>
        <br >
        <a id="pointcomp" href="#">TOPへ</a>
    </center>

</div><!-- list-box ここまで -->
