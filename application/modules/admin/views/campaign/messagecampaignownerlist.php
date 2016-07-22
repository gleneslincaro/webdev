<script type="text/javascript">
    $(function() {
       var count_owners = "<?php echo $count_owners; ?>";
       if (count_owners == 20) {
          $('#add_owner').prop('disabled', true);
       }
    });

    function add_owner() {
        window.location.replace("<?php echo base_url();?>admin/campaign/messagecampaignaddowner/");
    }

    function delete_owner(id) {
        x = confirm("この店舗を削除してよろしいですか。");
        if (x) {
            $.get('<?php echo base_url();?>admin/campaign/messagecampaigndeleteowner', { id: id}, function(result) {
                if (result) {
                    alert('正常にキャンペーン店舗が削除されました。');
                    $('#owner_'+id).fadeOut(1000);
                } else {
                    alert('キャンペーン店舗が削除できませんでした。');
                }
            });
        }
    }
</script>
<center>
    <div class="makia-login-bonus-list">
        <p>メッセージキャンペーンに店舗追加</p>
        <div class="mb20">
            <input type="button" value="店舗追加" id="add_owner" name="add_owner" onclick="add_owner()">
        </div>
        <table>
            <tbody>
                <tr>
                    <th class="condition-id">エリア名</th>
                    <th class="num-of-days">店舗名</th>
                    <th class="bonus-points">店舗名に対するＵＲＬ</th>
                    <th class="bonus-points"></th>
                </tr>
                <?php if ( count($message_campaign) > 0 ): ?>
                    <?php foreach( $message_campaign as $data): ?>
                        <tr id="owner_<?php echo $data['id']; ?>">
                            <td><?php echo $data['area']; ?></td>
                            <td><?php echo $data['storename']; ?></td>
                            <td><?php echo $data['url']; ?></td>
                            <td>
                              <a href="<?php echo base_url().'admin/campaign/messagecampaigneditowner/'.$data['id'].'/'; ?>">編集</a> |
                              <a href="javascript:void(0)" onclick="delete_owner(<?php echo $data['id']; ?>)">削除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan=3>レコードが見つかりませんでした。</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</center>
