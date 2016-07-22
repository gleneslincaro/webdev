<div id="bbsThreadContentDetail" >
	<h2>あるある掲示板　ポイント設定</h2>
	<?php 
	if (isset($error)): ?>
		<p class="error"><?php echo $error; ?></p>
	<?php endif; ?>
	<table id="table-detail" border="1">
		<tr>
			<th colspan="6" class="header-title">スレッド詳細</th>
		</tr>
		<tr>
			<th>投稿日</th>
			<th>大カテゴリ</th>
			<th>小カテゴリ</th>
			<th>あるある数</th>
			<th>コメント数</th>
			<th>公開/非公開</th>
		</tr>
		<tr>
			<td><?php echo $threadDetail['create_date']; ?></td>
			<td><?php echo $threadDetail['big_cate_name']; ?></td>
			<td><?php echo $threadDetail['cate_name']; ?></td>
			<td><?php echo $threadDetail['comment_like_count']; ?></td>
			<td><?php echo $threadDetail['comment_count']; ?></td>
			<td>
				<select name="threadStatus" class="threadStatus" data-thread="<?php echo $threadDetail['id']; ?>">
					<option value>選択してください</option>
					<?php
						foreach ($status as $key => $value) {
							if ($key == $threadDetail['display_flag']) {
								echo "<option selected value=$key>$value</option>";
							} else {
								echo "<option value=$key>$value</option>";
							}
						}
					 ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>ユーザーID</th>
			<th>属性</th>
			<th>アカウント作成日</th>
			<th rowspan="2" width="200px" id="action-button">
				<p>pt取り消し</p>
				 <?php
				 	if (isset($threadDetail['points'])):
				 		foreach ($threadDetail['points'] as $key => $value) {
				 			if ($value['target'] == 1) {
				 				echo "<button class='cancelPoint owner-bonus' data-point-id=".$value['id'].">スレッド立てボーナス</button>";
				 			} else if ($value['target'] == 2) {
				 				echo "<button class='cancelPoint comment-bonus' data-point-id=".$value['thread_id'].':'.$value['target'].">あるある獲得ボーナス</button>";
				 			} else if ($value['target'] == 3) {
				 				echo "<button class='cancelPoint weekly-bonus' data-point-id=".$value['thread_id'].':'.$value['target'].">あるある累計ボーナス</button>";
				 			} else if ($value['target'] == 4) {
				 				echo "<button class='cancelPoint like-bonus' data-point-id=".$value['thread_id'].':'.$value['target'].">好きだ</button>";
				 			} 

				 		}

					endif;
				?>
			</th>
		</tr>
		<tr>
			<td><?php echo $threadDetail['unique_id']; ?></td>
			<td><?php echo $threadDetail['user_from_site']; ?></td>
			<td><?php echo $threadDetail['offcial_reg_date']; ?></td>
		</tr>
		<tr>
			<th colspan="6" class="align-word">タイトル</th>
		</tr>
		<tr>
			<td colspan="6" class="align-word"><?php echo htmlentities($threadDetail['title'], ENT_COMPAT, 'UTF-8'); ?></td>
		</tr>
		<tr>
			<th colspan="6" class="align-word">文言</th>
		</tr>
		<tr>
			<td colspan="6" class="align-word"><?php echo htmlentities($threadDetail['message'], ENT_COMPAT, 'UTF-8'); ?></td>
		</tr>
	</table>
	<div class="comment-list-container">
	<?php 
		if (count($comments)){
			foreach ($comments as $key => $value): ?>
	<table id="table-comment-detail" border="1">
		<tr>
			<th colspan="6" class="header-title">回答一覧</th>
		</tr>
		<tr>
			<th>投稿日</th>
			<th>ユーザーID</th>
			<th>属性</th>
			<th>アカウント作成日</th>
			<th>あるある数</th>
			<th>公開/非公開</th>
		</tr>
		<tr>
			<td><?php echo $value['posted_date']; ?></td>
			<td><?php echo $value['unique_id']; ?></td>
			<td>マシェモバ</td>
			<td>2015/10/10</td>
			<td><?php echo $value['evaluate']; ?></td>
			<td>
				<?php
					if ($threadDetail['display_flag'] == 1):
				?>
				<select name="commentStatus" class="commentStatus" data-comment="<?php echo $value['id']; ?>">
					<option value>選択してください</option>
					<?php
						foreach ($status as $key => $value1) {
							if ($key == $value['display_flag']) {
								echo "<option selected value=$key>$value1</option>";
							} else {
								echo "<option value=$key>$value1</option>";
							}
						}
					 ?>
				</select>
				<?php 
					else:
						echo $status[$value['display_flag']];
					endif;
				?>
			</td>
		</tr>
		<tr>
			<td colspan="4" rowspan="3"><?php echo htmlentities($value['message'], ENT_COMPAT, 'UTF-8'); ?></td>
			<th colspan="2" rowspan="3">
				<p>pt取り消し</p>
				 <?php 
				 	if (isset($value['points'])):
				 		echo "<button class='cancelPoint' data-point-id=".$value['points']['comment_id'].">あるある獲得ボーナス</button>";
					endif;
				?>
			</th>	
		</tr>
	</table>
	<?php 			
		if (isset($value['reply'])) {
	?>
	<div class="button-wrap">
		<button class="display-replay" data-id="<?php echo $value['id']; ?>">返信</button>
	</div>
	<div class="container-replay replay<?php echo $value['id']; ?>" >
		<table id="table-replay-detail">
			<tr>
				<th>投稿日</th>
				<th>あるある数</th>
				<th>公開/非公開</th>
			</tr>
			<tr>
				<td><?php echo $value['posted_date']; ?></td>
				<td><?php echo $value['evaluate']; ?></td>
				<td>
					<?php 
						echo $status[$value['display_flag']];
					?>
				</td>
			</tr>
			<tr>
				<td colspan="6" rowspan="5" class="align-word"><?php echo htmlentities($value['message'],ENT_COMPAT, 'UTF-8'); ?></td>
			</tr>
		</table>
		<table id="table-replay-comment">
			<tr>
				<th>IP</th>
				<th>投稿日</th>
				<th>ユーザーID</th>
				<th>属性</th>
				<th>アカウント作成日</th>
				<th>あるある数</th>
				<th>公開/非公開</th>
			</tr>
			<tr>
				<td><?php echo $value['reply']['create_ip']; ?></td>
				<td>2016/01/15 13:25:11</td>
				<td><?php echo $value['reply']['unique_id']; ?></td>
				<td><?php echo $value['reply']['user_from_site']; ?></td>
				<td><?php echo $value['reply']['offcial_reg_date']; ?></td>
				<td><?php echo $value['reply']['evaluate']; ?></td>
				<td>
					<?php
						if ($threadDetail['display_flag'] == 1):
					?>
					<select name="replayStatus" class="replayStatus" data-replay="<?php echo $value['reply']['id']; ?>">
					<option value>選択してください</option>
						<?php
							foreach ($status as $key => $value1) {
								if ($key == $value['reply']['display_flag']) {
									echo "<option selected value=$key>$value1</option>";
								} else {
									echo "<option value=$key>$value1</option>";
								}
							}
						 ?>
					</select>
					<?php
						else:
							echo $status[$value['display_flag']];
						endif;
					?>
				</td>
			</tr>
			<tr>
				<td colspan="4" rowspan="3" class="align-word">
					<?php echo htmlentities($value['reply']['message'], ENT_COMPAT, 'UTF-8'); ?>
				</td>
				<td colspan="2" rowspan="3" class="non-border"></td>
			</tr>
		</table>
	</div>
		<?php 
			}
			endforeach;
		}	 
	?>
	</div>
