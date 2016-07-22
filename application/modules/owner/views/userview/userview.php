<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/themes/light/light.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/themes/dark/dark.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/themes/bar/bar.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/user/css/jquery-bxslider.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/user/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/user/css/component.css?v=20150512" />
<script type="text/javascript" src="<?php echo base_url();?>public/user/js/jquery.bxslider.js"></script>
<script type="text/javascript">
  $(function(){
        // slider
        $('#slider--shop_main > ul').bxSlider({
            controls: false
        });
    });

  $(document).ready(function() {
    $("#th5").addClass("visited");
    showMoreText();

    function showMoreText() {
      var slideHeight = 330;
      var defHeight = $('.show-more').height();
      if(defHeight >= slideHeight){
        addShowMore(slideHeight, defHeight);
      }
    }

    function addShowMore(slideHeight, defHeight) {
      $('.show-more').css('height' , '330px');
      $('#read-more').append('<a href="#"><button>もっと見る</button></a>');
      $('#read-more').css('padding', '8px 0');
      $('#read-more a').css('text-decoration', 'none');
      $('#read-more a').click(function(){
        var curHeight = $('.show-more').height();
        if(curHeight == slideHeight){
          showMoreDisplay(defHeight);
        }else{
          hideMoreDisplay(slideHeight);
        }
        return false;
      });
    }

    function showMoreDisplay(defHeight) {
      $('.show-more').animate({
        height: defHeight
      }, "fast");
    }

    function hideMoreDisplay(slideHeight) {
      $('.show-more').animate({
        height: slideHeight
      }, "fast");
    }

    $(window).resize(function() {
      var defHeight = $('.show-more').height();
      if(defHeight > 330) {
        if($("#read-more:has(a)").length == 0) {
          addShowMore(330, defHeight);
        }
        else {
          $('#read-more a').remove();
          addShowMore(330, defHeight);
        }
        $('#read-more').show();
      }
      else {
        $('#read-more').hide();
        hideMoreDisplay(defHeight);
      }
    });

  });
  function show(inputData) {
    var objID=document.getElementById( "layer_" + inputData );
    var buttonID=document.getElementById( "category_" + inputData );
    if(objID.className=='close') {
      objID.style.display='block';
      objID.className='open';
    }else{
      objID.style.display='none';
      objID.className='close';
    }
  }
</script>

