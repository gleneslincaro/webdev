<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/themes/light/light.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/themes/dark/dark.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/themes/bar/bar.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>public/owner/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#th11").addClass("visited");
  $('[name=from_date],[name=to_date]').change(function(){
      var fromdate = $('[name=from_date] option:selected').text();
      var todate = $('[name=to_date] option:selected').text();
      $('#sort_in_progress').show();
      $.post("<?php echo base_url();?>owner/analysis/result_of_analysis",{from_date:fromdate,to_date:todate}, function(data){
        $('#analysis').html(data);
        $("#top_of").show();        
        $('#sort_in_progress').hide();
        var size = $('#analysis tr.head td').length * 67;
        $('#analysis').css('width',size+'px');
      });
  });
});
</script>
<style>
.analysis_box{
overflow:hidden;
margin: 0 auto;
width: 98%; 
}
.lock_box{
float:left;
width: 104px;
}
.x_scroll_box{
overflow-x:scroll; 
}
table#analysis_head{
margin-left: auto;
margin-right: auto;
}
table#analysis_head tr{
border: 1px solid #333;
width: 100px;
height: 50px;  
}
table#analysis_head tbody tr.head{
height: 30px;  
}
table#analysis_head tr th{
border: 1px solid #FFF;
width: 35px;
background-color:#ADADAD;  
}
table#analysis_head tr td{
border: 1px solid #FFF;
width: 100px;  
background-color:#ADADAD;  
}
table#analysis_head tr td span{
color:#FF0000;
}
table#analysis{
margin-left: auto;
margin-right: auto;
float: left;
}
table#analysis tr{
border: 1px solid #333;
height: 50px;  
}
table#analysis tr.head{
height: 30px;  
}
table#analysis tr th{
border: 1px solid #FFF;
width: 35px;
background-color:#ADADAD;  
}
table#analysis tr td{
border: 1px solid #FFF;
width: 65px;  
background-color:#ADADAD;  
}
table#analysis tr td span{
color:#FF0000;
}
a#to_detail{
  color: #00f;
  font-size: 16px;
  text-decoration: underline;
  cursor: pointer;
}
</style>

<div class="crumb">TOP ＞ アクセス解析</div><br>

<!-- <div style="float:right;"><a id="to_detail">くわしくは</a></div>  -->

<div class="list-box"><!-- list-box ここから -->
  <div class="list-title">アクセス解析

      <!--search -->
      <form class="historical-data-form" name="myForm" action="<?php echo base_url()."owner/analysis/doAnalysis"; ?>" method ="post" style="width:255px;float:right;">
        <span style="font-size:14px;">期間指定</span>
        <select name="from_date">
        <?php 
        end($select_date_from);
        $lastkey = key($select_date_from);
        foreach($select_date_from as $key=>$value): ?>
        <option <?php if($key == $lastkey){echo "selected";}?> value=""><?php echo $value;?></option>
        <?php endforeach; ?>
        </select>~

        <select name="to_date">
        <?php 
        end($select_date_to);
        $lastkey = key($select_date_to);
        foreach($select_date_to as $key=>$value): ?>
        <option <?php if($key == $lastkey){echo "selected";}?> value=""><?php echo $value;?></option>
        <?php endforeach; ?>
        </select>
      </form>
      <!--end search -->
  </div>
    <div class="contents-box-wrapper">
      <div class="analysis_box">
        <div class="lock_box">
          <table id = "analysis_head" border="0" cellpadding="5" cellspacing="0" width="100%" style="">
              <tr class="head" >
              <th style="background-color:#1DDCD5;">&nbsp;</th>
              </tr>
              <tr>
              <th>開封率</th>
              </tr>

              <tr>
              <th>アクセス</th>
              </tr>

              <tr>
              <th>HP</th>
              </tr>

              <tr>
              <th>クチコミ</th>
              </tr>

              <tr>
              <th>電話</th>
              </tr>

              <tr>
              <th>Email</th>
              </tr>

              <tr>
              <th>匿名質問</th>
              </tr>

              <tr>
              <th>面接</th>
              </tr>

              <tr>
              <th>体験入店</th>
              </tr>
          </table>
        </div>
        <div class="x_scroll_box">
          <table id = "analysis" border="0" cellpadding="5" cellspacing="0" width="100%" style="">
              <tr  class="head" >
              <td style="background-color:#1DDCD5;"><?php echo $analysis_data[0]['nowmonth']; ?></td>
              </tr>

              <tr>
              <td><?php
                  echo round($analysis_data[0]['scout_open_rate'] * 100 ,1);
              ?>%</td>
              </tr>

              <tr>
              <td><?php echo $analysis_data[0]['shop_access_num']; ?></td>
              </tr>

              <tr>
              <td><?php echo $analysis_data[0]['hp_click_num']; ?></td>
              </tr>

              <tr>
              <td><?php echo $analysis_data[0]['kuchikomi_click_num']; ?></td>
              </tr>

              <tr>
              <td><?php echo $analysis_data[0]['tel_click_num']; ?></td>
              </tr>

              <tr>
              <td><?php echo $analysis_data[0]['mail_click_num']; ?></td>
              </tr>

              <tr>
              <td><?php echo $analysis_data[0]['question_num']; ?></td>
              </tr>

              <tr>
              <td><?php echo $analysis_data[0]['travel_num']; ?></td>
              </tr>

              <tr>
              <td><?php echo $analysis_data[0]['campaign_bonus_num']; ?></td>
              </tr>
          </table>
        </div>
      </div><!-- / .analysis_box -->
      <p id ="top_of" style="display:none;margin-left:20px;color:#F00;">※赤文字は上位の店舗のデータです。</p>
    </div><!-- / .contents-box-wrapper -->
    <!--this is for the latest user log access-->
    <div class="list-box"><!-- list-box ここから -->
        <div class="list-title">ページ全体アクセス数：<?php echo $count_access_log;?>アクセス</div>
        <div class="contents-box-wrapper">
            <center>
                <table>
                <?php foreach ($latest_user_access_log as $latest_log):?>
                    <tr>
                        <td><?php echo date('Y年m月d日 H:i ',strtotime($latest_log['visited_date']));?></td>
                        <td><span id="name" style="color:#026CD1;"><?php echo ($latest_log['user_id']==0) ? '非会員' :$latest_log['unique_id']?></span></td>
                    </tr>
                <?php endforeach;?>    
                </table>
            </center>
        </div>

    </div>
</div>
<?php
    $this->load->view('index/wait_for_sort');
?>