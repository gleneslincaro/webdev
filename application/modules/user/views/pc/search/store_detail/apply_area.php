<div class="apply_area cf">
	<ul>
		<li>
			<?php if (isset($travel_expense)) : ?>
			<div class="apply_item">
				<div class="col_wrap">
					<div class="col_left">
						<h3 class="ttl">ジョイスペ交通費保証</h3>
						<p class="desc">面接交通費「<?php echo $travel_expense_bonus_point; ?>円」を支給！</p>
						<small>※面接が終わったらボタンを押してください。</small>
					</div>
					<div class="col_right">
						<p>
<!--                        <a id="request_travel_expense" href="javascript:void(0)" class="ui_btn ui_btn--bg_white ui_btn--c_magenta ui_btn--middle">交通費申請</a>  -->
						<?php if (isset($request_status) && $request_status == 0) : ?>
							<a id="request_travel_expense" class="ui_btn ui_btn--bg_white ui_btn--c_magenta ui_btn--middle" href="javascript:void(0)" id="request_travel_expense">交通費申請</a>
						<?php elseif ( isset($request_status) && $request_status == 3 ) : ?>
							<p class="ui_btn ui_btn--bg_grey ui_btn--c_magenta ui_btn--middle ui_btn--disabled" >交通費済み</p>
						<?php else: ?>
							<p class="ui_btn ui_btn--bg_grey ui_btn--c_magenta ui_btn--middle ui_btn--disabled">受付終了</p>
						<?php endif; ?>
						</p>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</li>
		<li>
			<?php if( isset($campaignBonusRequest)) : ?>
			<div class="apply_item">
				<div class="col_wrap">
					<div class="col_left">
						<h3 class="ttl">ジョイスペ体験入店保証</h3>
						<p class="desc">面接交通費「<?php echo $bonus_money; ?>円」を支給！</p>
						<small>※体験入店が終わったらボタンを押してください。</small>
					</div>
					<div class="col_right">
						<p>
<!--                       <a href="javascript:void(0)" class="ui_btn ui_btn--bg_white ui_btn--c_magenta ui_btn--middle" id="request_campaingn_bonus_date">体験入店申請</a>  -->
						  <?php if ( isset($requestCampaignStatus)  && $requestCampaignStatus == 0) : ?>
							  <?php if (isset($ckdecline) && $ckdecline == true) { ?>
								  <p class="ui_btn ui_btn--bg_grey ui_btn--c_magenta ui_btn--middle ui_btn--disabled">体験入店申請済み</p>
							  <?php } else { ?>
								  <a class="ui_btn ui_btn--bg_white ui_btn--c_magenta ui_btn--middle" href="javascript:void(0)" id="request_campaingn_bonus_date">体験入店申請</a>
							  <?php } ?>
						  <?php  elseif ( isset($requestCampaignStatus) && $requestCampaignStatus == 3 ) : ?>
							  <p class="ui_btn ui_btn--bg_grey ui_btn--c_magenta ui_btn--middle ui_btn--disabled"> 体験入店申請済み</p>
						  <?php else : ?>
							  <a class="ui_btn ui_btn--bg_grey ui_btn--c_magenta ui_btn--middle ui_btn--disabled">受付終了</a>
						  <?php endif; ?>
						</p>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</li>
	</ul>
</div>
