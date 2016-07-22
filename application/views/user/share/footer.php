<footer id="footer" class="footer">
    <div class="footer_inner cf">
		<dl class="footer_nav">
			<dt><a href="<?php echo base_url(); ?>">全国の風俗求人情報</a></dt>
			<dd>
				<ul>
					<li><a href="<?php echo base_url(); ?>user/jobs/hokkaido/">北海道・東北</a></li>
					<li><a href="<?php echo base_url(); ?>user/jobs/kanto/">関東</a></li>
					<li><a href="<?php echo base_url(); ?>user/jobs/kitakanto/">北関東</a></li>
					<li><a href="<?php echo base_url(); ?>user/jobs/hokuriku/">北陸・甲信越</a></li>
					<li><a href="<?php echo base_url(); ?>user/jobs/tokai/">東海</a></li>
					<li><a href="<?php echo base_url(); ?>user/jobs/kansai/">関西</a></li>
					<li><a href="<?php echo base_url(); ?>user/jobs/shikoku/">中国・四国</a></li>
					<li><a href="<?php echo base_url(); ?>user/jobs/kyushu/">九州・沖縄</a></li>
				</ul>
			</dd>
		</dl>
	
<?php if (isset($long_tail)): ?>
	<?php if ($long_tail === 'store_detail'): ?>
    	<p>
	    このページでは<?php echo $town_name; ?>にある「<?php echo $storename; ?>」の求人をご案内<br>
		日払いや体入（体験入店）情報も盛りだくさん！<br>
		<?php echo $town_name; ?>の<?php echo $jobtypename; ?>の風俗求人情報が満載！<br>
		高収入アルバイトをお探しならジョイスペで決まり！
		</p>
	<?php endif; ?>
<?php endif; ?>
		
        <small>Copyright © Joyspe All Rights Reserved.</small>
    </div>
</footer>
<?php if (!isset($no_scroll)) :?>
<a id="scroll_top" href="#" style="display: none; padding-top: 12px;"><img width="95" height="14" alt="PAGE TOP" src="<?php echo base_url(); ?>public/user/image/btn_page_top.png"></a>
<?php include_once("analyticstracking.php") ?>
<?php endif; ?>