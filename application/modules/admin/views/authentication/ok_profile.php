<script type="text/javascript">
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
    $(document).ready(function(){
            var flag =$("#txtflag").val();
            var base = $("#base").attr("value");
            var id=$("#txtowid").val();
            var rid=$("#txtowrid").val();
            var store=$("#txtstorename").val();
            var pic=$("#txtpic").val();
            var info=$("#txtcominfo").val();
            var station=$("#txtstation").val();
            var stylework=$("#txtworkingstyle").val();
            var ernote=$("#txternote").val();
            var image1=$('#hdImage1').val();
            var image2=$('#hdImage2').val();
            var image3=$('#hdImage3').val();
            var image4=$('#hdImage4').val();
            var image5=$('#hdImage5').val();
            var image6=$('#hdImage6').val();
            var main=$("#txtmainimg").val();
        if(flag!=null && flag!=""){
            bol=window.confirm("登録しますか？");
            if(bol==true){
                $("#txtflag").val("");
                $.ajax({
                    url:base+"admin/authentication/updateOk_Profile",
                    type:"post",
                    data:"txtowid="+id+"&txtstorename="+store+"&txtpic="+pic+"&txtcominfo="+info+"&txtstation="+station+"&txtworkingstyle="+stylework
                    +"&txternote="+ernote+"&hdImage1="+image1+"&hdImage2="+image2+"&hdImage3="+image3+"&hdImage4="+image4+"&hdImage5="+image5
            +"&hdImage6="+image6+"&txtmainimg="+main+"&id="+rid,
                    async:true,
                    success:function(kq){
                        window.location=base+"admin/authentication/a_complete";
                    }
                })
            }
        } 
    })
    function deleteImage()
        {        
            var base = $("#base").attr("value");
            var path = base + "/public/owner/images/no_image.jpg";
            var imageArr = new Array();
            var imagePath = new Array();
            var checkDel = new Array()
            var n=0;
            var flag = false;

            $.each($("input[name='cknImage[]']:checked"), function() {

                i = $(this).attr('value');
                checkDel[i]=i;
                flag = true;

            });

            if(!flag)
            {   
                alert('チェックボックスが選択されておりません。対象を選択して下さい');
                return false;
            }

            if(!confirm('削除しますか？'))
            {
                return false;    
            }


            for(i=1 ; i<=6; i++)
            { 
               if(!checkDel[i] && ($("#image" + i).attr("src")!= path) )
                {  
                    imageArr[n] = $("#image" + i).attr("src");
                    imagePath[n++] = $("#hdImage" + i).val();

                }
            }

            for(i = imageArr.length; i<6; i++)
            {
                imageArr[i] = path;
                imagePath[i] = '';

            }

            for(i=1; i<=6; i++)
            {
                $("#image" + i).attr("src",imageArr[i-1]);
                $("#hdImage" + i ).val(imagePath[i-1]);
            } 
            return true;
        }
