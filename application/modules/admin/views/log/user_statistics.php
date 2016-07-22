<script language='javascript'>
    $(document).ready(function(){
        $("#txtDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
        $("#txtDateTo").datepicker({ dateFormat: "yy/mm/dd" });
        pagingByAjaxSearch();
        paginationUserStatistics();
    })
</script>
<div id="content">
    <center>
        <form name="formSearchSends" method="post" action="<?php echo base_url()?>admin/log/userStatistics" >
            日付 &nbsp;<input type="text" id="txtDateFrom" name="txtDateFrom" value="<?php echo $dateFrom?>">　〜　<input type="text" id="txtDateTo" name="txtDateTo" value="<?php echo $dateTo?>">
            <p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>
            <p><button type="submit">検索</button></p>
        </form>
    </center>
    <?php if(isset($userStats)):?>
        <div style="margin:0px;padding:0px;" align="center">
            <br/>
            <table width="100%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
                <tr>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザーユニークＩＤ&nbsp;</th>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザー名&nbsp;</th>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">メールクリック&nbsp;</th>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">電話クリック&nbsp;</th>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ＬＩＮＥクリック&nbsp;</th>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">口コミクリック&nbsp;</th>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">お問い合わせ&nbsp;</th>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ＨＰクリック&nbsp;</th>
                </tr>
              <?php if ($userStats !=null): ?>
                  <?php foreach ($userStats as $row):?>
                      <tr>
                          <td style="border:1px solid #000000;text-align:left;"><?php echo $row['unique_id']?>&nbsp;</td>
                          <td style="border:1px solid #000000;text-align:left;"><?php echo $row['name']?>&nbsp;</td>
                          <td style="border:1px solid #000000;text-align:left;"><?php echo $row['count_mail'];?>&nbsp;</td><!--mail_click-->
                          <td style="border:1px solid #000000;text-align:left;"><?php echo $row['count_tel'];?>&nbsp;</td><!--tel_click-->
                          <td style="border:1px solid #000000;text-align:left;"><?php echo $row['count_line']?>&nbsp;</td><!--line_click-->
                          <td style="border:1px solid #000000;text-align:left;"><?php echo $row['count_kuchikomi'];?>&nbsp;</td><!--kuchikomi_click-->
                          <td style="border:1px solid #000000;text-align:left;"><?php echo $row['question_no'];?>&nbsp;</td><!--question_no-->
                          <td style="border:1px solid #000000;text-align:left;"><?php echo $row['hp_click'];?>&nbsp;</td><!--HP_click-->
                          
                          
                      </tr>
                  <?php endforeach;?>
              <?php endif;?>
            </table>
          <br/>
          <div id="userStatistics" align="center"><?php echo $this->pagination->create_links()?></div><br/>
          <?php if(count($userStats) > 0):?>
              <div id="download_csv" align="center">
                  <form name="formCsvOwner" method="post" action="<?php echo base_url();?>admin/authentication/downloadUserStatisticsCsv">
                      <input type="hidden" name="txtDateFrom" value="<?php echo $dateFrom?>" />
                      <input type="hidden" name="txtDateTo" value="<?php echo $dateTo?>" />
                      <button type="submit">ダウンロード</button>
                  </form>
              </div>
        <?php endif;?>
        </div>
    <?php endif;?>
    
</div>