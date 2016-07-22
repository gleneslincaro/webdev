<?php 
header('Content-type: text/html; charset=utf-8');
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
				 		echo "<button class='cancelPoint' data-point-id=".$value['points']['id'].">あるある獲得ボーナス</button>";
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
				<th>IP</th>
				<th>投稿日</th>
				<th>あるある数</th>
				<th>公開/非公開</th>
			</tr>
			<tr>
				<td><?php echo $value['create_ip']; ?></td>
				<td><?php echo $value['posted_date']; ?></td>
				<td><?php echo $value['evaluate']; ?></td>
				<td>
					<?php 
						echo $status[$value['display_flag']];
					?>
				</td>
			</tr>
			<tr>
				<td colspan="6" rowspan="5" class="align-word"><?php echo $value['message']; ?></td>
			</tr>
		</table>
		<table id="table-replay-comment">
			<tr>
				<th>投稿日</th>
				<th>ユーザーID</th>
				<th>属性</th>
				<th>アカウント作成日</th>
				<th>あるある数</th>
				<th>公開/非公開</th>
			</tr>
			<tr>
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