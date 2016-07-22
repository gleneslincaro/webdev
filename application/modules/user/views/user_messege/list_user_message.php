
<script type="text/javascript">
        $(document).ready(function() {
        var count = parseInt($("#count_message_id").val());
        var count_all = parseInt($("#countall_message_id").val());
        var limit = parseInt($("#limit_message_id").val());
        //alert("all:"+count_all+"count:"+count+"limit:"+limit);
       if(count==0){
           $("#btnphuong").hide();
       }
        if (count == 0 || count_all <= limit) {
            $("#show_more_message_id").hide();
        }
        else
        {
            $("#show_more_message_id").show();
        }
    })
</script>
<input type="hidden" value="<?php echo $gettype?>" id="gettype_meessage_id">
<input type="hidden" value="<?php echo $count?>" id="count_message_id">
<input type="hidden" value="<?php echo $count_all?>" id="countall_message_id">
<input type="hidden" value="<?php echo $limit?>" id="limit_message_id">
<div>
<?php if ($count < 1): ?>
             <div> 現在、対象のデータがありません。 </div>          
    <?php endif; ?>
              <?php $t = 0;?>
<?php foreach ($data as $key) { ?>
         

        <div class="box">
            <div class="box_in">   
                <?php
               
                if(($key['is_read'] == "0" && $key['send_type'] == 1) || ($key['is_read'] == "1" && $key['send_type'] == 2)) {
                    echo '<div class="box_bold">' . '件名：' .$chuoi[$t]. '</div>';
                } else {
                    echo '<div>' . '件名：' .$chuoi[$t]. '</div>';
                }
                
                ?>
                
                <hr size="1px" color="#666666">
                差出人：<?php 
                if($key['user_message_status']==1)
                    echo $key['store_name']; 
                else
                    echo "Joyspe";
                ?><br >
                日付：<?php echo strftime("%Y/%m/%d %H:%M", strtotime($key['send_date'])); ?>
                <div class="messege_delete"><input type="checkbox" class="clCheck" id="id-<?php echo $key['id']; ?>" name="cbkdel[]" value="<?php echo $key['id'].':'.$key['send_type']; ?>"> 削除</div>
            </div>
            <div class="messege_bottom">
                <a class="messege_bottom" href="<?php echo base_url() . 'user/user_messege/messege_reception_in/' . $key['id'].'/'.$key['send_type']; ?>/">本文表示＞</a>
            </div>
        </div>
        <br >

    <?php  $t++; } ?>
</div>