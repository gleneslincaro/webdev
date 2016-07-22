<?php
 
echo '<center>
<p>配信ログ・閲覧</p>
</center>

<center>
<tr>
<p>件名：&nbsp;<input type="text" name="txtTitle" size="100" value="'.$info["title"].'"></p>

</tr>
</center>

<div style="margin:0px;padding:0px;" align="center">
<table width="70%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<td style="border:1px solid #000000;width:120px;"><span id="aspan">送信内容</span></td>
<td style="border:1px solid #000000;width:450px;">
<textarea name="example2" cols="70" rows="40">'.$info["content"].'</textarea>
</td>
</tr>
</tbody>
</table>
</div>';
                    
         
?>
