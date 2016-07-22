<section class="section section--mission cf">
    <h3 class="ttl_1 mb_20">ミッション確認</h3>
    <div class="campaign_current mb_20">
        <div class="step_up_campaign">
            <?php if (isset($stepUpNewCamp)): ?>
                <div class="step_up_campaign_inner">
                  <div class="step_up_top">
                    <ul>
                      <li class="campaign_title">超絶倍々キャンペーン実地中</li>
                      <li class="campaign_rest">残り：<span class="txt_green txt_big" id="remaining-time"></span></li>
                    </ul>
                  </div>

                  <div class="step_up_body">
                  <p class="txt_center">キャンペーン期間：<span class="txt_green txt_big">
                      <?php
                          if ($stepUpNewCamp['new_campaign_flag'] == 1) {
                              echo date("y/m/d", strtotime($stepUpNewCampProg['offcial_reg_date']))." ~ ".$stepUpNewCamp['campaign1_end_date'];
                          }
                          else {
                              echo date("y/m/d", strtotime($stepUpNewCamp['campaign2_start_date']))." ~ ".$stepUpNewCamp['campaign2_end_date2'];
                          }
                      ?>
                  </span></p>
                  <p>
                  <?php if ($remainingSteps > 0) { ?>
                  残り<span class="txt_big"><?php echo ($remainingSteps < 10)?'0'.$remainingSteps:'00'; ?>
                  </span>個のミッション達成で、<br />合計<span class="txt_red txt_big">
                      <?php echo number_format($subTotalPoint); ?>
                  </span>円をゲット！
                  <?php } ?>
                  <br/>ミッションの詳細は<a href="<?php echo base_url() . 'user/misc/stepUpDescription/' ;?>">こちら</a>
                  </p>
                  <div class="step_up_table">

                    <table width="100%" border="0">
                      <caption>ミッション01：スカウトメール受信</caption>
                      <tr>
                        <th scope="row">獲得PT</th>
                        <td><span class="txt_big"><?php echo number_format($scoutMailBonus); ?></span>PT</td>
                      </tr>
                      <tr>
                        <th scope="row">倍率</th>
                        <td><span class="txt_big"><?php echo $stepUpNewCamp['scout_bonus_mag_times']; ?></span>倍</td>
                      </tr>
                      <tr>
                        <th scope="row">達成度</th>
                        <td><span class="txt_big <?php echo ($stepUpNewCampProg['step1_fin_flag'] == 1)?' txt_red':''; ?>"><?php echo $campaignStatus[$stepUpNewCampProg['step1_fin_flag']]; ?></span></td>
                      </tr>
                    </table>

                    <table width="100%" border="0">
                      <caption>ミッション02：お問い合わせボーナス</caption>
                      <tr>
                        <th scope="row">獲得PT</th>
                        <td><span class="txt_big"><?php echo number_format($inquiryBonus); ?></span>PT</td>
                      </tr>
                      <tr>
                        <th scope="row">倍率</th>
                        <td><span class="txt_big"><?php echo $stepUpNewCamp['msg_bonus_mag_times']; ?></span>倍</td>
                      </tr>
                      <tr>
                        <th scope="row">達成度</th>
                        <td><span class="txt_big <?php echo ($stepUpNewCampProg['step2_fin_flag'] == 1)?' txt_red':''; ?>"><?php echo $campaignStatus[$stepUpNewCampProg['step2_fin_flag']]; ?></span></td>
                      </tr>
                    </table>

                    <table width="100%" border="0">
                      <caption>ミッション03：累計ログインボーナス</caption>
                      <tr>
                        <th scope="row">獲得PT</th>
                        <td><span class="txt_big"><?php echo number_format($loginBonus); ?></span>PT</td>
                      </tr>
                      <tr>
                        <th scope="row">倍率</th>
                        <td><span class="txt_big"><?php echo $stepUpNewCamp['login_bonus_mag_times']; ?></span>倍</td>
                      </tr>
                      <?php if ($stepUpNewCampProg['step3_fin_flag'] != 1) { ?>
                      <tr>
                        <th scope="row">現在のクリア日数</th>
                        <td><span class="txt_big"><?php echo $totalLoginBonusDays . "/" . MISSION_LOGIN_DAYS; ?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <th scope="row">達成度</th>
                        <td><span class="txt_big <?php echo ($stepUpNewCampProg['step3_fin_flag'] == 1)?' txt_red':''; ?>"><?php echo $campaignStatus[$stepUpNewCampProg['step3_fin_flag']]; ?></span></td>
                      </tr>
                    </table>

                    <table width="100%" border="0">
                      <caption>ミッション04：ページアクセスボーナス</caption>
                      <tr>
                        <th scope="row">獲得PT</th>
                        <td><span class="txt_big"><?php echo number_format($pageAccessBonus); ?></span>PT</td>
                      </tr>
                      <tr>
                        <th scope="row">倍率</th>
                        <td><span class="txt_big"><?php echo $stepUpNewCamp['page_access_bonus_mag_times']; ?></span>倍</td>
                      </tr>
                      <?php if ($stepUpNewCampProg['step4_fin_flag'] != 1) { ?>
                      <tr>
                        <th scope="row">現在のクリア日数</th>
                        <td><span class="txt_big"><?php echo $totalPageAccessDays . "/" . MISSION_ACCESS_PAGE_DAYS; ?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <th scope="row">達成度</th>
                        <td><span class="txt_big <?php echo ($stepUpNewCampProg['step4_fin_flag'] == 1)?' txt_red':''; ?>"><?php echo $campaignStatus[$stepUpNewCampProg['step4_fin_flag']]; ?></span></td>
                      </tr>
                    </table>

                    <table width="100%" border="0">
                      <caption>ミッション05：面接ボーナス</caption>
                      <tr>
                        <th scope="row">獲得PT</th>
                        <td><span class="txt_big"><?php echo number_format($interviewBonus); ?></span>PT</td>
                      </tr>
                      <tr>
                        <th scope="row">倍率</th>
                        <td><span class="txt_big"><?php echo $stepUpNewCamp['interview_bonus_mag_times']; ?></span>倍</td>
                      </tr>
                      <tr>
                        <th scope="row">達成度</th>
                        <td><span class="txt_big <?php echo ($stepUpNewCampProg['step5_fin_flag'] == 1)?' txt_red':''; ?>"><?php echo $campaignStatus[$stepUpNewCampProg['step5_fin_flag']]; ?></span></td>
                      </tr>
                    </table>
                    <p>合計：<span class="txt_red txt_big"><?php echo number_format($subTotalPoint); ?></span>円</p>
                    <?php if (isset($requestMagnificationBonus) && $requestMagnificationBonus): ?>
                        <p class="t_center">
                            総額 : <span class="txt_red txt_big"><?php echo number_format($grandTotalPoint); ?></span>円
                            <?php if ( $stepUpNewCampProg['request_money_flag'] == 0): ?>
                                <button class="p_5" onclick="requestMagnificationBonus()" id="request-magnification-bonus">倍率ボーナスを申請する</button>
                            <?php else: ?>
                                <button class="p_5" disabled>倍率ボーナス申請済み</button>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                  </div>

                  <div class="step_up_bottom">
                    <p>先着人数に達した場合は、予告なくキャンペーンが終了することがあります。<br />
                    <?php if($stepUpNewCamp['max_user_display_flg'] == 0) { ?>
                    残り人数 <span class="txt_big txt_size_18"><?php echo ($remainingSlot < 10)?"0".(string)$remainingSlot:$remainingSlot; ?></span>人</p>
                    <?php } ?>
                    <p class="txt_red">"複数の店舗へ面接へ行くことで、獲得したボーナスが店舗の数だけ倍になります。<br />例：合計10000円　×　面接３件　＝30000円"</p>
                  </div>
                  </div>

                </div>
            <?php else: ?>
                <div class="step_up_top">
                    <ul>
                        <li class="campaign_rest">現在ご利用いただけるキャンペーンはありません</li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<input type="hidden" id="time-left" name="time-left" value="<?php echo isset($remainingTime)?$remainingTime:''; ?>" />
<script type="text/javascript">
    var days_remaining = "<?php echo isset($remainingTime)?floor($remainingTime / 86400):0; ?>";
    var hours_remaining = "<?php echo isset($remainingTime)?floor(($remainingTime % 86400) / 3600):0; ?>";
    var mins_remaining = "<?php echo isset($remainingTime)?floor((($remainingTime % 86400) % 3600) / 60):0; ?>";
    var secs_remaining = "<?php echo isset($remainingTime)?floor((($remainingTime % 86400) % 3600) % 60):0; ?>";
    var base_url = "<?php echo base_url(); ?>";
    var suncp_id = "<?php echo $stepUpNewCampProg['id']; ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/mission.js?v=20150508"></script>
