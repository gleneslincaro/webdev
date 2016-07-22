<script type="text/javascript">
    var user_id = <?php echo (isset($user_id))?$user_id:'';?>;   
    var nmu_id = <?php echo (isset($nmu_id))?$nmu_id:'';?>;
    var msg_history_total = <?php echo (isset($msg_history_total))?$msg_history_total:0;?>;   
    $(document).ready(function() {
        var init_text_height = 25;
        var rp_message_height = 100;
        var one_line_height = 17;
        var sh_plus = init_text_height + rp_message_height;
        autoheight($("#reply_message"), sh_plus);
        $("#reply_message").keyup(function (e) {
            e.preventDefault();
            if ( $('#insert_signature').val() == 0 ) {
                autoheight(this, init_text_height);
            } else {
                autoheight(this, sh_plus);
            }
        });

        $('#insert_signature').click(function() {
            if($(this).val() == 0) {
               $('.owner_signature').show();
               $(this).val(1);
               autoheight($("#reply_message"), sh_plus);
               $('#dialog-form').css('height', 480 + $('#reply_message').height());
            }
            else  {
                $('.owner_signature').hide();
                $(this).val(0);
                autoheight($("#reply_message"), init_text_height);
                $('#dialog-form').css('height', 480 + $('#reply_message').height());
                //$('#dialog-form').css('height', $('#dialog-form').height() - one_line_height);
            }
        });

        function autoheight(a, sh_plus) {
            if (!$(a).prop('scrollTop')) {
                do {
                    var b = $(a).prop('scrollHeight');
                    var h = $(a).height();
                    $(a).height(h - 5);
                }
                while (b && (b != $(a).prop('scrollHeight')));
            };
            $(a).height($(a).prop('scrollHeight') + sh_plus);

            if ($('#content_height').val() < $(a).height()) {
                $('#dialog-form').css('height', $('#dialog-form').height() + one_line_height);
                $('#content_height').val($(a).height());
            } else if($('#content_height').val() > $(a).height() && $('#content_height').val() != 0) {
                $('#dialog-form').css('height', $('#dialog-form').height() - one_line_height);
                $('#content_height').val($(a).height());
            } else {
                $('#content_height').val($(a).height());
            }
        }
        
        var nVer = navigator.appVersion;
        var nAgt = navigator.userAgent;
        var browserName  = navigator.appName;
        var fullVersion  = ''+parseFloat(navigator.appVersion); 
        var majorVersion = parseInt(navigator.appVersion,10);
        var nameOffset,verOffset,ix;

        if ((verOffset=nAgt.indexOf("OPR/"))!=-1 || (verOffset=nAgt.indexOf("Opera"))!=-1 || (verOffset=nAgt.indexOf("Chrome"))!=-1) {
            $('.owner_signature').css('font-size', '12px');
        }  
                
        display_message_history();       
        $('#scroll').scrollTop(0); 
    });
        
    //Show more user owner message history when scroll reach at the bottom.    
    (function(scroll)
    {
        if (scroll != null) {
            scroll.onscroll = function()
            {
                if (scroll.scrollTop + scroll.clientHeight == scroll.scrollHeight) {
                    offset = $('ul#message_list').children('li.with_message_history').length;
                    if (offset > 0 && offset < msg_history_total) {
                        display_message_history();    
                    }            
                }
            }
        }
    })(document.getElementById('scroll'));
    
    //Get and display user owner message history.
    function display_message_history() {
        offset = $('ul#message_list').children('li.with_message_history').length;
        $('#loader_wrapper').html('<img src="'+ '<?php echo base_url(); ?>' + 'public/owner/images/loading.gif" id="loader">');
        $.ajax({
            url: "<?php echo base_url(); ?>owner/inbox/getSendHistory",
            type: "POST",
            data: { user_id: user_id, type: 1, offset: offset, nmu_id: nmu_id },
            success: function(data){
                $('#loader').remove();
                $('.message_history_wrapper ul').append(data);
            },
            error: function(){             
            }
        });
    }
