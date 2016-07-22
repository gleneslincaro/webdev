<script type="text/javascript">
$(document).ready(function() {
       $("#th4").addClass("visited");
    });
</script>
TOP ＞ テンプレート ＞ 承認不備
<!--
<div style="float:right"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">▼ポイント購入</a></div><br >
-->
<?php header('Content-Type: text/html; charset=utf-8'); ?>
<div class="list-box"><!-- list-box ここから -->
    <div class="list-menu">

        <a href="<?php echo base_url() . 'owner/message/message_approval' ?>"><font color="#000000">承認不備</font></a> ｜
        <a href="<?php echo base_url() . 'owner/history/history_app_message_temp' ?>" target="_blank">テンプレート確認</a>
    </div>

    <table class="list">
        <tr>
            <th>カテゴリ</th>
            <th>店舗名</th>
            <th>お知らせ</th>
            <th>作成日付</th>
            <th>不備内容</th>

            <?php
            if (count($ownerprofile_data) > 0) {
                foreach ($ownerprofile_data as $o) {
                    ?>
                <tr>
                    <td>プロフィール</td>
                    <td><?php echo $o['storename']; ?></td>
                    <td>店舗情報・プロフィール確認中または不備がありました。</td>
                    <td><?php echo date('Y/m/d H:i', strtotime($o['created_date'])); ?></td>
                    <td><a href="<?php echo ($recruitErr['recruit_status'] == 1) ? base_url() . 'owner/dialog/dialog_request/1' : base_url() . 'owner/message/message_approval_profile' ?>"><?php echo ($recruitErr['recruit_status'] == 1) ? '承認依頼中' : '不備あり'; ?></a></td>
                </tr>
            <?php
            }
        }
        ?>
    </table>
</div><!-- list-box ここまで -->
