<?php if (isset($stepUpNewCamp)): ?>

<div class="step_up_campaign">
	<?php if (isset($requestMagnificationBonus) && $requestMagnificationBonus): ?>
	
	
	
	
	<!-- キャンペーン ミッション達成  campaign mission accomplished -->
	<div class="mission_wrap">
		<div class="campaign_title">
			<h2>ミッション達成<br />
				おめでとうございます！</h2>
			<p>残り：<span class="red remaining-time"></span></p>
		</div>
		<?php if ($oneMoreInterViewFlag == true) { ?>
		<div class="box_wrap">
			<div class="left_box">
				<p>今ならもう<span>1</span>店舗面接に行くと、<br />
					合計<span class="red"><?php echo number_format($oneMoreInterviePoint) ?></span>円をゲット！</p>
			</div>
			<div class="right_box red">※面接した店舗の数に応じて倍になっていきます。</div>
		</div>
		<?php } else { // finish all interviews ?>
		<div class="box_wrap">
			<div class="left_box">
				<p>ミッション確認メニューより、<br />
					ボーナス申請をしてください！<br />
					合計<span class="red"><?php echo number_format($totalPoint) ?></span>円</p>
			</div>
			<div class="right_box">
				<p><a href="<?php echo base_url() . "user/mission/index"; ?>">ボーナス申請へ</a></p>
			</div>
			<ul class="step_up_note">
				<li class="red pt_10">※全てのミッションを達成した時点で必ず申請を行ってください。申請が無い場合はミッションで獲得したボーナスは無効となります。</li>
				<li class="red pt_5">※ミッション５はミッション期日内に店舗から承認をもらう必要があります。期間外に承認となった場合はキャンペーンの適用外となります。</li>
				<li class="red pt_5">ミッション発動中は15000円の交通費は適用外となります。15000円の交通費をご希望の場合は新たにアカウントを取得されることをお勧めします。</li>
			</ul>
		</div>
		<?php }?>
	</div>
	<!-- キャンペーン ミッション達成 -->
	

	<?php elseif (isset($planDate2) && $planDate2): ?>
	
	
	<!-- キャンペーン 期間延長 Campaign Period extension -->
	<div class="mission_wrap">
		<div class="campaign_title">
			<h2>超絶倍々キャンペーン実地中<br />
				<span><?php echo $stepUpNewCamp['more_info'] ?></span></h2>
			<p>残り：<span class="red remaining-time"></span></p>
		</div>
		<div class="box_wrap">
			<div class="left_box">
				<p>残り<strong><?php echo ($remainingSteps < 10)?'0'.$remainingSteps:'00'; ?></strong> 個のミッション達成で、<br />
					合計 <span class="red"><?php echo number_format($totalPoint) ?></span>円をゲット！
					<?php if($stepUpNewCamp['max_user_display_flg'] == 0): ?>
					<br />
					残り人数<span><?php echo ($remainingSlot < 10)?"0".(string)$remainingSlot:$remainingSlot; ?> </span>人
					<?php endif; ?>
				</p>
			</div>
			<div class="right_box">
				<p><a href="<?php echo base_url() . "user/mission/index"; ?>">残りのミッションを確認する</a></p>
			</div>
			<ul class="step_up_note">
				<li class="red pt_10">※全てのミッションを達成した時点で必ず申請を行ってください。申請が無い場合はミッションで獲得したボーナスは無効となります。</li>
				<li class="red pt_5">※ミッション５はミッション期日内に店舗から承認をもらう必要があります。期間外に承認となった場合はキャンペーンの適用外となります。</li>
				<li class="red pt_5">ミッション発動中は15000円の交通費は適用外となります。15000円の交通費をご希望の場合は新たにアカウントを取得されることをお勧めします。</li>
			</ul>
		</div>
	</div>
	<!-- キャンペーン 期間延長 -->
	
	
	<?php elseif (isset($remainingSlot) && $remainingSlot < 20): ?>
	<!-- キャンペーン 残り20人以下  Remaining slots for campaign is less than 20 people -->
	<div class="mission_wrap">
		<div class="campaign_title">
			<h2>超絶倍々キャンペーン実地中<br />
				<span><?php echo $stepUpNewCamp['more_info'] ?></span></h2>
			<p>残り：<span class="red remaining-time"></span></p>
		</div>
		<div class="box_wrap">
			<div class="left_box">
				<p>残り<span><?php echo ($remainingSteps < 10)?'0'.$remainingSteps:'00'; ?></span>個のミッション達成で、 <br />
					合計<span class="red"><?php echo number_format($totalPoint) ?></span>円をゲット！
					<?php if($stepUpNewCamp['max_user_display_flg'] == 0): ?>
					<br />
					残り人数<span class="red"><?php echo ($remainingSlot < 10)?"0".(string)$remainingSlot:$remainingSlot; ?> </span>人
					<?php endif; ?>
				</p>
			</div>
			<div class="right_box">
				<p><a href="<?php echo base_url() . "user/mission/index"; ?>">残りのミッションを確認する</a></p>
			</div>
			<ul class="step_up_note">
				<li class="red pt_10">※全てのミッションを達成した時点で必ず申請を行ってください。申請が無い場合はミッションで獲得したボーナスは無効となります。</li>
				<li class="red pt_5">※ミッション５はミッション期日内に店舗から承認をもらう必要があります。期間外に承認となった場合はキャンペーンの適用外となります。</li>
				<li class="red pt_5">ミッション発動中は15000円の交通費は適用外となります。15000円の交通費をご希望の場合は新たにアカウントを取得されることをお勧めします。</li>
			</ul>
		</div>
	</div>
	<!-- キャンペーン 残り20人以下 -->
	
	
	<?php elseif(isset($remainingDays) && $remainingDays < 7): ?>
	
	
	<!-- キャンペーン 残り7日以内  remaining days for campaign is less than 7 days -->
	<div class="mission_wrap">
		<div class="campaign_title">
			<h2>超絶倍々キャンペーン実地中</h2>
			<p>残り：<span class="red remaining-time"></span></p>
		</div>
		<div class="box_wrap">
			<div class="left_box">
				<p>残り<strong><?php echo ($remainingSteps < 10)?'0'.$remainingSteps:'00'; ?></strong>個のミッション達成で、 <br />
					合計<span class="red"><?php echo number_format($totalPoint) ?></span>円をゲット！
					<?php if($stepUpNewCamp['max_user_display_flg'] == 0): ?>
					<br />
					残り人数<strong> <?php echo ($remainingSlot < 10)?"0".(string)$remainingSlot:$remainingSlot; ?> </strong>人
					<?php endif; ?>
				</p>
			</div>
			<div class="right_box">
				<p><a href="<?php echo base_url() . "user/mission/index"; ?>">残りのミッションを確認する</a></p>
			</div>
			<ul class="step_up_note">
				<li class="red pt_10">※全てのミッションを達成した時点で必ず申請を行ってください。申請が無い場合はミッションで獲得したボーナスは無効となります。</li>
				<li class="red pt_5">※ミッション５はミッション期日内に店舗から承認をもらう必要があります。期間外に承認となった場合はキャンペーンの適用外となります。</li>
				<li class="red pt_5">ミッション発動中は15000円の交通費は適用外となります。15000円の交通費をご希望の場合は新たにアカウントを取得されることをお勧めします。</li>
			</ul>
		</div>
	</div>
	<!-- キャンペーン 残り7日以内 -->
	
	
	<?php elseif(isset($canAvailStepUpCampaign) && $canAvailStepUpCampaign): ?>
	
	
	<!-- キャンペーン開催中 on-going campaign -->
	<div class="mission_wrap">
		<div class="campaign_title">
			<h2>超絶倍々キャンペーン実地中</h2>
			<p>残り：<span class="green remaining-time"></span></p>
		</div>
		<div class="box_wrap">
			<div class="left_box">
				<p>残り<span><?php echo ($remainingSteps < 10)?'0'.$remainingSteps:'00'; ?></span>個のミッション達成で、<br />
					合計<span class="red"><?php echo number_format($totalPoint) ?></span>円をゲット！
					<?php if($stepUpNewCamp['max_user_display_flg'] == 0): ?>
					<br />
					残り人数<span> <?php echo ($remainingSlot < 10)?"0".(string)$remainingSlot:$remainingSlot; ?> </span>人
					<?php endif; ?>
				</p>
			</div>
			<div class="right_box">
				<p><a href="<?php echo base_url() . "user/mission/index"; ?>">残りのミッションを確認する</a></p>
			</div>
			<ul class="step_up_note">
				<li class="red pt_10">※全てのミッションを達成した時点で必ず申請を行ってください。申請が無い場合はミッションで獲得したボーナスは無効となります。</li>
				<li class="red pt_5">※ミッション５はミッション期日内に店舗から承認をもらう必要があります。期間外に承認となった場合はキャンペーンの適用外となります。</li>
				<li class="red pt_5">ミッション発動中は15000円の交通費は適用外となります。15000円の交通費をご希望の場合は新たにアカウントを取得されることをお勧めします。</li>
			</ul>
		</div>
	</div>
	<!-- キャンペーン開催中 -->
	
	
	<?php endif; ?>
