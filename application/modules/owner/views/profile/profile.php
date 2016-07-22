<!--
<div style="float:right"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt　
    <a href="<?php echo base_url(); ?>owner/settlement/index" target="_blank">▼ポイント購入</a>
</div>
-->
TOP ＞ ユーザープロフィール
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■ユーザープロフィール</div><br >

    <div style="margin:0px;padding:0px;" align="center">
        <table width="60%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
            <tbody>
                <tr>
                    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">プロフィール&nbsp;</th>
                </tr>

                <tr>
                    <td style="border:1px solid #000000;text-align:center;">ID&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:center;"><?php echo $up['unique_id']; ?>&nbsp;</td>
                </tr>

                <tr>
                    <td style="border:1px solid #000000;text-align:center;">年齢&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:center;"><?php echo $up['age_name1']; ?>歳〜<?php echo $up['age_name2'] != 0?$up['age_name2'].'歳':''; ?>&nbsp;</td>
                </tr>

                <tr>
                    <td style="border:1px solid #000000;text-align:center;">身長&nbsp;</td>
                    <td style="border:1px solid #000000;text-align:center;"><?php echo $up['height_name1'] != 0?$up['height_name1'].'cm':""; ?>〜<?php echo $up['height_name2'] != 0?$up['height_name2'].'cm':""; ?>&nbsp;</td>
                </tr>

            </tbody>
        </table>
    </div>
        <center>
        <p><a href="#" onClick="window.close();">ページを閉じる</a></p>
    </center>

</div><!-- list-box ここまで -->