</div>
<div class="action-wrap">
	<?php if ($more_page != 0): ?>
		<div class="more-wrap">
			<button class="load_more" data-page="<?php echo $more_page; ?>">もっと見る</button>
		</div>
	<?php endif; ?>
	<form action="" method="POST" name="mypoint">
		<input type="hidden" name="id">
		<input type="hidden" name="page">
		<input type="hidden" name="bonus_type" id="bonus_type">
		<input type="hidden" name="current_page" id="thread_id" value="<?php echo $current_page; ?>">
		<input type="hidden" id="totalRow" value="<?php echo $total_row; ?>">
	</form>
</div>
<script type="text/javascript">
	$(document).on('click', '.display-replay',function() {
		var id = $(this).data('id');
		$('.replay'+id).toggle();
	});

	$(document).on('click', '.cancelPoint',function() {
		var id = $(this).data('point-id');
		if ($(this).hasClass('owner-bonus')) {
			document.mypoint.bonus_type.value = 1;
		}
		document.mypoint.id.value=id;
		document.mypoint.submit();
	});

	$(document).on('change', '.threadStatus,.commentStatus,.replayStatus',function() {
		var selectedstatus = $(this).val();
		var obj = $(this).data();
		var id;
		if (selectedstatus !== '') {
			for (var key in obj) {
	    		id = $(this).data(key);
    			if (confirm('are you sure you want to change this?')) {
	    			$.ajax({
					type: "POST",
					url: '/admin/onayami/update_status/',
					data: {type:key, id:id, select:selectedstatus},
					dataType: 'JSON',
					cache: false,
					success:function(response){
							if (response.status == 'success') {
								if (key == 'thread') {
									location.reload();
								}
							}
						}
					});
    			}    		
			}
		}
	});

	$('.load_more').click(function() {
		var id = $(this).data('page');
		var thread_id = $('#thread_id').val();
		var data = {page:id,thread_id:thread_id,is_ajax : 1};
		$.ajax({
			type: "POST",
			url: '/admin/onayami/thread_detail/'+thread_id,
			data: data,
			dataType: 'HTML',
			cache: false,
			success:
				function(data){
					$('.comment-list-container').append(data);
					id = id + 1;
					var curr_row = id * 10;
					var old_row = $('#totalRow').val();
					if (curr_row < old_row ) {
						$('.load_more').data('page', id);
					} else {
						$('.load_more').remove();
					}
					
				}
		});
	});
</script>