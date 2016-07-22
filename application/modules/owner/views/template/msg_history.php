<div class="list-t-center" >
<div class="msg-history-wrapper">
<?php
  if (isset($msg_history) && $msg_history && is_array($msg_history)) {
?>
<table>
  <tr>
    <th class="col_direction">送受信</th>
    <th class="col_date">送受信日</th>
    <th class="col_content">件名/内容</th>
  </tr>
<?php
    $count = count($msg_history);
    foreach ($msg_history as $one_msg) {

      $send_or_reply = $one_msg['msg_from_flag'] == 0? "受信" : "送信";
      $from_class = $one_msg['msg_from_flag'] == 0? "from_user" : "from_owner";
?>
  <tr class="<?php echo $from_class; ?>">
    <td><?php echo $send_or_reply; ?></td>
    <td><?php $cre_time = strtotime($one_msg['created_date']);
              echo date("Y-m-d", $cre_time) . "<br>" . date('H:i:s', $cre_time); ?></td>
    <td>
      <ul>
        <li><?php echo $one_msg['title']; ?></li>
        <li><?php echo nl2br($one_msg['content']); ?></li>
      </ul>
    </td>
  </tr>
<?php
    $count--;
    }
  }else{
    echo "ユーザーからのお問い合わせはまだありません";
  }
?>
</table>
</div>
</div>
<div class="btn_box historical-btn-box">
  <?php
  if ($totalpage > 1) { ?>
    <!--<a href="<?php echo $first_link; ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_back.png' ?>" alt="前へ"></a>-->
    <?php echo $paging; ?>
    <!--<a href="<?php echo $last_link; ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_next.png' ?>" alt="次へ"></a>-->
  <?php } ?>
</div>
