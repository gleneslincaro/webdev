<div id="dialog-form">
  <div class="t_right"><button onclick="return close_dialog()" class="j-ui-x-button">×</button></div>
  <div class="box_bold">店舗名:</div>
  <input class="messege_width100 messege_width100_a height_38 text ui-widget-content ui-corner-all" disabled="disabled" type="text" name="storename" id="storename" value="<?php echo $storename; ?>" >
  <input type="hidden" id="bk_storename" value="<?php echo $storename; ; ?>">
  <input type="hidden" id="bk_owner_id" value="<?php echo $owner_id; ; ?>">
  <hr color="#666666" size="1px">
  <div class="box_bold">件名：</div>
  <select class="messege_width100 messege_width100_a" name="user_title" id="user_title">
    <option value="質問" selected>質問</option>
    <option value="応募">応募</option>
    <option value="面接依頼">面接依頼</option>
    <option value="その他">その他</option>
  </select>
  <div id="validateTips1" class="validateTips box_bold fc_red"></div>
  <hr color="#666666" size="1px">
  <div class="box_bold">本文：</div>
  <div id="validateTips2" class="validateTips box_bold fc_red"></div>
  <textarea id="owner_message" class="messege_width100 messege_width100_a watermark" rows="5" cols="50" name="body" <?php echo ($user_from_site == 1)?"placeholder='マシェモバ関連の質問はしないでください。'":''; ?>></textarea>
</div>
        
