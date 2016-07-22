<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/bonus_list.js?v=20150506"></script>
<section class="section section--bonus cf">
    <h3 class="h_ttl_1 title">ボーナス確認</h3>
    <div class="box_inner cf">
        <div class="bonus_total clearfix">
            <ul>
            <li>
                <p>
                    現在の報酬<br>
                    <?php
                        $bonus_money = isset($userSMBData0['bonus_money']) ? $userSMBData0['bonus_money']:0;
                        echo Helper::numberToMoney($bonus_money);
                    ?>
                </p>
            </li>
            <li>
                <form id="frmRequestBonus">
                    <input value=" 払い出し申請をする " class="btn ui_btn ui_btn--blue" type="button" onclick="requestBonus('ボーナス申請を行なってよいでしょうか？')">
                    <input type="hidden" id="bonus_money" name="bonus_money" value="<?php echo (isset($userSMBData0['bonus_money']))?$userSMBData0['bonus_money']:0; ?>">
                </form>
            </li>
            </ul>
        </div>
        
        <table>
            <tr>
                <th colspan="4">ボーナス報酬追加履歴(最新の一か月分)</th>
            </tr>
            <tr>
                <td> 追加日付</td>
                <td>追加金額(円)</td>
                <td>追加後の金額(円)</td>
                <td>備考</td>
            </tr>
            <?php foreach ($data_user_bonus as $key) : ?>
            <tr>
                <td><?php echo $key['created_date'] ?></td>
                <td><?php echo $key['bonus_money'] ?></td>
                <td><?php echo $key['new_bonus_money'] ?></td>
                <td><?php echo $key['bonus_title'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="text-center"><?php echo $pagination_links; ?></div>
     
    </div>
    <div class="mb_20 cf t_center">
        
        <div>
            <br >
            【ボーナス注意事項】<br >
            ボーナスの申請は、2,000円以上になります。また、申請後・翌営業日中に登録されたサイトのボーナスに反映されます。
            <br >
            ※各サイトのボーナス備考<br >
            例：ジョイスペボーナス　3,535円<br >
            <br >
            ※ジョイスペ営業日<br >
            月～金 11：00～19：00（祝日は除く）
        </div>
    </div>
</section>
<section class="section section--bonus cf">
    <h3 class="h_ttl_1 title">ボーナス申請履歴</h3>
    <div class="box_inner cf"> 
        <table>
            <tbody>
                <tr>
                    <th>ボーナス申請日</th>
                    <th>金額</th>
                </tr>
            </tbody>
            <tbody id="bonus_application_history">
              <?php foreach($userSMBData1 as $data) : ?>
                  <tr>
                      <td><?php echo (isset($data['bonus_requested_date']) && $data['bonus_requested_date'] != null && $data['bonus_requested_date'] != '')?$data['bonus_requested_date']:'-----'; ?></td>
                      <td><?php echo Helper::numberToMoney($data['bonus_money']); ?></td>
                  </tr>
              <?php endforeach ?>
            </tbody>
        </table>
        <?php if($limit < $total_smb) : ?>
            <div id="logout_text"><span onclick="more_bonus_application_history()" id="logout_text1">次へ</span></div>
            <input type="hidden" value="<?php echo $limit; ?>" name="bah_limit" id="bah_limit" />
        <?php endif ?>
        <div class="mt_35">
            <center>上記の日付は、ジョイスペでのボーナス申請日となります。実際に各サイトへ追加されるのは翌営業日となりますのでご注意ください。</center>
        </div>
    </div>
</section>



