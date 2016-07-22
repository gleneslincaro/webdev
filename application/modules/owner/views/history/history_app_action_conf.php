TOP ＞ 履歴一覧 ＞ 応募一覧 ＞ 店舗情報　送信
<?php $o = $owner_data; ?>
<!--
<div style="float:right"><?php echo $o['storename']; ?>　様　ポイント：<?php echo number_format($o['total_point']); ?>pt　<a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">▼ポイント購入</a></div><br >
-->
<div class="list-box">
    <div class="list-title">■店舗情報　送信</div><br>
    <form action="<?php echo base_url() . 'owner/history/history_app_action_conf_message' ?>" onsubmit="return confirm('送信しますか？')" method = "post">
        <table class="list">
            <tr>
                <th>ID</th>
                <th>希望地域</th>
                <th>採用金額（円）</th>
                <th>勤務日数</th>
                <th>勤務時間</th>
                <th>応募時間</th>
            </tr>
            <?php
            foreach ($information as $arr) {
                ?>
                <tr>
                    <td><a target="_blank" href="<?php echo base_url() . 'owner/profile/index/' . $arr['usid']; ?>"><?php echo $arr['id']; ?></a></td>
                    <td><?php echo $arr['mst_cities_name']; ?></td>
                    <td><?php echo number_format($arr['mst_happy_moneys_joyspe']); ?></td>
                    <td>〜週<?php echo $arr['mst_hope_day_working_nam2']; ?></td>
                    <td><?php echo $arr['mst_hope_time_working_name1']; ?>〜<?php echo $arr['mst_hope_time_working_name2']; ?></td>
                    <td>
                        <?php echo date('Y/m/d H:i', strtotime($arr['user_payments_apply_date'])); ?></td>
                </tr>
            <?php } ?>
            <?php foreach ($arrUserId as $usId) { ?>
                <input type="hidden" name="arrUserId[]" value="<?php echo $usId; ?>" />
            <?php } ?>
        </table>
        <div class="list-t-center">
            <br><br>
            <?php echo count($information); ?>名の方へ、店舗情報を送信しますか？
            <br><br>
            <?php if ((count($information) >= 0)) { ?>
                <input type="submit" value="店舗情報　送信"/>
            <?php } ?>
            <br><br>
            ※店舗公開メッセージ内容　店舗情報のメッセージは編集は行えません。ご了承下さいませ。
            <br><br>
            <a href = "<?php echo base_url() . 'owner/index' ?>" title="前のページへ戻る">
                前のページへ戻る
            </a>
            <br><br>
        </div>
    </form>
    <?php if (count($information) > 0) { ?>
        <div class="message_box">
            <table class="message">
                <tr>
                    <td>件名：<?php echo $titlemail; ?></td>
                </tr>
                <tr>
                    <td><?php echo $body; ?></td>
                </tr>
            </table>
        </div>
    <?php } ?>
