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

TOP ＞ ポイント購入 ＞ 決済完了
<div class="owner-box">
  <?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($owner_info['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a>
  <br >
</div>
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■ポイント決済完了ページ</div>

    <br >

    <center>
        <p>
            <font size="4">ポイントでの決済が完了しました。ご利用誠に有難う御座います。</font>
        </p>

        <p>
            <font size="4">現在のポイントは下記となります。引き続きjoyspeをよろしくお願い致します。<br>
            <br>
            現在のポイント　：　<?php echo number_format($total_point);?>pt</font>
        </p>
        <br >
        <a id="pointcomp" href="#">TOPへ</a>
    </center>

</div><!-- list-box ここまで -->
