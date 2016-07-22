TOP ＞ 履歴一覧 ＞ 勤務確認一覧 ＞ 採用金額
<!--
<div class="owner-box">
  <?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($owner_info['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a>
  <br >
</div>
-->
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■勤務確認　採用金額</div><br >


    <table class="list">
        <tr>
            <th>ID</th><th>写真</th><th>地域</th><th>年齢</th><th>面接完了報告時間</th><th>勤務申請</th>
        </tr>
        <?php //foreach($userProfiles as $u):?>
        <tr>
            <td><?php echo $userProfiles['unique_id']; ?></td>
            <td><?php
                $data_from_site = $userProfiles['user_from_site'];
                if ( $userProfiles['profile_pic'] ){
                    $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$userProfiles['profile_pic'];
                    if ( file_exists($pic_path) ){
                        $src = base_url().$this->config->item('upload_userdir').'images/'.$userProfiles['profile_pic'];
                    }else{
                        if ( $data_from_site == 1 ){
                            $src = $this->config->item('machemoba_pic_path').$userProfiles['profile_pic'];
                        }else{
                            $src = $this->config->item('aruke_pic_path').$userProfiles['profile_pic'];
                        }
                    }
                    echo "<img src='".$src."' alt='写真' height='90'>";
                }else{
                    echo "<img src='".base_url()."/public/user/image/no_image.jpg' alt='写真'
                                width='120px' height='90'>";
                }
            ?>
            </td>
            <td><?php echo $userProfiles['city_name']; ?></td>
            <td><?php echo $userProfiles['age_name1']; ?>〜<?php echo $userProfiles['age_name2'] != 0 ? $userProfiles['age_name2'] : ''; ?></td>
            <td><?php echo date('Y/m/d H:i', strtotime($userProfiles['apply_date'])); ?></td>
            <td><?php echo date('Y/m/d H:i', strtotime($userProfiles['request_money_date'])); ?></td>
        </tr>
        <?php //endforeach; ?>
    </table>


    <div class="list-t-center">


        <br >
        上記の方を承認する。<br >
        <br >
        <?php if ($remainder_point >= 0) { ?>



            <div style="margin:0px;padding:0px;" align="center">
                <table class="font_size" width="60%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                    <tbody>
                        <tr>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">現在の保有ポイント&nbsp;</th>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">採用金額（ポイント）&nbsp;</th>
                        </tr>

                        <tr>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($point_owner); ?>pt&nbsp;</td>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($recruit_money); ?>円（<?php echo number_format($recruit_point); ?>pt）&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
            </div>


            <p>決済後のポイント数：<?php echo number_format($remainder_point); ?>pt</p>

            <p><font size="4">上記内容で決済手続きする</font><br>
            <div class="list-t-center">
                <form action="<?php echo base_url(); ?>owner/point/pointcomp_recruit" method="post">
                    <input type="hidden" name="remainder_money" value="<?php echo $remainder_money; ?>"/>
                    <input type="hidden" name="remainder_point" value="<?php echo $remainder_point; ?>"/>
                    <input type="hidden" name="recruit_money" value="<?php echo $recruit_money; ?>"/>
                    <input type="hidden" name="recruit_point" value="<?php echo $recruit_point; ?>"/>
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                    <input type="hidden" name="owner_recruit_id" value="<?php echo $owner_recruit_id; ?>"/>
                    <input type="submit" name="" value="勤務承認（決済）" style="width:150px; height:40px;">
                </form>
            </div>
            </p>

            <br>
            決済完了後、当サイトからユーザーへお祝い金がお支払いされます。<br >
            万が一、お祝い金の条件をクリアされていないようでしたら下記より非承認を行ってください。<br ><br >
            <form action="<?php echo base_url(); ?>owner/dialog/dialog_unapproved" method="post">
                <input type="hidden" name="owner_recruit_id" value="<?php echo $owner_recruit_id; ?>"/>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                <input type="submit" value="　非承認　" onClick="res = confirm('非承認しますか？');
                        if (res == true) {
                            location.href = '#'
                        } else
                            return false;">
            </form>


<?php } else { ?>
            <br >


            <div style="margin:0px;padding:0px;" align="center">
                <table class="font_size" width="60%" height="100px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                    <tbody>
                        <tr>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">現在の保有ポイント&nbsp;</th>
                            <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">採用金額（ポイント）&nbsp;</th>
                        </tr>

                        <tr>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($point_owner); ?>pt&nbsp;</td>
                            <td style="border:1px solid #000000;text-align:center;"><?php echo number_format($recruit_money); ?>円（<?php echo number_format($recruit_money); ?>pt&nbsp;)</td>
                        </tr>

                    </tbody>
                </table>
            </div>


            <p><font size="4">保有ポイントが　<?php echo number_format($remainder_money < 0 ? -$remainder_money : $remainder_money); ?>円（<?php echo number_format($remainder_point < 0 ? -$remainder_point : $remainder_point); ?>pt）不足しております。<br>
                下記より「クレジット決済」または「銀行決済」で決済して下さい。</font></p>


            <div style="margin:0px;padding:0px;" align="center">

                    <table width="60%" height="150px" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">
                        <tbody>
                            <tr>
                                <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">残りの採用金額・決済内容&nbsp;</th>

                            </tr>
                            <tr>
                                <td style="width:50%;border:1px solid #000000;text-align:center;">残りの採用金額&nbsp;</td>
                                <td style="width:50%;border:1px solid #000000;text-align:center;"><?php echo number_format($remainder_money < 0 ? -$remainder_money : $remainder_money); ?>円（<?php echo number_format($remainder_point < 0 ? -$remainder_point : $remainder_point); ?>pt）&nbsp;</td>
                            </tr>

                            <tr>
                                <td style="text-align:center;" >
                                    <form id="credit_card_form" action="<? echo base_url()."owner/credit/credit_confirm"; ?>" method="POST" >
                                    <button style = "width:140px" type="submit" >　クレジット決済 <br>　（勤務承認）　</button></a>
                                    <?php
                                    $money = $remainder_money < 0?-$remainder_money:$remainder_money;
                                    $point = $remainder_point < 0 ?-$remainder_point:$remainder_point;
                                    ?>
                                    <input type="hidden" name="money" value="<?php echo $money; ?>"/>
                                    <input type="hidden" name="point" value="<?php echo $point; ?>"/>
                                    <input type="hidden" name="payment_case" value="3"/>
                                    </form>
                                </td>
                                <td style="text-align:center;">
                                    <form action="<?php echo base_url() ?>owner/bank/recruit" method="post">
                                    <input type="hidden" name="remainder_money" value="<?php echo $remainder_money < 0 ? -$remainder_money : $remainder_money; ?>"/>
                                    <input type="hidden" name="remainder_point" value="<?php echo $remainder_point < 0 ? -$remainder_point : $remainder_point; ?>" />
                                    <?php HelperApp::add_session('remainder_money', $remainder_money < 0 ? -$remainder_money : $remainder_money) ?>
                                    <?php HelperApp::add_session('remainder_point', $remainder_point < 0 ? -$remainder_point : $remainder_point) ?>
                                    <?php HelperApp::add_session('payment_money', $recruit_money)?>
                                    <?php HelperApp::add_session('payment_point', $recruit_point)?>
                                    <a href="#"><button style = "width:140px" type="submit">　銀行決済　<br>　（勤務承認）　</button></a>
                                     </form>
                                </td>
                            </tr>

                        </tbody>
                    </table>
            </div>


            <br>
            採用者へのお祝い金は当社から支払いされます。お支払いを重複しないようご注意ください。<br >
            万が一、お祝い金の条件をクリアされていないようでしたら下記より非承認を行ってください。<br ><br >
            <form action="<?php echo base_url(); ?>owner/dialog/dialog_unapproved" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                <input type="hidden" name="owner_recruit_id" value="<?php echo $owner_recruit_id; ?>"/>
                <input type="submit" value="　非承認　" onClick="res = confirm('非承認しますか？');
                        if (res == true) {
                            location.href = ''
                        } else {
                            return false;
                        }">
            </form>
            <br >
<?php } ?>
    </div>
    <!--</div> list-box ここまで -->
