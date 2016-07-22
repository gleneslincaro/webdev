<div class="page_wrap page_wrap--experiences_detail">
    <div class="page_wrap_inner">
        <div class="pagebody pagebody--gray">
            <section class="section section--experiences_detail">
                <div class="pagebody_inner">
                    <h3 class="ttl_1">みんなの体験談</h3>
                    <div class="experiences_wrap">
                        <div class="box_inner">
                            <ul class="experiences_list ttl">
                                <li>
                                <?php if (date('Y-m-d', strtotime('-7 days')) <= $get_msg['created_date']) :?>
                                    <span class="new_experiences">New</span>
                                <?php endif; ?>
                                <span class="experiences_h"><?php echo nl2br($get_msg['title']); ?></span></li>
                                <li><span class="area_age"><?php echo $get_msg['age_name1']; ?>歳～<?php echo $get_msg['age_name2']; ?>歳</span><span class="area_age"><?php echo $get_msg['city_name']; ?></span></li>
                            </ul>
                            <div class="experiences_list sentence detail">
                                <p><?php echo preg_replace('/[ ](?=[^<>]*(?:<|$))/', '&nbsp', nl2br($get_msg['content'])); ?></p>
                            </div>
                        </div>
                        <div class="experiences_arrow">
                            <?php if ( isset($get_msg['left_id'])) : ?>
                            <div>
                                <a href="/user/experiences/experiences_detail/<?php echo $get_msg['left_id']; ?>"> 
                                    <div class="experiences_arrow left">
                                        <i class="fa fa-chevron-left"></i><span>前へ</span>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                            <?php if ( isset($get_msg['right_id'])) : ?>
                            <div>
                                <a href="/user/experiences/experiences_detail/<?php echo $get_msg['right_id']; ?>"> 
                                    <div class="experiences_arrow right"><span>次へ</span><i class="fa fa-chevron-right"></i></div>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- // .box_inner --> 
                </div>
            </section>
            <!-- // .pagebody_inner --> 
        </div>
        <!-- // .pagebody --> 
    </div>
    <!-- // .page_wrap_inner --> 
</div>