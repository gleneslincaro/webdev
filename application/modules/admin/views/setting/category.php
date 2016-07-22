<script language="javascript">
    $(document).ready(function(){
         var base = $("#base").attr("value");
        $("#btnset").click(function(){
        window.location=base+"admin/setting/category_Set";
    });
   
    })
    
</script>
<?php
echo '<center>
<span id="note">'.$this->session->flashdata('note').'</span>    
<input id="spid" type="hidden" value="" />
<p>業種</p>

※スタッフへ業種内容は８０文字以内で記入。


<div style="margin:0px;padding:0px;" align="center">
<table width="40%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;" >
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">NO&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">業種内容&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">表示変更&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アクティブ&nbsp;</th>
</tr>';
foreach($info as $k=>$i){
    $k++;
    echo '<tr>
    <td style="border:1px solid #000000;">'.$k.'</td>
    <td style="border:1px solid #000000;">'.$i["name"].'</td>
    <td style="border:1px solid #000000;text-align:center;">　<a href="#" class="aup" id="'.$i["id"].'">↑</a>　<a href="#" class="adown" id="'.$i["id"].'">↓</a>　&nbsp;</td>
    <form name="forms" method="post" action="'.base_url().'index.php/admin/setting/deleteJobType" onsubmit="return confirm(\'編集しますか？\')">
    <td style="border:1px solid #000000;text-align:center;"><input type="checkbox" name="chk_display['.$i["id"].']" value="'.$i["display_flag"].'" ' ;
        if($i["display_flag"]==1){
            echo "checked = checked";
        }
    echo '></td>
    </tr>';
}
echo '</tbody>
</table>
</div>


<p>

<button type="button" id="btnset">追加</button>
<input type="submit" name="deljob" value="編集" />
</p>

</center>';

?>
