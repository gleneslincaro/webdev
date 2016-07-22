<!--
<div style="float:right"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($point_owner); ?>pt　
    <a href="<?php echo base_url(); ?>owner/settlement/index" target="_blank">▼ポイント購入</a>
</div>
-->
TOP ＞ スカウト機能 ＞ スカウトメッセージ ＞ 決済
<script type="text/javascript">
    function checkExistListUserSpam() {
        var upload_action = baseUrl + "owner/scout/scout_settlement_check";
        var settlement_action = baseUrl + "owner/scout/scout_settlement";
        var scout_action = baseUrl + "owner/scout/scout_after";
        var point_action = baseUrl + "owner/point/pointcomp_scout";
        $('#scout_settlement').ajaxSubmit({
            url: upload_action,
            dataType: 'json',
            success: function(responseText, statusText, xhr, $form) {
                if (responseText.error != null)
                {
                    alert(responseText.error);
                    return false;
                }
                else
                {
                    count = responseText.count;
                    count_spams = responseText.count_spams;
                    count_unsent = responseText.count_unsent;
                    str_unique_id = responseText.str_unique_id;
                    if (count == count_spams) {
                        var msg = "ID: " + str_unique_id + " \n" + "がブロックしているためスカウトできません。";
                        alert(msg);
//                        $('#scout_settlement').load(scout_action);
                        window.location.replace(scout_action);
                    }
                    if (count_spams > 0 && count_spams < count) {
                        var msg = "ID: " + str_unique_id + " \n" + "がブロックしているためスカウトできません。";
                        alert(msg);
                        arr_user_id_unsent = responseText.arr_user_id_unsent;
//                        window.location.replace(settlement_action, arr_user_id_unsent);
                        $('.list-box').load(settlement_action + " .list-box", arr_user_id_unsent);
                    }
                    if (count_unsent == count) {
                        arr_user_id_unsent = responseText.arr_user_id_unsent;
                        window.location.replace(point_action, arr_user_id_unsent);
                    }
                }
            }
        });
    }

</script>
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■スカウトメッセージ　決済</div><br >
    <form action="<?php echo base_url().'owner/scout/scout_settlement'; ?>"  name='scout_settlement' id='scout_settlement' method="post" >
        <div class="img-prof in_new">
        <ul>
        <?php
            $cnt = 0;
            foreach ($user_profiles as $key => $value) {
                if ( ($cnt != 0) && ($cnt % 3) == 0 ){ echo "</ul><ul>"; }
                if ( ($cnt % 3) != 2 ){
                    echo ' <li class="right_m">';
                }else{
                    echo ' <li>';
                }
                ?>
                <img src="<?php
                $data_from_site = $value['user_from_site'];
                if ( $value['profile_pic'] ){
                    $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                    if ( file_exists($pic_path) ){
                        $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                    }else{
                        if ( $data_from_site == 1 ){
                            $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                        }else{
                            $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                        }
                    }
                    echo $src;
                }else{
                    echo base_url().'/public/user/image/no_image.jpg';
                }
                ?>" width="100" height="100" alt="">
                <p>地域：<?php echo $value['cityname']; ?>
                <br>年齢：<?php echo (($value['age_name1'] != 0)? $value['age_name1'] : '')  . '~' . (($value['age_name2']!=0) ? $value['age_name2'] : '') ?>
                <br>身長：<?php echo $value['height_l'] . "~". $value['height_h']; ?>
                <br><?php echo "B".$value['bust'] . " W". $value['waist']. " H". $value['hip']; ?></p>
                <input type="hidden" name="user_id[]" value="<?php echo $value['uid']; ?>">

                </li>
        <?php
        $cnt++;
        } ?>
        </ul>



    </form>
    <div class="list-t-center">
        <?php if ($remainder_point >= 0) { ?>
            <br >
            上記の方へスカウトメッセージを送信する。<br >
            <br >
            ※保有ポイント内で決済を行うことができる場合は下記を表示させる。<br >
            <br >
            <div style="margin:0px;padding:0px;" align="center">
                <table width="40%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                    <tbody>
                        <tr>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">スカウト送信人数・金額&nbsp;</th>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000;text-align:center;">　<?php echo number_format($count_unsent); ?>名　&nbsp;</td>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($total_scout_money); ?>円&nbsp;</td>
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
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">スカウト送信金額（ポイント）&nbsp;</th>
                        </tr>

                        <tr>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($point_owner); ?>pt&nbsp;</td>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($total_scout_money); ?>円（<?php echo number_format($total_scout_point); ?>pt）&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <p>決済後のポイント数：<?php echo number_format($remainder_point); ?>pt</p>

            <p><font size="4">上記内容で決済手続きする</font><br>
            <div class="list-t-center">
                <input type="button" onclick="return checkExistListUserSpam();" name="submit_scout_settlement" value="決済する" style="width:150px; height:40px;"/>
            </div>
            </p>
            <br>
        <?php } else { ?>
            <br >
            ※保有ポイントがスカウト送信人数・金額に対して不足していた場合は下記を表示させる。<br >
            <br >
            <div style="margin:0px;padding:0px;" align="center">
                <table width="40%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                    <tbody>
                        <tr>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">スカウト送信人数・金額&nbsp;</th>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000;text-align:center;">　<?php echo number_format($count_unsent); ?>名　&nbsp;</td>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($total_scout_money); ?>円&nbsp;</td>
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
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">スカウト送信人数・金額（ポイント）&nbsp;</th>
                        </tr>

                        <tr>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($point_owner); ?>pt&nbsp;</td>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($total_scout_money); ?>円（<?php echo number_format($total_scout_point); ?>pt）&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <p><font size="4">保有ポイントが　<?php echo number_format($remainder_money < 0?-$remainder_money:$remainder_money); ?>円（<?php echo number_format($remainder_point < 0 ?-$remainder_point:$remainder_point); ?>pt）不足しております。<br>
                下記より「クレジット決済」または「銀行決済」で決済をして下さい。</font></p>

            <div style="margin:0px;padding:0px;" align="center">
                    <table width="60%" height="150px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                        <tbody>
                            <tr>
                                <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">残りのスカウト送信金額・決済内容&nbsp;</th>
                            </tr>
                            <tr>
                                <td style="width:50%;border:1px solid #000000;text-align:center;">残りのスカウト送信金額&nbsp;</td>
                                <td style="width:50%;border:1px solid #000000;text-align:center;"><?php echo number_format($remainder_money < 0?-$remainder_money:$remainder_money); ?>円（<?php echo number_format($remainder_point < 0 ?-$remainder_point:$remainder_point); ?>pt）&nbsp;</td>
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
                                    <input type="hidden" name="payment_case" value="1"/>
                                    </form>
                                </td>
                                <td style="text-align:center;">
                                    <form action="<?php echo base_url() ?>owner/bank/scout" method="post">
                                        <?php HelperApp::add_session('remainder_money', $remainder_money < 0?-$remainder_money:$remainder_money)?>
                                        <?php HelperApp::add_session('remainder_point', $remainder_point < 0 ?-$remainder_point:$remainder_point)?>
                                        <?php HelperApp::add_session('payment_money', $total_scout_money)?>
                                        <?php HelperApp::add_session('payment_point', $total_scout_point)?>
                                        <a href="#"><button style = "width:140px" type="submit">　銀行決済　</button></a>
                                    </form>
                                </td>
                            </tr>

                        </tbody>
                    </table>
            </div>
        <?php } ?>
    </div>

<!--</div> list-box ここまで -->
