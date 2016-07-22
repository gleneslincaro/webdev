<div id="container">

    TOP ＞ 履歴一覧 ＞ 応募非表示一覧 ＞ 採用見送りメッセージ<br>

    <div class="list-box"><!-- list-box ここから -->

        <div class="list-title">■採用見送りメッセージ</div>

        <br >

        <table class="list">
            <tr>
                <th>ID</th>
                <th>希望地域</th>
                <th>年齢</th>
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
                                    location.href = '<?php echo base_url() . 'owner/dialog/dialog_transmission/' . $id . '/0'?>'
                                }">
                    <br>
                </center>

            </div><!-- list-box ここまで -->


    </div><!-- container ここまで -->