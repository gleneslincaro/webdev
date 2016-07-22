<script language="javascript">
$(document).ready(function(){
   $( "#txtLastLoginFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
   $( "#txtLastLoginTo" ).datepicker({ dateFormat: "yy/mm/dd" });
   $( "#scout_date_start" ).datepicker({ dateFormat: "yy/mm/dd" });
   $( "#scout_date_end" ).datepicker({ dateFormat: "yy/mm/dd" });
   pagingByAjax();
})
</script>

<center>
    <p>ユーザー検索項目</p>
    <form name="input" action="<?php echo base_url(); ?>admin/mail/<?php echo isset($edit_id) ? 'edit_auto_send_magazine/' . $edit_id : 'create_auto_send_magazine'; ?>/" method="POST">
        <table border="0" cellspacing="10">
            <tr>
                <td>
                    システムID&nbsp;
                    <input style="float:right;" type="text" name="txtSystemID" id="txtSystemID" value="<?php echo isset($condition['txtSystemID']) ? $condition['txtSystemID'] : set_value('txtSystemID'); ?>" size="40" maxlength="100">
                </td>
                <td>
                    氏名　&nbsp;
                    <input type="text" name="txtUserName" id="txtUserName" value="<?php echo isset($condition['txtUserName']) ? $condition['txtUserName'] : set_value('txtUserName'); ?>" size="40" maxlength="100">
                </td>
            </tr>
            <tr>
                <td>
                    <p>アドレス　&nbsp;
                        <input style="float:right;" type="text" name="txtEmailAddress" id="txtEmailAddress" value="<?php echo isset($condition['txtEmailAddress']) ? $condition['txtEmailAddress'] : set_value('txtEmailAddress'); ?>" size="40" maxlength="200">
                    </p>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    最終ログイン&nbsp;
                    <input style="float:right;" class="txtdatePicker" type="text" name="txtLastLoginFrom" id="txtLastLoginFrom" value="<?php echo isset($condition['txtLastLoginFrom']) ? $condition['txtLastLoginFrom'] : set_value('txtLastLoginFrom'); ?>" size="40" maxlength="100">　
                </td>
                <td>
                    〜
                    <input type="text" class="txtdatePicker" name="txtLastLoginTo" id="txtLastLoginTo" value="<?php echo isset($condition['txtLastLoginTo']) ? $condition['txtLastLoginTo'] : set_value('txtLastLoginTo'); ?>" size="40" maxlength="100">
                </td>
            </tr>
            <tr>
                <td>
                     ジョイスペ認証日
                    <input style="float:right;" class="txtdatePicker" type="text" name="scout_date_start" id="scout_date_start" value="<?php echo isset($condition['scout_date_start']) ? $condition['scout_date_start'] : set_value('scout_date_start'); ?>" size="40" maxlength="100">　
                </td>
                <td>
                    〜
                    <input type="text" class="txtdatePicker" name="scout_date_end" id="scout_date_end" value="<?php echo isset($condition['scout_date_end']) ? $condition['scout_date_end'] : set_value('scout_date_end'); ?>" size="40" maxlength="100">
                </td>
            </tr>
            <tr>
                <td>
                    これまでの累計報酬獲得金額
                    <input style="float:right;" type="text" name="rec_money_range_start" id="rec_money_range_start" value="<?php echo isset($condition['rec_money_range_start']) ? $condition['rec_money_range_start'] : set_value('rec_money_range_start'); ?>" size="20"> 円
                </td>
                <td>
                    〜
                    <input type="text" name="rec_money_range_end" id="rec_money_range_end" value="<?php echo isset($condition['rec_money_range_end']) ? $condition['rec_money_range_end'] : set_value('rec_money_range_end'); ?>" size="20"> 円
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    メモ&nbsp;<input type="text" name="txtNote" id="txtNote" value="<?php echo isset($condition['txtNote']) ? $condition['txtNote'] : set_value('txtNote'); ?>" size="80" maxlength="200">
                </td>
            </tr>
        </table>
        <p>登録状態　：
            <select name="sltStatusOfRegistration" id="sltStatusOfRegistration">
                <option value="" <?php  if (!isset($userStatus) || !$userStatus) echo  'selected="selected"'; ?>>選択して下さい</option>
                <option value="0" <?php echo isset($userStatus) && ($userStatus == '0')? 'selected' : '';?>>仮登録</option>
                <option value="1" <?php echo isset($userStatus) && ($userStatus == '1')? 'selected' : '';?>>本登録</option>
                <option value="2" <?php echo isset($userStatus) && ($userStatus == '2')? 'selected' : '';?>>無効</option>
                <option value="3" <?php echo isset($userStatus) && ($userStatus == '3')? 'selected' : '';?>>ステルス</option>
                <option value="4" <?php echo isset($userStatus) && ($userStatus == '4')? 'selected' : '';?>>確認待ち</option>
            </select>
        </p>
        <p>ボーナス付与: 未 <input type="checkbox" name="bonus_grant" <?php echo isset($bonus_grant) && $bonus_grant? 'checked' : ''; ?>></p>
        <p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>
        <p>※検索後の結果は「配信OK」のみ表示される</p>
        <p><input type="submit" name="btnSearchEmailUser" id="btnSearchEmailUser" value="   検索   " /></p>
    </form>
    <?php if(isset($info)): ?>
    <form action="<?php echo base_url(); ?>admin/mail/saveAutoSendMagazine/<?php echo isset($edit_id) ? $edit_id : ''; ?>" method="post">
        <p>合計件数：<?php echo $totalRows;?></p>
        <input type="submit" name="btnSendEmail" id="btnSendEmail" value="<?php echo isset($edit_id) ? 'メルマガ修正' : 'メルマガ作成'; ?>" <?php echo $totalRows? '':'disabled';?>><br><br>
        <table class="template1">
            <tr>
                <th width="15%">システムID </th>
                <th width="20%">状態</th>
                <th width="25%">氏名</th>
                <th width="13%">登録サイト</th>
                <th width="27%">アドレス</th>
            </tr>
            <?php foreach($info as $k=>$item) : ?>
            <tr>
                <td><?php echo $item["unique_id"]; ?></td>
                <td>
                    <?php
                        switch($item['user_status']) {
                        case 0:
                            echo "仮登録";
                            break;
                        case 1:
                            echo "本登録";
                            break;
                        case 2:
                            echo "無効";
                            break;
                        case 3:
                            echo "ステルス(非表示)";
                            break;
                        case 4:
                            echo "確認待ち";
                            break;
                        default:
                            echo "変な値";
                        }
                    ?>
                </td>
                <td><?php echo $item["userName"]; ?></td>
                <td><?php echo $item["websiteName"]; ?></td>
                <td><?php echo $item["email_address"]; ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
        <input type="hidden" value="<?php echo htmlspecialchars($post_condition); ?>" name="post_condition" />
        <input type="hidden" value="<?php echo $arrayEmail; ?>" name="arrayEmail" />
        <div id="jquery_link_user" align="center"></div>
    </form>
    <?php endif; ?>
    <div id="jquery_link_user" align="center">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</center>
