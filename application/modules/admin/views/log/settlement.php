<?php
            $year = date("Y");            
?>
<form name="input" action="<?php echo base_url(); ?>admin/log/searchSettlement" method="post">
    <center>
        <p>日別売上・決済数</p>

        <p>
            対象：
            <select name="cbYear">
              <?php  for($i = 0;$i<2;$i++){
                    $year = $year + $i;?>
                <option value="<?php echo $year; ?>" <?php if($selectYear==$year)echo 'selected'; ?>><?php echo $year; ?></option>';  
                <?php } ?>
            </select>
            年　
            <select name="cbMonth">
                <option value="1" <?php if($selectMonth==1)echo 'selected'; ?>>01</option>
                <option value="2" <?php if($selectMonth==2)echo 'selected'; ?>>02</option>
                <option value="3" <?php if($selectMonth==3)echo 'selected'; ?>>03</option>
                <option value="4" <?php if($selectMonth==4)echo 'selected'; ?>>04</option>
                <option value="5" <?php if($selectMonth==5)echo 'selected'; ?>>05</option>
                <option value="6" <?php if($selectMonth==6)echo 'selected'; ?>>06</option>
                <option value="7" <?php if($selectMonth==7)echo 'selected'; ?>>07</option>
                <option value="8" <?php if($selectMonth==8)echo 'selected'; ?>>08</option>
                <option value="9" <?php if($selectMonth==9)echo 'selected'; ?>>09</option>   
                <option value="10" <?php if($selectMonth==10)echo 'selected'; ?>>10</option>
                <option value="11" <?php if($selectMonth==11)echo 'selected'; ?>>11</option>
                <option value="12" <?php if($selectMonth==12)echo 'selected'; ?>>12</option>
            </select>　月
        </p>
        <p><BUTTON type="submit">　検索　</BUTTON></p>
    </center>
</form>
   <?php if(isset($data_search)){ ?>
   <div style="margin:0px;padding:0px;" align="center">       
        <table width="40%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
            <tbody>
                <tr>
                    <th width="40%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">日付&nbsp;</th>
                    <th width="40%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">売上&nbsp;</th>
                    <th width="20%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">件数&nbsp;</th>
                </tr>                
                   <?php foreach ($data_search as $key => $items) { ?>
                        <tr>
                            <td width="40%" style="border:1px solid #000000;"><?php echo $items['updated_date']; ?></td>
                            <td width="40%" class="right" style="border:1px solid #000000;"><?php echo '\\'.number_format($items['amount'], 0, '.', ','); ?></td>
                            <td width="20%" class="right" style="border:1px solid #000000;"><?php echo $items['rowcount'];?></td>
                        </tr>
                <?php }?>
                
            </tbody>
        </table>
    </div>
    <?php }?>

