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
					<td>相談ボーナス</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['question_bonus'] != '') ? $bonusData['question_bonus'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="questionBonus" id="questionBonus" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
				<tr>
					<td>回答ボーナス</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['answer_bonus'] != '') ? $bonusData['answer_bonus'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="answerBonus" id="answerBonus" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
				<tr>
					<td>そう思う累計ボーナス</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['like_points_multiply_by'] != '') ? $bonusData['like_points_multiply_by'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="likePointsMultiplyBy" id="likePointsMultiplyBy" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
				<tr>
					<td>そう思う獲得ボーナス</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['evaluate_bonus'] != '') ? $bonusData['evaluate_bonus'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="evaluateBonus" id="evaluateBonus" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
				<tr>
					<td>ボーナス対象回答数</td>
					<td><b><?php echo (!empty($bonusData) && $bonusData['max_answer_has_bonus'] != '') ? $bonusData['max_answer_has_bonus'] : 0; ?></b>ポイント</td>
					<td>
						<input type="number" name="maxAnswerHasBonus" id="maxAnswerHasBonus" min="0" max="9999"> 
						ポイント
					</td>
				</tr>
			</tbody>
		</table>
		<div class='button_wrap'>
			<input type="submit" onclick="editOnayamiBonus();" value="更新">
		</div>
	</form>
</div>