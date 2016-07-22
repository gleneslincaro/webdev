<div class="crumb">TOP ＞ <?php echo $title_header; ?></div>
<div style="clear: both; margin: 40px 0px -20px">
    <a class="create_article" href="<?php echo base_url(); ?>owner/recruitment/" ><span>募集</span></a>  
</div>
<div class="list-box"><!-- list-box ここから -->
    <div class="list-title"><?php echo $title_header; ?></div>
    <div class="contents-box-wrapper">
        <div class="article_container">
            <div class="errors">
            <?php echo validation_errors(); ?>
            <?php if(isset($errors)) : ?>
                <?php for ($i = 0; $i < count($errors); $i++) :?>
                    <p><?php echo $errors[$i]; ?></p>
                <?php endfor; ?>
            <?php endif; ?>
            </div>
            <form method='POST'>
                <div class="article_types">
                曜日投稿
                    <div id="weekly_wrapper">
                        <input type='hidden' name='recruitment_type' value='weekly' id='weekly' >
                        <label>曜日投稿</label>
                        <select name='post_day' id='post_day'>
                            <option value=''></option>
                            <?php for ($i = 0; $i <= 6; $i++) : ?>
                                <option value='<?php echo $i; ?>'><?php echo $days[$i]; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="post_hour" id="post_hour">
                          <option value=''></option>
                          <?php for ($i = 0; $i<=23; $i++) : ?>
                              <option value="<?php echo $i; ?>"><?php echo ($i < 10)?'0'.(string)$i.':00':(string)$i.':00'; ?></option>
                          <?php endfor; ?>
                        </select> 時
                    </div>
                </div>
                <textarea id ="message" name="message" placeholder="急募求人内容をご記入ください"><?php echo set_value('message', isset($message)?$message:''); ?></textarea>               
                <div class="t_center mt_15 mb_15">
                    <input type='submit' value='投稿' name='post_article' id='post_article'/>
                </div>
            </form>
        </div>
    </div>
</div>

<script type='text/javascript'>
    $(function() {     
        $('.success').fadeOut(2000);
        $("#post_date").datetimepicker({lang: 'ja'}); 
//        $('#weekly_wrapper').hide();
//        $('#occasional_wrapper').hide();

        var recruitment_type = "<?php echo isset($recruitment_type)?$recruitment_type:''; ?>";
        if (recruitment_type != '') {
            $('#'+recruitment_type+'_wrapper').show();
        } else {
//          $('#post_article').attr('disabled', 'disabled');
        }
        $("#post_day").find("option").each(function () {
            if ($(this).val() == "<?php echo isset($post_day)?$post_day:''; ?>") {
              $(this).prop("selected", "selected");
            }
        });
        
        $("#post_hour").find("option").each(function () {
            if ($(this).val() == "<?php echo isset($post_hour)?$post_hour:''; ?>") {
              $(this).prop("selected", "selected");
            }
        });

        $('#weekly').change(function() {
            $('#post_date').val('');
            $('#occasional_wrapper').hide();            
            $('#weekly_wrapper').show();      
//            $('#post_article').removeAttr('disabled');
        });
/*        
        $('#occasional').change(function() {
            $('#post_day').val('');
            $('#post_hour').val('');
            $('#weekly_wrapper').hide();
            $('#occasional_wrapper').show();            
            $('#post_article').removeAttr('disabled');
        }); 
*/
        var success = "<?php echo isset($success_message)?$success_message:0; ?>";
        if (success != '0') {
            if (success == 'edit') {
                alert('急募情報を更新しました。');
            } else {
                alert('急募情報が保存されました。');
            }             
            window.location.href = "<?php echo base_url().'owner/recruitment/'; ?>";
        }
          
    });
</script>
<style>
    #weekly_wrapper, #occasional_wrapper {
        float: right;
    }
    
    #message {
        width: 795px;
        height: 200px;
        padding: 10px;
    }    
</style>