<?php $this->load->view('user/pc/header/header'); ?>
<section class="section--main_content_area">
  <div class="container p_b_50">
    <div class="box_white">
      <section class="section--info_detail">
        <h2 class="ttl_style_1">お知らせ</h2>
        <div class="box_white">
          <div class="info_detail_header">
            <dl>
              <dt>受信日時</dt>
              <dd><?php echo $specific_news['created_date']; ?></dd>
            </dl>
            <dl>
              <dt>From</dt>
              <dd>ジョイスペ事務局</dd>
            </dl>
          </div>
          <h3><span>重要</span><?php echo $specific_news['title']; ?></h3>
          <div class="info_detail_massage"><?php echo nl2br($specific_news['content']); ?></div>
        </div>
        <a class="t_link" href="<?php echo base_url(); ?>user/info_list/">＜お知らせ一覧へ</a>
      </section>
    </div>
  </div>
  <!-- // .container --> 
</section>