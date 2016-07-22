<ul>
<?php
    $cnt = 0;
    foreach ($newUser as $key => $value) :
        $ongoing_scout_flag = false;
        if (isset($value['sm_created_date']) && $value['sm_created_date'] && 
            isset($value['last_visit_date']) && strtotime($value['last_visit_date']) > strtotime($value['sm_created_date'])) {
            $ongoing_scout_flag = true;
        }
        if (($cnt != 0) && ($cnt % 3) == 0) {
            echo "</ul><ul>";
        }
        if (($cnt % 3) != 2) {
            echo ( $value['is_read'] == 1 || $ongoing_scout_flag)? '<li class="right_m r_m_pale_yellow" id="user_'.$value['id'].'">':'<li class="right_m" id="user_'.$value['id'].'">';
        } else {
            echo ( $value['is_read'] == 1 || $ongoing_scout_flag)? '<li class="r_m_pale_yellow" id="user_'.$value['id'].'">':'<li id="user_'.$value['id'].'">';
        }
?>
        <div class="hide_user_scout">
            <div class="scout_history">
            <?php if ($value['is_read'] == 1 || $ongoing_scout_flag) : ?>
                <a href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['id']; ?>">スカウト中</a>
                <?php if (Muser::checkIfUserHasMessageToOwner($owner['id'], $value['id'])) : ?>
                    &nbsp;<a class="return-log" href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['id'].'/1'; ?>">返信履歴</a>
                <?php endif; ?>
            <?php else : ?>
                <?php if (Muser::checkIfUserHasMessageToOwner($owner['id'], $value['id'])) : ?>
                    <a class="return-log" href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['id'].'/1'; ?>">返信履歴</a>
                <?php else : ?>
                    &nbsp;
                <?php endif; ?>
            <?php endif; ?>
            <?php if (Muser::checkIfUserHasMessageToOwner($owner['id'], $value['id'])) : ?>
                <a class="return-log" href="<?php echo base_url() . 'owner/history/history_transmission/'.$value['id'].'/1'; ?>" style="margin-left: 63px; text-align:center; background:#F25D5D;">
                <?php $totalconversation = Mowner::getUsrOwrMessageCnt($owner['id'], $value['id'], null); echo $totalconversation; ?>
                </a>
            <?php endif; ?>
            </div>
            <span onclick="hide_user(<?php echo $value['id']; ?>)">×</span>
        </div>
        <?php if ($value['new_flg'] == 1) { ?>
        <div class="new_user">NEW</div>
        <?php } ?>
        <div class="pic">
        <div>
        <?php
        $data_from_site = $value['user_from_site'];
        if ($value['profile_pic']) {
            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
            if (file_exists($pic_path)) {
                $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
            } else {
                if ($data_from_site == 1) {
                    $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                } else {
                    $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                }
            }
            echo '<img class="user-image" src="'.$src.'" alt="">';
        } else {
            $src = base_url().'public/user/image/no_image.jpg';
            echo '<img class="user-image" src="'.$src.'" height="90" alt="">';
        }
        
        if ($value['profile_pic2']) {
            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic2'];
            if (file_exists($pic_path)) {
                $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic2'];
            } else {
                if ($data_from_site == 1) {
                    $src = $this->config->item('machemoba_pic_path').$value['profile_pic2'];
                } else {
                    $src = $this->config->item('aruke_pic_path').$value['profile_pic2'];
                }
            }
            echo '<img class="user-image" src="'.$src.'" alt="">';
        } else {
            $src = base_url().'public/user/image/no_image.jpg';
            echo '<img class="user-image" src="'.$src.'" height="90" alt="">';
        }
        if ($value['profile_pic3']) {
            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic3'];
            if (file_exists($pic_path)) {
                $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic3'];
            } else {
                if ($data_from_site == 1) {
                    $src = $this->config->item('machemoba_pic_path').$value['profile_pic3'];
                } else {
                    $src = $this->config->item('aruke_pic_path').$value['profile_pic3'];
                }
            }
            echo '<img class="user-image" src="'.$src.'" alt="">';
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
        <br><?php echo "B".$value['bust'] . " W". $value['waist']. " H". $value['hip']; ?>
        <span class="profile_detail" style="display:none;">
        <br>希望収入：<?php echo (($value['salary_l'] != 0)? $value['salary_l'].'万' : '')  . '~' . (($value['salary_h']!=0) ? $value['salary_h'].'万' : '') ?>
        <br>
        <?php if ($value['working_exp'] == 1) : ?>
        風俗経験なし
        <?php elseif ($value['working_exp'] == 2) : ?>
        風俗経験あり
        <?php else : ?>
        &nbsp;
        <?php endif; ?>
        </span>
        </p>
        <p class="pr_msg"><?php echo nl2br($value['pr_message']); ?></p>
        <p class="stat">
        <?php if ($owner['remaining_scout_mail'] > 0) : ?>
        <?php if (!isset($function_name)) {$function_name = "return sendScout(this);";} ?>
        <input type="checkbox" onchange="<?php echo $function_name; ?>"
 class="case" name="checkrs[]" id="checkrss<?php echo $value['id']; ?>" value="<?php echo $value['id']; ?>" <?php echo ((isset($sRetainCheckrs))?((in_array($value['id'], $sRetainCheckrs))?true:false):false)?"checked":""; ?>>
        <?php endif; ?>

        <?php
        $rd = str_pad($value['received_no'], 3, ' ', STR_PAD_LEFT);
        $op = str_pad($value['openned_no'], 3, ' ', STR_PAD_LEFT);
        $rp = str_pad($value['reply_no'], 3, ' ', STR_PAD_LEFT);
        $hp = str_pad($value['hp_no'], 3, ' ', STR_PAD_LEFT);
        $ra = str_pad(round($value['open_rate'], 1) * 100, 3, ' ', STR_PAD_LEFT);
        $stat_str = "受信数:".str_replace(" ", "&nbsp;", $rd)." 開封数:".str_replace(" ", "&nbsp;", $op)." 開封率:".str_replace(" ", "&nbsp;", $ra."%");
        echo $stat_str;
        if ($value['reply_no'] > 0 || $value['hp_no'] > 0 || $value['travel_status'] !=0) {
            echo '<img style="top: 0px; float: right; left: 0px; margin:1px 0px 0px 0px;width:35px;" src="'.base_url().'public/owner/images/hot_icon.png'.'">';
        }
        ?>
        </p>
        <p data-tgt="wd1" data-id="<?php echo $value['id']; ?>" class="btns">詳しく見る</p>
<?php
    echo '</li>';
    $cnt++;
    endforeach; ?>
</ul>