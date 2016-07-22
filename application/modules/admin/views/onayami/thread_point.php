<div id="bbsThreadContent" >
	<h2><?php echo $titlePage; ?></h2>
	<form action="" method="POST" name="search" id="search">
		<table id="table-action">
			<tbody>
				<tr>
					<th>キーワード</th>
					<td><input type="text" name="subject" value="<?php echo $subject;?>" placeholder="部分一致でも検索可能"></td>
				</tr>
				<tr>
					<th>登録日付</th>
					<td><input type="text" placeholder="年/月/日" value="<?php echo $start_date;?>" name="start_date"> ～ <input type="text" value="<?php echo $end_date;?>" placeholder="年/月/日" name="end_date"></td>
				</tr>
			</tbody>
		</table>
		<div class='button_wrap'>
			<input type="hidden" name="buttonSearch" id="page">
			<input type="hidden" name="mode" id="mode">
			<input type="submit" name="buttonSearch" value="検索">
		</div>
	</form>
	<?php if (isset($error) &&  $error != ''): ?>
			<p class="s_error" style="color:red;"><?php echo $error; ?></p>
	<?php endif; ?>
	<table id="table-result">
		<thead>
			<tr>
				<th>登録日</th>
				<th>件名</th>
				<th>コメント</th>
				<th>詳細</th>
				<th>表示</th>
				<th>総あるある</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if (count($threadList)){
					foreach ($threadList as $value): ?>
			<tr>
				<td><?php echo $value['create_date'];?></td>
				<td><?php echo htmlentities($value['title'], ENT_COMPAT, 'UTF-8'); ?></td>
				<td><?php echo $value['comment_count'];?>件</td>
				<td><a href="/admin/onayami/thread_detail/<?php echo $value['id']; ?>"><button>詳細</button></a></td>
				<td><?php echo $value['publish'];?></td>
				<td><?php echo $value['comment_like_count'];?></td>
			</tr>
			<?php 
					endforeach;
				}	 
			?>
		</tbody>
	</table>
	<div class="pagination-wrap">
		<?php echo $pagination; ?>
	</div>
</div>
<script type="text/javascript">
	$('.pagination-wrap a').click(function () {
	    var link = $(this).get(0).href;
	    var form = $('#search');
	    var segments = link.split('/');
	   
	    $('#page').val(segments[4]);
	    $('#mode').val(1);  
	    form.attr('action', link); 
	    form.submit(); 
	    return false; 
	});
</script>