</div>
<?php endif; ?>
<input type="hidden" id="time-left" name="time-left" value="<?php echo isset($remainingTime)?$remainingTime:''; ?>" />
<script type="text/javascript">
    var days_remaining = "<?php echo isset($remainingTime)?floor($remainingTime / 86400):0; ?>";
    var hours_remaining = "<?php echo isset($remainingTime)?floor(($remainingTime % 86400) / 3600):0; ?>";
    var mins_remaining = "<?php echo isset($remainingTime)?floor((($remainingTime % 86400) % 3600) / 60):0; ?>";
    var secs_remaining = "<?php echo isset($remainingTime)?floor((($remainingTime % 86400) % 3600) % 60):0; ?>";
    var time = '';
  if ($("#time-left").val() != "") {
      if (secs_remaining <= 0 && mins_remaining <= 0 && hours_remaining <= 0 && days_remaining <= 0) {
          $('.step_up_campaign').remove();
      }
      else {
          createTime();
          $('.remaining-time').text(time);
          var countdownTimer = setInterval('remainingTime()', 1000);
      }
  }

  function remainingTime() {
      if (secs_remaining == 0 && mins_remaining > 0) {
          secs_remaining = 59;
          if (mins_remaining == 0 && hours_remaining > 0) {
              mins_remaining = 59;
              if (hours_remaining == 0 && days_remaining > 0) {
                  hours_remaining = 23;
                  if (days_remaining == 0) {
                      days_remaining = 0;
                  }
                  else {
                      --days_remaining
                  }
              }
              else {
                  if (hours_remaining == 0) {
                      hours_remaining = 0;
                  }
                  else {
                      --hours_remaining;
                  }
              }
          }
          else {
              if (mins_remaining == 0) {
                  mins_remaining = 0;
              }
              else {
                  --mins_remaining;
              }
          }
      }
      else {
          if (secs_remaining == 0) {
                  secs_remaining = 0;
          }
          else {
              --secs_remaining;
          }
      }
      createTime();
      $('.remaining-time').text(time);
  }

  function addZero(num) {
      if (num < 10) {
          return '0'+num;
      }
      else {
          return num;
      }
  }

  function createTime() {
      time = '';
      if (days_remaining > 0) {
          time = time + addZero(days_remaining)+' 日';
      }
      if (hours_remaining > 0 || (hours_remaining == 0 && days_remaining >= 1)) {
          time = time + addZero(hours_remaining)+' 時間';
      }
      if (mins_remaining > 0 || (mins_remaining == 0 && hours_remaining >= 1)) {
          time = time + addZero(mins_remaining)+' 分';
      }
      time = time + addZero(secs_remaining)+' 秒';
      if (secs_remaining <= 0 && mins_remaining <= 0 && hours_remaining <= 0 && days_remaining <= 0) {
          time = '00秒';
          clearInterval(countdownTimer);
          $('.step_up_campaign').remove();
      }
  }
</script> 