</script>
<?php
echo '<center>
<p>認証一覧・プロフィール認証</p>
</center>';
foreach ($owinfo as $k=>$ow){
echo "<form action='".base_url()."admin/authentication/ok_Profile/".$ow["reid"]."' method='post'  enctype='multipart/form-data' id='form_ow'>";
echo "<input type='hidden' value='".$ow["wid"]."' id='txtowid' name='txtowid' />";
echo "<input type='hidden' value='".$ow["reid"]."' id='txtowrid' name='txtowrid' />";
echo "<input type='hidden' id='txtflag' value='";
    if(isset($flag)){
        echo $flag;
       
    }
echo "'>";
echo '<center>
<table border width="40%">

<tr>
<td>アドレス</td>
<td>'.$ow["email_address"].'</td>
</tr>
<tr>
<td>店舗名</td>
<td>'.$ow["storename"].'</td>
</tr>

</table>
</center>


<center>
<p>';
echo '<table border width="90%">
<tr>
<td>店舗名</td>
<td><input type="text" name="txtstorename" id="txtstorename" size="50" value="';
    if(isset($store)){
        echo $store;
    }else if (isset($cc)){
        echo set_value("txtstorename");
    }else{
        echo $ow["storename"];
    }
echo'"></td>
</tr>
<tr>
<td>求人担当</td>
<td><input type="text" name="txtpic" id="txtpic" size="50" value="';
    if(isset($pic)){
        echo $pic;
    }else if (isset($cc)){
        echo set_value("txtpic");
    }else{
        echo $ow["pic"];
    }

echo '"></td>
</tr>
<tr>
<td>イメージ写真</td>
<td align="center">
<div class="photo_box">';
if($ow["image1"]=="" && $ow["image1"]==null){
    if(isset($image1) && $image1!=""){
        echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image1.'" /></div>';
    }else{
        echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }
}else{
    if(isset($image1)&& $image1!=""){
        if($image1==$ow["image1"]){
            echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="150" height="60" src="'. base_url()."public/owner/uploads/images/".$image1.'" /></div>';
        }else{
            echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image1.'" /></div>';
        }
    }else if(isset($image1)&& $image1==""){
         echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }
    else{
        echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="150" height="60" src="'. base_url()."public/owner/uploads/images/".$ow["image1"].'" /></div>';
    }
}
if($ow["image2"]=="" && $ow["image2"]==null){
   if(isset($image2) && $image2!=""){
        echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image2.'" /></div>';
    }else{
        echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }
}else{
    if(isset($image2) && $image2!=""){
        if($image2==$ow["image2"]){
             echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="150" height="60" src="'. base_url()."public/owner/uploads/images/".$image2.'" /></div>';
        }else{
            echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image2.'" /></div>';
        }
    }else if(isset($image2) && $image2==""){
        echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }
    else{
        echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="150" height="60" src="'.  base_url()."public/owner/uploads/images/".$ow["image2"].'" /></div>';
    } 
}
if($ow["image3"]=="" && $ow["image3"]==null){
   if(isset($image3) && $image3!=""){
        echo '<div class="photo"><img id="image3" name="image3" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image3.'" /></div>';
    }else{
        echo '<div class="photo"><img id="image3" name="image3" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }  
}else{
    if(isset($image3) && $image3!=""){
        if($image3==$ow["image3"]){
            echo '<div class="photo"><img id="image3" name="image3" width="150" height="60" src="'. base_url()."public/owner/uploads/images/".$image3.'" /></div>';
        }else{
            echo '<div class="photo"><img id="image3" name="image3" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image3.'" /></div>';
        }
    }else if(isset($image3) && $image3==""){
        echo '<div class="photo"><img id="image3" name="image3" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }
    else{
       echo '<div class="photo"><img id="image3" name="image3" width="150" height="60" src="'.  base_url()."public/owner/uploads/images/".$ow["image3"].'"></div>';
    }    
}
echo '<br style="clear:both;">
</div>
<div class="photo_box">';
if($ow["image4"]=="" && $ow["image4"]==null){
    if(isset($image4) && $image4!=""){
        echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image4.'" /></div>';
    }else{
        echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    } 
    
}else{
    if(isset($image4) && $image4!=""){
         if($image4==$ow["image4"]){
            echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="150" height="60" src="'. base_url()."public/owner/uploads/images/".$image4.'" /></div>';
        }else{
            echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image4.'" /></div>';
        }
    }else if(isset($image4) && $image4==""){
        echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }
    else{
       echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="150" height="60" src="'.  base_url()."public/owner/uploads/images/".$ow["image4"].'"></div>';
    }        
}
if($ow["image5"]=="" && $ow["image5"]==null){
     if(isset($image5) && $image5!=""){
        echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image5.'" /></div>';
    }
    else{
        echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    } 
}else{
      if(isset($image5) && $image5!=""){
         if($image5==$ow["image5"]){
            echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="150" height="60" src="'. base_url()."public/owner/uploads/images/".$image5.'" /></div>';
        }else{
            echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image5.'" /></div>';
        }
    }else if(isset($image5) && $image5==""){
        echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }
    else{
       echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="150" height="60" src="'.  base_url()."public/owner/uploads/images/".$ow["image5"].'"></div>';
    }     
}
if($ow["image6"]=="" && $ow["image6"]==null){
 if(isset($image6) && $image6!=""){
        echo '<div class="photo"><img id="image6" name="image6" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image6.'" /></div>';
    }else{
        echo '<div class="photo"><img id="image6" name="image6" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    } 
    
}else{
    if(isset($image6) && $image6!=""){
         if($image6==$ow["image6"]){
            echo '<div class="photo"><img id="image6" name="image6" width="150" height="60" src="'. base_url()."public/owner/uploads/images/".$image6.'" /></div>';
        }else{
            echo '<div class="photo"><img id="image6" name="image6" width="150" height="60" src="'. base_url()."public/owner/uploads/tmp/".$image6.'" /></div>';
        }
    }else if(isset($image6) && $image6==""){
         echo '<div class="photo"><img id="image6" name="image6" width="150" height="60" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
    }
    else{
      echo '<div class="photo"><img id="image6" name="image6" width="150" height="60" src="'.  base_url()."public/owner/uploads/images/".$ow["image6"].'"></div>';
    } 
    
}
echo '<br style="clear:both;">
</div>
<p>
    <input type="checkbox" id="cknImage[]" name="cknImage[]" value="1"> 写真1
    <input type="checkbox" id="cknImage[]" name="cknImage[]" value="2"> 写真2
    <input type="checkbox" id="cknImage[]" name="cknImage[]" value="3"> 写真3
    <input type="checkbox" id="cknImage[]" name="cknImage[]" value="4"> 写真4
    <input type="checkbox" id="cknImage[]" name="cknImage[]" value="5"> 写真5
    <input type="checkbox" id="cknImage[]" name="cknImage[]" value="6"> 写真6
</p>
<input type="button" value="　削除　" onclick="deleteImage()"><br>
<p>JPEGファイル：<input type="file" name="flUpload" accept="image/jpeg" id="iuploadow"></p>';
if($ow["image1"]==""){
echo ' <input type="hidden" id="hdImage1" name ="hdImage1" value="';
    if(isset($image1)){
        echo $image1;
    }
echo '" >'; 
}else{
echo ' <input type="hidden" id="hdImage1" name ="hdImage1" value="';
    if(isset($image1)){
        echo $image1;
    }else{
        echo $ow["image1"];
    }
    echo '" >';     
}
if($ow["image2"]==""){
    echo ' <input type="hidden" id="hdImage2" name ="hdImage2" value="';
         if(isset($image2)){
            echo $image2;
         }
    echo'">'; 
}else{
    echo ' <input type="hidden" id="hdImage2" name ="hdImage2" value="';
     if(isset($image2)){
        echo $image2;
    }else{
        echo $ow["image2"];
    }
    echo'">'; 
}
if($ow["image3"]==""){
    echo ' <input type="hidden" id="hdImage3" name ="hdImage3" value="';
          if(isset($image3)){
            echo $image3;
          }
    echo'">'; 
}else{
    echo ' <input type="hidden" id="hdImage3" name ="hdImage3" value="';
    if(isset($image3)){
        echo $image3;
    }else{
        echo $ow["image3"];
    }
    echo'">'; 
}
if($ow["image4"]==""){
    echo ' <input type="hidden" id="hdImage4" name ="hdImage4" value="';
         if(isset($image4)){
            echo $image4;
          }
    echo'">'; 
}else{
    echo ' <input type="hidden" id="hdImage4" name ="hdImage4" value="';
     if(isset($image4)){
        echo $image4;
    }else{
        echo $ow["image4"];
    }
    echo'">'; 
} 
if($ow["image5"]==""){
    echo ' <input type="hidden" id="hdImage5" name ="hdImage5" value="';
         if(isset($image5)){
            echo $image5;
        }
    echo'">'; 
}else{
    echo ' <input type="hidden" id="hdImage5" name ="hdImage5" value="';
         if(isset($image5)){
            echo $image5;
        }else{
            echo $ow["image5"];
        }
    echo'">'; 
}
if($ow["image6"]==""){
    echo ' <input type="hidden" id="hdImage6" name ="hdImage6" value="';
        if(isset($image6)){
            echo $image6;
        }
    echo'">'; 
}else{
    echo ' <input type="hidden" id="hdImage6" name ="hdImage6" value="';
        if(isset($image6)){
            echo $image6;
        }else{
            echo $ow["image6"];
        }
    echo'">'; 
}
echo '<p>メイン画像：
<select name="sltmainimg">
<option value="1"';
if($ow["main_image"]==1){
    echo "selected='selected'";
}else if(isset($main) && $main==1){
    echo "selected='selected'";
}
echo '>写真1</option>
<option value="2"';
if($ow["main_image"]==2){
    echo "selected='selected'";
}else if(isset($main) && $main==2){
    echo "selected='selected'";
}else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==2){
     echo "selected='selected'";
}
echo '>写真2</option>
<option value="3"';
if($ow["main_image"]==3){
    echo "selected='selected'";
}else if(isset($main) && $main==3){
    echo "selected='selected'";
}else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==3){
     echo "selected='selected'";
}
echo '>写真3</option>
<option value="4"';
if($ow["main_image"]==4){
    echo "selected='selected'";
}else if(isset($main) && $main==4){
    echo "selected='selected'";
}else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==4){
     echo "selected='selected'";
}
echo '>写真4</option>
<option value="5"';
if($ow["main_image"]==5){
    echo "selected='selected'";
}else if(isset($main) && $main==5){
    echo "selected='selected'";
}else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==5){
     echo "selected='selected'";
}
echo '>写真5</option>
<option value="6"';
if($ow["main_image"]==6){
    echo "selected='selected'";
}else if(isset($main) && $main==6){
    echo "selected='selected'";
}else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==6){
     echo "selected='selected'";
}
echo '>写真6</option>
</select>
</p>';
echo "<input type='hidden' id='txtmainimg' value='";
    if(isset($main)){
        echo $main;
    }
