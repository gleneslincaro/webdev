<script type="text/javascript">
      $(document).ready(function(){       
       displayPopupError();
    });
    
    function displayPopupError(){
        var div_error = $(".hide-error");
        if(div_error.length > 0){
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
</script>

<div class="list-box">
    <div class="list-title">問合せフォーム</div>
<div class="contents-box-wrapper">
    <center>
        <?php echo Helper::print_error($message); ?>
        <br><br ></center>
    <form action="<?php echo base_url().'owner/inquiry/inquiry'; ?>" method="POST" >
        <table align="center">
            <tr>
                <th style="font-size: medium">会社名・店舗名</th>
                <td><input type="text" name="txtStoreName" id="txtStoreName" size="68" value="<?php if(!empty($storename)) {echo $storename;} ?>"></td>
            </tr>
            <tr>
                <th style="font-size: medium">メールアドレス</th>
                <td><input type="text" name="txtEmail" id="txtEmail" size="68" value="<?php if(!empty($email)) {echo $email;} ?>"></td>
            </tr>
            <tr>
                <th style="font-size: medium">件名　</th>
                <td><input type="text" name="txtSubject" id="txtSubject" size="68" value="<?php if(!empty($sSubject)) {echo $sSubject;} ?>"></td>
            </tr>
            <tr id="inquiry-last">
                <th style="font-size: medium">メッセージ　</th>
                <td><textarea name="txaBody" id="txaBody" cols="60" rows="14"><?php if(!empty($sBody)) {echo $sBody;} ?></textarea></td>
            </tr>
        </table>
        <br><br>
        <center><button type="submit">　送信　</button></center>
    </form>
    <br><br>
</div><!-- /. contents-box-wrapper -->
</div>

