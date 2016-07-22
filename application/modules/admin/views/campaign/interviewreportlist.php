<div id='interview_reports'>
    <center>
        <h2>面接報告一覧</h2>
        <table>
            <?php foreach($reports as $val):?>
                <tr>
                    <td>
                      <?php
                          echo date("Y/m/d",strtotime($val['interview_date'])).' '.substr($val['user_unique_id'],0,2).str_repeat('*',strlen(mb_substr($val['user_unique_id'],2,strlen($val['user_unique_id'])))).' さんが面接をしました'
                      ?>
                      <?php if ($val['display_flag'] == 1):?>
                      <button id='hide_report' onclick="hideReport('<?php echo $val['id']?>')">報告を非表示</button>
                      <?php elseif($val['display_flag'] == 0) :?>
                      <button id='show_report' onclick="showReport('<?php echo $val['id']?>')">報告を表示</button>
                      <?php endif;?>
                    </td>
                </tr>

            <?php endforeach;?>
        </table>
    </center>
</div>
<script>
    var base_url = "<?php echo base_url()?>";
    function hideReport(id) {
        $.post(base_url+'admin/campaign/changeStatusReport',{"hide_report":id},function(result){if(result==true)window.location.reload()});
    }
    function showReport(id) {
        $.post(base_url+'admin/campaign/changeStatusReport',{"show_report":id},function(result){if(result==true)window.location.reload()});
    }

</script>
