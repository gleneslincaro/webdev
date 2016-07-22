<script type="text/javascript">  
    $(function() {
        var message = "<?php echo isset($save_message)?$save_message:''; ?>";
        if (message) {
            alert(message);
        }
        $('#disable-campaign').click(function(){
            var base_url = "<?php echo base_url()?>";
            if(confirm('このキャンペーン広告を本当に削除しますか？')){
                $.post(base_url+'admin/setting/disableCampaignAd',function(data){window.location.href=base_url+'admin/setting/monthly_campaign_result_ads';});
            }
            return false;
        });
    });
</script>
<center>
<div class="mcra-list">
    <p>月度キャンペーンの結果広告</p>   
    <div class="validation">
        <?php echo validation_errors(); ?>        
    </div>
    <form method="POST">
        <table>
            <tbody>
                <tr>
                    <th class="month">月度</th>
                    <th class="travel-expense-total-paid-money">面接交通費</th>
                    <th class="trial-work-total-paid-money">入店お祝い金</th>       
                </tr>                      
                <tr>                    
                    <td>
                        <select name="mcra-month" id="mcra-month">
                            <?php foreach($months as $key => $val1) : ?>
                                <option value="<?php echo ($key == 0)?'':$key; ?>" <?php echo ((isset($month) && $month == $key) || (isset($data['month']) && $data['month'] == $key))?'selected':''; ?>><?php echo $val1?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td width="170px">                    
                        <input type="text" name="tetp-money" id="tetp-money" value="<?php echo isset($tetp_money)?$tetp_money:''; ?>"><span style="float: right;">円</span>
                    </td>
                    <td width="170px">
                        <input type="text" name="twtp-money" id="twtp-money" value="<?php echo isset($twtp_money)?$twtp_money:'' ?>"><span style="float: right;">円</span>
                    </td>                                        
                </tr>                
            </tbody>
        </table>
        <br />          
        <input type="submit" style="padding: 5px; " id="save-mcra" name="save-mcra" value="保存">
        <button name="disable-campaign" id="disable-campaign" style="padding: 5px;" onclick="return false;">非表示</button> 
    </form>
    
   
       
</div>
</center>
