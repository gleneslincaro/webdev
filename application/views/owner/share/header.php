<?php $page_url = base_url(); ?>
<div id="header">
    <div id="header-logo">
        <div class="kame_link">
            <?php if(HelperApp::get_session('kame_credentials')):?>
                <?php $this->load->view('index/kame_tv');?>
            <?php endif;?>
        </div>
        <a class="link_blog" href="http://joyspe1.blog.fc2.com/" target="_blank">
            <img src="/public/owner/images/blog_banner.png" alt="ブログはじめました" />
        </a>
		<a class="link_help" href="<?php echo $page_url ?>owner/help/help"> ヘルプ</a>
        <a href="<?php echo $page_url . 'owner/index'?>" style="text-decoration: none" >
          <img src="<?php echo $page_url ?>public/owner/images/logo_owner2.png" width="142" height="57" alt="ロゴ">
        </a>
    </div>
</div>
