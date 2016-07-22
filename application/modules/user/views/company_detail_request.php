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
        <div class="store_title">
            <h2><?php echo $company_data[0]['storename'];?></h2>
        </div>
    </section>
    <section class="section section--store_info cf">
        <h2 class="ttl_2">風俗求人情報</h2>
        <div class="section_inner">
            <ul class="tabs_header">
                <li class="active"><a link="#store_info" id="trigger_store_info_content">基本情報</a></li>
            </ul>
            <div class="store_info">
                <div class="tabs_body store_info_content" id="store_info_content">
                    <table>
                        <tbody>
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
                        </tbody>
                    </table>
                    <div class="ui_btn_wrap">
                        <ul>
                            <li><a href="<?php echo base_url()?>owner/top" class="ui_btn" style="background: #2bc1e0;color: #fff !important;border:none;box-shadow: 0 2px 2px 0 rgba(0,0,0,0.2);">店舗オーナー様はコチラ！</a></li>
                        </ul>
                    </div>
                    <div class="top_info_2_desc" style="padding:0 10px 10px;">
                        <p>コチラの店舗様の情報はユーザー様のリクエストによる情報です。あくまでも参考としてご活用ください。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section style="background-color: #F3F3F3;" class="section section--access cf">
        <h2 class="ttl_2">現在のアクセス数</h2>
        <div style="padding: 5px;" class="section_inner">
            <div style="padding: 14px;border: solid 1px #ccc;border-radius: 5px;background-color: #fff;" class="access_area">
                <p class="t_center"><strong style="font-weight:bold;"><?php echo $count_log;?></strong></p>
            </div>
        </div>
    </section>
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
<div id="campaingn_bonus_date">
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
