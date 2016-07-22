<script type="text/javascript">
  $(document).ready(function(){
    $('#makiaCampaignListName select').change(function(){
      $('#makiaCampaignListName').submit();
    });
  });
</script>
<div class="expense-request-list" >
<?php if(isset($listUser)):?>
  <table style="width: 100%;">
    <tr>
      <th>システムID</th>
      <th>名前</th>
      <th>登録サイト</th>
      <th>最終ログイン</th>
      <th>登録日</th>
      <th>ステプ達成日時</th>
    </tr>
    <?php foreach ($listUser as $key): ?>
    <tr>
      <td><?php echo $key['unique_id']; ?></td>
      <td><?php echo $key['name']; ?></td>
      <td><?php echo $key['website_id']; ?></td>
      <td><?php echo $key['last_visit_date']; ?></td>
      <td><?php echo $key['offcial_reg_date']; ?></td>
      <td></td>
    </tr>
    <?php endforeach ?>
  </table>
<?php else: ?>
  <form id="makiaCampaignListName" method="post">
    <p>キャンペーンを選択する。
      <select name="makiaCampaignId" style="width: 285px;">
        <option></option>
        <?php foreach ($makiaCampaign as $key):?> 
          <option value="<?php echo $key['id'];?>" <?php if(isset($campaign_id)){ echo ($campaign_id== $key['id']? 'selected': ''); }; ?>><?php echo $key['name'];?></option>
        <?php endforeach;?>
      </select>
    </p>
  </form>
  <?php if(isset($list)):?>
    <table style="width: 100%;">
      <tr>
        <th>ステップ</th>
        <th>期間内</th>
        <th>期間終了</th>
      </tr>
      <tr>
       <td>ステップ1</td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/1/in"><?php echo (!$list['step1in']? 0:$list['step1in']); ?></a></td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/1/out"><?php echo (!$list['step1out']? 0:$list['step1out']); ?></a></td>
      </tr>
      <tr>
       <td>ステップ2</td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/2/in"><?php echo (!$list['step2in']? 0:$list['step2in']); ?></a></td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/2/out"><?php echo (!$list['step2out']? 0:$list['step2out']); ?></a></td>
      </tr>
      <tr>
       <td>ステップ3</td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/3/in"><?php echo (!$list['step3in']? 0:$list['step3in']); ?></a></td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/3/out"><?php echo (!$list['step3out']? 0:$list['step3out']); ?></a></td>
      </tr>
      <tr>
       <td>ステップ4</td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/4/in"><?php echo (!$list['step4in']? 0:$list['step4in']); ?></a></td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/4/out"><?php echo (!$list['step4out']? 0:$list['step4out']); ?></a></td>
      </tr>
      <tr>
       <td>ステップ5</td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/5/in"><?php echo (!$list['step5in']? 0:$list['step5in']); ?></a></td>
       <td><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignlist/<?php echo $campaign_id; ?>/5/out"><?php echo (!$list['step5out']? 0:$list['step5out']); ?></a></td>
      </tr>
    </table>
  <?php endif; ?>
<?php endif; ?>
</div>