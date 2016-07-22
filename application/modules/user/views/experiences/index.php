<div class="page_wrap page_wrap--experiences">
        <div class="pagebody pagebody--gray">
            <section class="section section--experiences">
                <div class="pagebody_inner">
                    <h3 class="ttl_1">体験談トップページ</h3>
                    <div class="box_inner">
                        <div class="experiences_list sentence">
                            <p>joyspeを実際にご利用いただいたユーザー様の体験談をご紹介しております。<br>
                                また、皆様からの体験談も随時募集しております。</p>
                            <div class="position_center">
                                <p><a class="posting" href="/user/experiences/experiences_form"><span>体験談を投稿する</span></a></p>
                            </div>
                        </div>
                        <ul>
                        <?php foreach ($data as $key => $value) : ?>
                            <li class="experiences_list">
                            <a class="link_detail" href="/user/experiences/experiences_detail/<?php echo $value['msg_id']; ?>/">
                                <ul class="form_preview list">
                                <?php if (date('Y-m-d', strtotime('-7 days')) <= $value['created_date']) :?>
                                    <li><span class="new_experiences">New</span>
                                <?php endif; ?>
                                    <span class="experiences_ttl"><?php echo $value['title']; ?></span></li>
                                    <li><span class="area_age"><?php echo $value['age_name1']; ?>歳～<?php echo $value['age_name2']; ?>歳</span><span class="area_age"><?php echo $value['city_name']; ?></span></li>
                                </ul>
                                <ul class="information_list">
                                    <li><i class="fa fa-angle-right"></i></li>
                                </ul>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <?php if ($pagination['count'] > $pagination['limit']) : ?>
                            <li>
                                <div class="position_center"> 
                                    <!--▼10件以上でボタン表示＆全て現れる▼-->
                                    <input type="button" class="experience_load_more more_btn" data-page="1" value="もっと見る">
                                </div>
                            </li>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <!-- // .box_inner --> 
            </section>
    </div>
    <!-- // .pagebody --> 
</div>