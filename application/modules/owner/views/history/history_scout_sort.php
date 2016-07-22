<div class="table-list-wrapper">
<table>
  <tr>
    <th>ID</th>
    <th>写真</th>
    <th>地域</th>
    <th>年齢</th>
    <th>受信</th>
    <th>開封</th>
    <!--
    <th>HP</th>
    <th>返信</th>
    -->
    <th>送信履歴</th>
    <th>スカウト時間</th>
    <th>再送信</th>
    <th>開封日時</th>
  </tr>
  <?php foreach ($user_data as $value): ?>
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
          echo "<img class='user-image' src='".base_url()."/public/user/image/no_image.jpg' alt='写真' width='120px' height='90'>";
        }
      ?>
      </td>
      <td><?php echo $value['cityname']; ?></td>
      <?php if($value['name1']!=0 && $value['name2']!=0) { ?>
        <td><?php echo $value['name1']; ?>〜<?php echo $value['name2']; ?></td>
      <?php } else { if($value['name1']!=0) { ?>
        <td><?php echo $value['name1']; ?>〜</td>
      <?php } else { ?>
        <td>〜<?php echo $value['name2']; ?></td>
      <?php } } ?>
      <td><?php echo str_pad($value['statistics']['received_no'],3,'0',STR_PAD_LEFT); ?></td>
      <td><?php echo str_pad($value['statistics']['openned_no'],3,'0',STR_PAD_LEFT); ?></td>
      <!--
      <td><?php
      $hp_str = str_pad($value['statistics']['hp_no'],3,'0',STR_PAD_LEFT);
      if ( $value['statistics']['hp_no'] > 0 ){
         $hp_str = '<span style="color:red">'.$hp_str.'</span>';
      }
      echo $hp_str;
      ?></td>
      <td><?php
      $rp_str = str_pad($value['statistics']['reply_no'],3,'0',STR_PAD_LEFT);
      if ( $value['statistics']['reply_no'] > 0 ){
          $rp_str = '<span style="color:red">'.$rp_str.'</span>';
      }
      echo $rp_str;
      ?></td>
      -->
      <td><a href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['id']; ?>">履歴確認</a></td>
      <td><?php echo date('Y/m/d H:i', strtotime($value['created_date'])); ?></td>
      <td>
        <?php
          $openScoutMail = Mowner::getUserOpenScoutMail($value['id'], $value['owner_id']);
          $smNo = Mowner::countOwnerScoutMailSent($value['id'], $value['owner_id']);
          if($openScoutMail[0]['is_read'] == 1 && $smNo[0] > 1) {
            echo "<a href=".base_url()."owner/history/manualAssignsScheckrs/".$value['id'].">再送信×".$smNo[0]."</a>";
          }
          elseif($openScoutMail[0]['is_read'] == 1 && $smNo[0] == 1)
            echo "<a href=".base_url()."owner/history/manualAssignsScheckrs/".$value['id'].">再送信</a>";
          else
            echo '送信済';
        ?>
      </td>
      <td><?php
        if( isset($value['mail_open_date']) ){
          echo $value['mail_open_date'];
        }else{
          echo "未";
        }
      ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</div><!-- / .table-list-wrapper -->
