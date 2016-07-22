<script type="text/javascript">
	$(function(){
		pagination_user_experience_list();
	});
</script>
<style type="text/css">
    td , button{
        padding: 0;
        margin: 0;
    }
    td {
        padding: 5px;
    }
</style>
<div id="validation" style="color:red;text-align:center;">
	<?php echo $this->session->flashdata('success')?>

</div>
<p style="text-align:center">投稿の体験談　編集・有効・無効・削除</p>
<table class="template1" cellpadding="5" style="word-break: break-all; margin-bottom:25px;">
	<tr>
		<th>ユーザーID</th>
		<th>ロケーション</th>
		<th>年齢</th>
		<th>タイトル</th>
		<th>コンテンツ</th>
		<th colspan="4"></th>
	</tr>
    <?php foreach($list_experiences as $le):?>
    <tr id="row_<?php echo $le['msg_id']?>" class="<?php echo ($le['status']==0)? 'hidden_exp' : ''?>">
    	<td width="70"><?php echo ($le['unique_id']!= null) ? $le['unique_id'] : 'サクラ';?></td>
    	<td width="50" align="center"><?php echo $le['city_name']?></td>
    	<td width="50" align="center"><?php echo $le['age_name1'].'-'.$le['age_name2']?></td>
    	<td width="150" align="center"><?php echo $le['title']?></td>
    	<td width="400"><?php echo nl2br($le['content'])?></td>
    	<td align="center" width="30">
    		<?php if($le['status']==1):?>
    		<a href="<?php echo  base_url().'admin/experiences/modify/'.$le['msg_id'] ?>" target="_blank">
    			<button id="btn_edit_<?php echo $le['msg_id']?>">編集</button>
    		</a>
    		<?php else:?>
    		<button id="btn_edit_<?php echo $le['msg_id']?>" disabled>編集</button>
    		<?php endif;?>
    	</td>
    	<td align="center" width="30"><button id="btn_show_<?php echo $le['msg_id']?>" <?php echo ($le['status'] == 1) ? 'disabled':'';?> onclick="showExp(<?php echo $le['msg_id']?>,'<?php echo base_url()?>')">有効</button></td>
    	<td align="center" width="30"><button id="btn_not_show_<?php echo $le['msg_id']?>" <?php echo ($le['status'] == 0) ? 'disabled':'';?> onclick="hideExp(<?php echo $le['msg_id']?>,'<?php echo base_url()?>')">無効</button></td>
    	<td align="center" width="30"><button id="btn_delete" onclick="deleteExp(<?php echo $le['msg_id']?>,'<?php echo base_url()?>')">削除</button></td>
    </tr>
	<?php endforeach;?>
    
</table>
<div id="user_exp_pagination" style="text-align:center; padding-bottom: 100px;">
	<?php echo  $this->pagination->create_links(); ?>	
</div>
