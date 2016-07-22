<center>
<p>月次配信</p>
<p>※店舗詳細のメール送信がオンになっている店舗、代理店に月次配信</p>
<p><input type="submit" name="btnMonthlySend" id="btnMonthlySend" value="   送信   " /></p>
</center>

<script>
    $("#btnMonthlySend").click(function(){
        if(confirm('月次送信します、よろしいですか？')){
            $.ajax({
                url:"<?php echo base_url();?>admin/mail/analysissend",
                type:"post",
                data:{},
                success:function(data){
                    window.location="<?php echo base_url();?>admin/mail/send_complete";
                }
            });
        }
    });
</script>