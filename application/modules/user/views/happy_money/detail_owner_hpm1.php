<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/jquery-ui.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-ui.js"></script>
<script type="text/javascript">
	var baseUrl = '<?php echo base_url(); ?>';
	var ors_id = '<?php echo $ors_id; ?>';
  var user_id = '<?php echo $user_id; ?>';
	var owner_id = '<?php echo $owner_id; ?>';
	var campaign_id = '<?php echo (isset($campaign_id))?$campaign_id:''; ?>';
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/send_message.js" ></script>
<script type="text/javascript">
   $(document).ready(function(){
    var count_scout_id= $("#count_scout_id").val();
    var status_scout_spam_id=$("#status_scout_spam_id").val();
    var hpm_stt_id=$("#hpm_stt_id").val();
    var datetime_hpmn_id=$("#datetime_hpmn_id").val();
    var hpm_day_inter_id=$("#hpm_day_inter_id").val();
   // alert("trang thai:"+hpm_stt_id+"ngay pv:"+hpm_day_inter_id+"hien tai:"+datetime_hpmn_id);

    if((hpm_stt_id==4 && hpm_day_inter_id > datetime_hpmn_id)||(hpm_stt_id!=7&&hpm_stt_id!=4)){
            $("#btntake_hpm1").hide();
            $("#btntake_hpm2").hide();
            $("#wait_for_apply_money").show();
    }

    if(count_scout_id<1||status_scout_spam_id==0){
        $("#deny_scout_id").show();
        $("#cancel_deny_scout_id").hide();
    }
    else
    {
      $("#deny_scout_id").hide();
      $("#cancel_deny_scout_id").show();
    }

    $("#contact_hp").click(function(){
      var href = $(this).attr("href");
      // count up HP click
      var do_statistics_url = baseUrl + "user/statistics/updateClick";
      $.ajax({
        type:'POST',
        url: do_statistics_url,
        data: {type: "HP"},
        success:function(ret_data){
            insertUserStatisticsLog(user_id, owner_id, ors_id, 5, href); 
        },
        error:function() {
            location.href = href; // redirect
        }
      });
   });
   $("#contact_tel").click(function(){
      //var href = $(this).attr("data-href");
      // count up HP click
      var do_statistics_url = baseUrl + "user/statistics/updateClick";
      $.ajax({
        type:'POST',
        url: do_statistics_url,
        data: {type: "TEL"},
        success:function(ret_data){
            insertUserStatisticsLog(user_id, owner_id, ors_id, 2, ''); 
        }
      });
      //location.href = href; // redirect
   });
   $("#contact_mail").click(function(){
      var href = $(this).attr("href");
      // count up HP click
      var do_statistics_url = baseUrl + "user/statistics/updateClick";
      $.ajax({
        type:'POST',
        url: do_statistics_url,
        data: {type: "MAIL"},
        success:function(ret_data){
            insertUserStatisticsLog(user_id, owner_id, ors_id, 1, href); 
        },
        error:function() {
            location.href = href; // redirect
        }
      });     
   });
   $("#contact_line").click(function(){
      // count up HP click
      var do_statistics_url = baseUrl + "user/statistics/updateClick";
      $.ajax({
        type:'POST',
        url: do_statistics_url,
        data: {type: "LINE"},
        success:function(ret_data){
            insertUserStatisticsLog(user_id, owner_id, ors_id, 3, '');    
        }
      });
   });
   $("#contact_kuchikomi").click(function(){
      var href = $(this).attr("href");
      var do_statistics_url = baseUrl + "user/statistics/updateClick";
      $.ajax({
        type:'POST',
        url: do_statistics_url,
        data: {type: "KUCHIKOMI"},
        success:function(ret_data){
            insertUserStatisticsLog(user_id, owner_id, ors_id, 6, href);
        },
        error:function() {
            location.href = href; // redirect
        }
      });
   });
  });

  function show(inputData) {
    var objID=document.getElementById( "layer_" + inputData );
    var buttonID=document.getElementById( "category_" + inputData );
    if(objID.className=='close') {
      objID.style.display='block';
      objID.className='open';
    }else{
      objID.style.display='none';
      objID.className='close';
    }
  }
