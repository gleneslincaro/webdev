

<div class="crumb">TOP ＞ お知らせページ</div>
<!--
<div class="owner-box"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">▼ポイント購入</a></div>
-->
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">お知らせページ　※1ページに10件表示</div>
<div class="contents-box-wrapper">
    <div class="news-box">

    <?php if ($total > 0) { ?>
        <table class="news">
            <?php foreach ($news as $key => $value) { ?>
                <tr>
                    <div class="news-title" style="word-wrap: break-word;"><?php echo date('Y/m/d', strtotime($value['created_date'])) . '&nbsp' . $value['title']; ?></div>
                    <div style="word-wrap: break-word; padding: 7px;"><?php echo $value['content']; ?></div>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="list-t-center">
            <font color="#ff0000">
            現在、対象のデータがありません。</font>
        </div>
    <?php } ?>
    </div><!-- / .news-box -->

    <div class="btn_box">
        <?php
        if ($totalpage > 1) {
              ?>
                <?php echo $paging; ?>
            <?php
        }
        ?>
    </div>

</div><!-- / .contents-box-wrapper -->
</div><!-- list-box ここまで -->
