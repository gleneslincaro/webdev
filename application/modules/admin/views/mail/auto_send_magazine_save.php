<script language="javascript">
    $(document).ready(function(){
            addText();
           $('#btn_save').click(function(){
                var title = $('#txtTitle').val();
                if (!$("#owner option:selected" ).val() || !title) {
                    alert('select owner and add title');
                    return false;
                }
           });
    })
</script>

<form action="" method="post">
    <center>
        <p>メルマガ作成</p>
        <p><input type="text" name="searchStore" id="searchStore" placeholder ="店舗名のキーワードを入力"/>
            <button id="btnSearchStore" onclick="storeKeyword();return false;">検索</button>
            店舗名一覧:
            <select name="owner" id="owner">
            <option value="">--店舗名一覧--</option>
            <?php foreach($owners as $store): ?>
                <option value="<?php echo $store['id']; ?>" <?php echo isset($owner_id) && $owner_id == $store['id'] ? 'selected': '' ;?>> <?php echo $store['storename']; ?></option>
            <?php endforeach; ?>
            </select>
        </p>
        <p>件名：&nbsp;<input type="text" maxlength="200" name="txtTitle" id="txtTitle" value="<?php echo isset($title) ? $title: '' ;?>" size="100" /></p>
        <p>送信時間指定:
            <select name="time_to_send">
            <?php for ($i=0; $i <= 23 ; $i++) : ?>
                <option <?php echo isset($send_time) && $send_time == $i? 'selected' : ''; ?>><?php echo $i; ?>:00</option>
            <?php endfor; ?>
            </select>
        </p>
    </center>
    <div style="margin:0px;padding:0px;" align="center">
        <table width="95%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
            <tr>
                <td style="border:1px solid #000000;width:120px;">
                    <span id="aspan">送信内容</span>
                </td>
                <td style="border:1px solid #000000;width:450px;">
                    <textarea name="context" id="context" cols="60" rows="40" maxlength="50000">
                        <?php
                        if(isset($_POST["context"])){
                            echo $_POST["context"];
                        }else {
                            echo $content['content'];
                        }?>
                    </textarea>
                </td>
                <td style="border:1px solid #000000;" width="40">
                    <input type="button" id="btnReplace" name="btnReplace" value="<=">
                </td>
                <td style="border:1px solid #000000;" width="100">
                    <select name="sltOptions" id="sltOptions" size="10">
                        <option value="ユーザーID">ユーザーID</option>
                        <option value="ユーザー地域">ユーザー地域</option>
                        <option value="ユーザー氏名">ユーザー氏名</option>
                        <option value="トップページURL">トップページURL(ログイン情報含む)</option>
                        <option value="店舗URL">店舗URL</option>
                        <option value="未読のスカウトメール">未読のスカウトメール</option>
                        <option value="現在の報酬額">現在の報酬額</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #000000;"width="80">配信アドレス&nbsp;</td>
                <td colspan="3">
                    <input type="text" name="txtFromEmail" id="txtFromEmail" size="50" value="info@joyspe.com">
                </td>
            </tr>
        </table>
        <input type="hidden" name="post_condition" value="<?php echo htmlspecialchars($post_condition); ?>">
        <input type="hidden" name="arrayEmail" value="<?php echo $arrayEmail; ?>">
    </div>
    <center>
        <p><input type="submit" id="btn_save" name="btn_save" value="<?php echo isset($edit_id) ? '自動送信メール修正' : '自動送信メール予約'; ?>"></p>
    </center>
</form>