</script>
<input type="hidden" value="<?php echo $count_scout?>" id="count_scout_id"/>
<input type="hidden" value="<?php echo $stt?>" id="status_scout_spam_id"/>
<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" id="datetime_hpmn_id"/>
    <?php
    foreach ($detail_owners as $data) {
        $user_hm = 0;
        $money_font_size = OIWAI_PAY_MONEY_FONTSIZE_LARGE;
        $yen_font_size = OIWAI_PAY_YEN_FONTSIZE_LARGE;
        $num_of_characters = strlen($data['user_happy_money']);
        if ( $num_of_characters > 6){
            $money_font_size = OIWAI_PAY_MONEY_FONTSIZE_SMALL;
            $yen_font_size = OIWAI_PAY_YEN_FONTSIZE_SMALL;
        }
        if ($data['user_happy_money'] ){
            $user_hm = number_format($data['user_happy_money']);
        }
        ?>
        <?php echo $this->load->view('user/template/send_message', array('user_from_site' => $user_from_site, 'storename' => $data['storename']), true); ?>
        <?php echo $this->load->view('user/template/special_phrase', array('user_from_site' => $user_from_site), true); ?>
        <div class="box">
            <div class="box_title">
                <input type ="hidden" value="<?php echo $data['ors_id']?>" id="hpm_ors_id">
                <input type ="hidden" value="<?php echo $status_hpm['user_payment_status']?>" id="hpm_stt_id">
                <input type ="hidden" value="<?php echo $status_hpm['day_inter']?>" id="hpm_day_inter_id">
                <?php echo $data['storename']; ?></div>
            <div class="box_in">
              <?php if($user_hm > 0 && 0 /* 2015/01/09 Stop using happy money scheme */): ?>
                <img src="<?php echo base_url().'public/user/image/oiwai.jpg'; ?>" />
                <div class="vertical_align_wrapper">
                    <div class="outer">
                        <div class="middle">
                            <div class="inner" style="font-size: <?=$money_font_size;?>px;">
                                <?=$user_hm;?><span style="font-size:<?=$yen_font_size;?>px;">円</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="happy_text">
                    <span style="color:black;"><?php echo OIWAI_PAY_TEXT_PRFEFIX; ?>
                    <span style="color:#ff2b00"><?php echo OIWAI_PAY_TEXT_MIDDLE."</span>".OIWAI_PAY_TEXT_SUFFIX; ?></span>
                </div>
              <?php endif ?>
              <div class="job_box">
                 <div class="photo_box_c">
                  <div id="wrapper">
                    <div class="slider-wrapper theme-default">
                        <div id="slider" class="nivoSlider " style="border: 1px solid #005702;">
                          <?php
                            $count=0;
                            for($i=1;$i<7;$i++){
                              if(!isset($data['image' . $i]) || $data['image' . $i] == "")
                                $count++;
                            }
                            if($count==6) { ?>
                              <img src="<?php echo base_url();?>public/owner/images/no_image_top.jpg" width="100%" />
                            <?php }
                            else{
                              for ($i = 1; $i < 7- $count; $i++) {
                                if(!isset($data['image' . $i]) || $data['image' . $i] == "") { ?>
                                  <img src="<?php echo base_url();?>public/owner/images/no_image_top.jpg" width="100%" />
                                  <?php
                                }
                                else { ?>
                                  <img src="<?php echo $imagePath.$data['image' . $i]; ?>" width="100%"/>
                               <?php
                                }
                            }}
                          ?>
                        </div>
                        <div id="htmlcaption" class="nivo-html-caption"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="kyubo">
                <h3 class="info">店舗からのメッセージ</h3>
                <div class="company_info" style="overflow: hidden">
                  <div class="show-more">
                    <p class="show-more-text" style="word-break: break-all;"><?php echo nl2br($data['company_info']);?></p>
                  </div>
                  <div id="read-more" style="left: 50%; padding: 8px 0; position: absolute; margin-left: -37px;"></div>
                </div>
              </div>
                <?php if( isset($travel_expense) ) { ?>
                <div id="request_travel_expense_container">
                  <br style="clear:both">
                  <div class="kyubo">
                    <h3 class="info">ジョイスペ交通費保証</h3>
                		<p style="word-break: break-all;">ジョイスペから面接交通費
											<span style="color:red; font-weight:bold;"><?php echo $travel_expense; ?>円</span>を支給！</p>
                		<div id="campaign_btn_area">
                			<?php if ( isset($request_status) && $request_status == 0 ) { ?>
                			<button class="btn50 btn" style="cursor: pointer;" id="request_travel_expense">交通費申請</button>
                			<?php } elseif ( isset($request_status) && $request_status == 3 ) { ?>
                			<button class="btn50 btn" disabled>交通費済み</button>
                			<?php } else { ?>
                			<button class="btn50 btn" disabled>受付終了</button>
                			<?php } ?>
                		</div>
                		<p style="word-break: break-all;">※面接が終わったらボタンを押してください。</p>
                	</div>
                </div>
                <?php } ?>
              <br style="clear:both">
              <div class="kyujin">
                <h3 class="info">求人情報</h3>
                <dl>
                  <dt>店名</dt>
                  <dd><?php echo $data['storename']; ?></dd>
                  <dd>
                  　<div class="btn50"><a href="javascript:void(0)" data-href="<?php echo $data['home_page_url']; ?>" class="btn" id="contact_hp">オフィシャルHP</a></div>
                  <?php if ( $data['kuchikomi_url'] ){ ?>
                    <div class="btn50" style="margin-top:5px">
                      <a href="<?php echo $data['kuchikomi_url']; ?>/" class="btn" id="contact_kuchikomi">クチコミをみる</a>
                    </div>
                  <?php } ?>
                　　</dd>
                  <dt>地域</dt>
                  <?php if($data['group_name']) : ?>
                    <dd><?php echo $data['group_name'].' / '.$data['city_name'].' / '.$data['town_name']; ?></dd>
                  <?php endif ?>
                  <dt>応募用連絡先</dt>
                  <?php if($data['apply_time']) : ?><dd><span>受付時間 / <?php echo $data['apply_time']; ?></span></dd><?php endif ?>
                  <dd><font color="red">「ジョイスペを見た」</font>というとスムーズです。</dd>
                  <dd class="bk_btn_blue">
                  <?php if($data['apply_tel']) : ?><a class="btn" href="javascript:void(0)" data-href="tel:<?php echo $data['apply_tel']; ?>" id="contact_tel">
                  <em class="btn_telephone"><?php echo $data['apply_tel']; ?></em></a><br/><?php endif ?>
                  <?php if($data['apply_emailaddress']) : ?><a class="btn" href="<?php
                    $mail_txt = "mailto:".$data['apply_emailaddress']."?subject=".MAIL_TITLE;
                    if ( isset($user_unique_id) && $user_unique_id ){
                      $mail_txt .= "&amp;body=ID:".$user_unique_id.MAIL_HEAD_SUFFIX;
                    }else{
                      $mail_txt .= "&amp;body=本文";
                    }
                    echo $mail_txt;
                  ?>" id="contact_mail">
                  <em class="btn_mailaddress"><?php echo $data['apply_emailaddress']; ?></em></a><br /><?php endif ?>
                  <?php if($data['line_id']) : ?><a class="btn line">
                  <em class="btn_line">ID:<input id="contact_line" type="text" value="<?php echo $data['line_id']; ?>" onfocus="this.selectionStart=0; this.selectionEnd=this.value.length;" onmouseup="return false"></em>
                </a><?php endif ?>
                </dd>
	            <dd class="bk_btn_blue mt30">
	            	<a href="javascript:void(0)" class="btn mb07" id="anonymous_ask">匿名質問</a>
					※直アドじゃないから匿名性が保たれるよ
                <?php echo $this->load->view('user/template/special_phrase', array('user_from_site' => $user_from_site), true); ?>
				</dd>
                  <dt>業種</dt>
                  <dd>
                    <?php
                      $tam=count($data['jobtypename']);
                      //echo $tam;
                      $i=0;
                       foreach ($data['jobtypename'] as $j) {
                        echo $j['name'] ;
                        $i++;
                        if($i<$tam)
                          echo"、";
                      }
                    ?>
                  </dd>
                  <dt>応募資格</dt>
                  <dd><?php echo nl2br($data['con_to_apply']); ?></dd>
                  <dt>給与</dt>
                  <dd><?php echo nl2br($data['salary']); ?></dd>
                  <dt>勤務地</dt>
                  <dd><?php echo $data['work_place']; ?></dd>
                  <dt>勤務日</dt>
                  <dd><?php echo $data['working_day']; ?></dd>
                  <dt>勤務時間</dt>
                  <dd><?php echo $data['working_time']; ?></dd>
                  <dt>待遇</dt>
                  <dd>
                    <div class="job_box_comp">
                      <?php
                        $br = 0;
                        foreach ($data['treatment'] as $t) {
                      ?>
                          <div class="job_treatment_box">
                            <div class="job_treatment">
                              <?php
                                $br++;
                                echo $t['name'];
                                if ($br == 3) {
                                  echo "<br/>";
                                }
                              ?>
                            </div>
                          </div>
                      <?php } ?>
                      <br style="clear:both">
                    </div>
                  </dd>
                  <dt>交通</dt>
                  <dd><?php echo nl2br($data['how_to_access']); ?></dd>
                </dl>
                <div class="job_menu" id="deny_scout_id">
                  <a href="<?php echo base_url()."user/denial/index/".$data['ors_id']?>/">
                    スカウトを拒否する
                  </a>
                </div>
                <div class="job_menu" id="cancel_deny_scout_id">
                  <a href="<?php echo base_url()."user/denial/not_denial/".$data['ors_id']?>/">
                    スカウトが拒否状態です
                  </a>
                </div>
              </div>
            </div>
        </div>
        <?php if($user_hm > 0 && 0 /* 2015/01/09 Stop using happy money scheme */): ?>
          <div class="box" style="margin-top:1rem;">
            <div class="oubo_btn">
                <div class="box_title"><a href="javascript:void(0)" onclick="show('【お祝い】');" class="shinsei_a">お祝い金申請はこちらから</a></div>
                <div id="layer_【お祝い】" style="display: none;position:relative;margin-left:15pt" class="close">
                      <br />
                      <div class="btn" id="btntake_hpm1">
                        <a class="btn50" href="<?php echo base_url()."user/celebration/celebration_app/".$data['ors_id']?>/">
                          お祝い金申請
                        </a>
                      </div>
                      <div id="wait_for_apply_money" style="display:none">
                        <p style="text-align:center;">
                        状態：面接完了報告済み
                        </p>
                        <p style="text-align:center;">
                        お祝い金の申請は面接完了報告から<br />
                        48時間後に行うことが出来ます。<br />
                        また、お店から勤務確認の連絡を受けることで<br />
                        お支払い手続きをさせて頂きます。
                        </p>
                      </div>
                      <br />
                </div>
            </div>
        </div>
        <?php endif ?>

  <?php } ?>
