<link rel="stylesheet" type="text/css" href="<?php echo base_url()."public/owner/css/jquery-ui.css";?> ">
<script src="<?php echo base_url()."public/owner/js/jquery-ui.min.js"; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()."public/owner/js/jquery.ui.datepicker-ja.min.js"; ?>" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $( "#create-user" ).button().on( "click", function() {
        if (!confirm("このテンプレートをベースにして、新しいテンプレートを作成します。よろしいでしょうか？")) {
            return;
        }
        if($('#scout_title').val() != '' && $('#scout_title').val() != 'undefined') {
            $('#scout_mail_register').val(1);
            $('#history_app_scout').submit();
        }
        else {
            alert('テンプレート名前は必須項目です。');
            $('#scout_title').focus();
        }
    });

    $( "#edit-user" ).button().on( "click", function() {
        if (!confirm("このテンプレートの修正を行います。よろしいでしょうか？")) {
            return;
        }
        if($('#scout_title').val() != '' && $('#scout_title').val() != 'undefined')    {
            $('#history_app_scout').submit();
        }
        else {
            alert('テンプレート名前は必須項目です。');
            $('#scout_title').focus();
        }
    });

    var disp_pr_text = "<?php echo isset($disp_pr_text)?$disp_pr_text:''; ?>";
    var str = $('#scout_pr_text').val();
    var res1 = '';
    if(disp_pr_text != '') {
      $('#scout_pr_text').show();
      $('#scout_pr_text').css('border', '1px solid #ccc');
      $('#scout_pr_text').css('resize', 'none');
      $('#scout_pr_text').attr("readonly", false);
      $('#scout_pr_text').attr("placeholder", '自由入力フォーム');
    }
    else {
    if(str == '')
      $('#scout_pr_text').val("");
    }

    if(str!='')
      res = str.split("<br/>");
    else
      res = '';
    for(var i=0;i<res.length;i++) {
      if(res[i] !='') {
        res1 = res1+res[i];
        if(res.length > 1 && i != res.length - 1)
          res1 = res1+'\n';
      }
      else
        res1 = res1+'\n';
    }

    $('#scout_pr_text').text(res1);

    $("#scout_pr_text").keyup(function (e) {
        autoheight(this);
    });

    function autoheight(a) {
      if (!$(a).prop('scrollTop')) {
        do {
          var b = $(a).prop('scrollHeight');
          var h = $(a).height();
          $(a).height(h - 5);
        }
        while (b && (b != $(a).prop('scrollHeight')));
      };
      $(a).height($(a).prop('scrollHeight') + 17);
    }

    autoheight($("#scout_pr_text"));

    var scout_mail = "<?php echo isset($scout_mail)?$scout_mail:''; ?>";
    if(scout_mail != '') {
      alert(scout_mail);
    }

    $('.user-image').bind('contextmenu', function(e){
      return false;
    });

    $("#selectall").attr("checked", "checked");
    $(".case").attr("checked", "checked");
    // add multiple select / deselect functionality
    $("#selectall").click(function() {
      $('.case').attr('checked', this.checked);
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function() {
      if ($(".case").length == $(".case:checked").length) {
        $("#selectall").attr("checked", "checked");
      } else {
        $("#selectall").removeAttr("checked");
      }
    });

    // add multiple select / deselect functionality
    $("#selectall").click(function() {
      var checkall = $(this).attr('id');
      $('.' + checkall).attr('checked', this.checked);
    });

    $('#ownerScoutPrText').change(function() {
      var id = $('#ownerScoutPrText').val();
      $.ajax({
        url: '<?php echo base_url().'owner/history/getOwnerScoutPrText'?>',
          type:'GET',
          dataType: 'json',
          data: {id: id},
          success: function(data){
            $('#scout_pr_text').val(data['pr_text']);
            $('#scout_pr_id').val(data['id']);
            $('#scout_pr_ttle').html(data['pr_title']);
            autoheight($("#scout_pr_text"));
          }
      });
    });
  });

  function checkExistListUserSpam() {
      if (!confirm("この内容で送信しますか？")) {
          return false;
      }
      var check_action = baseUrl + "owner/history/history_app_scout_check";
      var scout_action = baseUrl + "owner/scout/scout_after";
      var send_scout_finish = baseUrl + "owner/scout/scout_finish";
      $('#history_app_scout').ajaxSubmit({
          url: check_action,
          dataType: 'json',
          success: function(responseText, statusText, xhr, $form) {
              if (responseText.error != null)
              {
                  alert(responseText.error);
                  return false;
              }
              else
              {
                  count = responseText.count;
                  count_spams = responseText.count_spams;
                  count_unsent = responseText.count_unsent;
                  str_unique_id = responseText.str_unique_id;
                  if ( count == count_spams ) {
                      var msg = "ID: " + str_unique_id + " \n" + "がブロックしているためスカウトできません。";
                      alert(msg);
                      window.location.replace(scout_action);
                  }
                  if ( count_spams <= count && (count_unsent != count)) {
                      var msg = "ID: " + str_unique_id + " \n" + "がブロックしているためスカウトできません。";
                      arr_user_id_unsent = responseText.arr_user_id_unsent;
                      alert(msg);
                      return false;
                  }
                  if (count_unsent == count) {
                      arr_user_id_unsent = responseText.arr_user_id_unsent;
                      window.location.replace(send_scout_finish);
                  }
              }
          }
      });
  }
