<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/interviewer.css" />
<script type="text/javascript">
    var baseUrl = '<?php echo base_url(); ?>';
    var ors_id = '<?php echo $ors_id; ?>';
    var user_id = '<?php echo (isset($user_id)? $user_id: "" ); ?>';
    var owner_id = '<?php echo $owner_id; ?>';
    var campaign_id = '<?php echo (isset($campaign_id))?$campaign_id:''; ?>';
    var campaignBonusRequestId = '<?php echo (isset($campaignBonusRequest))?$campaignBonusRequest["id"]:''; ?>';
    var getUrl = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/send_message.js?v=20150609" ></script>
<?php if(isset($message)) : ?>
    <div class="center">
        <br /><br /><br />
        <b><?php echo $message; ?></b>
        <br /><br />
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/company_detail.js?v=20150630" ></script>
<input type="hidden" value="<?php echo $stt?>" id="status_scout_spam_id" />
<?php foreach ($company_data as $data) : ?>
    <?php echo $this->load->view('user/template/special_phrase'); ?>
    <?php echo $this->load->view('user/template/send_message', array('user_from_site' => $user_from_site, 'storename' => $data['storename']), true); ?>
    <section class="section section--store cf">
        <ul class="mybreadcrumb">
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>" itemprop="url"><span itemprop="title">TOP</span></a></li>
			<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $data['group_name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $data['city_name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/<?php echo $data['town_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $data['town_name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/<?php echo $data['town_alph_name']; ?>/?cate=<?php echo $data['job_type_alph_name']; ?>" itemprop="url"><span itemprop="title"><?php print_r($data['jobtypename'][0]['name']);?></span></a></li>
        </ul>
        <ul class="mybreadcrumb">
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>" itemprop="url"><span itemprop="title">TOP</span></a></li>

            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo base_url(); ?>jobtype_<?php echo $data['job_type_alph_name']; ?>/" itemprop="url">
            <span itemprop="title"><?php print_r($data['jobtypename'][0]['name']);?></span></a></li>

            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo base_url(); ?>jobtype_<?php echo $data['job_type_alph_name']; ?>/<?php echo $data['group_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $data['group_name']; ?></span></a></li>

            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo base_url(); ?>jobtype_<?php echo $data['job_type_alph_name']; ?>/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $data['city_name']; ?></span></a></li>

            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/<?php echo $data['town_alph_name']; ?>/?cate=<?php echo $data['job_type_alph_name']; ?>" itemprop="url"><span itemprop="title"><?php echo $data['town_name']; ?></span></a></li>
        </ul>
        <div class="store_title">
            <h2><?php echo $company_data[0]['storename'];?></h2>
        </div>
        <div class="slider slider--store_main" id="slider--store_main">
            <ul>
                <li>
                    <figure class="banner">
                        <?php if ($data['main_image'] != 0 && $data['image' . $data['main_image']] ) : ?>
                            <img width="350px" src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$data['main_image']]; ?>" alt="<?php echo $data['storename']; ?>" />
                        <?php else : ?>
                            <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                        <?php endif; ?>
                    </figure>
                </li>
                <?php for ($i = 1; $i<=6; $i++) : ?>
                    <?php if ($data['image'.$data['main_image']] != $data['image'.$i] && $data['image'.$i] != '') : ?>
                    <li>
                        <figure class="banner">
                            <?php if($data['image'.$i] ) : ?>
                                <img width="350px" src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$i]; ?>" alt="<?php echo $data['storename']; ?>" />
                            <?php else : ?>
                                <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                        <?php endif; ?>
                        </figure>
                    </li>
                    <?php endif; ?>
                <?php endfor; ?>
            </ul>
        </div>
        <div class="store_comment">
            <p class="store_treatment"><?php echo (isset($data['salary']) && $data['salary'])?$data['salary']:''; ?></p>
            <p class="store_purpose"><?php echo (isset($data['title']) && $data['title'])?nl2br($data['title']):'';?></p>
        </div>
    </section>
    <?php if ($data['happy_money'] != 0) : ?>
        <section class="section section--celebration">
            <div class="section_inner">
                <div class="celebration_area">
                    <p><?php echo $data['happy_money_type']; ?>お祝い金：<strong><?php echo $data['happy_money']; ?></strong>円</p>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php echo $this->load->view('user/template/store_application', array('apply_email_address' => $hide_apply_emailaddress, 'data' => $data)); ?>
    <?php if (isset($owner_senior_profile) || isset($user_statistics) || isset($owner_working_days) || isset($faq)) : ?>
        <section class="section section--store_tabs cf">
            <div class="section_inner">
                <ul class="tabs_header">
                    <li class="active"><a href="#tabs_senior" id="trigger_senior">教えて先輩</a></li>
                    <li><a href="#tabs_work_flow" id="trigger_flow">1日の流れ</a></li>
                    <li><a href="#" id="trigger_qa">よくある質問</a></li>
                </ul>
                <div class="tabs_body tabs_senior" id="tabs_senior">
                    <?php if (isset($owner_senior_profile)) : ?>
                        <div class="slider slider--store_tabs" id="slider--store_tabs">
                            <ul>
                              <?php foreach ($owner_senior_profile as $value) : ?>
                                  <li>
                                      <dl>
                                          <dt>
                                              <?php if ($value['senior_photo'] && file_exists($value['senior_photo'])) : ?>
                                                  <img src="<?php echo base_url().$value['senior_photo']; ?>"></dt>
                                              <?php else : ?>
                                                  <img src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" />
                                              <?php endif; ?>
                                          <dd>
                                              <p><!--<span class="senior_name"></span>--><span class="senior_age"><?php echo $value['senior_age']; ?>歳</span></p>
                                              <p class="senior_revenue">月収 <?php echo $value['monthly_income']; ?>万円</p>
                                              <p class="senior_shince">勤続<?php echo $value['service_length']; ?>ヶ月</p>
                                              <p class="senior_many">月<?php echo $value['monthly_work_days']; ?>日勤務</p>
                                              <p class="senior_experience">風俗経験：<?php echo $value['work_experience']; ?></p>
                                          </dd>
                                      </dl>
                                      <div class="senior_comment toggle_area">
                                          <p class="more_wrap"><?php echo nl2br($value['comment']); ?></p>
                                          <span class="more_btn short">･･･もっと見る</span>
                                      </div>
                                  </li>
                              <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php if (isset($user_statistics)) : ?>
                            <div class="staff_enrollment">
                              <h3>在籍女性データ</h3>
                              <ul>
                                <?php
                                    $cntr = 10;
                                    $ext = '';
                                    $content_stat ='';
                                    foreach ($user_statistics as $key => $value) : ?>
                                        <?php
                                        if ((end(array_keys($user_statistics)) - 1) == $key) {
                                            $ext = '以上';
                                        }
                                        if ($value['content'] == null) : ?>
                                            <li><span><?php echo $cntr; ?>代<?php echo $ext; ?></span><span><em style="width:<?php echo $value['user_percent']; ?>%;"></em></span><span><?php echo $value['user_percent']; ?>%</span></li>
                                            <?php $cntr += 10; ?>
                                <?php
                                        else:
                                            $content_stat = $value['content'];
                                        endif;
                                    endforeach; ?>
                              </ul>
                              <p><?php echo $content_stat;?></p>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="p_10">現在登録中です。</p>
                    <?php endif; ?>
                </div>
                <div class="tabs_body tabs_work_flow" id="tabs_work_flow">
                    <?php if (isset($owner_working_days)) : ?>
                        <?php if ($owner_working_days[0]['content']) : ?>
                            <div class="work_description toggle_area">
                                <h3>お仕事の説明</h3>
                                <p class="more_wrap"><?php echo nl2br($owner_working_days[0]['content']); ?></p>
                                <span class="more_btn short">･･･もっと見る</span>
                            </div>
                        <?php endif; ?>
                        <?php if (count($owner_working_days) > 0 && $owner_working_days[0]['working_day_description']) : ?>
                            <div class="work_flow">
                                <h3>一日の流れ</h3>
                                <div class="slider slider--tabs_work_flow" id="slider--tabs_work_flow">
                                    <ul>
                                        <?php foreach ($owner_working_days as $key => $value) : ?>
                                            <li>
                                                <dl>
                                                    <dt>
                                                        <?php if($value['working_day_pic'] && file_exists($value['working_day_pic'])) : ?>
                                                            <img src="<?php echo base_url().$value['working_day_pic']; ?>">
                                                        <?php else : ?>
                                                            <img src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" />
                                                        <?php endif; ?>
                                                        <p><?php echo strval($key + 1).'.'; ?></p>
                                                    </dt>
                                                    <dd><p><?php echo $value['working_day_description']; ?></p></dd>
                                                </dl>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($owner_working_days[0]['youtube_embed']) :?>
                            <div class="work_animation">
                                <h3>お仕事動画</h3>
                                <div class="animation_content">
                                    <?php echo $owner_working_days[0]['youtube_embed']; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <p class="p_10">現在登録中です。</p>
                    <?php endif; ?>
                </div>
                <div class="tabs_body tabs_qa" id="tabs_qa">
                    <?php if (isset($faq)) : ?>
                        <div class="toggle_area">
                            <dl class="store_info more_wrap">
                                <?php foreach($faq as $value) : ?>
                                    <dt><span>Q.</span><?php echo nl2br($value['question']); ?></dt>
                                    <dd><span class="answer">A.</span><?php echo nl2br($value['answer']); ?></dd>
                                <?php endforeach; ?>
                            </dl>
                            <span class="more_btn short p_10">･･･もっと見る</span>
                        </div>
                    <?php else: ?>
                        <p class="p_10">現在登録中です。</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if (isset($category_message_num)) : ?>
	<section class="section section--everyone_qa_category pb_10 cf">
		<div class="section_inner">
			<div class="everyone_qa_category">
				<h3 class="section_item_ttl"><img src="<?php echo base_url(); ?>public/user/image/icon_qa.png"><strong>みんなの質問</strong>カテゴリー</h3>
				<ul>
                    <?php foreach($category_message_num as $entry) : ?>
					<li><a class="t_link" href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$entry['id'];?>"><?php echo $entry['name'].'('.$entry['count'].')'; ?> </a></li>
                    <?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>
    <?php endif; ?>
    <?php if (isset($owner_speciality)) : ?>
        <section class="section section--store_different m_t_5 cf">
            <h2 class="ttl_2">当店はここが違う</h2>
            <div class="section_inner">
                <div class="store_different">
                    <dl>
                        <?php if ($owner_speciality['photo']) : ?>
                        <dt>
                            <img src="<?php echo base_url().$owner_speciality['photo']; ?>" />
                        </dt>
                        <?php endif; ?>
                        <dd><?php echo nl2br($owner_speciality['content']); ?></dd>
                    </dl>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <section class="section section--store_info cf">
        <h2 class="ttl_2">風俗求人情報</h2>
        <div class="section_inner">
            <ul class="tabs_header">
                <li class="active"><a link="#store_info" id="trigger_store_info_content">基本情報</a></li>
                <?php if (isset($article) && count($article) > 0) { ?>
                <li><a link="#store_conscription" id="trigger_store_conscription">急募情報</a></li>
                <?php } ?>
            </ul>
            <div class="store_info">
                <div class="tabs_body store_info_content" id="store_info_content">
                    <table>
                        <tr>
                            <th>店舗名</th>
                            <td><?php echo $company_data[0]['storename'];?></td>
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
                                        if ($i<$tam)
                                            echo"、";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>応募資格</th>
                            <td><?php echo nl2br($data['con_to_apply']); ?></td>
                        </tr>
                        <tr>
                            <th>給与</th>
                            <td><?php echo nl2br($data['salary']); ?></td>
                        </tr>
                        <tr>
                            <th>交通</th>
                            <td><?php echo nl2br($data['how_to_access']); ?></td>
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
                            <th>住所</th>
                            <td><?php echo $data['address']?></td>
                        </tr>
                    </table>
                    <div class="ui_btn_wrap">
                        <ul>
                            <li><a id="contact_hp" href="javascript:void(0)" data-href="<?php echo $data['home_page_url']; ?>" class="ui_btn official" rel="nofollow">オフィシャルHP</a></li>
                            <?php if ($data['kuchikomi_url']) : ?>
                                <li><a id="contact_kuchikomi" class="ui_btn reviews" href="javascript:void(0)" data-href="<?php echo $data['kuchikomi_url']; ?>" rel="nofollow">クチコミを見る</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <?php if (isset($article) && count($article) > 0): ?>
                <div class="tabs_body store_conscription" id="store_conscription">
                      <div class="pickup_info">
                          <dl>
                              <dd>
                                  <div class="pickup_info_time">
                                      更新時間 <?php echo date('Y', strtotime($article['post_date']))."年".date('m', strtotime($article['post_date']))."月".date('d', strtotime($article['post_date']))."日(".$article['jap_day'].')'.date('H:i', strtotime($article['c_post_date'])); ?>
                                  </div>
                                  <div class="pickup_info_content info_close"><?php echo nl2br($article['message']); ?></div>
                                  <div class="pickup_info_btn_area">
                                      <p class="pickup_info_btn" id="pickup_info_btn">もっと見る</p>
                                  </div>
                              </dd>
                          </dl>
                      </div>
                  <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php if ( isset($treatments)) : ?>
        <section class="section section--store_treatment cf">
            <div class="section_inner">
                <div class="tags tags--benefit cf">
                    <h3>待遇</h3>
                    <ul>
                        <?php
                        $reg_trment_array = array();
                        if (isset($data['treatment'])) {
                            foreach ($data['treatment'] as $one_reg_trment) {
                                $reg_trment_array[$one_reg_trment['id']] = $one_reg_trment; // set ID to array key
                            }
                        }
                        foreach ($treatments as $treatment) { ?>
                            <li>
                                <img class="tag" src="<?php echo base_url(); ?>public/user/image/tags/treatment/<?php echo isset($reg_trment_array[$treatment['id']]) ? $treatment['id'] . "_on" : $treatment['id'] . "_off"; ?>.png" alt="<?php echo $treatment['name']; ?>">
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if ($data['other_service']) :  ?>
        <section class="section section--store_other_treatment cf">
            <div class="section_inner">
                <div class="store_other_treatment">
                    <h3>その他の待遇</h3>
                    <div class="store_other_content">
                        <p><?php echo nl2br($data['other_service']); ?></p>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if ($data['company_info']) : ?>
        <section class="section section--store_message cf">
            <div class="section_inner">
                <div class="store_message">
                    <h3>店舗からのメッセージ</h3>
                    <div class="store_comment toggle_area">
                        <p class="more_wrap"><?php echo nl2br($data['company_info']); ?></p>
                        <span class="more_btn short">･･･もっと見る</span>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if (isset($user_characters) && isset($reg_user_character) && $reg_user_character) : ?>
        <section class="section section--also_people cf">
            <div class="section_inner">
                <div class="tags tags--benefit cf">
                    <h3>こんな方も大丈夫</h3>
                    <ul>
                        <?php foreach ($user_characters as $key => $character) : ?>
                            <li>
                                <img class="tag" src="<?php echo base_url(); ?>public/user/image/tags/also/<?php echo isset($reg_user_character[$character['id']]) ? 'w'. $character['id'] . "_on" : 'w'. $character['id'] . "_off"; ?>.png" alt="<?php echo $character['name']; ?>">
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if (isset($owner_benefits)) : ?>
        <section class="section section--store_flow cf">
            <div class="section_inner">
                <div class="store_flow toggle_area">
                    <h3>入店までの流れ</h3>
                    <div class="store_comment more_wrap">
                        <?php foreach($owner_benefits as $key => $value) : ?>
                            <h4><?php echo strval($key+1).":".$value['title']; ?></h4>
                            <p><?php echo nl2br($value['content']); ?></p>
                        <?php endforeach; ?>
                    </div>
                    <span class="more_btn short">･･･もっと見る</span>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!--Start of interviewer information-->
    <?php if(isset($interviewer_info)) : ?>
        <section class="section section--store_interview cf">
            <div class="section_inner">
                <div class="store_interview">
                    <h3>私が面接します</h3>
                    <dl>
                        <dt><img src="<?php echo base_url().$interviewer_info['interviewer_photo']?>"></dt>
                        <dd>
                            <h4><?php echo $interviewer_info['interviewer_name']; ?>さん</h4>
                            <ul>
                                <li><span>性別</span><?php echo $interviewer_info['gender']; ?></li>
                                <?php if ($interviewer_info['age']) : ?>
                                    <li><span>年齢</span><?php echo $interviewer_info['age']; ?>歳</li>
                                <?php endif; ?>
                                <?php if ($interviewer_info['hobby']) : ?>
                                    <li><span>趣味</span><?php echo $interviewer_info['hobby']; ?></li>
                                <?php endif; ?>
                            </ul>
                        </dd>
                    </dl>
                    <div class="interview_comment toggle_area">
                        <p class="more_wrap"><?php echo nl2br($interviewer_info['description']); ?></p>
                        <span class="more_btn short">･･･もっと見る</span>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!--end of interviewer information-->
    <?php if ($data['visiting_benefits_title_1'] || $data['visiting_benefits_title_2'] || $data['visiting_benefits_title_3'] || $data['visiting_benefits_title_1'] || $data['visiting_benefits_title_2'] || $data['visiting_benefits_title_3']) : ?>
        <section class="section section--store_privilege cf">
            <div class="section_inner">
                <div class="store_privilege">
                    <h3>ジョイスペ入店特典</h3>
                    <p class="sub_title">ジョイスペを見たとお伝えください</p>
                    <div class="privilege_comment">
                        <?php if ($data['visiting_benefits_title_1']) : ?>
                            <h4>特典1:<?php echo $data['visiting_benefits_title_1']; ?></h4>
                        <?php endif;?>
                        <?php if ($data['visiting_benefits_content_1']) : ?>
                            <p><?php echo $data['visiting_benefits_content_1']; ?></p>
                        <?php endif; ?>
                        <?php if ($data['visiting_benefits_title_1']) : ?>
                            <h4>特典2:<?php echo $data['visiting_benefits_title_2']; ?></h4>
                        <?php endif;?>
                        <?php if ($data['visiting_benefits_content_2']) : ?>
                            <p><?php echo $data['visiting_benefits_content_2']; ?></p>
                        <?php endif; ?>
                        <?php if ($data['visiting_benefits_title_1']) : ?>
                            <h4>特典3:<?php echo $data['visiting_benefits_title_3']; ?></h4>
                        <?php endif;?>
                        <?php if ($data['visiting_benefits_content_3']) : ?>
                            <p><?php echo $data['visiting_benefits_content_3']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php echo $this->load->view('user/template/store_application', array('apply_email_address' => $hide_apply_emailaddress1, 'data' => $data)); ?>
    <?php if (isset($travel_expense) || isset($campaignBonusRequest)) : ?>
        <section class="section section--store_warranty cf">
            <h2 class="ttl_2">ジョイスペ保証</h2>
            <div class="section_inner">
                <div class="store_warranty">
                    <?php if (isset($travel_expense)) : ?>
                        <h3>ジョイスペ交通費保証</h3>
                        <p>ジョイスペから面接交通費<span>「<?php echo $travel_expense_bonus_point; ?>円」</span>を支給！
                        <?php if(isset($owner_travel_expense) && ($user_from_site == 1|| $user_from_site == 2)) : ?>
                        <span>ステップアップキャンペーン除外店舗</span>
                        <?php endif; ?></p>
                        <div class="ui_btn_wrap ui_btn_wrap--center">
                            <ul>
                                <li>
                                    <?php if (isset($request_status) && $request_status == 0) : ?>
                                        <a class="ui_btn ui_btn--rosepink  ui_btn--x_large_liquid" href="javascript:void(0)" id="request_travel_expense">交通費申請</a>
                                    <?php elseif ( isset($request_status) && $request_status == 3 ) : ?>
                                        <a class="ui_btn ui_btn--rosepink  ui_btn--x_large_liquid" href="javascript:void(0)" disabled>交通費済み</a>
                                    <?php else: ?>
                                        <a class="ui_btn ui_btn--rosepink  ui_btn--x_large_liquid" href="javascript:void(0)" disabled>受付終了</a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                        <p>※面接が終わったらボタンを押してください。</p>
                    <?php endif; ?>
                    <?php if( isset($campaignBonusRequest)) : ?>
                        <h3>ジョイスペ体験入店保証</h3>
                        <p>ジョイスペから体験入店保証<span>「<?php echo $bonus_money; ?>円」</span>を支給！</p>
                        <div class="ui_btn_wrap ui_btn_wrap--center">
                            <ul>
                                <li>
                                  <?php if ( isset($requestCampaignStatus)  && $requestCampaignStatus == 0) : ?>
                                      <?php if (isset($ckdecline) && $ckdecline == true) { ?>
                                          <a class="ui_btn ui_btn--rosepink  ui_btn--x_large_liquid" href="javascript:void(0)" id="request_campaingn_bonus_date" disabled>体験入店申請済み</a>
                                      <?php } else { ?>
                                          <a class="ui_btn ui_btn--rosepink  ui_btn--x_large_liquid" href="javascript:void(0)" id="request_campaingn_bonus_date">体験入店申請</a>
                                      <?php } ?>
                                  <?php  elseif ( isset($requestCampaignStatus) && $requestCampaignStatus == 3 ) : ?>
                                      <a class="ui_btn ui_btn--rosepink  ui_btn--x_large_liquid" href="javascript:void(0)" disabled>体験入店申請済み</a>
                                  <?php else : ?>
                                      <a class="ui_btn ui_btn--rosepink  ui_btn--x_large_liquid" href="javascript:void(0)" disabled>受付終了</a>
                                  <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if (count($towns) > 1) :?>
    <section class="section section--peripheral_area cf">
        <h2 class="ttl_2">周辺エリア</h2>
        <div class="section_inner">
            <div class="peripheral_area">
                <ul>
                    <?php foreach ($towns as $key_id => $field) : ?>
                        <?php if ($data['town_id'] != $field['id']) :?>
                            <li><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/<?php echo $field['alph_name']; ?>/"><?php echo $field['name']; ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
    <?php endif;?>
<?php endforeach; ?>
<div id="campaingn_bonus_date" style="display: none;">
    <div><button onclick="return close_dialog()" id="btnclose" class="j-ui-x-button c_pointer">×</button></div>
    来店日付 <input type="text" id="txtDateFrom" name="daterequest" placeholder="YYYY/MM/DD"><br><br>
</div>
<section class="section section--store_keep cf" id="scroll_top">
    <div class="ui_btn_wrap">
        <ul>
            <li>
                <?php if ($data['keepstt']==0) : ?>
                    <a class="ui_btn keep" href="<?php echo base_url() . "user/keep/index/" . $data["ors_id"]; ?>/">この求人をキープ</a>
                <?php else : ?>
                    <a class="ui_btn keep" href="<?php echo base_url() . "user/keep/keep_clear/" . $data["ors_id"]; ?>/">キープからはずす</a>
                <?php endif; ?>
            </li>
            <li class="job_menu" id="deny_scout_id">
                <a class="ui_btn denial" href="<?php echo base_url()."user/denial/index/".$data['ors_id']?>">スカウトを拒否</a>
            </li>
            <li class="job_menu" id="cancel_deny_scout_id">
                <a class="ui_btn denial" href="<?php echo base_url()."user/denial/not_denial/".$data['ors_id']?>">スカウトが拒否状態です</a>
            </li>
        </ul>
    </div>
</section>
