

<script type="text/javascript">
    $(document).ready(function() {
        var count = parseInt($("#count_message_id").val());
        var count_all = parseInt($("#countall_message_id").val());
        var limit = parseInt($("#limit_message_id").val());
        //alert("all:"+count_all+"count:"+count+"limit:"+limit);

        if (count == 0 || count_all <= limit) {
            $("#show_more_message_dustbox").hide();
        }
        else
        {
            $("#show_more_message_dustbox").show();
        }
    })
</script>

<input type="hidden" value="<?php echo $gettype ?>" id="gettype_meessage_id">
<input type="hidden" value="<?php echo $count ?>" id="count_message_id">
<input type="hidden" value="<?php echo $count_all ?>" id="countall_message_id">
<input type="hidden" value="<?php echo $limit ?>" id="limit_message_id">
<div>
    <?php if ($count < 1): ?>
        <div> 現在、対象のデータがありません。 </div>          
    <?php endif;?>
        <?php $t = 0; ?>
    <?php foreach ($data as $key) { ?>
        
      
            <div class="box">
                <div class="box_in">   
                    <?php
                    echo '件名：'.$chuoi[$t];
                   
                    ?>
                    <hr size="1px" color="#666666">
                    差出人：<?php
                        if ($key['user_message_status'] == 1)
                            echo $key['store_name'];
                        else
                            echo "Joyspe";
                        ?><br >
                    日付：<?php echo strftime("%Y/%m/%d %H:%M", strtotime($key['send_date'])); ?><br >
                    状態： 
                    <?php
                    if ($key['is_read'] == "0") {
                        echo '未読 / 受信箱';
                    } else {
                        echo '既読 / 受信箱 ';
                    }
                    ?>  

                </div>
                <div class="messege_bottom">
                    <a class="messege_bottom" href="<?php echo base_url() . 'user/user_messege/messege_return/' . $key['id']; ?>/">戻す</a>    
                </div>

            </div>
        <br>
    <?php  $t++;} ?>
</div>