<?php //$data = $company_data[0]; ?>
<div class="contact_area">
	<div class="col_wrap">
		<div class="col_item contact-tel">
			<h3 class="sub_ttl ic ic-tel">電話で応募する</h3>
			<p class="tel_available_time"><span class="reception_time">電話受付時間</span><span class="available_time"><?php echo $data['apply_time']; ?></span></p>
			<p>
				<span class="tel_number"><?php echo $data['apply_tel']; ?></span>
				<?php if(isset($interviewer_info)) : ?>
				<span class="tel_rep">担当：<?php echo $interviewer_info['interviewer_name']; ?></span>
				<?php endif; ?>
			</p>
		</div>
		<?php echo $apply_email_address; ?>
		<?php
/*		<div class="col_item contact-email">
			<h3 class="sub_ttl ic ic-email">メールで応募する</h3>
			<p><a href="#" class="ui_btn ui_btn--bg_magenta ui_btn--middle">メールで応募する</a></p>
		</div>
*/
		?>

		<?php if ($data['line_url'] || $data['line_id']): ?>
		<div class="col_item contact-line">
			<h3 class="sub_ttl ic ic-line">LINEでカンタン応募</h3>
			<p class="line_id"><span>LINE <?php if (!$data['line_url']) { echo " ID"; } ?></span>
			<a href="javascript:void(0)" class="contact_line" data-href="<?php echo $data['line_url']; ?>">
				<input class="input_line_id" type="text" value="<?php echo $data['line_url'] ? '友だち追加':"" . $data['line_id']; ?>" onfocus="this.selectionStart=0; this.selectionEnd=this.value.length;" onmouseup="return false">
			</a></p>
			<p class="line_help"><a href="javascript:void();">LINEでカンタン応募って？</a></p>
			<div class="line_help_modal hide">
				<ol>
					<li>上の LINE ID をコピーして LINE から「ID検索」→「追加」で友達に追加。</li>
					<li>「Joyspeで求人情報を見て応募しました！」とお伝えください。</li>
				</ol>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>
<script>
$(function(){
	$(".contact_area .line_help a").hover(function(){
		$(".contact_area .line_help_modal").removeClass("hide");
	},
	function(){
		$(".contact_area .line_help_modal").addClass("hide");
	});
});
</script>