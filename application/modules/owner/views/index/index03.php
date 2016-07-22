<br/>
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■勤務確認</div><br >

    <center>
        <font size="3" color="#ff0000">
        勤務確認依頼（お祝い申請）から「7日間」経過しております。下記ユーザー様の勤務確認をお願い致します。<br ></font>
        <br >
        <table class="list">
            <tr>
                <th>ID</th><th>写真></th><th>地域</th><th>年齢</th><th>応募時間</th><th>勤務申請</th><th>勤務確認</th>
            </tr>
            <?php if (count($data) > 0) {
                foreach ($data as $d) { ?>
                    <tr>
                        <td><?php echo $d['user_unique_id']; ?></td>
                        <td><?php
                            $data_from_site = $d['user_from_site'];
                            if ( $d['profile_pic'] ){
                                $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$d['profile_pic'];
                                if ( file_exists($pic_path) ){
                                    $src = base_url().$this->config->item('upload_userdir').'images/'.$d['profile_pic'];
                                }else{
                                    if ( $data_from_site == 1 ){
                                        $src = $this->config->item('machemoba_pic_path').$d['profile_pic'];
                                    }else{
                                        $src = $this->config->item('aruke_pic_path').$d['profile_pic'];
                                    }
                                }
                                echo "<img src='".$src."' alt='写真' height='90'>";
                            }else{
                                echo "<img src='".base_url()."/public/user/image/no_image.jpg' alt='写真'
                                            width='120px' height='90'>";
                            }
                        ?>
                        </td>
                        <td><?php echo $d['city_name']; ?></td>
                        <td><?php echo $d['age1'] . '〜' . $d['age2']; ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($d['apply_date'])); ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($d['request_money_date'])); ?></td>
                        <td><button type="button" onClick="javascript:location.href = '<?php echo base_url() . 'owner/history/history_app_work/'.$d['userid'].'/'.$d['owner_recruit_id'] ?>';">確認ページ</button></a></td>
                    </tr>
    <?php }
} ?>
                    
        </table>
        
        <?php if (count($data) > 50) {
            ?>
        <a href="<?php echo base_url() . 'owner/index/index03/' ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_back.png' ?>" alt="次へ"></a><?php echo $paging; ?><a href="<?php echo base_url() . 'owner/index/index03/' . $totalpage; ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_next.png' ?>" alt="次へ"></a> 
        <?php 
        }
        ?>
</div><!-- list-box ここまで -->
<center>
    ※上記ユーザー様の勤務確認が終了するまで他のページへアクセスは一時的に制限がかかっております。<br >
</center>
</div><!-- container ここまで -->
