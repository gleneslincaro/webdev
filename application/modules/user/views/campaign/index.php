<section class="section section--campaign cf">
<h3 class="ttl_1">面接交通費/入店お祝い金申請一覧</h3>
<div class="box_inner pt_15 pb_7 cf">
  <div>
    <?php if (isset($expense_pay_requests)) { ?>
    <table class="width_100p">
      <tbody>
        <tr>
            <th class="col-req-date">申請日</th>
            <th class="col-classification">区分</th>
            <th class="col-owner-name">店名</th>
            <th class="col-owner-approve">可否</th>
            <!-- <th class="col-req-approve">承認</th>  -->
        </tr>
        <?php foreach ($expense_pay_requests as $request) {
          //var_dump($expense_pay_requests); die();
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

            ?>
          <tr>
            <td><?php echo date('Y/m/d',strtotime($request['req_date'])); ?></td>
            <td><?php echo $request['classification']; ?></td>
            <td><?php echo $request['o_shop_name']; ?></td>
            <td id="shop_approval_status_<?php echo $request['req_id']; ?>"><?php echo $o_approval_status_str; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } else { ?>
    <center>申請リクエストがありません。</center>
    <?php } ?>
  </div>
  <div><?php echo $this->pagination->create_links() ?></div>
</div>
</section>

