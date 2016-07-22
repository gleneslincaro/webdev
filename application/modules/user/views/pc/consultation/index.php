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
            <?php if (isset($searchRes)) : ?>
                <?php $this->load->view($load_page_area); ?>
            <?php else: ?>

                <?php if (isset($getCity)) : ?>
                    <?php $this->load->view($load_page_area); ?>
                    <?php $this->load->view('user/pc/search_detail'); ?>
                <?php endif; ?>

                <?php  if (isset($getTowns)) : ?>
                    <?php $this->load->view($load_page_area); ?>
                    <?php //$this->load->view('user/pc/search_detail'); ?>
                <?php endif; ?>

                <?php if (isset($storeOwner)) : ?>
                    <?php $this->load->view($load_page_area); ?>
                <?php endif; ?>

            <?php endif; ?>

            </div>
            <div class="f_right">
                <?php $this->load->view('user/pc/share/aside'); ?>
            </div>
        </div>
        <?php if (isset($storeOwner) && isset($allJobType) && isset($treatments)) : ?>
        <div class="container section--store_detail">

            <?php if (isset($category_message_num)) : ?>
			<section class="section--store_detail m_b_30">
				<div class="everyone_qa box_wrap">
					<h2 class="ttl box_ttl ic ic-qa"><?php echo $breadText; ?>の<strong>みんなの質問</strong>を探す</h2>
					<div class="box_inner">
						<ul class="everyone_qa_search_list">
                            <?php foreach($category_message_num as $key => $data) : ?>
							<li><a href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c='.$key; ?>" class="t_link"><strong>【<?php echo $data['name']; ?>】</strong>の質問一覧（<strong><?php echo $data['count']; ?></strong>）</a></li>
                            <?php endforeach; ?>
						</ul>
					</div>
				</div>
			</section>
           <?php endif; ?>
            <?php $this->load->view('search/store_detail/rel_link_area', array('towns' => $all_towns, 'this_town_id' => $towns_id, 'this_town_name' => $town_info['name'], 'town_alph_name' => array_unique(explode(',',$town_info['alph_name'])))); ?>
            <?php $this->load->view('user/pc/search/store_detail/rel_link_job_type', array('jobs_in_town' => $jobs_in_town)); ?>
        </div>
        <?php endif; ?>
    </section>
<?php
if (!isset($searchRes)) {
    if (isset($articles) && $articles && $city == null && $town == null) { // 下記の新着急募情報はエリア検索に表示する
        $this->load->view('user/pc/share/pickup_store');
    }
}
?>
<?php $this->load->view('user/pc/share/pickup_column'); ?>
<?php $this->load->view('user/pc/share/footer_msg'); ?>
