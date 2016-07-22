<div class="img-prof in_new">
    <ul>
	<?php
	    $cnt = 0;
		foreach ($newUser as $key => $value) {
            $ongoing_scout_flag = false;
            if (isset($value['sm_created_date']) && $value['sm_created_date'] && $value['last_visit_date'] &&
                strtotime($value['last_visit_date']) > strtotime($value['sm_created_date'])) {
                $ongoing_scout_flag = true;
            }
		    if ( ($cnt != 0) && ($cnt % 3) == 0 ){ echo "</ul><ul>"; }
            if ( ($cnt % 3) != 2 ){
          	    $b_color = ' <li class="right_m ';
                echo ($value['is_read'] == 1 || $ongoing_scout_flag) ? $b_color.'r_m_pale_yellow"  id="hide_user_'.$value['id'].'">':$b_color.'" id="hide_user_'.$value['id'].'">';
            }else {
                if ($value['is_read'] == 1 || $ongoing_scout_flag)
          	        echo ' <li class="r_m_pale_yellow" id="hide_user_'.$value['id'].'">';
          	    else
                    echo ' <li id="hide_user_'.$value['id'].'">';
            }
    ?>
            <div class="hide_user_scout">
                <div class="scout_history_hide scout_history">
	            <?php if($value['is_read'] == 1 || $ongoing_scout_flag): ?>
	               	<a href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['id'] ?>">スカウト中</a>
	               	<?php if(Muser::checkIfUserHasMessageToOwner($owner_id, $value['id'])): ?>
                		&nbsp;<a class="return-log" href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['id'].'/1' ?>">返信履歴</a>
                	<?php endif; ?>
	            <?php else: ?>
	               	<?php if(Muser::checkIfUserHasMessageToOwner($owner_id, $value['id'])): ?>
                		<a class="return-log" href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['id'].'/1' ?>">返信履歴</a>
                	<?php else: ?>
                		&nbsp;
                	<?php endif; ?>
	            <?php endif; ?>
                </div>
            	<span onclick="show_users(<?php echo $value['id']; ?>)">○</span>
           	</div>
            <?php if ( $value['new_flg'] == 1) { ?>
                <div class="new_user">NEW</div>
            <?php } ?>
            <div class="pic">
            <div>
            <?php 
            if ($value['profile_pic']){
                $data_from_site = $value['user_from_site'];
                $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                if (file_exists($pic_path)){
                    $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                } else {
                    if ($data_from_site == 1){
                        $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                    } else {
                        $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                    }
                }
                echo '<img class="user-image" src="'.$src.'" height="90" alt="">';
            } else {
                $src = base_url().'public/user/image/no_image.jpg';
                echo '<img class="user-image" src="'.$src.'" height="90" alt="">';
            }
            ?>
            </div>
            </div>
            <p class="profile_text">ID: <?php echo $value['unique_id']; ?>
            <br>地域：<?php echo $value['cityName']; ?>
            <br>年齢：<?php echo (($value['ageName1'] != 0)? $value['ageName1'] : '')  . '~' . (($value['ageName2']!=0) ? $value['ageName2'] : '') ?>
            <br>身長：<?php echo $value['height_l'] . "~". $value['height_h']; ?>
            <br><?php echo "B".$value['bust'] . " W". $value['waist']. " H". $value['hip']; ?></p>
            <p class="stat"><?php
            $rd = str_pad($value['received_no'],3,' ',STR_PAD_LEFT);
            $op = str_pad($value['openned_no'],3,' ',STR_PAD_LEFT);
            $rp = str_pad($value['reply_no'],3,' ',STR_PAD_LEFT);
            $hp = str_pad($value['hp_no'],3,' ',STR_PAD_LEFT);
            $stat_str = "受信数:".str_replace(" ","&nbsp;",$rd)." 開封数:".str_replace(" ","&nbsp;",$op);
            echo $stat_str;
			?>
		  </p>
		</li>
	  <?php
	  $cnt++;
	} ?>
    </ul>
</div>
