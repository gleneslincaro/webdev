<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/jquery-ui_new.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/interview-report.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url() ?>public/owner/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/owner/js/index.js"></script>
<div class="ta-right">ようこそ　<span class="bold"><?php echo $owner['storename']; ?></span>　様</div>
<div class="crumb">TOP ＞</div>
<!--
<div class="owner-box"><?php echo $owner['storename']; ?>　様　ポイント：<?php echo number_format($owner['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="settlement" target="_blank">ポイント購入</a></div><br >
-->
<!-- 先週登録したユーザー数・累計登録人数 -->
<br/>
<?php if($owner['email_error_flag'] == 1): ?>
<p><a style="width: 100%;text-align: left;margin: 0 0 20px 0;margin: 0;color: red;" href="<?php echo base_url(); ?>owner/company/">お問合せ通知のメールアドレスを変更してください</a></p>
<?php endif; ?>
<div id="interview-report-wrap">
	<ul id="interview-report">
		<li id="interview-col1">
			<div id="col1-header">会員登録数</div>
			<div id="inflow-data-col1">
				<table cellspacing="0" cellpadding="0" border="0" id="inflow-tbl1" class="inflow-tbl">
					<tbody><tr>
						<td>
							<span class="label-black">累計登録人数</span><br>
							<span class="to-right"><span class="label-orange"><?php echo $totalUserNo; ?></span><span class="person">人</span></span>
						</td>
					</tr>
					<tr>
						<td>
							<span class="label-black">今日</span>
							<span class="to-right"><span class="label-orange"><?php echo $todayRegisteredUser; ?></span><span class="label-black">人</span></span>
						</td>
					</tr>
					<tr>
						<td>
							<span class="label-black">昨日</span>
							<span class="to-right"><span class="label-orange"><?php echo $yesterdayRegisteredUser; ?></span><span class="label-black">人</span></span>
						</td>
					</tr>
				</tbody></table>
			</div>
		</li>

		<li id="interview-col2">
        <div id="col2-header">面接報告</div>
        <div id="inflow-data-col2">
        <?php if(isset($interviewreport) && count($interviewreport) > 0):?>
            <table cellspacing="0" cellpadding="0" border="0" class="inflow-tbl" id ="inflow-tbl2">
                <?php foreach($interviewreport as $report):?>
                <tr>
                    <td>
                        <span class="date"><?php echo $report['interview_date']?></span> <br/>
                        <span class="label-orange"><?php echo substr($report['user_unique_id'],0,2).str_repeat('*',strlen(mb_substr($report['user_unique_id'],2,strlen($report['user_unique_id']))))?></span>
                        <span class="label-black">さんが面接をしました</span>
                    </td>
                </tr>
                <?php endforeach;?>
            </table>
            <?php else:?>
            <p class="no-fetch-data"></p><center>現在、面接報告がありません。</center><p></p>
        <?php endif;?>
        </div>
		</li>

		<li id="interview-col3">
        <div id="col3-header">支給金額</div>
        <div id="inflow-data-col3">
            <?php if ($campaignMonth && $totalTravelExpense && $totalTrialWorkExpense) : ?>
            <table cellspacing="0" cellpadding="0" border="0" id="travel-tbl" class="inflow-tbl">
                <tbody>
                    <tr>
                        <th><span class="label-orange"><?php echo $campaignMonth; ?>月度現在</span></th>
                    </tr>
                    <tr>
                        <td>
                            <span class="label-black">面接交通費</span> <br>
                            <span class="to-right">
                                <span class="label-orange"><?php echo $totalTravelExpense; ?></span>
                                <span class="label-black">円</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="label-black">入店お祝い金</span> <br>
                            <span class="to-right">
                                <span class="label-orange"><?php echo $totalTrialWorkExpense; ?></span>
                                <span class="label-black">円</span>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php else:?>
            <p class="no-fetch-data"><center>現在、集計中です。</center></p>
            <?php endif;?>
        </div>
		</li>
    <?php if($getOwnerDisplayCampaign) : ?>
		<li id="interview-col4">
			<div id="col4-header">お知らせ</div>
			<div id="inflow-data-col4">
        <?php foreach ($getOwnerDisplayCampaign as $key) :?>
				<dl>
					<dt class="interview-<?php echo $key['status']; ?>">
              <?php
                  switch ($key['status']) {
                      case 1:
                          echo '開催中';
                          break;
                      case 2:
                          echo '準備中';
                          break;
                      case 3:
                          echo '終了';
                          break;
                      default:
                          break;
                  }
              ?>
                    </dt>
					<dd>
						<p><a href="<?php echo $key['link']; ?>" target="_blank"><?php echo $key['campaign_name']; ?></a></p>
						<p><?php echo $key['period_start']; ?> ~ <?php echo $key['period_end']; ?></p>
					</dd>
				</dl>
        <?php endforeach; ?>
			</div>
		</li>
    <?php endif; ?>
	</ul>
</div>
<?php if ( isset($step_up_campaign_flag) && $step_up_campaign_flag ) : ?>
<!--会員誘導強化-->
    <div class="index_campaign_stepup">
	<!--キャンペーンある時ここにバナー -->
<!-- バナー告知
<div class="list-box" style="width:883px;margin:-25px auto 60px;border:solid 1px #CCC;">
        <img src="<?php echo base_url(); ?>public/owner/images/campaign/bunner01.jpg">
</div>
-->
    </div>
<?php endif; ?>
<!--<div class="cm-wrapper">
  <div class="cm-contents-wrapper">-->
    <!--<img src="<?php echo base_url(); ?>public/owner/images/demodemo.png">-->
    <!--<div class="cm-title">業界No.1の登録数!!</div>
    <div class="cm-text">新規ユーザー獲得に力を入れています！</div>
    <div class="total">累計登録人数<span><?php echo $totalUserNo; ?></span><span style="font-size:50px;color:#555555;padding-left:0;">人</span></div>
  </div>
</div>-->

<!-- 面接交通費申請報告 -->
<div class="list-box"><!-- list-box ここから -->
  <?php if ( isset($travelExpenseRequest) && count($travelExpenseRequest) > 0 ) { ?>
    <div class="list-title">■面接交通費申請報告(会員が実際に面接に来た後に承認ボタンを押してください。ジョイスペが負担)</div>
    <div class="contents-box-wrapper">
        <table class="list user_apply">
            <tr>
                <th>面接日付</th><th>申請日付</th><th>ID</th><th>写真</th><th>年齢</th><th>身長</th> <th>スリーサイズ</th><th>送受信履歴</th><th>承認ボタンを表示</th>
            </tr>
            <?php foreach ($travelExpenseRequest as $key => $value) { ?>
            <tr>
                <td><?php echo date('Y-m-d',strtotime($value['interview_date'])); ?></td>
                <td><?php echo $value['requested_date']; ?></td>
                <td><?php echo $value['unique_id']; ?></td>
                <td><?php
                $data_from_site = $value['user_from_site'];
                if ( $value['profile_pic'] ){
                    $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                    if ( file_exists($pic_path) ){
                        $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                    }else{
                        if ( $data_from_site == 1 ){
                            $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                        }else{
                            $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                        }
                    }
                    echo "<img class='user-image' src='".$src."' alt='写真' height='90'>";
                }else{
                    echo "<img class='user-image' src='".base_url()."/public/user/image/no_image.jpg' alt='写真' width='120px' height='90'>";
                }
            ?>
                </td>
                <td><?php echo $value['ageName1']."~".$value['ageName2']; ?></td>
                <td><?php echo $value['height_l']."~".$value['height_h']; ?></td>
                <td><?php echo "B".$value['bust'] . " W". $value['waist']. " H". $value['hip']; ?></td>
                <td><a style="color:#000" href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['user_id'].'/1#msghistory' ?>">送受信履歴</a></td>
                <td>
                    <button data-id="<?php echo $value['id']?>" data-approval_val="1">承認</button>
                    <button data-id="<?php echo $value['id']?>" data-approval_val="2">非承認</button>
                </td>
            </tr>
          <?php } ?>
        </table>
    </div><!-- / .contents-box-wrapper -->
  <?php } ?>
</div><!-- list-box ここまで -->
<?php if ( isset($masterCampaignRequest) && count($masterCampaignRequest) > 0 ) { ?>
<div class="list-box">
    <div class="list-title">■体験入店保証申請報告（会員が実際に体験入店、入店が実際にあった場合に承認をしてください。ジョイスペが負担）</div>
    <div class="contents-box-wrapper">
    <table class="list user_request_bunos" style="margin: 10px auto 30px;">
        <tr>
            <th>来店日付</th><th>申請日付</th><th>ID</th><th>写真</th><th>年齢</th><th>身長</th> <th>スリーサイズ</th><th>承認ボタンを表示</th>
        </tr>
        <?php foreach ($masterCampaignRequest as $key) { ?>
        <tr>
            <td><?php echo $key['visit_owner_office_date']; ?></td>
            <td><?php echo $key['requested_date']; ?></td>
            <td><?php echo $key['unique_id']; ?></td>
            <td><?php
            $data_from_site = $key['user_from_site'];
            if ( $key['profile_pic'] ){
                $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$key['profile_pic'];
                if ( file_exists($pic_path) ){
                    $src = base_url().$this->config->item('upload_userdir').'images/'.$key['profile_pic'];
                }else{
                    if ( $data_from_site == 1 ){
                        $src = $this->config->item('machemoba_pic_path').$key['profile_pic'];
                    }else{
                        $src = $this->config->item('aruke_pic_path').$key['profile_pic'];
                    }
                }
                echo "<img class='user-image' src='".$src."' alt='写真' height='90'>";
            }else{
                echo "<img class='user-image' src='".base_url()."/public/user/image/no_image.jpg' alt='写真' width='120px' height='90'>";
            }
        ?>
        </td>
        <td><?php echo $key['ageName1']."~".$key['ageName2']; ?></td>
        <td><?php echo $key['height_l']."~".$key['height_h']; ?></td>
        <td><?php echo "B".$key['bust'] . " W". $key['waist']. " H". $key['hip']; ?></td>
        <td>
            <button data-id_req="<?php echo $key['id']?>" data-reqapproval_val="1">承認</button>
            <button data-id_req="<?php echo $key['id']?>" data-reqapproval_val="2">非承認</button>
        </td>
      </tr>
      <?php } ?>
    </table>
    </div>
</div>
<?php } ?>
<!-- 新着ユーザー -->
<div class="list-box"><!-- list-box ここから -->

<div class="list-title">新着ユーザー</div>
<div class="contents-box-wrapper">
    <div class="list-title-box-top">
    	<div class="list-t-right">
    		<a href="<?php echo base_url(); ?>owner/history/history_app_message_temp" target="_blank"><img class="link_icon" src="<?php echo base_url(); ?>public/owner/images/link_icon.png" width="23" height="23" alt="リンクアイコン">テンプレート確認</a>
    	</div>
    </div>
    <div class="scout-mail-wrapper">
        <div class="scout-mail-text">

            <div class="ribbon">

                <h2>本日送信可能スカウトメール　<span><?php echo $owner['remaining_scout_mail']; ?></span>通</h2>

            </div>

        </div>
        <p>
        ※1日のスカウトメール送信上限は<?php echo $owner['default_scout_mails_per_day']; ?>通となります。(送信数は毎朝5時に更新されます)<br>
        ※ジョイスペでは個人情報の保護の観点からユーザー名は独自ＩＤで管理しております。<br>
        ※ユーザーの表示は登録またはログイン順に表示されています。
        </p>
    </div>
    <div class="help-wrapper">
	    <div class="prf_help">
	        <div class="hint-wrapper">
	    		<img class="hint-img" src="<?php echo base_url(); ?>public/owner/images/hint.png" width="221" height="104" alt="ヒント">

		    	<ul class="hint-list">
		        	<li><a href="<?php echo base_url(); ?>owner/help#reply">返信をもらうには</a></li>
		        	<li><a href="<?php echo base_url(); ?>owner/help#profile">プロフィールの項目について</a></li>
		        	<li><a href="<?php echo base_url(); ?>owner/help/scoutmail">スカウトメール作成講座</a></li>
		        </ul>
		    	<ul class="hint-list">
		        	<li><a href="<?php echo base_url(); ?>owner/help#resend">再送信について</a></li>
		        	<li><a href="<?php echo base_url(); ?>owner/help#increase">より開封率をあげるには</a></li>
		        </ul>
	        </div>
	    </div>
    </div>

    <div id="dialog-confirm">
        <p>一覧から非表示にしますか？</p>
	</div>

    <div id="dialog-list_of_hide_users">
        <p></p>
    </div>

    <?php if (count($newUser) > 0) { ?>

	<?php if (count($newUser) > 1): ?>
        <div class="sort_area">
            <?php $this->load->view('user_sort'); ?>
            <a class="hide-text" href="javascript:void(0)" id="show_list_of_hide_users">非表示を戻す</a>
        </div>
    <?php endif; ?>

        <form id="sendScout" action="<?php echo base_url(); ?>owner/history/history_app_scout" method="post" onsubmit="return check();">
        <div class="img-prof in_new">
        <?php
            $this->load->view('index/list_of_users.php');
        ?>        
        </div>
        <?php
            $this->load->view('index/user_popup.php');
        ?>        
        <br>
        <div align="center">
            <?php if ( $owner['remaining_scout_mail'] <= 0 ){ ?>
            <input type="submit" value="スカウト送信" disabled style="width:160px; height:40px;">
            <center>本日送信可能スカウトメールは0通です</center>
            <?php } else { ?>
            <input type="submit" value="スカウト送信" style="width:160px; height:40px;">
            <?php } ?>
        </div>
        <input type="hidden" id="_sendScout" name="_sendScout" value="1">
        <input type="hidden" id="hdPage" name="hdPage" value="1">
        <input type="hidden" id="sortUsers" name="sortUsers" value="">
        <input type='hidden' id="sendlimit" name='sendlimit' value='<?php echo $owner['remaining_scout_mail']; ?>'>
        </form>
        <div class="list-title-box-bottom"><div class="list-t-right"><a href="<?php echo base_url() . 'owner/scout/scout_after' ?>"><img class="link_icon" src="<?php echo base_url(); ?>public/owner/images/link_icon.png" width="23" height="23" alt="リンクアイコン">もっとみる</a></div></div>
    <?php } else { ?>
        <div class="list-t-center">
            <font color="#ff0000">
            現在、対象のデータがありません。</font>
            <img src="<?php echo base_url(); ?>public/owner/images/newcandidatesample.jpg">
        </div>
    <?php } ?>
</div><!-- / .contents-box-wrapper -->
</div><!-- list-box ここまで -->

<!-- 新着応募ー -->
<!--<div class="list-box">--><!-- list-box ここから -->
<!--
    <div class="list-title">面接完了報告（48時間後から勤務申請を受け付けます。）</div>

    <?php if (count($userApply) > 0) { ?>
        <br>
        <form id="userApply" name="userApply" method="POST" action="<?php echo base_url(); ?>owner/history/history_app_action_conf">
            <table class="list">
                <tr>
                    <th>ID</th><th>写真</th><th>地域</th><th>年齢</th> <th>採用金額（円）</th><th>面接完了報告時間</th>
                </tr>
                <?php foreach ($userApply as $key => $value) { ?>

                    <tr>
                        <td><?php echo $value['unique_id']; ?></td>
                        <td><?php
                        $data_from_site = $value['user_from_site'];
                        if ( $value['profile_pic'] ){
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                            if ( file_exists($pic_path) ){
                                $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                            }else{
                                if ( $data_from_site == 1 ){
                                    $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                                }else{
                                    $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                                }
                            }
                            echo "<img class='user-image' src='".$src."' alt='写真' height='90'>";
                        }else{
                            echo "<img class='user-image' src='".base_url()."/public/user/image/no_image.jpg' alt='写真'
                                        width='120px' height='90'>";
                        }
                        ?>
                        </td>
                        <td><?php echo $value['cityname']; ?></td>
                        <td><?php echo $value['name1']."~".$value['name2']; ?></td>
                        <td><?php echo number_format($value['joyspe_happy_money']); ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($value['apply_date'])); ?></td>
                    </tr>

    <?php } ?>

            </table>

            <div class="list-title-box-bottom"><div class="list-t-right"><a href="<?php echo base_url(); ?>owner/history/history_app"><img class="link_icon" src="<?php echo base_url(); ?>public/owner/images/link_icon.png" width="23" height="23" alt="リンクアイコン">もっとみる</a></div></div>
        </form>
<?php } else { ?>
        <div class="list-t-center">
            <font color="#ff0000">
                <span style="font-size: 12pt;">
            現在、対象のデータがありません。</span></font><br >
            <img src="<?php echo base_url(); ?>public/owner/images/appdescripsample.jpg">
        </div>

<?php } ?>
</div>--><!-- list-box ここまで -->

<!-- 勤務確認 -->
<!--<div class="list-box">--><!-- list-box ここから -->
<!--
    <div class="list-title">勤務確認（お祝い金・承認確認）</div><br >
    <?php if (count($appMoney) > 0) { ?>

        <table class="list">
            <tr>
                <th>ID</th><th>写真</th><th>地域</th><th>年齢</th><th>応募時間</th><th>勤務申請</th><th>勤務確認</th>
            </tr>
            <?php foreach ($appMoney as $key => $value) { ?>
                <tr>
                    <td><?php echo $value['unique_id']; ?></td>
                    <td><?php
                        $data_from_site = $value['user_from_site'];
                        if ( $value['profile_pic'] ){
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                            if ( file_exists($pic_path) ){
                                $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                            }else{
                                if ( $data_from_site == 1 ){
                                    $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                                }else{
                                    $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                                }
                            }
                            echo "<img class='user-image' src='".$src."' alt='写真' height='90'>";
                        }else{
                            echo "<img class='user-image' src='".base_url()."/public/user/image/no_image.jpg' alt='写真'
                                        width='120px' height='90'>";
                        }
                    ?>
                    </td>
                    <td><?php echo $value['cityname']; ?></td>
                    <td><?php echo (($value['name1']!= 0)? $value['name1'] : '')  . '?' . (($value['name2']!= 0)? $value['name2'] : '') ?></td>
                    <td><?php echo date('Y/m/d H:i', strtotime($value['apply_date'])); ?></td>
                    <td><?php echo date('Y/m/d H:i', strtotime($value['request_money_date'])); ?></td>
                    <td>
                        <button onclick="location.href = '<?php echo base_url() . 'owner/history/history_app_work/' . $value['id'] . '/' . $value['owner_recruit_id'] ?>'"type="button">確認ページ
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <div class="list-title-box-bottom"><div class="list-t-right"><a href="<?php echo base_url(); ?>owner/history/history_work"><img class="link_icon" src="<?php echo base_url(); ?>public/owner/images/link_icon.png" width="23" height="23" alt="リンクアイコン">もっとみる</a></div></div>

    <?php } else { ?>

        <div class="list-t-center">
            <font color="#ff0000">
                <span style="font-size: 12pt;">
            現在、対象のデータがありません。</span></font><br >
            <img src="<?php echo base_url(); ?>public/owner/images/celebrationsample.jpg">
        </div>

    <?php } ?>

</div>--><!-- list-box ここまで -->

<!-- お知らせ -->
<div class="list-box"><!-- list-box ここから -->
    <div class="list-title">お知らせ</div>
    <div class="contents-box-wrapper">
    <?php if (count($news) > 0) { ?>
        <table class="news">
        <?php foreach ($news as $key => $value) { ?>
            <tr>
                <td >
                    <div class="news-title" style="word-wrap: break-word;"><?php echo date('Y/m/d', strtotime($value['created_date'])) . '&nbsp' . $value['title']; ?></div>
                    <div style="word-wrap: break-word; margin: 15px;"><?php echo $value['content']; ?></div>
                </td>
            </tr>
        <?php } ?>
        </table>
    <?php } else { ?>
        <div class="list-t-center">
            <font color="#ff0000">
            現在、対象のデータがありません。</font>
        </div>
    <?php } ?>
        <div class="list-title-box-bottom">
            <div class="list-t-right">
                <a href="news"><img class="link_icon" src="<?php echo base_url(); ?>public/owner/images/link_icon.png" width="23" height="23" alt="リンクアイコン">もっとみる</a>
            </div>
        </div>
    </div><!-- / .contents-box-wrapper -->
</div><!-- list-box ここまで -->
<?php
    $this->load->view('index/wait_for_sort');
?>