echo "'>";
echo '</td>
</tr>
<tr>
<td>会社情報</td>
<td><textarea name="txtcominfo" id="txtcominfo" cols="80" rows="12">
';
    if(isset($info)){
        echo $info;
    }else if (isset($cc)){
        echo set_value("txtcominfo");
    }else{
        echo $ow["company_info"];
    }
echo'
</textarea></td>
</tr>
<tr>
<td>最寄駅</td>
<td><input type="text" name="txtstation" id="txtstation" size="50" value="';
    if(isset($station)){
        echo $station;
    }else if (isset($cc)){
        echo set_value("txtstation");
    }else{
        echo $ow["nearest_station"];
    }
echo'"></td>
</tr>
<tr>
<td>出勤スタイル</td>
<td><input type="text" name="txtworkingstyle" id="txtworkingstyle" size="50" value="';
    if(isset($stylework)){
        echo $stylework;
    }else if (isset($cc)){
        echo set_value("txtworkingstyle");
    }else{
        echo $ow["working_style_note"];
    }
echo'"></td>
</tr>
</table>
</center>


<center>
<p>スタッフ記入欄<br>

<textarea name="txternote" id="txternote" cols="70" rows="15">
';
    if(isset($ernote)){
        echo $ernote;
    }else if (isset($cc)){
        echo set_value("txternote");
    }else{
        echo $ow["error_recruit_note"]; 
    }
echo'
</textarea></p>
</center>

<center>

<p><input type="submit" value="　承認　" name="btnupow" /></p>';
echo "</form>";
}
echo '</center>';
?>
