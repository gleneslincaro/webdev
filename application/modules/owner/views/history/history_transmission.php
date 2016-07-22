<script>
$(function(){
  var url = window.location.href;
  var hash = url.substring(url.indexOf("#")+1);
  if(hash=='msghistory'){
    $('#tabmenu_msg_history').attr('class', 'active');
    $('#tabmenu_scout_history').attr('class', '');
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>owner/history/getSendHistory',
      data: { type: '1',
              owner_id:<?php echo $owner_id; ?>,
              user_id:<?php echo $user_id; ?>
            },
      dataType: 'json',
      success: function(data){
        if (data) {
          $('#send_history').html(data);
        }
      }
    });
  }
  $('#tabmenu_msg_history').click(function(){
    $('#tabmenu_msg_history').attr('class', 'active');
    $('#tabmenu_scout_history').attr('class', '');
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>owner/history/getSendHistory',
      data: { type: '1',
              owner_id:<?php echo $owner_id; ?>,
              user_id:<?php echo $user_id; ?>,
              nmu_id:<?php echo ($nmu_id)?$nmu_id:0; ?>,
            },
      dataType: 'json',
      success: function(data){
        if (data) {
          $('#send_history').html(data);
        }
      }
    });
  });
  $('#tabmenu_scout_history').click(function(){
    $('#tabmenu_msg_history').attr('class', '');
    $('#tabmenu_scout_history').attr('class', 'active');
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>owner/history/getSendHistory',
      data: { type: '0',
              owner_id:<?php echo $owner_id; ?>,
              user_id:<?php echo $user_id; ?>
            },
      dataType: 'json',
      success: function(data){
        if (data) {
          $('#send_history').html(data);
        }
      }
    });
  });

});
</script>
<div class="crumb">TOP ＞ 履歴一覧 ＞ 送受信履歴</div>
<!--
<div class="owner-box"><?php echo $storename; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt
  <img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url(); ?>owner/settlement/index" target="_blank">ポイント購入</a>
</div>
-->
<br><br>
<div class="menu">
  <ul class="tabmenu" id="tabmenu_pf">
    <li id="tabmenu_scout_history"  class="<?php if ($type == 0) echo "active"; ?>">スカウト履歴</li>
    <li id="tabmenu_msg_history"    class="<?php if ($type != 0) echo "active"; ?>">送受信履歴</li>
    <li><div class="return-historial-btn" onclick='javascript: history.go(-1)' style="cursor: pointer">戻る</div></li>
  </ul>

</div>
<div class="list-box"><!-- list-box ここから -->
  <div class="list-title">送受信履歴</div>
<div class="contents-box-wrapper" id="send_history">
<?php
  $html = "";
  if ($type == 0){
    if (isset($content) && isset($title_mail) && isset($sent_date) && isset($scout_mail_open_date)) {
      $data['content'] = $content;
      $data['title_mail'] = $title_mail;
      $data['sent_date'] = $sent_date;
      $data['scout_mail_open_date'] = $scout_mail_open_date;
      $html = $this->load->view('owner/template/scout_history', $data, true);
    }
  }else{
    if (isset($msg_history)) {
      $data['msg_history'] = $msg_history;
      $html = $this->load->view('owner/template/msg_history', $data, true);
    }
  }
  echo $html;
?>
</div><!-- / .contents-box-wrapper -->
</div><!-- list-box ここまで -->
