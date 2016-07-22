<?php $this->load->view('user/pc/header/header'); ?>
<section class="section--main_content_area">
    <section class="section--bonus_history">
        <div class="container cf">
            <div class="box_white m_b_30">
                <h2 class="ttl_style_1">獲得金額確認</h2>
                <div class="bonus_list">
                    <table>
                        <tr>
                            <th class="bonus record">現在の保有金額</th>
                            <td class="bonus">
                                <?php
                                    $bonus_money = isset($userSMBData0['bonus_money']) ? $userSMBData0['bonus_money']:0;
                                    echo Helper::numberToMoney($bonus_money);
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="btn_wrap m_t_20 m_b_20">
                    <form id="frmRequestBonus">
                        <button class="ui_btn ui_btn--large ui_btn--bg_magenta" type="button" id="submit_paying_out">払い出し申請をする</button>
                        <input type="hidden" id="bonus_money" name="bonus_money" value="<?php echo (isset($userSMBData0['bonus_money']))?$userSMBData0['bonus_money']:0; ?>">
                    </form>
                </div>
                <div class="point">
                    <h3>【ボーナス注意事項】</h3>
                    <p> ※口座を登録されていない方は <a href="#">こちら</a> から<br>
                        ※ジョイスペ営業日<br>
                        月～金11:00～19:00（祝日は除く）</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section--bonus_list">
        <div class="container cf">
            <div class="box_white">
                <h2 class="ttl_style_1">振込み申請履歴</h2>
                <div class="bonus_list">
                    <table id="bonus_application_history" class="bonus_record">
                        <tr>
                            <th class="bonus record t_center">振込み申請日</th>
                            <td class="bonus t_center">金額</td>
                        </tr>
                        <?php foreach($userSMBData1 as $data) : ?>
                        <tr>
                            <th class="bonus record">
                                <?php echo (isset($data['bonus_requested_date']) && $data['bonus_requested_date'] != null && $data['bonus_requested_date'] != '')?$data['bonus_requested_date']:'-----'; ?>
                            </th>
                            <td class="bonus">
                                <?php echo Helper::numberToMoney($data['bonus_money']); ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </table>
                    <?php if ($limit < $total_smb) : ?>
                        <span onclick="more_bonus_application_history()" id="logout_text1">次へ</span>
                        <input type="hidden" value="<?php echo $limit; ?>" name="bah_limit" id="bah_limit" />
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
</section>