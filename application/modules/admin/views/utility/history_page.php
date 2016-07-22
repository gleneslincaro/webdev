<script language="javascript">
$(document).ready(function(){
    $("#txtDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtDateTo").datepicker({ dateFormat: "yy/mm/dd" });
    pagingByAjaxSearch();
    pagingAjax();
})
</script>
<div id="content">
    <center>
    <div id="history_log">
        <form id="history_log" method="post" action="">
            <table>
                <tr>
                    <td><label>追加理由</label><span style="color:red">*</span></td>
                    <td><input type="text" name="reason" id="reason" placeholder="追加理由" value="<?php echo $reason?>"/></td>
                </tr>
                <tr>
                    <td><label>ユニークＩＤ</label></td>
                    <td><input type="text" name="unique_id" id="unique_id" placeholder="ユニークＩＤ" value="<?php echo $unique_id?>"/></td>
                </tr>
                <tr>
                    <td><label>メール</label></td>
                    <td><input type="text" name="email" id="email" placeholder="メール" value="<?php echo $email?>"/></td>
                </tr>
                <tr>
                    <td><label>日付</label></td>
                    <td><input type="text" id="txtDateFrom" name="txtDateFrom" value="<?php echo $dateFrom; ?>">　〜　<input type="text" id="txtDateTo" name="txtDateTo" value="<?php echo $dateTo; ?>"></td>
                </tr>
                <tr>
                  <td></td>
                  <td><button type="submit">検索</button></td>
                </tr>
            </table>
        </form>
        <?php if (isset($history_log)):?>
            <table width="100%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
                <tbody>
                    <tr>
                        <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center">ID</th>
                        <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center">ユーザーID</th>
                        <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center">追加日付</th>
                        <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center">追加金額（円）</th>
                        <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center">追加理由</th>
                    </tr>
                    <?php foreach($history_log as $result_history):?>
                        <tr>
                            <td style="border:1px solid #000000;"><?php echo $result_history['id']?></td>
                            <td style="border:1px solid #000000;"><?php echo $result_history['unique_id']?></td>
                            <td style="border:1px solid #000000;"><?php echo $result_history['created_date']?></td>
                            <td style="border:1px solid #000000;"><?php echo $result_history['new_bonus_money']?></td>
                            <td style="border:1px solid #000000;"><?php echo $result_history['reason']?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <div id="pagination"><?php echo $this->pagination->create_links()?></div>
        <?php endif;?>
    </div>
    </center>
</div>
