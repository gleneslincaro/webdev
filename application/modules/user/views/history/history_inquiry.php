<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/history_inquiry.js?v=20150508"></script>
<section class="section section--history-inquiry cf">
    <h3 class="ttl_1">メッセージ履歴</h3>    
    <div class="box_inner pt_15 pb_7 cf">
    <?php if (isset($conversation) && $conversation && is_array($conversation)): ?>   
    <table width="100%">
      <tr>
        <th class="col_direction">送受信</th>
        <th class="col_date">送受信日</th>
        <th class="col_content">件名/内容</th>
      </tr>
    <?php
        foreach ($conversation as $message) {
          $send_or_reply = $message['msg_from_flag'] == 1? "受信" : "送信";
          $from_class = $message['msg_from_flag'] == 1? "from_user" : "from_owner";
    ?>
      <tr class="<?php echo $from_class; ?>">
        <td><?php echo $send_or_reply; ?></td>
        <td><?php $cre_time = strtotime($message['created_date']);
                  echo date("Y-m-d", $cre_time) . "<br>" . date('H:i:s', $cre_time); ?></td>
        <td>
          <ul>
            <li id='title'><?php echo $message['title']; ?></li>
            <li id='content-value'><?php echo nl2br($message['content']); ?></li>
          </ul>
        </td>
      </tr>
    <?php } ?>
    </table>
    <center><div class='pagination'><?php echo $this->pagination->create_links(); ?></div></center>
    <?php else : ?>
      <p class="mb_10">メッセージの交流がまだありません。</p>
    <?php endif; ?>  
    </div>    
</section>

