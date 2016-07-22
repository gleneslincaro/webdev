
<?php
    $this->load->view('user/pc/header/header');
    $section_area = '';
    if (isset($getCity)) {
        $section_area = 'city';
    }
?>
    <section class="section--main_content_area">
        <div class="container cf">
            <div class="f_left <?php echo $section_area; ?>">
            	<section class="section--search_find m_b_20">
					<h2>キープ一覧</h2>
					<p class="cnt_txt">キープ件数：<span><strong><?php echo $count_all; ?></strong>件</span></p>
				</section>

            	<?php if (isset($storeOwner)) : ?>
                    <?php $this->load->view($load_page_area); ?>
                <?php endif; ?>
            </div>
            <div class="f_right">
                <?php $this->load->view('user/pc/share/aside'); ?>
            </div>
        </div>
    </section>
<?php
if (!isset($searchRes)) {
    if (isset($articles) && $articles && $city == null && $town == null) { // 下記の新着急募情報はエリア検索に表示する
        $this->load->view('user/pc/share/pickup_store');
    }
}
?>