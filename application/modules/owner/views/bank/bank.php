<script type="text/javascript">
    $(document).ready(function() {
        var d = new Date(),
                month = d.getMonth();
                day = d.getDate()-1;
                hours = d.getHours()-1;

        $('#sltMonth option:eq(' + month + ')').prop('selected', true);
        $('#sltDay option:eq(' + day + ')').prop('selected', true);
        $('#sltHour option:eq(' + hours + ')').prop('selected', true);
        displayPopupError();
    });
    function checkDate() {
        year = $("#sltYear option:selected").text();
        month = $("#sltMonth option:selected").text();
        if (((year % 4 == 0 && year % 100 != 0) || (year % 400 == 0)) && month == 2) {
            day = 29;
            $("#sltDay option").remove();
            for (i = 1; i <= day; i++) {
                o = new Option(i, i);
                $(o).html(i, i);
                $('#sltDay').append(o);
            }

        } else {
            day = 28;
            $("#sltDay option").remove();
            for (i = 1; i <= day; i++) {
                o = new Option(i, i);
                $(o).html(i, i);
                $('#sltDay').append(o);
            }
        }
        if ((month == 4 || month == 6 || month == 9 || month == 11)) {
            day = 30;
            $("#sltDay option").remove();
            for (i = 1; i <= day; i++) {
                o = new Option(i, i);
                $(o).html(i, i);
                $('#sltDay').append(o);
            }
        }
        if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {

            day = 31;
            $("#sltDay option").remove();
            for (i = 1; i <= day; i++) {
                o = new Option(i, i);
                $(o).html(i, i);
                $('#sltDay').append(o);
            }

        }        



    }
    function displayPopupError() {
        var div_error = $(".hide-error");
        if (div_error.length > 0) {
            var error = div_error.text();
            alert(error);
        }
    }

</script>
<div class="crumb">TOP ＞ ポイント購入・銀行決済 ＞ 振込お知らせメール</div>
<div class="owner-box"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt　</div>
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">銀行決済ページ</div>
    <div class="contents-box-wrapper">

    <div style="font-size: 13pt; text-align: center; width: 928px;">
    銀行決済でお支払の場合、下記<font color="#ff0000">「振込お知らせメール」</font>を必ずお送りください。<br >
    「お振込先口座」情報は、下記「メール送信」時にご登録アドレス宛へお送りさせて頂きます。</div>
<?php echo Helper::print_error($message); ?>

    <div class="table-list-wrapper">
        <form action="<?php echo base_url(); ?>owner/bank/<?php echo $action; ?>" method="post">
            <table>
                <tbody>
                    <tr>
                        <th colspan="2">振込お知らせメール内容</th>
                    </tr>

                    <tr>
                        <td>振込名義</td>
                        <td>
                            <input type="hidden" name="txtTranferName" value="<?php echo set_value('txtTranferName'); ?>" size="35">
                            <input type="text" name="txtTranferName" value="<?php echo set_value('txtTranferName'); ?>" size="35">&nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td>振込日時</td>
                        <td>

                            <select onchange="return checkDate();" name="sltYear" id="sltYear">
                                <option value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
                                <option selected="true" value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                                <option value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
                            </select>
                            年
                            <select onchange="return checkDate();" name="sltMonth" id="sltMonth">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            月
                            <select name="sltDay" id="sltDay">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                            日　
                            <select name="sltHour" id="sltHour">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                            </select>
                            時頃
                        </td>
                    </tr>

                    <tr>
                        <td>振込口座</td>
                        <td>ジャパンネット銀行</td>
                    </tr>

                    <tr>
                        <td>振込金額</td>
                        <td>
                            <input type="hidden" id="money" name ="money" value="//<?php echo $money;?>" > 
                            <input type="hidden" id="point" name ="point" value="//<?php echo $point;?>" > 
                            
                            <?php echo number_format($money); ?>円&nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>" />
                            <a href="dialog_transfer.html"><button type="submit" name="submit_bank">　メール送信　</button></a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <font size="-1">
                            ※振込名義は、全角カタカナでご記入ください。<br>
                            ※振込お知らせメールをお送りして頂けませんと、振込みの特定ができず決済<br>
                            手続きが行えません。お手数ですがご連絡の程よろしくお願い致します。</font>
                        </td>
                    </tr>

                </tbody>
            </table>
        </form>
    </div>
    <div class="table-list-wrapper">
        <table>
            <tbody>
                <tr>
                    <th colspan="2">お振込先口座のご案内</th>
                </tr>

                <tr>
                    <td colspan="2">ジャパンネット銀行</td>
                </tr>

                <tr>
                    <td>支店名</td>
                    <td>すずめ支店　002</td>
                </tr>

                <tr>
                    <td>口座種類・番号</td>
                    <td>（普）5219131</td>
                </tr>

                <tr>
                    <td>口座名義</td>
                    <td>ユ）ユニ</td>
                </tr>

            </tbody>
        </table>
    </div>
    </div><!-- / .contents-box-wrapper -->
</div><!-- list-box ここまで -->
