<option value="" selected>選択してください</option>
<?php foreach ($city_list as $k => $v): ?>
<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
<?php endforeach; ?>