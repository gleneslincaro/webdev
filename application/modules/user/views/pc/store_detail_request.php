<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/jquery-ui.css" />


<?php $this->load->view('user/pc/header/header'); ?>
<section class="section--main_content_area">
<?php foreach ($company_data as $data) : ?>
    <div class="container cf">
        <section class="section--store_detail">
            <div class="m_b_20">
                <a href="javascript: history.back();" class="ui_btn ui_btn--bg_brown btn_back">検索結果に戻る</a>
            </div>

            <div class="top_info_1 cf">
                <?php //$this->load->view('user/pc/search/store_detail/special_phrase'); ?>
                <h1 class="store_name"><!-- <span class="tag tag-new">NEW</span>--><?php echo $company_data[0]['storename'];?></h1>
            </div><!-- // .top_info_1 -->
            <div class="top_info_2 cf">
                <div class="col_wrap">
                    <div class="col_left">
                        <div class="data_2">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>地域</th>
                                        <td><?php echo $data['town_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>業種</th>
                                        <td>
                                        <?php
                                            $tam=count($data['jobtypename']);
                                            $i=0;
                                            foreach ($data['jobtypename'] as $j) {
                                                echo $j['name'] ;
                                                $i++;
                                                if ($i<$tam) {
                                                    echo"、";
                                                }
                                            }
                                        ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- // .col_left -->
                    <div class="col_right">
                        <div class="rel_link rel_link-area box_wrap box_wrap-gray">
                            <h3 class="box_ttl">現在の総アクセス数</h3>
                            <div class="box_inner">
                                <p><?php echo $count_log ;?></p>
                            </div>
                        </div>
                    </div><!-- // .col_right -->
                </div><!-- // .col_wrap -->
                <div class="col_wrap">
                    <div class="col_left">
                        <div class="top_info_2_desc">
                            <p>コチラの店舗様の情報はユーザー様のリクエストによる情報です。あくまでも参考としてご活用ください。</p>
                        </div>
                    </div><!-- // .col_left -->
                    <div class="col_right">
                        <ul class="btn_wrap owner_entrance">
                            <li><a class="ui_btn ui_btn--bg_blue" href="<?php echo base_url('owner/top')?>">店舗オーナー様はコチラ！</a></li>
                        </ul>
                    </div><!-- // .col_right -->
                </div>
            </div><!-- // .top_info -->
            
            
            <?php $this->load->view('search/store_detail/rel_link_area', array('data'=>$data,'towns' => $towns, 'this_town_id' => $data['town_id'], 'this_town_name' => $data['town_name'], 'town_alph_name' => $data['town_alph_name'])); ?>
            <?php $this->load->view('user/pc/search/store_detail/rel_link_job_type', array('data'=>$data,'jobs_in_town' => $jobs_in_town)); ?>
        </section>
    
    </div><!-- // .container -->
<?php endforeach; ?>
</section>
<?php $this->load->view('user/pc/share/script'); ?>
