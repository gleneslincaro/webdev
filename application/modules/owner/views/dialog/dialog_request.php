

<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■承認依頼</div>

    <br ><br ><br >



    <div class="message_box">
        <table class="message">
            <tr>

            店舗情報・プロフィールの承認依頼が完了しました。<br>
            joyspeサポートセンターで確認したのちにご連絡をさせて頂きます。<br>
            完了・不備のご連絡は「登録アドレス」宛に送信させて頂きますので、今しばらくお待ち下さいませ。<br><br>

            ※店舗情報・プロフィールの承認作業には1～2営業日頂いております。<br>
            </tr>
        </table>
    </div>

    <br><br>
    <?php
    if($flag==1)
    {
    ?>
    <center><a href="<?php echo base_url().'owner/index' ?>">TOPへ戻る</a></center>
<?php
    }
 else {
        ?>
    <center><a href="<?php echo base_url().'owner/index' ?>">TOPへ戻る</a></center>
    <?php
 }
    ?>
</div><!-- list-box ここまで -->


