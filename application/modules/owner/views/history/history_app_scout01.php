<!--
<div style="float:right"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt　
    <a href="<?php echo base_url(); ?>owner/settlement/index" target="_blank">▼ポイント購入</a>
</div>
-->
TOP ＞ スカウト機能 ＞ スカウトメッセージ
<div class="list-box"><!-- list-box ここから -->
    <form action="<?php echo base_url(); ?>owner/scout/scout_settlement" method="post"  >
        <div class="list-title">■スカウトメッセージ</div><br >

        ※スカウトメッセージは、1通（1名）に対して<?php echo number_format($scout_money); ?>円（<?php echo number_format($scout_point); ?>pt）となります。　※pt表記は予めポイントを購入（銀行決済）された場合の表記となります。<br>
        <br>

        <table class="list">
            <tr>
                <th>ID</th><th>希望地域</th><th>年齢</th><th>勤務日数</th>
            </tr>

            <tr>
                <input type="hidden" name="array_user_id[]" value="<?php echo $user_profile['uid'] ?>"/>
                <td><a  href="<?php echo base_url(); ?>owner/profile/index/<?php echo $user_profile['uid'] ?>" target="_blank"><?php echo $user_profile['unique_id']; ?></a></td>
                <td><?php echo $user_profile['city_name']; ?></td>
                <td><?php echo $user_profile['age_name1']; ?>〜<?php echo $user_profile['age_name2'] != 0?$user_profile['age_name2']:''; ?></td>
                <td>〜週<?php echo $user_profile['day_name2']; ?></td>
            </tr>

        </table>

        <br >

        <div class="list-t-center"><input type="submit" name="" value="送信・決済へ進む" style="width:150px; height:40px;"></button></div>

        <div class="list-t-center">
            <br >

            ※送信されるスカウトメッセージ内容は、下記のものとなります。

            <br >

            <div class="message_box">
                <table class="message" style="text-align: left">
                    <tr>
                        <th></th>
                    </tr>

                    <tr>
                        <td>件名：<?php echo $title_mail; ?></td>
                    </tr>
                    <tr>

                        <td>

                            <?php echo $content; ?>

                        </td>
                    </tr>
                </table>
            </div>
            <br >

            <div class="list-t-center">
                <input type="submit" name="" value="送信・決済へ進む" style="width:150px; height:40px;"></button>
            </div>
        </div>
    </form>
<!--</div> list-box ここまで -->
