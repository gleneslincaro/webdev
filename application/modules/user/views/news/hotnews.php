<input type="hidden" value="<?php echo $count?>" id="count_news_id">    
<input type="hidden" value="<?php echo $limit?>" id="limit_news_id">
<input type="hidden" value="<?php echo $count_all?>" id="countall_news_id">
<input type="hidden" id="limit_id" value="<?php echo $limit?>">
<section class="section section--info_list cf">
    <h3 class="ttl_1">お知らせ</h3>
    <div class="box_inner pt_15 pb_15 cf">
        <div class="ui_list_1 info_list cf" id="news_id">
            <?php echo $this->load->view("news/list_hot_news")?>                    
        </div>                
        <div id="loader_wrapper" class="t_center"></div>       
    </div><!-- // .box_inner -->
</section>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/info_list.js?v=20150508"></script>
