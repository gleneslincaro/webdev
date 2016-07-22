<?php foreach ($big_category_ar as $key => $value): ?>
<li id="jquery-menu-<?php echo $key; ?>"><?php echo $value['big_category_name'];?><span id="jquery-menu-triangle<?php echo $key; ?>" class="menu-triangle">▼</span>
    <input type="button" class="btn_large" value="登録">
    <ul class="jquery-menu-sub" id="jquery-menu-<?php echo $key; ?>-sub">
        <li>メニュー1-1</li>
        <li>メニュー1-2</li>
        <li>メニュー1-3</li>
    </ul>
</li>
<?php endforeach; ?>
<li id="jquery-menu-add"><input type="button" class="btn_large" value="追加"></li>