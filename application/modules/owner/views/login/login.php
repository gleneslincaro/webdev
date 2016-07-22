<script type="text/javascript">
    $(document).ready(function() {
        displayPopupError();
        
        if($('#ckAccept').is(':checked'))
       {
           $('#loginBtn').attr('disabled',false);
           $("#loginBtn").removeAttr('disabled');
       }
       else{      
           $('#loginBtn').attr("disabled",true);
       }
       
    });

    function displayPopupError() {
        var div_error = $(".hide-error");
        if (div_error.length > 0) {
            var error = div_error.text();
            var arr = error.split('● ');
            var strErr = "";
            for (i = 1; i < arr.length; i++)
            {
                strErr += '● ' + arr[i] + "\n";
            }
            alert(strErr);
        }
    }
    function initPlaceholder() {
        var inputFields = $('input[myPlaceholder]').stickyPlaceholders({
                placeholderAttr: 'myPlaceholder'
        });
    };
    function autoFocus(){
        $('input[myPlaceholder]').each(function(idx, value){
            setTimeout(function(){
                $(value).trigger('focusin');
                $(value).trigger('focusout');
            }, 100);
        });
    }
    
    function showBtnLogin()
    {
       if($('#ckAccept').is(':checked'))
       {
           $('#loginBtn').attr('disabled',false);
           $("#loginBtn").removeAttr('disabled');
       }
       else{       
           $('#loginBtn').attr("disabled",true);
       }
    }


</script>

<style>
    
    .ie8 #loginBtn{
        width: 108px !important;        
    } 
    
    .ie8 .sticky-placeholder-label{
        padding-top: 4px !important;        
    } 
    
    .ie9 #loginBtn,
    .ie10 #loginBtn{
        width: 104px !important;
    }
    
    .ie9 sticky-placeholder-label,
    .ie10 sticky-placeholder-label{
        padding-top: 4px !important; 
    }
    
</style>

<div class="list-box"><!-- list-box ここから -->
    <div class="login_box">
        <?php echo Helper::print_error($message); ?>
        <div class="login_box_c">
            <form id="login" name="login" method="post" action="">
                <table class="login">
                    <tr>
                        <td id="tdEmail" style="text-align: left; padding-left: 24px; border-bottom: none; padding-top: 8px; padding-bottom: 0px; ">
                            <input myPlaceholder="メールアドレス" type="text" id="txtEmail" name="txtEmail" size="50" value="<?php echo set_value('txtEmail'); ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td id="tdPass" style="text-align: left; padding-left: 24px; padding-top: 1px; padding-bottom: 8px">
                            <div style="padding-top: 2px; float: left; padding-right: 2px;">
                                <input myPlaceholder="パスワード" type="password" id ="txtPassword" name="txtPassword" size="50" value="<?php echo set_value('txtPassword'); ?>">
                            </div>                            
                       </td>
                    </tr>  
                    <?php if (isset($captcha_img)) : ?>
                    <tr>
                        <td style="text-align: left; padding-left: 24px; border-bottom: none; padding-top: 8px; padding-bottom: 0px; ">
                            <?php echo $captcha_img; ?>                            
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding-left: 24px; border-bottom: none; padding-top: 8px; padding-bottom: 8px; ">
                            <input type="text" name="captcha" value="" size="50" placeholder="キャップトチャ" />                
                        </td>
                    </tr>
                    <input type="hidden" name="has_captcha" value="true" />
                    <?php endif; ?>
                </table>
                <br />
                <div class="list-t-center">
                  ※健全なサイトを運営を行うため、利用規約に同意したうえでログインを行ってください。<br >
                  <input type="checkbox" id="ckAccept" name="ckAccept" <?php if(isset($_POST['ckAccept'])) echo "checked"; ?> onclick="showBtnLogin();">規約に同意する
                  <br />
                  <input type="submit" style="width:100px; height:26px;" value="ログイン" id="loginBtn">                                                              
                </div>
                   
            </form>
            <br />            
        </div>
        <div class="list-t-center">
          <p><iframe src="<?php echo $frame; ?>" class="example1"></iframe></p>      
          <br />
          <a href="<?php echo base_url(); ?>owner/inquiry/inquiry">パスワードを忘れた方はこちら</a>          
        </div>        
        <br >
        <table class="login list-t-center">
            <tr>
                <th>新規登録</th>
            </tr>
            <tr>
                <td>
                    <input type="button" id="btnRegist" name="btnRegist" value="新規登録はコチラ" style="width:200px; height:60px;" onClick="javascript:location.href = '<?php echo base_url() . 'owner/login/login_company' ?>';">
                    <br ><br >
                </td>
            </tr>
        </table>

    </div>
    <br style="clear:both">
  
</div><!-- list-box ここまで -->

<script>
(function() {  

    if ($.browser.msie){
        if($.browser.version == 8){
            $('body').addClass('ie8');
        } else if($.browser.version == 9){
            $('body').addClass('ie9');
        } else if($.browser.version == 10){
            $('body').addClass('ie10');
        } 
    }   
    initPlaceholder();
    autoFocus();
})();
</script>