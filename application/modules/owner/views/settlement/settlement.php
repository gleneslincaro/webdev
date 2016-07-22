<div class="crumb">TOP ＞ ポイント購入</div>
<!--
<div class="owner-box"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt</div>
-->
<div class="list-box"><!-- list-box ここから -->
    <div class="list-title">ポイント購入</div>
    <div class="contents-box-wrapper">
    <div class="list-t-center">
        <span>予めポイントを購入されますと「スカウトメッセージ・応募者確認・採用金支払」がスムーズに行えますのでオススメです。</span>

        <div class="table-list-wrapper">
            <!--<table width="60%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;font-size: medium;">-->
            <table>
                <tbody>

                    <tr>
                        <th>クレジットコース</th>
                        <th>ポイント数</th>
                        <th>購入画面を開く</th>
                    </tr>
                    <?php foreach ($card_point_masters as $pm): ?>
                        <form id="credit_card_form" action="<?php echo base_url()."owner/credit/credit_confirm"; ?>" method="POST" >
                        <tr>
                            <td><?php echo number_format($pm['amount']); ?>円</td>
                            <td><?php echo number_format($pm['point']); ?>pt</td>
                            <td><button style="font-size: 12px;" type="submit" >クレジット決済</button></td>
                        </tr>
                        <input TYPE = "HIDDEN" NAME = "payment_case" value="4"/>
                        <INPUT TYPE = "HIDDEN" NAME = "money" VALUE = "<?php echo $pm['amount']; ?>">
                        <INPUT TYPE = "HIDDEN" NAME = "point" VALUE = "<?php echo $pm['point']; ?>">
                        </form>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <div class="table-list-wrapper">

            <table>
                <tbody>
                    <tr>
                        <th>銀行決済コース</th>
                        <th>ポイント数</th>
                        <th>購入画面を開く</th>
                    </tr>
                    <?php foreach ($bank_point_masters as $pm): ?>

                        <tr>
                            <td><?php echo number_format($pm['amount']); ?>円</td>
                            <td><?php echo number_format($pm['point']); ?>pt</td>

                            <td>
                                <form action="<?php echo base_url() . 'owner/bank/add_point'; ?>" method="post">

                                    <input type="hidden" name="money" value="<?php echo $pm['amount']; ?>"/>
                                    <input type="hidden" name="point" value="<?php echo $pm['point']; ?>"/>
                                    <button style="font-size: 12px;" type="submit" name="submit_settlement">銀行決済</button>

                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>


        <div class="table-list-wrapper">
            <table>
                <tbody>
                    <tr>
                        <th colspan="2">お振込先口座のご案内</th>
                    </tr>

                    <tr>
                        <td>銀行名</td>
                        <td>ジャパンネット銀行</td>
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
