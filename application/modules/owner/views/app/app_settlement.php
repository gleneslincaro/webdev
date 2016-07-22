<script type="text/javascript">
    function check_payment_app_settle() {
        var check_action = baseUrl + "owner/app/check_app_settle";
        var app_settle_action = baseUrl + "owner/app/app_settlement";
        var pointcomp_info_action = baseUrl + "owner/point/pointcomp_info";
        $('#payment_app_settle').ajaxSubmit({
            url: check_action,
            dataType: 'json',
            success: function(responeText, status, xhr, $form) {
                if (responeText.error != null) {
                    alert(responeText.error);
                    return false;
                } else {
                    count_unview = responeText.count_unview;
                    count_apply = responeText.count_apply;
                    if (count_unview == count_apply) {
                        window.location.replace(pointcomp_info_action);
                    } else {
                        window.location.replace(app_settle_action + "/" + count_apply);
                    }
                }
            }
        })
    }

    function check_app_settlement() {
        var check_action = baseUrl + "owner/bank/check_app_conf";
        var app_settle_action = baseUrl + "owner/app/app_settlement";
        var app_conf_action = baseUrl + "owner/bank/app_conf";
        $('#app_settlement').ajaxSubmit({
            url: check_action,
            dataType: 'json',
            success: function(responeText, statusTex, xhr, $form) {
                if (responeText.error != null) {
                    alert(responeText.error);
                    return false;
                } else {
                    count_unview = responeText.count_unview;
                    count_apply = responeText.count_apply;
                    remainder_money = responeText.remainder_money;
                    remainder_point = responeText.remainder_point;
                    if (count_unview == count_apply) {
                        remainder = responeText.remainder;
                        window.location.replace(app_conf_action);
                    } else {

                        window.location.replace(app_settle_action + "/" + count_apply);
                    }
                }
            }
        });
    }
</script>
<div style="float:right"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($point_owner); ?>pt　
    <a href="<?php echo base_url(); ?>owner/settlement/index" target="_blank">▼ポイント購入</a>
</div>
TOP ＞ 応募者確認決済
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■応募者確認決済</div><br >


    ※応募者を確認するには、1応募（1名）に対して<?php echo number_format($info_money); ?>円（<?php echo number_format($info_point); ?>pt）が必要となります。
    <br >
    <br >
    <div class="list-t-center">

        <p><font size="5">現在、御社様へ<font size="6">　<?php echo $count_unview; ?>名　</font>の応募があります。<br>
            応募者の確認は、下記より手続きをお願い致します。</font></p>

        <?php if ($remainder_point >= 0) { ?>

            <br >


            <div style="margin:0px;padding:0px;" align="center">
                <table width="40%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                    <tbody>
                        <tr>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">応募人数・応募者確認金額&nbsp;</th>

                        </tr>
                        <tr>
                            <td style="border:1px solid #000000;text-align:center;">　<?php echo $count_unview; ?>名　&nbsp;</td>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($total_info_money); ?>円&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <br>
            <br>

            <div style="margin:0px;padding:0px;" align="center">
                <table width="60%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                    <tbody>
                        <tr>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">現在の保有ポイント&nbsp;</th>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">応募者確認金額（ポイント）&nbsp;</th>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($point_owner); ?>pt&nbsp;</td>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($total_info_money); ?>円（<?php echo number_format($total_info_point); ?>pt）&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <p>決済後のポイント数：<?php echo number_format($remainder_point); ?>pt</p>

            <p><font size="4">上記内容で決済手続きする</font><br>
            <div class="list-t-center">
                <form name="payment_app_settle" id="payment_app_settle" method="post">
                    <input type="hidden" name="count_unview" value="<?php echo $count_unview; ?>"/>
                    <input onclick="return check_payment_app_settle();" type="button" name="" value="決済する" style="width:150px; height:40px;">
                </form>
            </div>
            </p>

            <br>

        <?php } else { ?>

            <br >

            
                <div style="margin:0px;padding:0px;" align="center">
                    <table width="40%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                        <tbody>
                            <tr>
                                <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">応募人数・応募者確認金額&nbsp;</th>

                            </tr>
                            <tr>
                                <td style="border:1px solid #000000;text-align:center;">　<?php echo $count_unview; ?>名　&nbsp;</td>
                                <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($total_info_money); ?>円&nbsp;</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <br>
                <br>

                <div style="margin:0px;padding:0px;" align="center">
                    <table width="60%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                        <tbody>
                            <tr>
                                <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">現在の保有ポイント&nbsp;</th>
                                <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">応募者確認金額（ポイント）&nbsp;</th>
                            </tr>

                            <tr>
                                <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($point_owner); ?>pt&nbsp;</td>
                                <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($total_info_money); ?>円（<?php echo number_format($total_info_point); ?>pt）&nbsp;</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <p><font size="4">保有ポイントが　<?php echo number_format($remainder_money < 0 ? -$remainder_money : $remainder_money); ?>円（<?php echo number_format($remainder_point < 0 ? -$remainder_point : $remainder_point); ?>pt）不足しております。<br>
                    下記より「クレジット決済」または「銀行決済」で決済をして下さい。</font></p>

                <div style="margin:0px;padding:0px;" align="center">
                    <table width="60%" height="150px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                        <tbody>


                            <tr>
                                <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">応募者確認・不足金額（pt）・決済内容&nbsp;</th>

                            </tr>
                            <tr>
                                <td style="width:50%;border:1px solid #000000;text-align:center;">応募者確認・不足金額（pt）&nbsp;</td>
                                <td style="width:50%;border:1px solid #000000;text-align:center;"><?php echo number_format($remainder_money < 0 ? -$remainder_money : $remainder_money); ?>円（<?php echo number_format($remainder_point < 0 ? -$remainder_point : $remainder_point); ?>pt）&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">
                                    <form id="credit_card_form" action="<? echo base_url()."owner/credit/credit_confirm"; ?>" method="POST" >

                                    <button style = "width:140px" type="submit" >　クレジット決済　</button></a>
                                    <?php
                                    $money = $remainder_money < 0?-$remainder_money:$remainder_money;
                                    $point = $remainder_point < 0 ?-$remainder_point:$remainder_point;
                                    ?>
                                    <input type="hidden" name="money" value="<?php echo $money; ?>"/>
                                    <input type="hidden" name="point" value="<?php echo $point; ?>"/>
                                    <input type="hidden" name="payment_case" value="2"/>
                                    </form>

                                </td>
                                <td style="text-align:center;">
                                   <form name="app_settlement" id="app_settlement" method="post">
                                        <input type="hidden" name="count_unview" value="<?php echo $count_unview; ?>"/>
                                        <input type="hidden" name="remainder_money" value="<?php echo $remainder_money < 0 ? -$remainder_money : $remainder_money; ?>"/>
                                        <input type="hidden" name="remainder_point" value="<?php echo $remainder_point < 0 ? -$remainder_point : $remainder_point; ?>"/>
                                        <?php HelperApp::add_session('payment_money', $total_info_money)?>
                                        <?php HelperApp::add_session('payment_point', $total_info_point)?>
                                        <button  style = "width:140px"  onClick="return check_app_settlement();" type="button">　銀行決済　</button>
                                    </form>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            
        <?php } ?>
</div><!-- list-box ここまで -->
