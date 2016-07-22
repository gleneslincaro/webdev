<script type="text/javascript">
    $(document).ready(function() {
      $("#th8").addClass("visited");

      $('.user-image').bind('contextmenu', function(e){
        return false;
      });
    });
</script>


    <div class="crumb">TOP ＞ 申請一覧 ＞ 採用者一覧</div>
<!--
    <div class="owner-box"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a></div><br >
-->
    <div class="list-box"><!-- list-box ここから -->
        <div class="list-title">採用者一覧</div>
        <div class="contents-box-wrapper">
        <div class="work-list-wrapper">

        <div class="list-menu">
            <a class="pr35" href="<?php echo base_url() . 'owner/history/history_work' ?>">勤務確認一覧</a>
            <a class="pr35" href="<?php echo base_url() . 'owner/history/history_app' ?>">面接完了報告一覧</a>
            <a class="pr35" href="<?php echo base_url() . 'owner/history/history_adoption' ?>" style=" color: rgb(0,0,0)" ><font color="#000000">採用者一覧</font></a>
        </div>

    <div class="table-list-wrapper">
        <table>
            <tr>
                <th>ID</th>
                <th>写真</th>
                <th>地域</th>
                <th>年齢</th>
                <th>面接完了報告時間</th>
                <th>勤務申請</th>
                <th>勤務承認時間</th>
            </tr>
            <form name="myForm">
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
                                echo "<img class='user-image' src='".base_url()."/public/user/image/no_image.jpg' alt='写真'
                                            width='120px' height='90'>";
                            }
                        ?>
                        </td>
                        <td><?php echo $value['cityname']; ?></td>
                        <?php if($value['name1']!=0 && $value['name2']!=0)
                        {
                        ?>
                        <td><?php echo $value['name1']; ?>〜<?php echo $value['name2']; ?></td>
                        <?php
                        }
                        else
                        {
                            if($value['name1']!=0)
                            {
                        ?>
                        <td><?php echo $value['name1']; ?>〜</td>
                        <?php
                            }
                            else
                            {
                        ?>
                        <td>〜<?php echo $value['name2']; ?></td>
                        <?php
                            }
                        }
                        ?>
                        <td><?php echo date('Y/m/d H:i', strtotime($value['apply_date'])); ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($value['request_money_date'])); ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($value['approved_date'])); ?></td>
                    </tr>

                <?php endforeach; ?>
            </form>
        </table>
    </div><!-- / .table-list-wrapper -->

        <div class="btn_box">
            <?php
            if ($totalpage > 1) {
                 ?>
                <a href="<?php echo base_url() . 'owner/history/history_adoption' ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_back.png' ?>" alt="次へ"></a>
                <?php echo $paging; ?>
                <a href="<?php echo base_url() . 'owner/history/history_adoption/' . $totalpage; ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_next.png' ?>" alt="次へ"></a>
            <?php
            }
            ?>

        </div>
    </div><!-- / .work-list-wrapper -->
</div><!-- / .contents-box-wrapper -->
    </div><!-- list-box ここまで -->
