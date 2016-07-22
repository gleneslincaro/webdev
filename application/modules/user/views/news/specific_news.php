<section class="section section--info_detail cf">
    <h3 class="ttl_1">お知らせ</h3>
    <div class="box_inner pt_15 pb_15 cf">
      <div class="message_detail_top">
        <p class="datetime"><span>受信日時：</span><?php echo $specific_news['created_date']; ?></p>
        <p class="from"><span>From：</span>ジョイスペ事務局</p>
      </div>
      <div class="message_detail_wrap cf pagebody--white">
        <div class="message_detail_head">
          <p class="title"><?php echo $specific_news['title']; ?></p>
        </div><!-- // .message_detail_head -->
        <div class="message_detail_body">
          <p class="word_break"><?php echo nl2br($specific_news['content']); ?></p>
        </div><!-- // .message_detail_body --> 
      </div><!-- // .message_detail_wrap --> 
    </div><!-- // .box_inner -->
    
    <div class="ui_btn_wrap ui_btn_wrap--center cf">
        <ul>
            <li> <a class="ui_btn ui_btn--large_liquid" href="<?php echo base_url(); ?>user/info_list/">一覧へ戻る</a> </li>
        </ul>
    </div>
</section>
