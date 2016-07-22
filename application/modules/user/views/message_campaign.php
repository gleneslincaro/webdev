<div id="contact_campaign">
    <h2>お問い合わせキャンペーン実地中！</h2>
    <dl>
        <dt><i class="fa fa-lightbulb-o"></i>本日のキャンペーン対象<i class="fa fa-lightbulb-o"></i></dt>
        <?php if(count($message_campaign) > 0): ?>
            <?php foreach($message_campaign as $data) : ?>
                <dd><a href="<?php echo $data['url']; ?>"><span><?php echo $data['area'];?></span><?php echo $data['storename'];?></a></dd>
            <?php endforeach; ?>
        <?php else: ?>
            <dd>本日のキャンペーン対象のお店がありません。</dd>
        <?php endif; ?>
    </dl>
    <h3 class="ttl_3 ttl_3--salmon"><span>キャンペーンルール</span></h3>
    <ul>
        <li>・期間によってキャンペーンの店舗が変更されます。</li>
        <li>・1店舗あたりへのお問い合わせで<span>30円</span>ボーナス。</li>
        <li>・コピー文字はカウントしない。</li>
        <li>・10文字以下のお問い合せはカウントしません。</li>
        <li>・返信が来た際に無視をしてはいけない。（送りっぱなしは基本NG）</li>
        <li>・集計が終了した時点でお支払い。</li>
    </ul>
</div>

