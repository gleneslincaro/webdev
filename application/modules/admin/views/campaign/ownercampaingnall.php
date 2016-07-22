<script>
    $(document).ready(function(){
        $('.campaignDelete').click(function(){
            if (!confirm('Do you want to delete this campaign?')) {
                return false;
            }

        });
    });
</script>
<center>
    <div class="expense-request-list" >
        <p>キャンペーン告知</p>
        <p><a href="<?php echo base_url(); ?>admin/campaign/ownercampaingncreate">キャンペーン作成はこちら</a></p>
        <p style="color: blue;"><?php echo $this->session->flashdata('retMsg'); ?></p>
        <form method="post">
        <table style="width: 100%;">
            <tr>
                <th>キャンペーンID</th>
                <th>キャンペーン名</th>
                <th>期間</th>
                <th>状態</th>
            </tr>
            <?php foreach ($getOwnerDisplayCampaign as $key) : ?>
                <tr>
                <td width="100"><?php echo $key['id']; ?></td>
                <td><?php echo $key['campaign_name']; ?></td>
                <td  align="center"><span style="float: left;"><?php echo $key['period_start']; ?></span> ~ <span style="float: right;"><?php echo $key['period_end']; ?></span></td>
                <td width="180" align="right"><?php
                    switch ($key['status']) {
                        case 1:
                            echo '開催中';
                            break;
                        case 2:
                            echo '準備中';
                            break;
                        case 3:
                            echo '終了';
                            break;
                        default:
                            break;
                    }?>
                    <a href="<?php echo base_url(); ?>admin/campaign/ownercampaingnedit/<?php echo $key['id']; ?>">編集</a>
                    <button class="campaignDelete" value="<?php echo $key['id']; ?>" style="width:100px;" name="delete[]">削除
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </form>
    </div>
</center>
