<script language='javascript'>
    $(document).ready(function(){
        $("#txtDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
        $("#txtDateTo").datepicker({ dateFormat: "yy/mm/dd" });
        paginationOwner();
        pagingByAjaxSearch();
    })
</script>
<center>
<form name="formSearchSends" method="post" action="<?php echo base_url(); ?>admin/log/searchOwner" >
    日付&nbsp;<input type="text" id="txtDateFrom" name="txtDateFrom" value="<?php echo $txtDateFrom?>">　〜　<input type="text" id="txtDateTo" name="txtDateTo" value="<?php echo $txtDateTo?>">
    <p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>
    <p><button type="submit">検索</button></p>
</form>
<?php if(isset($ownerResult)):?>
  <div style="margin:0px;padding:0px;" align="center">
      <br/>
      <table width="80%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
          <tr>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">Unique ID&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">Owner店舗名&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">エリア地域&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">最終ログイント&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アクセス数&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">スカウト送信数&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">開封数&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">開封率&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">Email&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">電話&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">匿名&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">HP&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">クチコミ&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">面接&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">体験入店&nbsp;</th>
              <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">お問合せ受信数&nbsp;</th>
          </tr>
        <?php if ($ownerResult !=null): ?>
            <?php foreach ($ownerResult as $row):?>
                <tr>
                    <td style="border:1px solid #000000;text-align:left;"><?php echo $row['unique_id']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:left;"><?php echo $row['storename']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['area']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:left;"><?php echo $row['last_visit_date']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:left;"><?php echo $row['shop_access_num']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['scout_mail_send']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['scout_mail_open']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo round(($row['scout_open_rate'] * 100),1); ?>%&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['mail_click_num']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['tel_click_num']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['question_num']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['hp_click_num']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['kuchikomi_click_num']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['travel_num']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['campaign_bonus_num']?>&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:right;"><?php echo $row['mails_receive']?>&nbsp;</td>
                </tr>
            <?php endforeach;?>
        <?php endif;?>
      </table>
    <br/>
    <div id="pagination_owner" align="center"><?php echo $this->pagination->create_links()?></div><br/>
    <?php if(count($ownerResult) > 0):?>
    <div id="download_csv" align="center">
        <form name="formCsvOwner" method="post" action="<?php echo base_url();?>admin/authentication/downloadOwnerCsv">
            <input type="hidden" name="txtDateFrom" value="<?php echo $txtDateFrom?>" />
            <input type="hidden" name="txtDateTo" value="<?php echo $txtDateTo?>" />
            <button type="submit">ダウンロード</button>
        </form>
    </div>
    <?php endif;?>
  </div>

<?php endif;?>
</center>
