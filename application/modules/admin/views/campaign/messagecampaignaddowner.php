<script type="text/javascript">
    $(function() {
        var message = "<?php echo isset($_message)?$_message:'';?>";
        if (message != "") {
            alert(message);
            location.replace("<?php echo base_url().'admin/campaign/messagecampaignownerlist/'; ?>");
        } 
    }); 
    
    function _back() {    
        window.location.replace("<?php echo base_url();?>admin/campaign/messagecampaignownerlist/");
    }  
</script>
<center>
    <div class="makia-login-bonus-list">
        <p class="mb20">メッセージキャンペーンに店舗追加</p>                   
        <div class="validation"><?php echo validation_errors(); ?></div>
        <form method="POST" name="message_campaign_add_owner" id="message_campaign_add_owner">
            <table class="mb20">
                <tbody>
                    <tr>
                        <th class="condition-id">エリア名</th>
                        <td><input type="text" value="<?php echo set_value('area', isset($owner_data['area'])?$owner_data['area']:''); ?>" name="area" id="area"></td>
                    </tr>    
                    <tr>
                        <th class="num-of-days">店舗名</th>
                        <td><input type="text" class="w250" value="<?php echo set_value('storename', isset($owner_data['storename'])?$owner_data['storename']:''); ?>" name="storename" id="storename"></td>
                    </tr>
                    <tr>
                        <th class="bonus-points">店舗名に対するＵＲＬ</th>      
                        <td><input type="text" class="w350" value="<?php echo set_value('url', isset($owner_data['url'])?$owner_data['url']:''); ?>" name="url" id="url"></td>
                    </tr>                
                </tbody>
            </table>        
            <input id="add_owner" name="add_owner" type="submit" style="padding: 5px;"  value="店舗追加" />
            <input style="padding: 5px;" type="button" value="戻る" onclick="_back();" />    
        </form>        
    </div>
</center>
