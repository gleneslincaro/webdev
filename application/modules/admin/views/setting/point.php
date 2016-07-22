<script language="javascript">
    var unique =$("#txtunique").val();
    if (unique!=null){
        alert(unique);
    }
    
</script>
<?php
$today = date("F j, Y, g:i a");
echo '<center>
<input type="hidden" name="txtdatetime" value="'.$today.'" />    
<span id="note">'.$this->session->flashdata('note').'</span>    
<p>金額・ポイント設定</p>

<p>【　銀行振込でポイントを購入する場合の設定　】</p>';
echo '<form action="'.base_url().'admin/setting/point" method="post" id="form" onsubmit="return confirm(\'編集しますか？\');">';
if(isset($unique)){
    echo "<input type='hidden' name='txtunique' value='".$unique."' id='txtunique' />";
}
echo '<div style="margin:0px;padding:0px;" align="center">
<table width="60%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">購入方法&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">金額&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ポイント&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">追加&nbsp;</th>
</tr>
<tr>
<td style="border:1px solid #000000;">
<select name="sltgd" id="sltgd" style="width:100px">';
foreach ($method as $k=>$m){
    echo "<option value='".$m["id"]."'>".$m["name"]."</option>";
}
echo '</select></td>
<td style="border:1px solid #000000;"><input type="text" name="txtamount" id="txtamount" size="20" value="'.set_value('txtamount').'"></td>
<td style="border:1px solid #000000;"><input type="text" name="txtpoint" id="txtpoint" size="20" value="'.set_value('txtpoint').'"></td>
<td style="border:1px solid #000000;text-align:center;"><input type="submit" name="btnaddpoint" value="追加" /></td>
</tr>
</tbody>
</table>
</div>';

echo '</form>';

echo '<br>';
echo '<div style="margin:0px;padding:0px;" align="center">
<table width="60%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;" id="tblshow">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">購入方法</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">金額</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ポイント</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">変更</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">削除</th>
</tr>';
foreach ($info as $k=>$i){
    echo '<form action="'.base_url().'admin/setting/updatePoint" method="post" class="formshowpoint" onsubmit="return confirm(\'編集しますか？\');">';
    echo "<input type='hidden' value='".$i["id"]."' name='txtu_id'>";
    echo '<tr>
    <td style="border:1px solid #000000;">
    <select name="sltumethod"  style="width:100px;" id="slt'.$i["id"].'">';
    foreach ($method as $k=>$m){
        echo "<option value='".$m["id"]."'";
            if($i["payment_method_id"]==$m["id"]){
                echo "selected='selected'";
            }
        echo ">".$m["name"]."</option>";
    }
     echo '</select></td>
    <td style="border:1px solid #000000;"><input type="text" name="txtumoney" size="18" value="'.$i["amount"].'" id="a'.$i["id"].'"></td>
    <td style="border:1px solid #000000;"><input type="text" name="txtupoint" size="18" value="'.$i["point"].'"id="p'.$i["id"].'"></td>
    <td style="border:1px solid #000000;text-align:center;"><input type="submit" value="変更" name="btnu_update"></td>
    <td style="border:1px solid #000000;text-align:center;"><a class="delete" href="#" id="'.$i["id"].'"><button type="button">削除</button></a></td>
    </tr>';
    echo '</form>';
}
echo '</tbody>
</table>
</div>';
echo '<br><br>

<p>【　スカウト・メッセージ送信時の課金・ポイント設定　】<br>
※予め銀行決済でポイントを購入された場合は「消費ポイント（pt）」が適用されます。</p>

<br>';
echo '<form action="updatePointScout" method="post" id="formscout" onsubmit="return confirm(\'編集しますか？\');">';
echo '<div style="margin:0px;padding:0px;" align="center">
<table width="50%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">決済金額（円）&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">消費ポイント（pt）&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">変更&nbsp;</th>
</tr>';
foreach($scout as $k=>$c){
    echo '<tr>
    <input type="hidden" name="txtid" value="'.$c["id"].'" />    
    <td style="border:1px solid #000000;"><input type="text" name="txts_amount" size="20" value="';
        if(isset($_POST["txts_amount"])){
            echo set_value("txts_amount");
        }else{
            echo $c["amount"];
        }  
    echo'"></td>
    <td style="border:1px solid #000000;"><input type="text" name="txts_point" size="20" value="';
        if(isset($_POST["txts_point"])){
            echo set_value("txts_point");
        }else{
            echo $c["point"];
        }
    echo'"></td>
    <td style="border:1px solid #000000;text-align:center;"><input type="submit" name="btnaddpointscout" value="変更" /></td>
    </tr>';
}

echo '</tbody>
</table>
</div>';
echo '</form>';
echo '<br><br>

<p>【　応募者確認時の課金・ポイント設定　】<br>
※予め銀行決済でポイントを購入された場合は「消費ポイント（pt）」が適用されます。</p>

<br>';
echo '<form action="'.base_url().'admin/setting/updatePointView" method="post" id="formview" onsubmit="return confirm(\'編集しますか？\');">';
echo '<div style="margin:0px;padding:0px;" align="center">
<table width="50%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>';
echo '<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">決済金額（円）&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">消費ポイント（pt）&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">変更&nbsp;</th>
</tr>';
foreach($view as $k=>$v){
    echo '<tr>
    <input type="hidden" name="txtvid" value="'.$v["id"].'" />
    <td style="border:1px solid #000000;"><input type="text" name="txtv_amount" size="20" value="'; 
        if(isset($_POST["txtv_amount"])){
            echo set_value("txtv_amount");
        }else{
            echo $v["amount"];
        }
    echo'"></td>
    <td style="border:1px solid #000000;"><input type="text" name="txtv_point" size="20" value="';
     if(isset($_POST["txtv_point"])){
            echo set_value("txtv_point");
        }else{
            echo $v["point"];
        }
    echo'"></td>
    <td style="border:1px solid #000000;text-align:center;"><input type="submit" name="btnaddpointscout" value="変更" /></td>
    </tr>';
}

echo '</tbody>
</table>
</div>';

echo '</form>';
echo '</center>'; 

?>