</script>

<div class="crumb">TOP ＞ スカウト機能 ＞ スカウトメッセージ</div>
<!--
<div class="owner-box"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt　
    <img src="<? echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url(); ?>owner/settlement/index" target="_blank">ポイント購入</a>
</div>
-->

<div class="list-box"><!-- list-box ここから -->
  <div class="list-title">スカウトメッセージ</div>
<div class="contents-box-wrapper">
		<?php
			if(!isset($disp_pr_text))
				$url = 'owner/scout/scout_settlement';
			else
				$url = 'owner/history/history_app_scout';
		?>
    <form id="history_app_scout" name="history_app_scout" action="<?php echo base_url().$url; ?>" method="post"   >
		<?php if(!isset($disp_pr_text)): ?>
        <div class="img-prof in_new">
        <ul>
        <?php
            $cnt = 0;
            foreach ($user_profiles as $key => $value) {
                if ( ($cnt != 0) && ($cnt % 3) == 0 ){ echo "</ul><ul>"; }
                if ( ($cnt % 3) != 2 ){
                    echo ' <li class="right_m">';
                }else{
                    echo ' <li>';
                }
                ?>
                <?php if ( $value['new_flg'] == 1) { ?>
                <div class="new_user">NEW</div>
                <?php } ?>
                <div class="pic">
                <?php
                $data_from_site = $value['user_from_site'];
                if ($value['profile_pic']){
                    $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                    if (file_exists($pic_path)){
                        $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                    }else{
                        if ($data_from_site == 1){
                            $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                        }else{
                            $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                        }
                    }
                    echo '<img class="user-image" src="'.$src.'" alt="">';
                }else{
                    $src = base_url().'public/user/image/no_image.jpg';
                    echo '<img class="user-image" src="'.$src.'" height="90" alt="">';
                }
                ?>
                </div>
                <p>ID: <?php echo $value['unique_id']; ?>
                <br>地域：<?php echo $value['cityname']; ?>
                <br>年齢：<?php echo (($value['age_name1'] != 0)? $value['age_name1'] : '')  . '~' . (($value['age_name2']!=0) ? $value['age_name2'] : '') ?>
                <br>身長：<?php echo $value['height_l'] . "~". $value['height_h']; ?>
                <br><?php echo "B".$value['bust'] . " W". $value['waist']. " H". $value['hip']; ?>
<!--                <br>希望：<?php echo (($value['salary_l'] != 0)? $value['salary_l'].'万' : '')  . '~' . (($value['salary_h']!=0) ? $value['salary_h'].'万' : '') ?>
                <br>
                <?php if($value['working_exp'] == 1): ?>
                風俗経験なし
                <?php elseif($value['working_exp'] == 2): ?>
                風俗経験あり
                <?php else: ?>
                &nbsp;
                <?php endif; ?>  -->
                </p>
                <p class="stat"><?php
                $rd = str_pad($value['statistics']['received_no'],3,' ',STR_PAD_LEFT);
                $op = str_pad($value['statistics']['openned_no'],3,' ',STR_PAD_LEFT);
                $rp = str_pad($value['statistics']['reply_no'],3,' ',STR_PAD_LEFT);
                $hp = str_pad($value['statistics']['hp_no'],3,' ',STR_PAD_LEFT);
                $stat_str = "受信数:".str_replace(" ","&nbsp;",$rd)." 開封数:".str_replace(" ","&nbsp;",$op);
                echo $stat_str;
                ?>
                </p>
                <input type="hidden" name="array_user_id[]" value="<?php echo $value['uid']; ?>">
                </li>
        <?php
        $cnt++;
        } ?>
        </ul>
        </div>

        <div class="list-t-center">
            <input type="button" onclick="return checkExistListUserSpam();" value="送信" style="width:150px; height:40px;">
        </div>
		<?php endif; ?>
        <div class="list-t-center">
            <br ><br >
            ※送信されるスカウトメッセージ内容は、下記のものとなります。
            <?php if(isset($disp_pr_text)): ?>
            <br ><br ><br >
            <div class="taleft pl100 mb10" style="margin: 15px">
              テンプレート名前: <input placeholder="名前" type="text" name="scout_title" id="scout_title" value="<?php echo (isset($scout_title))?$scout_title:''?>" >
            </div>
            <?php endif; ?>
            <?php if(!isset($disp_pr_text)): ?>
              <br /><br >
              <?php if($o_s_pr_text_total > 1): ?>
                <br >
              <div class="taleft-wrapper">
                <div class="taleft pl100">
                  スカウトメールテンプレート：
                  <select name="ownerScoutPrText" id="ownerScoutPrText">
                    <?php foreach($owner_scout_pr_text_data as $value): ?>
                      <option value="<?php echo $value['id']?>" <?php if($value['id'] == ($scout_mail_template_id)) echo " selected"; ?>><?php echo $value['title']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              <?php else: ?>
                <div class="taleft pl100 mb10">
                  テンプレート名前: <input placeholder="名前" type="text" name="scout_title" id="scout_title" value="<?php echo (isset($scout_title))?$scout_title:''?>" readonly>
                </div>
                <br >
              <?php endif; ?>
                <div class="information_list">
                <a href="<?php echo base_url()."owner/history/history_app_scout/1"; ?>">編集</a>&nbsp;&nbsp;&nbsp;
                <a href="../help#template_toroku">テンプレート登録について</a>
                </div>
            </div><!-- / .taleft-wrapper -->
              <br ><br >
            <?php endif; ?>
            <div class="message_box">
                <table class="message" style="text-align: left;">
                    <tr>
                    <?php if(isset($disp_pr_text)) { ?>
                        <td >件名：<input type="text" name="scout_pr_ttle" id="scout_pr_ttle" value="<?php echo isset($scout_pr_ttle) ? $scout_pr_ttle : ''; ?>" maxlength="100" size="100"></td>
                    <?php } else { ?>
                        <td style="background: #FFC9C9;">件名：<span id="scout_pr_ttle"><?php echo $scout_pr_ttle; ?></span></td>
                    <?php } ?>
                    </tr>
                    <tr><td><br/></td></tr>
                    <tr>
                        <td>
                            <?php echo $content; ?>
                        </td>
                    </tr>
                </table>
            </div>
			<?php if(isset($disp_pr_text)): ?>
				<br />
				<input type="hidden" value='1' name="scout_pr_text_flag" id="scout_pr_text_flag">
				<div class="list-t-center input-bottom">
              <?php if($o_s_pr_text_total < 5): ?>
                <div id="create-user" class="c-button">登録する</div>
              <?php endif; ?>
                <div id="edit-user" class="c-button">更新する</div>
                <input type="hidden" name="scout_mail_register" id="scout_mail_register" value="">
                </div>
            <?php endif; ?>
                <input type="hidden" name="scout_pr_id" id="scout_pr_id" value="<?php echo (isset($scout_mail_template_id))?$scout_mail_template_id:''; ?>">
            <?php if(!isset($disp_pr_text)): ?>
            <br >
            <div class="list-t-center input-bottom">
                <input onclick="return checkExistListUserSpam();" type="button"  value="送信" style="width:150px; height:40px;">
            </div>
            <?php endif; ?>
        </div>
    </form>
    </div><!-- /.contents-box-wrapper -->
    </div> <!--list-box ここまで -->