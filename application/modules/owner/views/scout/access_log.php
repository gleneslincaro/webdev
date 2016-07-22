<script>
    $(document).ready(function(){
        $("#th12").addClass("visited");
        $('.user-image').bind('contextmenu', function(e){
          return false;
        });
    });
</script>
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
