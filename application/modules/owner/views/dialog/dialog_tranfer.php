<script language='javascript'>
    $(document).ready(function() {
        $('#dialog_tranfer').click(function() {            
            var strURL = baseUrl + "owner/dialog/checkDialogPenalty";
            $.ajax({
                url: strURL,
                type: 'POST',
                cache: false,
                success: function(string) {                  
                    var data = $.parseJSON(string);
                    if (data.count_penalty == 0){
                        window.location.replace(baseUrl + "owner/index");
                    } else {
                        window.location.replace(baseUrl + "owner/index/index03");
                    }
                },
                error: function() {
                    
                }
            });

        });
        
    })
</script>
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■振込お知らせメール・送信</div>

    <br ><br ><br >



    <div class="message_box">


        「振込お知らせメール」の送信が完了しました。<br>
        ご登録アドレス宛に「お振込先口座」情報をお送りしております。ご確認の程よろしくお願い致します。<br>
        また、お振込作業をお願い致します。入金確認後・決済手続きをさせて頂きます。<br>

    </div>
    <?php
//        echo "<input type='hidden' name='txtbase' id='txtbase' value='".base_url()."'>";
    ?>
    <br>
    <br>
    <center><a href="<?php echo base_url().'owner/index' ?>">TOPへ戻る</a></center>
</div><!-- list-box ここまで -->