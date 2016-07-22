<div class="campaign_total_payment">
    <dl class="fsize_20">
        <dt><strong><?php echo $monthly_campaign_result_ads['month']; ?></strong>月度現在<span class="total_amount">お支払い総額</span></dt>
        <dd>
            <ul>
                <li><p><span><img src="<?php echo base_url() ?>public/user/image/icon_trans.png"></span><strong>面接交通費</strong></p><p class="t_right"><span class="bold"><?php echo $monthly_campaign_result_ads['travel_expense_total_paid_money']; ?></span><strong>円突破！</strong></p></li>
                <li><p><span><img src="<?php echo base_url() ?>public/user/image/icon_celeb.jpg"></span><strong>入店お祝い金</strong></p><p class="t_right"><span class="bold"><?php echo $monthly_campaign_result_ads['trial_work_total_paid_money']; ?></span><strong>円突破！</strong></p></li>
            </ul>
        </dd>
    </dl>
</div>