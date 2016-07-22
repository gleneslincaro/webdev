<div id="bbsBonusContent">
	<h2>あるある掲示板　ポイント設定</h2>
	<form action="javascript:void(0);" id="bbsBonusPointSetting">
		<table>
			<tbody>
				<tr>
					<th width="35%">項目名</th>
					<th width="20%">現在</th>
					<th width="35%">編集</th>
				</tr>
				<tr>
					<td>スレッド立てボーナス</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['thread_bonus'] != '') ? $bonusData['thread_bonus'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="threadCreateBonusPoints" id="threadCreateBonusPoints" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
				<tr>
					<td>書き込みボーナス</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['comment_bonus'] != '') ? $bonusData['comment_bonus'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="commentBonusPoints" id="commentBonusPoints" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
				<tr>
					<td>あるある累計ボーナス</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['like_points_multiply_by'] != '') ? $bonusData['like_points_multiply_by'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="likePointsMultiplyBy" id="likePointsMultiplyBy" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
				<tr>
					<td>あるある獲得ボーナス</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['comment_like_bonus'] != '') ? $bonusData['comment_like_bonus'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="commentLikePoints" id="commentLikePoints" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
				<tr>
					<td>ボーナス対象コメント数</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['max_comment_has_bonus'] != '') ? $bonusData['max_comment_has_bonus'] : 0; ?></b>コメント</td>
					<td>
						<input type="number" name="MaxCommentsHasBonus" id="MaxCommentsHasBonus" min="0" max="9999"> 
						コメント
					</td>
				</tr>
			</tbody>
		</table>
		<div class='button_wrap'>
			<input type="submit" onclick="editAruaruBonus();" value="更新">
		</div>
	</form>
</div>