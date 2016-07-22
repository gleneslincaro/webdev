<script type="text/javascript">  
    function _back() {    
        window.location.replace("<?php echo base_url();?>admin/setting/makia_login_bonus");
    }  
</script>
<center>
<div class="makia-login-bonus-list">
    <p>累計ログインポイント設定</p>
    <p>作成日 : <?php echo date("Y-m-d H:i:s"); ?></p>
    <div class="validation">
        <?php echo validation_errors(); ?>
        <?php if ( isset($add_error_messages) ): ?>  
            <?php for ( $i=0; $i<count($add_error_messages); $i++ ): ?>
                <p><?php echo $add_error_messages[$i]; ?></p>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
    <form method="POST">
        <table>
            <tbody>
                <tr>
                    <th class="condition-id">条件</th>
                    <th class="num-of-days">日数</th>
                    <th class="bonus-points">ボーナス</th>      
                </tr>      
                <?php for ( $i = 0; $i<10; $i++ ): ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><input type="text" id="no_of_days<?php echo $i+1; ?>" name="no_of_days<?php echo $i+1; ?>" value="<?php echo isset($no_of_days_arr[$i])?$no_of_days_arr[$i]:''; ?>" ></td>
                        <td width="170px"><input type="text" id="bonus_point<?php echo $i+1; ?>" name="bonus_point<?php echo $i+1; ?>" value="<?php echo isset($bonus_point_arr[$i])?$bonus_point_arr[$i]:''; ?>" ><span style="float: right">円</span></td>
                    </tr>
                <?php endfor; ?>           
            </tbody>
        </table>
        <br />  
        <input type="submit" style="padding: 5px; " id="save-new-bonus" name="save-new-bonus" value="保存">
        <input style="padding: 5px;" type="button" value="戻る" onclick="_back();" />        
    </form>    
</div>
</center>