</script> 
<div style="text-align: right"><button onclick="return close_dialog()" class="j-ui-x-button">×</button></div>
<div class="img-prof in_new">
	<?php if ($message_data['user_id'] != 0) : ?>
    <ul style="width: auto">
		<li class="right_m" style="width: auto">
			<img class="user-image" src="<?php
              $data_from_site = $message_data['user_from_site'];
              if ( $message_data['profile_pic'] ){
                   $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$message_data['profile_pic'];
                  if ( file_exists($pic_path) ){
                      $src = base_url().$this->config->item('upload_userdir').'images/'.$message_data['profile_pic'];
                  }else{
                      if ( $data_from_site == 1 ){
                          $src = $this->config->item('machemoba_pic_path').$message_data['profile_pic'];
                      }else{
                          $src = $this->config->item('aruke_pic_path').$message_data['profile_pic'];
                      }
                  }
                  echo $src;
              }else{
                  echo base_url().'/public/user/image/no_image.jpg';
              }
              ?>" height="90" alt="">
              <p>ID: <?php echo $message_data['unique_id']; ?>
              <br>地域：<?php echo $message_data['cityName']; ?>
              <br>年齢：<?php echo (($message_data['ageName1'] != 0)? $message_data['ageName1'] : '')  . '~' . (($message_data['ageName2']!=0) ? $message_data['ageName2'] : '') ?>
              <br>身長：<?php echo $message_data['height_l'] . "~". $message_data['height_h']; ?>
              <br><?php echo "B".$message_data['bust'] . " W". $message_data['waist']. " H". $message_data['hip']; ?></p>
              <p class="stat" style="padding-left: 20px"><?php
                $rd = str_pad($message_data['received_no'],3,' ',STR_PAD_LEFT);
                $op = str_pad($message_data['openned_no'],3,' ',STR_PAD_LEFT);
                $rp = str_pad($message_data['reply_no'],3,' ',STR_PAD_LEFT);
                $hp = str_pad($message_data['hp_no'],3,' ',STR_PAD_LEFT);
                $stat_str = "受信数:".str_replace(" ","&nbsp;",$rd)." 開封数:".str_replace(" ","&nbsp;",$op);
                /*
                if ( $message_data['hp_no'] > 0 ){
                    $stat_str .= " HP:".'<span style="color:red">'.str_replace(" ","&nbsp;",$hp).'</span>';
                }else{
                    $stat_str .= " HP:".str_replace(" ","&nbsp;",$hp);
                }
                if ( $message_data['reply_no'] > 0 ){
                    $stat_str .= " 返信数:".'<span style="color:red">'.str_replace(" ","&nbsp;",$rp).'</span>';
                }else{
                    $stat_str .= " 返信数:".str_replace(" ","&nbsp;",$rp);
                }
                */

                echo $stat_str;

                ?>
              </p>
		</li>
    </ul>
  <?php endif; ?>
</div>
<hr>
<input type="hidden" name="orgin_msg_id" id="orgin_msg_id" value="<?php echo $message_data['orgin_msg_id']; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $message_data['user_id']; ?>">
<input type="hidden" name="none_member_id" id="none_member_id" value="<?php echo $message_data['none_member_id']; ?>">
<input type="hidden" name="user_title" id="user_title" value="<?php echo $message_data['title']; ?>">
<input type="hidden" name="content_height" id="content_height" value="0">
<div class="mb10">件名： <?php echo $message_data['title']; ?></div><hr>

<div class="mb10">本文：</div>
<div class="user_message_content"><?php echo nl2br($message_data['content']); ?></div>
<hr class="mb20" >
<div id="reply_message_container">
	<div class="mb10">返事メッセージ：</div>
	<p id="validateTips" style="color: red">メセッジを入力してください。</p>
	<textarea class="user_message_content1 mb05" placeholder="メッセージを入力してください" id="reply_message"></textarea>
	<div style="color: black; margin: -110px 0 17px 2px;" class="owner_signature">
        <?php
        echo "店舗名: " . $storename . "<br />";
        echo "電話番号: " . $tel . "<br />";
        echo "メールアドレス: " . $apply_emailaddress . "<br /><br />";
        ?>
        【匿名の返信はこちら】
        <br />
        <?php echo base_url() . "user/joyspe_user/company/" . $owner_recruit_id; ?>/
    </div>
	<input type="checkbox" id="insert_signature" name="insert_signature" value="1" checked>
	<label>署名（店舗名、電話番号を自動で読み込みます）</label>
	<hr class="mb20" >
	<div style="text-align: center"><button onclick="return reply_message_send()" class="j-ui-button" id="send_button">返信</button></div>  
</div>
<div style="text-align: center; margin-bottom: 10px"><button onclick="return reply_message()" class="j-ui-button" id="reply_button">返信</button></div>
<?php if ($msg_history_total > 1): ?>
    <p class="bold">メッセージ履歴</p>
    <div class="message_history_wrapper" id="scroll">    
        <ul id="message_list"></ul>
    </div>
<?php endif; ?>
<div id="loader_wrapper" class="t_center"></div>