<style>
.section--store .ttl_shop_name{background-color:#FF0D59;font-size:16px;font-size: 1.6rem;font-weight:bold;color: #fff;padding: 10px 2%;}
.store_comment{background-color:#fef5e6;border-top:solid 2px #FF0D59;border-bottom:solid 2px #FF0D59;padding:12px 8px;font-weight:bold;font-size:14px;}
.section--store .store_detail table{font-weight: bold;border-collapse: separate;border: solid 2px #0dbf84;background: #0dbf84;color:#555;}
.section--store .store_detail table caption{background-color: #0DBF85;padding: 12px 0;color: #fff;font-size: 16px;border: solid 1px #0dbf84;}
.section--store .store_detail table tr{outline: 1px solid #0dbf84;background: #0dbf84;position:relative;}
.section--store .store_detail table th{padding: 12px 8px;color: #fff;border-bottom: solid 3px #fff;font-size:14px;border-left: solid 2px #fff;border-top: solid 3px #fff;border-top: solid 3px #fff;vertical-align:middle;}
.section--store .store_detail table tr:first-child th{border-top:solid 2px #fff;}
.section--store .store_detail table tr:last-child th{border-bottom:solid 2px #fff;}
.section--store .store_detail table td{background: #fff;padding:12px 13px;vertical-align:middle;font-size:14px;}
.section--store .store_detail table .store_pr{color:#555;font-weight:normal;}
.section--store .store_data_wrap .tags .tag{width:73px;height:33px;}
.section--store .store_info .store_app dl{border:solid 1px #0dbf84;}
.section--store .store_info .store_app dt{background-color:#0dbf84;font-color:#fff;font-weight:bold;text-align:center;padding:12px 0;color:#fff;font-size:16px;}
.section--store .store_info .store_app dd{padding:12px -10px 5px;}
.section--store .store_info .store_app img{vertical-align:middle;margin-right:10px;display:inline-block;}

#line_chat {
    border : 0px;
    color:#1EB61D;
}
.tags ul li {
    list-style:none;
}
.tags {
    margin-left:-4%;
}
.ui_btn_wrap  a {
    text-decoration: none;
}
#app_button li {
    box-sizing: border-box;
    margin: -2rem 0 0;
    width: 100%;
}
.contact {
    margin-left:-4%;
}
</style>

<div class="crumb">TOP ＞ ユーザービュー</div>
<!--
<div class="owner-box"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a></div><br >
-->
<div class="list-box"><!-- list-box ここから -->
	<div class="list-title">ユーザービュー 【ユーザー様側（求職者）から見た表示画面です。】</div>
    <div class="pagebody">
        <div class="pagebody_inner cf">
            <?php foreach ($company_data as $data) { ?>
            <section class="section section--store cf">
                <h2 class="ttl_shop_name mb_10"><?php echo $company_data[0]['storename'];?></h2>
                <div class="slider slider--shop_main" id="slider--shop_main">
                    <ul>
                        <li>
                            <figure class="banner">
                                <?php if($data['main_image'] != 0 && $data['image' . $data['main_image']] ): ?>
                                    <img width="350px" src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$data['main_image']]; ?>" alt="<?php echo $data['storename']; ?>" />
                                <?php else: ?>
                                    <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                                <?php endif; ?>
                            </figure>
                        </li>
                        <?php for($i = 1; $i<=6; $i++) : ?>
                            <?php if ($data['image'.$data['main_image']] != $data['image'.$i] && $data['image'.$i] != '') : ?>
                            <li>
                                <figure class="banner">
                                    <?php if($data['image'.$i] ): ?>
                                        <img width="350px" src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$i]; ?>" alt="<?php echo $data['storename']; ?>" />
                                    <?php else: ?>
                                        <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                                <?php endif; ?>
                                </figure>
                            </li>
                            <?php endif; ?>

                        <?php endfor; ?>
                    </ul>
                </div>
                <?php if (isset($data['title']) && $data['title']) { ?>
                <div class="store_comment mb_15">
                    <?php echo nl2br($data['title']) ?>
                </div>
                <?php } ?>
                <div class="shop_detail_data_wrap">
                    <section class="section section--store cf">
                        <div class="box_inner">
                            <div class="store_data_wrap">
                                <div class="store_deta">
                                    <div class="store_detail">
                                        <table width="100%" border="0" cellspacing="0">
                                            <caption>風俗求人情報</caption>
                                            <tr>
                                                <th class="table_top">業種</th>
                                                <td><?php
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
                                                <th>地域</th>
                                                <td>
                                                    <?php if($data['group_name']) : ?>
                                                        <?php echo $data['group_name'].' / '.$data['city_name'].' / '.$data['town_name']; ?>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>勤務地</th>
                                                <td><?php echo $data['work_place'] ?></td>
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
                                            <tr>
                                                <td colspan="2" class="store_pr">
                                                    <?php echo nl2br($data['company_info']);?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br/>
                                    <div class="store_system mt_15">
                                        <div class="tags tags--benefit cf">
                                            <ul>
                                                <?php foreach ($data['treatment'] as $t) : ?>
                                                <li><img class="tag" src="<?php echo base_url().'public/user/image/treatment/'.$t['id'].'.png'; ?>" alt="<?php echo $t['name']; ?>" /></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ui_btn_wrap ui_btn_wrap--center mt_20 cf bl_b_1 pb_30">
                                        <ul>
                                          <li><a id="contact_hp" class="ui_btn ui_btn--rosepink ui_btn--bg_rosepink ui_btn--x_large_liquid ui_btn_fav" href="javascript:void(0)">オフィシャルHP</a></li>
                                          <li> <a id="contact_kuchikomi" class="ui_btn ui_btn--symphonyblue ui_btn--bg_symphonyblue ui_btn--x_large_liquid ui_btn_fav" href="javascript:void(0)" >クチコミを見る</a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="store_info">
                                <div class="store_app">
                                    <dl>
                                        <dt><span>応募用連絡先</span></dt>
                                        <dd>
                                            <div class="contact cf">
                                                <?php if($data['apply_time']) : ?>
                                                <p>受付時間 / <?php echo $data['apply_time']; ?><br><em class="c_rosepink">「ジョイスペを見た」</em>というとスムーズです。</p>
                                                <?php endif; ?>
                                                <div class="ui_btn_wrap ui_btn_wrap--center cf" id = 'app_button'>
                                                    <ul>
                                                        <li>
                                                            <?php if($data['apply_tel']) : ?>
                                                            <p class="ui_btn ui_btn--rosepink ui_btn--x_large_liquid">
                                                                <a href="javascript:void(0)"?>
                                                                    <span class="icon_wrap"><span class="icon--phone">
                                                                        <img src="<?php echo base_url(); ?>public/user/image/icon_phone.png"></span>
                                                                        電話で応募する
                                                                    </span>
                                                                </a>
                                                            </p>
                                                            <?php endif; ?>
                                                        </li>
                                                        <li>
                                                            <p class="ui_btn ui_btn--symphonyblue ui_btn--x_large_liquid">
                                                                  <span id="e350524902">
                                                                      <a href="javascript:void(0)">
                                                                          <span class="icon_wrap">
                                                                              <span class="icon--mail">
                                                                                  <img src="<?php echo base_url()?>public/user/image/icon_mail.png">
                                                                              </span>
                                                                              メールで応募する
                                                                          </span>
                                                                      </a>
                                                                  </span>
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <?php if($data['line_id']) : ?>
                                                            <p class="ui_btn ui_btn--glassgreen ui_btn--x_large_liquid">
                                                                 <span class="icon_wrap">
                                                                        <span class="icon--chat">
                                                                            <img src="<?php echo base_url(); ?>public/user/image/icon_chat.png">
                                                                        </span>
                                                                        <input id="line_chat" href="javascript:void(0)" value="<?php echo $data['line_id']?>" onfocus="this.selectionStart=0; this.selectionEnd=this.value.length;" onmouseup="return false" >

                                                                </span>
                                                             </p>
                                                            <?php endif; ?>
                                                        </li>
                                                        <li>
                                                            <p class="ui_btn ui_btn--purple ui_btn--x_large_liquid">
                                                                <a href="javascript:void(0)" ><span class="icon_wrap t_center">匿名質問</span></a>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="ui_btn_wrap ui_btn_wrap--center mt_30 mb_30 cf">
                                <ul>
                                    <li>
                                        <?php if ($data['keepstt']==0): ?>
                                        <a class="ui_btn ui_btn--orange ui_btn--bg_orange ui_btn--x_large_liquid" href="javascript:void(0)">この求人をキープする</a>
                                        <?php else: ?>
                                        <a class="ui_btn ui_btn--gray ui_btn--x_large_liquid" href="javascript:void(0)">キープからはずす</a>
                                        <?php endif; ?>
                                    </li>
                                    <li class="job_menu" id="deny_scout_id">
                                        <a class="ui_btn ui_btn--denial ui_btn--x_large_liquid" href="javascript:void(0)">スカウトを拒否する</a>
                                    </li>
                                </ul>
                            </div>
                    </div>
                <?php } ?>
                <div id="campaingn_bonus_date" style="text-align: center; background: #fff; padding: 20px; display: none;">
                    <div style="text-align: right; padding: 0 0 20px 0;"><button style="cursor: pointer;" onclick="return close_dialog()" id="btnclose" class="j-ui-x-button">×</button></div>
                    来店日付 <input type="text" id="txtDateFrom" name="daterequest" placeholder="YYYY/MM/DD" style="width: 175px;"><br><br>
                </div>
                </section>
        </div><!-- // .pagebody_inner -->
    </div><!-- // .pagebody -->
    </div>

	<div class="list-title-box-bottom"><div class="list-t-center"><a href="<?php echo base_url() . 'owner/company/company' ?>">▼編集はコチラ</a></div></div>
	</div>
