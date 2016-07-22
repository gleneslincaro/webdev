<?php $this->load->view('user/pc/header/header'); ?>
<section class="section">
<div>
待遇＋大エリア
</div>
</section>
<section class="section--area_search <?php echo $groupCity_info['alph_name']; ?>">
	<h1 class="m_b_20"><?php echo $groupCity_info['name']; ?>エリア</h1>
	<div class="area_wrap">
		<div class="area_navi">
			<ul>
		    <?php foreach ($get_city_ar as $key => $val) : ?>
				<li class="area_<?php echo $val['alph_name'];?>"><a href="" class="ui_btn"><?php echo $val['name'];?></a></li>
			<?php endforeach ; ?>
			</ul>
		</div>
		<div class="area_detail city">
			<p class="area_ttl">表示したいエリアを選択して下さい</p>
			<div class="left_box">
				<ul class="area_map">
						<li class="<?php echo 'alph_name'; ?>">
							<a href=""><?php echo 'name'; ?></a>
						</li>
				</ul>
			</div>

			<div class="right_box">
				<?php foreach ($city_towns_ar as $key1 => $value1): ?>
				<dl>
					<dt>
						<span>
						<a href="" class=""><?php echo $value1['name']; ?></a>
						</span>
					</dt>
					<dd>
						<ul>
							<?php foreach ($value1['towns'] as $key2 => $value2): ?>
							<li>
							<a href="<?php echo base_url().'user/jobs/'.$groupCity_info['alph_name'].'/'.$value1['alph_name'].'/'.$value2['alph_name'].'/?treatment='.$treatment; ?>" class="" ><?php echo $value2['name']; ?></a>
							</li>
							<?php endforeach; ?>
						</ul>
					</dd>
				</dl>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
</section>
