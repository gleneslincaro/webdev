<link rel="stylesheet" type="text/css" href="<?php echo base_url()."public/owner/css/jquery-ui.css";?> ">
<script src="<?php echo base_url()."public/owner/js/jquery-ui.min.js"; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()."public/owner/js/jquery.ui.datepicker-ja.min.js"; ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {

      var sort_active = "<?php echo (isset($sort))?$sort:'';?>";
      $('.hs_sort').removeClass('active_blue');
      $('#'+sort_active).addClass('active_blue');

      $("#th3").addClass("visited");
      $('.user-image').bind('contextmenu', function(e){
        return false;
      });
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $(".date-picker").datepicker();

      $('.btn_box span span a').attr('onclick', 'return setSortBlue(this)');
      $('.btn_box span span a').attr('data-sort', "<?php echo $sort; ?>");
      $('._pagination').attr('data-sort', "<?php echo $sort; ?>");

    });

    function removeSHistoryScoutSort(e) {
      var href = $(e).attr('href');
	  $.post("<?php echo base_url().'owner/history/removeSHistoryScoutSort'; ?>", {}, function(data){
	  	window.location.href = href;
	  });
	  return false;
    }

    function hs_sort(e) {
      $.ajax({
        url: '<?php echo base_url().'owner/history/setSortBlue'?>',
          type:'POST',
          dataType: 'json',
          data: {sort: e.id},
          success: function(data){
            $('.btn_box span span a').attr('data-sort', data.result);
            $('._pagination').attr('data-sort', data.result);
            $.post("<?php echo base_url().'owner/history/history_scout_sort'?>", { page: "<?php echo (isset($page))?$page:''; ?>",  ppp: "<?php echo (isset($ppp))?$ppp:''; ?>", scout_start_date: "<?php echo (isset($scout_start_date))?$scout_start_date:''; ?>", scout_end_date: "<?php echo (isset($scout_end_date))?$scout_end_date:''; ?>", sort: e.id,unique_id:"<?php echo (isset($unique_id))?$unique_id:'';?>" }, function(data) {
              $('#list_container').html(data);
              $('.hs_sort').removeClass('active_blue');
              $('#'+e.id).addClass('active_blue');
            });
          }
      });
    }

    function setSortBlue(e) {
      var sort = $(e).data('sort');
      var href = $(e).attr('href');
      $.ajax({
        url: '<?php echo base_url().'owner/history/setSortBlue'?>',
          type:'POST',
          dataType: 'json',
          data: {sort: sort},
          success: function(data){
            window.location.href = href;
          }
      });
      return false;
    }

</script>

<!--<div id="container">-->

    <div class="crumb">TOP ＞ スカウト履歴</div>
<!--
<div class="owner-box"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a></div><br >
-->
    <div class="list-box"><!-- list-box ここから -->
        <div class="list-title">スカウト履歴</div>

    <div class="contents-box-wrapper">
        <form class="historical-data-form" name="myForm" action="<?php echo base_url()."owner/history/history_scout"; ?>" method ="get">
        <div class="scout-search">
            <div>
                スカウト期間:
                <input id ="scout_start_date" class="date-picker" type="text" style="width:150px" placeholder="YYYY/MM/DD" name="scout_start_date" value="<?php echo $scout_start_date; ?>" autocomplete="off">～
                <input id ="scout_end_date" class="date-picker" type="text" style="width:150px" placeholder="YYYY/MM/DD" name="scout_end_date" value="<?php echo $scout_end_date; ?>" autocomplete="off">
                ID: <input id ="u" type="text"  name="u" placeholder="ID" autocomplete="off" style="width:100px" value="<?php echo $unique_id;?>" />
                <input type="submit" id="search" value="検索" >
                <span class="scoutmail_open_rate">開封率： <?php if ( isset($mail_open_rate) ){ echo $mail_open_rate; } ?></span>
            </div>
            <div class="hs_m_sort">
            	<span id="created_date" class="hs_sort" onclick="hs_sort(this)">送信日時順</span>｜<span id="scout_mail_open_date" class="hs_sort" onclick="hs_sort(this)">開封日時順</span>
            </div>
        </div>
        <!--<p class="prf_help">
        	<a href="<?php echo base_url(); ?>owner/help#profile">プロフィールの項目について</a>&nbsp;|&nbsp;
          <a href="<?php echo base_url(); ?>owner/help#increase">より開封率をあげるには</a>&nbsp;|&nbsp;
          <a href="<?php echo base_url(); ?>owner/help#resend">再送信について</a>
        </p>-->
        <div id="list_container">
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
                            elseif(($openScoutMail[0]['is_read'] == 1 && $smNo[0] == 1) || strtotime($openScoutMail[0]['last_visit_date']) > strtotime($openScoutMail[0]['created_date']))
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
                        ?></td>
                    </tr>
                <?php endforeach; ?>
            </form>
        </table>
        </div><!-- / .table-list-wrapper -->

        </div><!-- / #list-container -->

        <div class="btn_box historical-btn-box">
            <?php
            if ($totalpage > 1) {
                 ?>
                <!--<a data-sort="<?php echo (isset($sort))?$sort:''; ?>" href="<?php echo $first_link; ?>" onclick='return setSortBlue(this)' class="_pagination"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_back.png' ?>" alt="前へ"></a>-->
                <?php echo $paging; ?>
                <!--<a data-sort="<?php echo (isset($sort))?$sort:''; ?>" href="<?php echo $last_link; ?>" onclick='return setSortBlue(this)' class="_pagination"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_next.png' ?>" alt="次へ"></a>-->
            <?php
            }
            ?>
        </div>
    </div><!-- / .contents-box-wrapper -->
    </div><!-- list-box ここまで -->
<!--</div>--><!-- container ここまで -->
