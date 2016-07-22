<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/interviewer.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/company_detail.js"></script>
<script type="text/javascript">
    var baseUrl = '<?php echo base_url(); ?>';
    var ors_id = '<?php echo $ors_id; ?>';
    var user_id = '<?php echo (isset($user_id)? $user_id: "" ); ?>';
    var owner_id = '<?php echo $owner_id; ?>';
    var campaign_id = '<?php echo (isset($campaign_id))?$campaign_id:''; ?>';
    var campaignBonusRequestId = '<?php echo (isset($campaignBonusRequest))?$campaignBonusRequest["id"]:''; ?>';
    var getUrl = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/send_message.js?v=20150726" ></script>
<style>
#campaingn_bonus_date {
  text-align: center;
  background: #fff;
  padding: 10px;
  display: none;
}
#campaingn_bonus_date div {
  text-align: right;
  padding: 0 0 20px 0;
  font-weight: bold;
  font-size: 25px;
}
#campaingn_bonus_date input {
  width: 175px;
}
</style>
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
                    <h2 class="store_name"><!-- <span class="tag tag-new">NEW</span>--><?php echo $company_data[0]['storename'];?></h2>
                    <div class="col_wrap">
                        <div class="col_left">
                            <div class="slider_wrap">
                                <ul class="slider_store_banner" id="slider_store_banner">
                                <li>
                                    <?php if ($data['main_image'] != 0 && $data['image' . $data['main_image']] ) : ?>
                                        <img src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$data['main_image']]; ?>" alt="<?php echo $data['storename']; ?>" />
                                    <?php else : ?>
                                        <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                                    <?php endif; ?>
                                </li>
                                <?php for ($i = 1; $i<=6; $i++) : ?>
                                    <?php if ($data['image'.$data['main_image']] != $data['image'.$i] && $data['image'.$i] != '') : ?>
                                    <li>
                                        <?php if($data['image'.$i] ) : ?>
                                                <img  src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$i]; ?>" alt="<?php echo $data['storename']; ?>" />
                                        <?php else : ?>
                                                <img  src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                                        <?php endif; ?>
                                    </li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                </ul>
                            </div>
                        </div><!-- // .col_left -->
                        <div class="col_right">
                            <p class="desc_1"><?php echo (isset($data['title']) && $data['title'])?nl2br($data['title']):'';?></p>
                            <div class="data_1">
                                <dl>
                                    <dt>給料</dt>
                                    <dd><?php echo nl2br($data['salary']); ?></dd>
                                </dl>
                            </div>
                        </div><!-- // .col_right -->
                    </div><!-- // .col_wrap -->
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
                                        <tr>
                                            <th>TEL</th>
                                            <td><?php echo $data['apply_tel']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- // .col_left -->
                        <div class="col_right">
                            <?php if ($data['happy_money'] != 0) : ?>
                            <div class="trial_bonus">
                                <p><?php echo $data['happy_money_type']; ?>お祝い金<strong><?php echo $data['happy_money']; ?></strong>円</p>
                            </div>
                            <?php endif; ?>
                            <ul class="btn_wrap">
                                <li>
                                    <?php if ($data['keepstt']==0) : ?>
                                        <a href="<?php echo base_url() . "user/keep/index/" . $data["ors_id"]; ?>/" class="ui_btn btn_keep ui_btn--middle"></a>
                                    <?php else : ?>
                                        <a href="<?php echo base_url() . "user/keep/keep_clear/" . $data["ors_id"]; ?>/" class="ui_btn btn_keep on ui_btn--middle"></a>
                                    <?php endif; ?>
                                </li>
                                <li>
                                    <?php if ($stt == 0) : ?>
                                        <a href="<?php echo base_url() . "user/denial/index/" . $data["ors_id"]; ?>/" class="ui_btn btn_block ui_btn--middle"></a>
                                    <?php else : ?>
                                        <a href="<?php echo base_url()."user/denial/not_denial/".$data['ors_id']?>/" class="ui_btn btn_block on ui_btn--middle"></a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div><!-- // .col_right -->
                    </div><!-- // .col_wrap -->
                </div><!-- // .top_info -->
                <?php //$this->load->view('user/pc/search/store_detail/tags_area.html'); ?>
                <div class="tags_area box_wrap">
                    <h2 class="ttl box_ttl t_center">待遇と条件</h2>
                    <div class="box_inner">
                        <dl>
                            <dt class="sub_ttl">お金や時間に関する待遇</dt>
                            <dd>
                                <?php
                                $reg_trment_array = array();
                                if (isset($data['treatment'])) {
                                    foreach ($data['treatment'] as $one_reg_trment) {
                                        $reg_trment_array[$one_reg_trment['group_id']][$one_reg_trment['id']] = $one_reg_trment; // set ID to array key
                                    }
                                    $treatment_array  = array();
                                    foreach ($treatments as $one_reg_trment) {
                                        $treatment_array[$one_reg_trment['group_id']][$one_reg_trment['id']] = $one_reg_trment; // set ID to array key
                                    }
                                }
                                ?>
                                <ul class="store_tags store_tags-treatments store_tags-large cf">
                                <?php foreach ($treatment_array[1] as $treatment) : ?>
                                    <li class="<?php echo isset($reg_trment_array[1][$treatment['id']]) ? 'on' : ''; ?>" >
                                        <?php echo $treatment['name']; ?>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            </dd>
                            <dt class="sub_ttl">その他待遇</dt>
                            <dd>
                                <ul class="store_tags store_tags-treatments_others store_tags-large cf">
                                <?php foreach ($treatment_array[0] as $treatment) : ?>
                                    <li class="<?php echo isset($reg_trment_array[0][$treatment['id']]) ? 'on' : ''; ?>" >
                                        <?php echo $treatment['name']; ?>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            </dd>
                            <?php if (isset($user_characters) && isset($reg_user_character) && $reg_user_character) : ?>
                            <dt class="sub_ttl">こんな方も大丈夫</dt>
                            <dd>
                                <ul class="store_tags store_tags-user_character store_tags-large cf">
                                    <?php foreach ($user_characters as $key => $character) : ?>
                                    <li class="<?php echo isset($reg_user_character[$character['id']]) ? 'on' : ''; ?>"><?php echo $character['name']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div><!-- // .tags_area_wrap -->
                <?php echo $this->load->view('user/pc/search/store_detail/contact_area', array('apply_email_address' => $hide_apply_emailaddress, 'data' => $data)); ?>
                <?php //include './inc/store_detail/tags_area.html'; ?>
                <?php //include './inc/store_detail/contact_area.html'; ?>
                <div class="everyone_qa box_wrap m_b_30">
                    <h2 class="ttl box_ttl ic ic-qa"><strong>みんなの</strong>質問カテゴリー</h2>
                    <div class="box_inner">
                        <ul class="everyone_qa_search_list">
                            <?php foreach($category_message_num as $key => $entry) : ?>
                            <?php if($entry['name'] == '全て') : ?>
                            <li><a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$entry['id'];?>" class="t_link"><?php echo $company_data[0]['storename'];?>の<strong><?php echo $entry['name']; ?></strong>の質問一覧（<strong><?php echo $entry['count']; ?></strong>）</a></li>
                            <?php else: ?>
                            <li><a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$entry['id'];?>" class="t_link"><?php echo $company_data[0]['storename'];?>の<strong>【<?php echo $entry['name']; ?>】</strong>に関する質問一覧（<strong><?php echo $entry['count']; ?></strong>）</a></li>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="inquiry_area">
                    <div class="col_wrap">
                        <div class="col_left">
                            <?php $this->load->view('user/pc/search/store_detail/inquiry'); ?>
                        </div>
                        <div class="col_right">
                            <ul class="btn_wrap">
                                <?php if ($data['kuchikomi_url']) : ?>
                                <li>
                                    <a id="contact_kuchikomi" href="javascript:void(0)" data-href="<?php echo $data['kuchikomi_url']; ?>" class="ui_btn ui_btn--bg_blue ui_btn--large">クチコミ</a>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <a id="contact_hp" href="javascript:void(0)" data-href="<?php echo $data['home_page_url']; ?>" class="ui_btn ui_btn--bg_black ui_btn--large" rel="nofollow">オフィシャルHP</a>
                                    <small>※別タブで開きます</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php
