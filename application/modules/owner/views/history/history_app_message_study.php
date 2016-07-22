<div id="container">

    TOP ＞ 履歴一覧 ＞ 応募一覧 ＞ 検討メッセージ
<!--
    <div style="float:right"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">▼ポイント購入</a></div><br >
-->
    <div class="list-box"><!-- list-box ここから -->

        <div class="list-title">■検討メッセージ</div>

        <br >

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
            $id = 0;
            if (count($user_data) > 0) {

                $value = $user_data[0];
                $id = $value['id'];
                ?>
                <tr>
                    <td><a href="<?php echo base_url() . 'owner/profile/index/' . $value['id'] ?>" target="_blank"><?php echo $value['unique_id']; ?></a></td>
                    <td><?php echo $value['cityname']; ?></td>
                    <td><?php echo number_format($value['joyspe_happy_money']); ?></td>
                    <td>〜週<?php echo $value['hope_day_working']; ?></td>
                    <td><?php echo $value['hope_time_working_name1']; ?>〜<?php echo $value['hope_time_working_name2']; ?></td>
                    <td><?php echo date('Y/m/d H:i', strtotime($value['apply_date'])); ?></td>
                </tr>
                <?php
            }
            ?>
        </table>

            <div class="list-box"><!-- list-box ここから -->

                <div class="message_box">
                    <table class="message">
                        <tr>
                            <td>件名：<?php echo $title_mail; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $body; ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <center>
                    <br>
                    <input type="button" value="　送信　" onClick="res = confirm('送信にしますか？');
                            if (res == true) {
                                location.href = '<?php echo base_url() . 'owner/dialog/dialog_transmission/' . $id .'/1'?>'
                            }">
                    <br>
                </center>

            </div><!-- list-box ここまで -->


    </div><!-- container ここまで -->
