<input id="step" type="hidden" value="<?php echo $step; ?>">
<p>エリア文言編集</p>
<div id="breadcrumb" style="width:480px;text-align:left;margin-bottom: 20px;">
	<a id="" href="#">エリア</a>
<?php if (isset($city_group_name)) : ?>
    &nbsp;&nbsp;>&nbsp;<a id="<?php echo $city_group_alphaname;?>" href="#"><?php echo $city_group_name; ?></a>
<?php endif; ?>
<?php if (isset($city_name)) : ?>
    &nbsp;&nbsp;>&nbsp;
    <a id="<?php echo $city_group_alphaname.$city_alphaname;?>" href="#"><?php echo $city_name; ?></a>
<?php endif; ?>
</div>
<div class="areatext_edit_list">
<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
<?php
if ($step == 0) {
    $ar = $city_groups;
} elseif ($step == 1) {
    $ar = $citys;
} elseif ($step == 2) {
    $ar = $towns;
}
foreach ((array)$ar as $value) :
    if ($step == 0) {
        $id = $value['alph_name'];
    } elseif ($step == 1) {
        $id = $city_group_alphaname.$value['alph_name'];
    }
    $area_id = $value['id'];
    $area_name = $value['name'];
    $updated_date = $value['updated_date'];
?>
    <tr>
    <td width="200">
<?php if ($step < 2) : ?>
        <a id="<?php echo $id; ?>" href="#"><?php echo $area_name; ?></a>
<?php else : ?>
        <?php echo $area_name; ?>
<?php endif; ?>
    </td>
    <td width="45">
        <button class="areatext_edit" type="button" name="<?php echo $area_name; ?>" value="<?php echo $area_id; ?>" >
        編集
        </button>
    </td>
    <td>
        <p style="display:inline-block;margin:0;"><?php echo $updated_date; ?></p>
    </td>
    </tr>
<?php endforeach; ?>
</table>
</div>