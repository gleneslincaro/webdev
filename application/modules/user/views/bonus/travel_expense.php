<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/bonus_list.js?v=20150506"></script>
<section class="section section--bonus cf">
    <h3 class="h_ttl_1 title">面接交通費確認/体験入店保証確認</h3>
    <div class="box_inner cf bonus_list">  
        <table>
            <tbody>
                <tr>
                    <td>交通費申請金額/体験入店保証金額</td>
                    <td><?php
                            $bonus_money = isset($userSMBData0['bonus_money']) ? $userSMBData0['bonus_money']:0;
                            echo Helper::numberToMoney($bonus_money);
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mb_20 cf t_center">
        <form id="frmRequestBonus">
            <input value=" 払い出し申請をする " class="btn ui_btn ui_btn--blue" type="button" onclick="requestBonus('申請を行なってもよろしいでしょうか？')">
            <input type="hidden" id="bonus_money" name="bonus_money" value="<?php echo (isset($userSMBData0['bonus_money']))?$userSMBData0['bonus_money']:0; ?>">
        </form>
        <div class="t_center mt_10">                   
            【ボーナス注意事項】<br >
            ※口座を登録されていない方は
            <a href="<?php echo base_url(); ?>user/settings/" class="fc_068ED8">こちら</a>
            から<br>
            ※ジョイスペ営業日<br>
            月～金11:00～19:00(祝日は除く）
        </div>
    </div>
</section>
<section class="section section--bonus cf">
    <h3 class="h_ttl_1 title">交通費/体験入店保証申請履歴</h3>
    <div class="box_inner cf bonus_list">  
        <table class="sample_01">
            <tbody>
                <tr>
                    <th>交通費申請日/体験入店保証申請日</th>
                    <th>金額</th>
                </tr>
            </tbody>
            <tbody id="bonus_application_history">
                <?php foreach($userSMBData1 as $data) : ?>
                    <tr>
                        <td><?php echo (isset($data['bonus_requested_date']) && $data['bonus_requested_date'] != null && $data['bonus_requested_date'] != '')?$data['bonus_requested_date']:'-----'; ?></td>
                        <td><?php
                                echo Helper::numberToMoney($data['bonus_money']);
                            ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php if ($limit < $total_smb) : ?>
            <div id="logout_text"><span onclick="more_bonus_application_history()" id="logout_text1">次へ</span></div>
            <input type="hidden" value="<?php echo $limit; ?>" name="bah_limit" id="bah_limit" />
        <?php endif ?>
    </div>
</section>

