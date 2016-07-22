<script type="text/javascript">

    $(document).ready(function() {
        displayPopupError();

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
        else
        {
            var hdflag = $('#hdflag').val();
            var action = baseUrl + "owner/company/do_edit";
            if(hdflag == 1)
            {
               if(window.confirm("登録しますか？"))
               {
                   $('#combanyBasic').ajaxSubmit({
                       url: action,
                       type: 'post',
                       dataType:'text',
                       success: function(result){
                           $('#hdflag').val(0);
                           window.location=baseUrl + "owner/dialog/dialog_change";
                       }
                   });
               }
            }
        }
    }
</script>


TOP ＞ 会社情報 ＞ 基本情報変更

<!--
<div style="float:right"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">▼ポイント購入</a></div><br >
-->

<?php
if (count($owner_info) > 0) {
    ?>
    <?php echo Helper::print_error($message); ?>
    <form id="combanyBasic" name="combanyBasic" action="" method="post" enctype="multipart/form-data" >
        <div class="list-box"><!-- list-box ここから -->
            <div class="list-title">■基本情報変更　(*)は必須項目です</div><br ><br >
            <div class="information_box">
                <input type="hidden" name ="id" value="<?php echo $owner_info['id']; ?>"/>
                <table class="information">
                    <tr>
                        <td>*メールアドレス</td>

                        <td><input type="text" id="txtEmailAddress" name="txtEmailAddress" size="60" value="<?php echo set_value('txtEmailAddress', $owner_info['email_address']); ?>"></td>
                    </tr>
                    <tr>
                        <td>*パスワード</td>
                        <td><input type="" id="txtPassword" name="txtPassword" size="60" value="<?php echo set_value('txtPassword', base64_decode($owner_info['password'])); ?>"></td>
                    </tr>
                    <tr>
                        <td>*店舗名</td>
                        <td><input type="text" id="txtStoreName" name="txtStoreName" size="60" value="<?php echo set_value('txtStoreName', $owner_info['storename']); ?>"></td>
                    </tr>
                    <tr>
                        <td>*住所</td>
                        <td><input type="text" id="txtAddress" name="txtAddress" size="60" value="<?php echo set_value('txtAddress', $owner_info['address']); ?>"></td>
                    </tr>
                    <tr>
                        <td>*転送設定</td>
                        <td>
                                <input type="radio" name="set_send_mail" value="1" <?php if ($set_send_mail == 1) echo "checked"; ?>> ON
                                <input type="radio" name="set_send_mail" value="0" <?php if ($set_send_mail == 0) echo "checked"; ?>> OFF
                        </td>
                    </tr>
                    <tr>
                        <td>店舗情報公開</td>
                        <td>
                            <input type="radio" name="public_info_flag" value="1" <?php if ($public_info_flag == 1) echo "checked"; ?>>公開
                            <input type="radio" name="public_info_flag" value="0" <?php if ($public_info_flag == 0) echo "checked"; ?>>非公開
                        </td>
                    </tr>
                </table>
            </div>
            <br/>
            <input type="hidden" id="hdflag" name="hdflag" value="<?php echo set_value('hdflag', $hdflag); ?>" />
            <div class="list-t-center">
                <input type="submit" value="　変更　" />
            </div>
        </div><!-- list-box ここまで -->
    </form>
    <?php
}?>
