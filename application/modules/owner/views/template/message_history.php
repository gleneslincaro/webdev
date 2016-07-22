<?php if (isset($msg_history) && count($msg_history) > 0) : ?>
    <?php foreach ($msg_history as $one_msg) : ?>
        <li class="<?php echo ($one_msg['msg_from_flag'] == 0)?'user':'owner'; ?> with_message_history">
            <?php if ($one_msg['msg_from_flag'] == 0) : ?>
                <img class="user-image f_left mr_10" src="<?php
                    $data_from_site = $one_msg['user_from_site'];
                    if ( $one_msg['profile_pic'] ){
                         $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$one_msg['profile_pic'];
                        if ( file_exists($pic_path) ){
                            $src = base_url().$this->config->item('upload_userdir').'images/'.$one_msg['profile_pic'];
                        }else{
                            if ( $data_from_site == 1 ){
                                $src = $this->config->item('machemoba_pic_path').$one_msg['profile_pic'];
                            }else{
                                $src = $this->config->item('aruke_pic_path').$one_msg['profile_pic'];
                            }
                        }
                        echo $src;
                    }else{
                        echo base_url().'/public/user/image/no_image.jpg';
                    }
                ?>" alt="">
                <span><img class="msg-container-ext-white" src="<?php echo base_url();?>public/owner/images/msg-container-ext-white.png" ></span>
            <?php endif; ?>
            <div><?php echo nl2br($one_msg['content']); ?></div>
            <?php if ($one_msg['msg_from_flag'] == 1) : ?>
                <span><img class="msg-container-ext-green" src="<?php echo base_url();?>public/owner/images/msg-container-ext-green.png" ></span>
            <?php endif; ?>
            <span class="created_date">
                <?php $cre_time = strtotime($one_msg['created_date']);
                echo date("y/m/d", $cre_time) . "<br>" . date('H:i:s', $cre_time); ?>
            </span>
        </li>        
    <?php endforeach; ?>
<?php else: ?>
    <li class="t_center">メッセージがありません。</li>
<?php endif; ?>
