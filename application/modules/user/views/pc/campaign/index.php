<?php $this->load->view('user/pc/header/header'); ?>
<section class="section--main_content_area">
    <div class="container cf">
        <div class="box_white">
            <section class="section--application_list">
                <h2 class="ttl_style_1">面接交通費/入店お祝い金申請一覧</h2>
                <div class="request">
                <?php if (isset($expense_pay_requests)) : ?>
                    <table class="request_list">
                        <tr class="request_list_h">
                                <th>申請日</th>
                                <th>区分</th>
                                <th>店名</th>
                                <th>可否</th>
                        </tr>
                        <?php if (isset($expense_pay_requests)) : ?>
                        <?php foreach ($expense_pay_requests as $request) : ?>
                        <tr>
                            <td><?php echo date('Y/m/d',strtotime($request['req_date'])); ?></td>
                            <td><?php echo $request['classification']; ?></td>
                            <td><?php echo $request['o_shop_name']; ?></td>
                            <td>
                            <?php 
                                switch( $request['req_status'] ) {
                                    case 0: // 申請中
                                    case 1: // 店舗承認済み
                                    $o_approval_status_str = "確認中";
                                    break;

                                    case 2: // 店舗不承認済み
                                    $o_approval_status_str = "不承認済み";
                                    break;

                                    case 3: // 店舗、管理者承認済み
                                    $o_approval_status_str = "承認済み";
                                    break;

                                    case 4: // 店舗諸運済み、管理者不承認済み
                                    $o_approval_status_str = "不承認済み";
                                    break;

                                    default:
                                    $o_approval_status_str = "エラー";
                                    break;
                                }
                                echo $o_approval_status_str; 
                            ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                <?php else: ?>
                    <p class="request none">申請リクエストがありません。</p>
                <?php endif; ?>
                </div>
            </section>

        </div>
    </div>
    <!-- // .container --> 
</section>