				<section class="section--search_find m_b_20 <?php //echo $city; ?>">
					<h2>検索結果</h2>
					<?php if ($count_all > 0) : ?>
					<p class="cnt_txt"><span><strong><?php echo $count_all; ?></strong>件</span>見つかりました</p>
					<?php else: ?>
					<p class="cnt_txt"><span><strong>0</strong>件</span></p>
					<p class="empty_txt">検索内容を変更して再度検索してください。</p>
					<?php endif; ?>
				</section>
				<?php $this->load->view('user/pc/result_store'); /* 店舗のリスト表示 */ ?>
