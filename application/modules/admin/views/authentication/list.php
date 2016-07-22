
<center>

    <p>承認一覧</p>   
    <p>合計件数：<?php echo $countRows; ?></p>

</center>

<div style="margin:0px;padding:0px;" align="center">
    <table width="80%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
        <tbody>
            <tr>
                <th width="30%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
                <th width="40%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
                <th width="20%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">作成時間&nbsp;</th>
                <th width="10%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">詳細&nbsp;</th>
            </tr>
            <?php foreach ($data_search as $key => $items) { ?>
                <tr>
                    <td style="border:1px solid #000000;"><?php echo $items['unique_id']; ?></td>
                    <td style="border:1px solid #000000;"><?php echo $items['storename']; ?></td>
                    <td style="border:1px solid #000000;"><?php echo $items['created_date']; ?></td>
                    <td style="border:1px solid #000000;text-align:center;"><a href="<?php echo base_url();?>admin/authentication/listProfile/<?php echo $items['id'];?>">開く&nbsp;</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <div id="jquery_link" align="center">
	<?php echo $this->pagination->create_links(); ?>
    </div>
        
</div>

