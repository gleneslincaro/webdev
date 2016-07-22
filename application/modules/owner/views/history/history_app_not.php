<script type="text/javascript">
    $(document).ready(function() {
        $("#th3").addClass("visited");
    });
</script>

<div id="container">

    TOP ＞ 履歴一覧 ＞ 応募非表示一覧
<!--
    <div style="float:right"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">▼ポイント購入</a></div><br >
-->
    <div class="list-box"><!-- list-box ここから -->

        <div class="list-menu">
            <a href="<?php echo base_url() . 'owner/history/history_work' ?>">勤務確認一覧</a> ｜
            <a href="<?php echo base_url() . 'owner/history/history_app' ?>">応募一覧</a> ｜
            <a href="<?php echo base_url() . 'owner/history/history_adoption' ?>">採用者一覧</a> ｜
            <a href="<?php echo base_url() . 'owner/history/history_scout' ?>">スカウト履歴</a>
        </div>

        <table class="list">
            <tr>
                <th>ID</th>
                <th>希望地域</th>
                <th>年齢</th>
                <th>勤務日数</th>
                <th>勤務時間</th>
                <th>応募時間</th>
                <th>採用見送り</th>
                <th>応募一覧へ戻す</th>
            </tr>
            <form name="myForm">
                <?php foreach ($user_data as $value): ?>

                    <tr>
                        <td><a href="<?php echo base_url() . 'owner/profile/index/' . $value['id'] ?>" target="_blank"><?php echo $value['unique_id']; ?></a></td>
                        <td><?php echo $value['cityname']; ?></td>
                        <?php if($value['name1']!=0 && $value['name2']!=0)
                        {
                        ?>
                        <td><?php echo $value['name1']; ?>〜<?php echo $value['name2']; ?></td>
                        <?php
                        }
                        else
                        {
                            if($value['name1']!=0)
                            {
                        ?>
                        <td><?php echo $value['name1']; ?>〜</td>
                        <?php
                            }
                            else
                            {
                        ?>
                        <td>〜<?php echo $value['name2']; ?></td>
                        <?php
                            }
                        }
                        ?>
                        <td>〜週<?php echo $value['hope_day_working']; ?></td>
                        <td><?php echo $value['hope_time_working_name1']; ?>〜<?php echo $value['hope_time_working_name2']; ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($value['apply_date'])); ?></td>
                        <?php
                        if ($value['user_payment_status'] != 2) {
                            ?>
                            <td><a href="<?php echo base_url() . 'owner/history/history_app_message_farewell/' . $value['id'] ?>" target="_blank">送信</a></td>

                            <td><input type="button" value="　戻す　" onClick="res = confirm('戻しますか？');
                                            if (res == true) {
                                                location.href = '<?php echo base_url() . 'owner/dialog/dialog_return/' . $value['id'] ?>'
                                            }"></td>
                                <?php
                            } else {
                                ?>
                            <td><?php echo date('Y/m/d H:i', strtotime($value['deny_for_apply_date'])); ?></td>
                            <td>---</td>
                            <?php
                        }
                        ?>
                    </tr>
                <?php endforeach; ?>
            </form>

        </table>

        <div class="btn_box">
            <?php
            if ($totalpage > 1) {
                ?>
                <a href="<?php echo base_url() . 'owner/history/history_app_not' ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_back.png' ?>" alt="次へ"></a>
                <?php echo $paging; ?>
                <a href="<?php echo base_url() . 'owner/history/history_app_not/' . $totalpage; ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_next.png' ?>" alt="次へ"></a>
            <?php
            }
            ?>

        </div>


    </div><!-- list-box ここまで -->



</div><!-- container ここまで -->