/*                                    <a id="contact_hp" href="javascript:void(0)" data-href="<?php echo $data['home_page_url']; ?>" class="ui_btn ui_btn--bg_black ui_btn--large" target="_blank" rel="nofollow">オフィシャルHP</a>*/


                    $tab_senior_hide = 'hide';
                    $tab_flow_hide = 'hide';
                    $tab_qa_hide = 'hide';
                    if (isset($owner_senior_profile) || isset($user_statistics)) {
                        $tab_contents_flag = true;
                        $tab_senior_flag = true;
                        $tab_senior_class = true;
                        $tab_senior_hide = '';
                    } elseif (isset($owner_working_days)) {
                        $tab_contents_flag = true;
                        $tab_flow_class = true;
                        $tab_flow_hide = '';
                    } elseif (isset($faq)) {
                        $tab_contents_flag = true;
                        $tab_qa_class = true;
                        $tab_qa_hide = '';
                    }

                    if (isset($owner_benefits) || isset($tab_contents_flag)) {
                        $entry_info_flag = true;
                    }
                ?>
                <?php if (isset($entry_info_flag)) : ?>
                <div class="entry_info">
                    <div class="tab_wrap">
                        <div class="tab_menu">
                            <ul>
                                <?php if (isset($owner_senior_profile) || isset($user_statistics)) { ?>
                                <li <?php echo ($tab_senior_class) ? 'class="on"':''; ?> > <a href="#tab_senior">教えて先輩</a> </li>
                                <?php } ?>
                                <?php if (isset($owner_working_days)) { ?>
                                 <li <?php echo (isset($tab_flow_class)) ? 'class="on"':''; ?>> <a href="#tab_flow">一日の流れ</a> </li>
                                <?php } ?>
                                <?php if (isset($faq)) { ?>
                                <li <?php echo (isset($tab_qa_class)) ? 'class="on"':''; ?>> <a href="#tab_qa">よくある質問</a> </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php if (isset($tab_senior_flag)) : ?>
                        <div class="tab_contents tab_senior <?php echo $tab_senior_hide; ?>" id="tab_senior">
                            <?php if (isset($owner_senior_profile)) { ?>
                            <div class="tab_senior_inner">
                                <div class="slider" id="slider_senior">
                                    <?php foreach ($owner_senior_profile as $value) : ?>
                                    <div class="senior_box">
                                        <dl>
                                            <dt>
                                            <?php if($value['senior_photo'] && file_exists($value['senior_photo'])) : ?>
                                                <img src="<?php echo base_url().$value['senior_photo']; ?>" >
                                            <?php else : ?>
                                                <img src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" />
                                            <?php endif; ?>
                                            </dt>
                                            <dd>
                                                <p>月収：<strong><?php echo $value['monthly_income']; ?>万円</strong></p>
                                                <p>勤続<?php echo $value['service_length']; ?>ヶ月</p>
                                                <p>月<?php echo $value['monthly_work_days']; ?>日勤務</p>
                                                <p>風俗経験：<?php echo $value['work_experience']; ?></p>
                                            </dd>
                                        </dl>
                                        <p class="desc"><?php echo $value['comment']; ?></p>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if (isset($user_statistics)) { ?>
                            <div>
                                <div class="entry_enrollment">
                                    <h3>在籍女性データ</h3>
                                    <div class="enrollment_box">
                                        <table>
                                            <tr>
                                        <?php
                                            $cntr = 10;
                                            $ext = '';
                                            $content_stat ='';
                                            foreach ($user_statistics as $key => $value) : ?>
                                                <?php
                                                if ((end(array_keys($user_statistics)) - 1) == $key) {
                                                    $ext = '以上';
                                                }
                                                $class_ar = array('teen_age','twenty_age', 'thirty_age', 'forty_age', 'fifty_age');
                                                if ($value['content'] == null) : ?>
                                                    <td class="<?php echo $class_ar[$key]; ?>">
                                                        <dl>
                                                            <dt><span></span></dt>
                                                            <dd>
                                                                <p><?php echo $cntr; ?>代<?php echo $ext; ?></p>
                                                                <p><strong><?php echo $value['user_percent']; ?>%</strong></p>
                                                            </dd>
                                                        </dl>
                                                    </td>
                                                <?php $cntr += 10; ?>
                                        <?php
                                                endif;
                                            endforeach; ?>
                                            </tr>
                                        </table>
                                        <ul class="cf">
                                        <?php
                                            $content_stat ='';
                                            foreach ($user_statistics as $key => $value) :
                                                $class_ar = array('teen_age','twenty_age', 'thirty_age', 'forty_age', 'fifty_age');
                                                if ($value['content'] == null) : ?>
                                                <li class="<?php echo $class_ar[$key]; ?>" style="width:<?php echo $value['user_percent']; ?>%;"></li>
                                        <?php
                                                else:
                                                    $content_stat = $value['content'];
                                                endif;
                                            endforeach; ?>
                                        </ul>
                                        <p><?php echo $content_stat;?></p>
                                    </div>
                                </div>
                            </div>
                            <?php } //if (isset($user_statistics)) ?>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($owner_working_days)) : ?>
                        <div class="tab_contents <?php echo $tab_flow_hide; ?>" id="tab_flow">
                            <div class="work_flow">
                                <div class="work_flow_desc">
                                    <?php if ($owner_working_days[0]['content']) : ?>
                                    <h3>お仕事の説明</h3>
                                    <p><?php echo nl2br($owner_working_days[0]['content']); ?></p>
                                    <?php if (count($owner_working_days) > 0 && $owner_working_days[0]['working_day_description']) : ?>
                                        <?php foreach ($owner_working_days as $key => $value) : ?>
                                        <dl>
                                            <?php if($value['working_day_pic'] && file_exists($value['working_day_pic'])) : ?>
                                            <dt>
                                                <img src="<?php echo base_url().$value['working_day_pic']; ?>" width="104" height="104">
                                            </dt>
                                            <?php endif; ?>
                                            <dd>
                                                <p><strong><?php echo strval($key + 1).'.'; ?></strong></p>
                                                <p><?php echo nl2br($value['working_day_description']); ?></p>
                                            </dd>
                                        </dl>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php endif; // if ($owner_working_days[0]['content']) : ?>
                                </div>
                                <?php if ($owner_working_days[0]['youtube_embed']) :?>
                                <div class="work_flow_video">
                                    <h3>お仕事動画</h3>
                                    <p><?php echo $owner_working_days[0]['youtube_embed']; ?></p>
                                </div>
                                <?php endif; ?>
                            </div> <!-- // .work_flow -->
                        </div>
                        <?php endif;  // if (isset($owner_working_days))?>
                        <?php if (isset($faq)) : ?>
                        <div class="tab_contents <?php echo $tab_qa_hide; ?>" id="tab_qa">
                            <div class="work_qa">
                                <h3>よくある質問　Q&A </h3>
                                 <?php foreach($faq as $value) : ?>
                                <dl>
                                    <dt> <span>Q.</span><?php echo nl2br($value['question']); ?></dt>
                                    <dd> <span>A.</span><?php echo nl2br($value['answer']); ?></dd>
                                </dl>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div><!-- // .tab_wrap -->
                    <?php if (isset($owner_benefits)) : ?>
                    <div class="entry_flow">
                        <h3>入店までの流れ</h3>
                        <ol>
                            <?php foreach($owner_benefits as $key => $value) : ?>
                            <li>
                                <h4><?php echo strval($key+1).":".$value['title']; ?></h4>
                                <p><?php echo nl2br($value['content']); ?></p>
                            </li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div><!-- // .entry_info -->
                <?php endif; ?>
                <div class="store_infos m_t_30">
                    <div class="tab_wrap">
                        <div class="tab_menu">
                            <ul>
                                <li class="on"> <a href="#tab_store_info"><span>基本情報</span></a> </li>
                                <?php if (isset($article) && count($article) > 0): ?>
                                <li class="hurry"> <a href="#tab_pickup_info"><span>急募情報</span></a> </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="tab_contents" id="tab_store_info">
                            <div class="store_info">
                                <table>
                                    <tr>
                                        <th>店舗名</th>
                                        <td><?php echo $company_data[0]['storename'];?></td>
                                    </tr>
                                    <tr>
                                        <th>地域</th>
                                        <td><?php echo $data['town_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>職業</th>
                                        <td>
                                        <?php
                                            $tam=count($data['jobtypename']);
                                            $i=0;
                                            foreach ($data['jobtypename'] as $j) {
                                                echo $j['name'] ;
                                                $i++;
                                                if ($i<$tam)
                                                    echo"、";
                                            }
                                        ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>給料</th>
                                        <td><?php echo nl2br($data['salary']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>応募資格</th>
                                        <td><?php echo nl2br($data['con_to_apply']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>勤務日</th>
                                        <td><?php echo $data['working_day'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>勤務時間</th>
                                        <td><?php echo $data['working_time'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>交通</th>
                                        <td><?php echo nl2br($data['how_to_access']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>住所</th>
                                        <td><?php echo $data['address']?></td>
                                    </tr>
                                    <?php if ($data['other_service']) :  ?>
                                    <tr>
                                        <th class="pick">その他の待遇</th>
                                        <td><?php echo nl2br($data['other_service']); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if (isset($owner_speciality)) : ?>
                                    <tr>
                                        <th class="pick">当店はここが違う</th>
                                        <td>
                                            <div class="col_wrap">
                                                <?php if ($owner_speciality['photo']) : ?>
                                                <div class="col_item desc_img">
                                                    <img src="<?php echo base_url().$owner_speciality['photo']; ?>" width="104" height="104" />
                                                </div>
                                                <?php endif; ?>
                                                <div class="col_item desc_box"><?php echo nl2br($owner_speciality['content']); ?></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                        <?php if (isset($article) && count($article) > 0): ?>
                        <div class="tab_contents  <?php echo $tab_qa_hide; ?>" id="tab_pickup_info">
                            <div class="pickup_info">
                                <p>更新時間 <?php echo date('Y', strtotime($article['post_date']))."年".date('m', strtotime($article['post_date']))."月".date('d', strtotime($article['post_date']))."日(".$article['jap_day'].')'.date('H:i', strtotime($article['c_post_date'])); ?></p>
                                <dl>
                                    <dt>急募：</dt>
                                    <dd><?php echo nl2br($article['message']); ?></dd>
                                </dl>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div><!-- // .tab_wrap -->
                    <div class="store_msg m_t_15">
                        <h3>店舗からのメッセージ</h3>
                        <div class="desc_box">
                            <?php echo nl2br($data['company_info']); ?>
                        </div>
                    </div><!-- // .store_msg -->
                    <!--Start of interviewer information-->
                    <?php if(isset($interviewer_info)) : ?>
                    <div class="store_rep">
                        <div class="col_wrap">
                            <div class="col_left">
                                <h4>私が面接します！</h4>
                                <figure><img src="<?php echo base_url().$interviewer_info['interviewer_photo']?>" /></figure>
                                <p class="rep_name"><em><?php echo $interviewer_info['interviewer_name']; ?></em>さん</p>
                                <div class="rep_data">
                                    <table>
                                        <tr>
                                            <th>性別</th>
                                            <td><?php echo $interviewer_info['gender']; ?></td>
                                        </tr>
                                        <?php if ($interviewer_info['age']) : ?>
                                        <tr>
                                            <th>年齢</th>
                                            <td><?php echo $interviewer_info['age']; ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if ($interviewer_info['hobby']) : ?>
                                        <tr>
                                            <th>趣味</th>
                                            <td><?php echo $interviewer_info['hobby']; ?></td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                            <div class="col_right">
                                <div class="rep_comment">
                                    <p><?php echo nl2br($interviewer_info['description']); ?></p>
                                </div>
                            </div>
                        </div><!-- // .col_wrap -->
                    </div>
                    <?php endif; ?>
                </div><!-- // .store_infos -->
                <?php echo $this->load->view('/search/store_detail/special_merit', array('data' => $data)); ?>
                <?php echo $this->load->view('user/pc/search/store_detail/contact_area', array('apply_email_address' => $hide_apply_emailaddress1, 'data' => $data)); ?>
                <div class="inquiry_area">
                    <div class="col_wrap">
                        <div class="col_left">
                            <?php $this->load->view('user/pc/search/store_detail/inquiry'); ?>
                        </div>
                        <div class="col_right">
                            <ul class="btn_wrap">
                                <li>
                                    <!-- <a href="#" class="ui_btn btn_keep ui_btn--large"></a>  -->
                                    <?php if ($data['keepstt']==0) : ?>
                                        <a class="ui_btn btn_keep ui_btn--large" href="<?php echo base_url() . "user/keep/index/" . $data["ors_id"]; ?>/"></a>
                                    <?php else : ?>
                                        <a class="ui_btn btn_keep on ui_btn--large" href="<?php echo base_url() . "user/keep/keep_clear/" . $data["ors_id"]; ?>/"></a>
                                    <?php endif; ?>
                                </li>
                                <li>
                                    <?php if ($stt == 0) : ?>
                                        <a href="<?php echo base_url() . "user/denial/index/" . $data["ors_id"]; ?>/" class="ui_btn btn_block ui_btn--large"></a>
                                    <?php else : ?>
                                        <a href="<?php echo base_url()."user/denial/not_denial/".$data['ors_id']?>/" class="ui_btn btn_block on ui_btn--large"></a>
                                    <?php endif; ?>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <?php $this->load->view('user/pc/search/store_detail/apply_area'); ?>
                <?php $this->load->view('search/store_detail/rel_link_area', array('towns' => $towns, 'this_town_id' => $data['town_id'], 'this_town_name' => $data['town_name'], 'town_alph_name' => $data['town_alph_name'])); ?>
                <?php $this->load->view('user/pc/search/store_detail/rel_link_job_type', array('jobs_in_town' => $jobs_in_town)); ?>
            </section>
        <div id="campaingn_bonus_date">
            <div><button onclick="return close_dialog()" id="btnclose" class="j-ui-x-button c_pointer">×</button></div>
            来店日付 <input type="text" id="txtDateFrom" name="daterequest" placeholder="YYYY/MM/DD"><br><br>
        </div>
        <?php $this->load->view('user/pc/template/send_message'); ?>
        </div><!-- // .container -->
    <?php endforeach; ?>
    </section>
<?php $this->load->view('user/pc/share/script'); ?>
<script src="<?php echo base_url().'public/user/pc/'; ?>js/jquery.bxslider.js"></script>
<script>
$(function(){
    /*---------------------------------------*/
    // slider senior
    /*---------------------------------------*/
<?php if (isset($tab_senior_flag) && isset($owner_senior_profile)) :
    $profile_count = count($owner_senior_profile);
        if ($profile_count > 2) :
?>
    $(document).ready(function(){
		if($('#slider_senior .senior_box').length < 4 ){
			$('#slider_senior').bxSlider({
				pager: false,
				auto: false,
				pause: 6000,
				speed: 500,
				infiniteLoop: false
			});
		} else {
			$('#slider_senior').bxSlider({
				pager: false,
				auto: false,
				pause: 6000,
				speed: 500,
				infiniteLoop: true,
			});
		}
    });
<?php   endif;
endif; ?>
    /*---------------------------------------*/
    // slider store banner
    /*---------------------------------------*/
    $(document).ready(function(){
        $('#slider_store_banner').bxSlider({
            pager: true,
            controls: false,
            auto: false,
            pause: 6000,
            speed: 500
        });
    });
});
</script>
