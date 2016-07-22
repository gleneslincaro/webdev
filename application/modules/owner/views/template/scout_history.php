<div class="list-t-center" >
<?php
if (isset($content) && $content && is_array($content)) {
  for ($i = 0;$i < count($content); $i++) {
?>
  <div class="message_box">
  <p style="position:relative">
  <span>開封日付 :<?php echo ($scout_mail_open_date[$i])?$scout_mail_open_date[$i]:' --:--:--';?></span>
  <span class="send-date">送信日付： <?php echo $sent_date[$i]; ?></span>
  </p>
  <table class="message" style="text-align: left;">
    <tr>
      <th></th>
    </tr>
    <tr>
      <td>件名：<?php echo $title_mail[$i]; ?>
      </td>
    </tr>
    <tr>
      <td>
<?php echo $content[$i]; ?>
    </td>
    </tr>
  </table>
</div>
<br />
<br />
<?php
  }
}else{ ?>
  <div class="message message_box">
  現在、このユーザーへのスカウトメールはありません
  </div>
<?php
}
?>
</div>
<div class="list-t-center">
  <?php
  if ($totalpage > 1) { ?>
    <a href="<?php echo $first_link; ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_back.png' ?>" alt="前へ"></a>
    <?php echo $paging; ?>
    <a href="<?php echo $last_link; ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_next.png' ?>" alt="次へ"></a>
  <?php } ?>
</div>
