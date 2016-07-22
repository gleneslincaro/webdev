<script language="javascript">
$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
$("document").ready(function(){
        var flag =$("#txtflag").val();
        var base = $("#base").attr("value");
        var id=$("#txtuid").val();
        var old_id=$("#txtOldID").val();
        var pass=$("#txtpass").val();
        var uname=$("#txtUname").val();
        var status=$("#txtstatus").val();
        var email=$("#txtemail").val();
        var birthday=$("#txtbirthday").val();
        var charge=$("#txtcharge").val();
        var bank=$("#txtbankname").val();
        var bankkana=$("#txtbankkana").val();
        var ac_type=$("#txtac_type").val();
        var ac_no=$("#txtacountno").val();
        var ac_name=$("#txtaccountname").val();
        var getmail=$("#txtgetmail").val();
        var memo=$("#txtmemo").val();
        var image1=$("#img1").val();
        var image2=$("#img2").val();
        var telephone_number = $('#txttelephone').val();
        var telephone_record = $('#txttelrecord').val();
        if(flag!=null && flag!=""){
            bol=window.confirm("登録しますか？");
            if(bol==true){
                $("#txtflag").val("");
                $.ajax({
                    url:base+"admin/search/do_updateUser",
                    type:"post",
                    data:
                    {
                        txtpass:pass,
                        txtOldID:old_id,
                        txtUname:uname,
                        txtstatus:status,
                        txtemail:email,
                        txtbirthday:birthday,
                        txtcharge:charge,
                        txtbankname:bank,
                        txtbankkana:bankkana,
                        txtac_type:ac_type,
                        txtacountno:ac_no,
                        txtaccountname:ac_name,
                        txtgetmail:getmail,
                        txtmemo:memo,
                        img1:image1,
                        img2:image2,
                        id:id,
                        txttelephone:telephone_number,
                        txttelrecord:telephone_record
                    },
                    async:true,
                     beforeSend: function ( xhr ) {
                        $.blockUI();
                    },
                    success:function(kq){
                        window.location=base+"admin/search/complete";
                    }
                })
            }
        }    
 })
</script>
<?php
echo '<center>
<p>ユーザー詳細</p>

<p>
下記「本登録ボタン」ですが、仮登録状態の場合に表示される。「本登録ボタン」をクリックすると状態が「本登録」へ切り替わる。<br>
また、全体図【　us02本登録　】自動配信メールが飛ぶ。　※メール文言設定・ユーザー側・us02_本登録</p>';

foreach ($detail as $k=>$de){
    if($de["user_status"]==0){
        echo '<p><a href="#" class="a_apro" id="'.$de["uid"].'"><input type="button" value="本登録ボタン"></a></p></center>';
    }
    if(!empty($recruit)){
        echo '<p><a href="'.base_url().'admin/search/user_profile/'.$de["uid"].'">プロフィール確認</a></p></center>';
    }
echo "<form action='".base_url()."admin/search/userDetail?uid=".$de["uid"]."' method='post'  enctype='multipart/form-data' id='form_mn'>";
echo "<input type='hidden' id='txtflag' value='";
    if(isset($flag)){
        echo $flag;
       
    }
echo "'>";
echo "<input type='hidden' value='".$de["uid"]."' name='txtuid' id='txtuid'>";    
echo '<table border width="98%">
<tr>
<td style="padding-right:30px;"><span style="display:block;width:100px;">システムID</span></td>
<td width="400px">'.$de["unique_id"].'</td>
</tr>
<tr>
<td>パスワード</td>
<td><input type="text" name="txtpass" id="txtpass" size="50" value="';
    if(isset($pass)){
        echo base64_decode($pass);
    }else if (isset($cc)){
        echo set_value("txtpass");
    }else{
       echo base64_decode($de["password"]);
    }    
echo '"></td>
</tr>
<tr>
<td>元のＩＤ</td>
<td><input type="text" readonly name="txtOldID" id="txtOldID" size="50" value="';
    if(isset($old_id)){
        echo $old_id;
    }else if (isset($cc)){
        echo set_value("txtOldID");
    }
    else{
       echo $de["old_id"];
    }
echo'"></td>
</tr>
<tr>
<td>状態</td>
<td>
<select name="sltstatus">';
if($de["user_status"]==0){
echo '<option value="0"';
    if($de["user_status"]==0){
        echo "selected='selected'";
    }
}
echo '>仮登録</option>
<option value="1"';
    if($de["user_status"]==1){
        echo "selected='selected'";
    }else if(isset($_POST["sltstatus"]) && $_POST["sltstatus"]==1){
         echo "selected='selected'";
    }
echo '>本登録</option>
<option value="2"';
    if($de["user_status"]==2){
        echo "selected='selected'";
    }else if(isset($_POST["sltstatus"]) && $_POST["sltstatus"]==2){
         echo "selected='selected'";
    }
echo '>無効</option>
<option value="3"';
    if($de["user_status"]==3){
        echo "selected='selected'";
    }else if(isset($_POST["sltstatus"]) && $_POST["sltstatus"]==3){
         echo "selected='selected'";
    }
echo '>ステルス</option>
<option value="4"';
    if($de["user_status"]==4){
        echo "selected='selected'";
    }else if(isset($_POST["sltstatus"]) && $_POST["sltstatus"]==3){
         echo "selected='selected'";
    }
echo '>確認待ち</option>';
echo "</select>";
echo "<input type='hidden' id='txtstatus' value='";
    if(isset($status)){
        echo $status;
    }else{
        $de["user_status"];
    }
echo "'>";
echo '</td>
  
</tr>
<tr>
<td>氏名</td>
<td><input type="text" name="txtUname" id="txtUname" value="';
    if(isset($uname)){
        echo $uname;
    }else if (isset($cc)){
        echo set_value("txtUname");
    }
    else{
       echo $de["uname"];
    }
echo'"></td>
</tr>
<tr>
<td>登録サイト</td>
<td>';
    echo $de["wname"];
echo'
</td>
</tr>




<tr>
<td>アドレス</td>
<td><input type="text" name="txtemail" id="txtemail" size="50" value="';
    if(isset($email)){
        echo $email;
    }else if (isset($cc)){
        echo set_value("txtemail");
    }
    else{
       echo $de["email_address"];
    }
echo'"></td>
</tr>
<tr>
<td>生年月日</td>
<td><input type="text" name="txtbirthday"  id="txtbirthday" size="20" value="';
    if(isset($birthday)){
        echo $birthday;
    }else if (isset($cc)){
        echo set_value("txtbirthday");
    }
    else{
       echo date("Y/m/d H:i", strtotime($de["birthday"]));
    }
echo '" id="txtbirthday"></td>
</tr>
<tr>
    <td>電話番号</td>
    <td><input type="text" name="txttelephone" size="20" value="';
    if(isset($tel_number)){
        echo $tel_number;
    } else if (isset($cc)) {
        echo set_value("txttelephone");
    } else {
        echo $de["telephone_number"];
    }

echo '" id="txttelephone" maxlength="25"></td>
</tr>
<tr>
<td>最終ログイン</td>
<td>';
    if($de["last_visit_date"]!=null || $de["last_visit_date"]!=""){
        echo date("Y/m/d H:i", strtotime($de["last_visit_date"]));
    }
echo'</td>
</tr>
<tr>
<td>仮登録日</td>
<td>';
    if($de["temp_reg_date"]!=null || $de["temp_reg_date"]!=""){
           echo date("Y/m/d H:i", strtotime($de["temp_reg_date"]));
    }
echo'</td>
</tr>
<tr>
<td>本登録日</td>
<td>';
    if($de["offcial_reg_date"]!=null || $de["offcial_reg_date"]!=""){
           echo date("Y/m/d H:i", strtotime($de["offcial_reg_date"]));
    }
echo'</td>
</tr>
<tr>
<td>スカウト受信数</td>
<td>'.$cscout.'</td>
</tr>
<tr>
<td>応募数</td>
<td>'.$capply.'</td>
</tr>
<tr>
<td>店舗情報受信</td>
<td>'.$cview.'</td>
</tr>

<tr>
<td>手数料区分</td>
<td>
<select name="sltcharge">
<option value="0"';
    if($de["charge"]==0){
        echo "selected='selected'";
    }else if(isset($_POST["sltcharge"]) && $_POST["sltcharge"]==0){
         echo "selected='selected'";
    }
echo '>銀行</option>
<option value="1"';
    if($de["charge"]==1){
        echo "selected='selected'";
    }else if(isset($_POST["sltcharge"]) && $_POST["sltcharge"]==1){
         echo "selected='selected'";
    }
echo '>郵便局</option>';
echo "</select>";
echo "<input type='hidden' id='txtcharge' value='";
    if(isset($charge)){
        echo $charge;
    }
echo "' />";
echo '</td>
</tr>
<tr>
<td>銀行名</td>
<td><input type="text" name="txtbankname" id="txtbankname" size="50" value="';
    if(isset($bank)){
        echo $bank;
    }else if (isset($cc)){
        echo set_value("txtbankname");
    }
    else{
       echo $de["bank_name"];
    }
echo '"></td>
</tr>
<tr>
<td>支店名（通帳記号）</td>
<td><input type="text" name="txtbankkana" id="txtbankkana" size="50" value="';
    if(isset($bankkana)){
        echo $bankkana;
    }else if (isset($cc)){
        echo set_value("txtbankkana");
    }else{
       echo $de["bank_agency_kara_name"];
    }
echo '"></td>
</tr>
<tr>
<td>種類</td>
<td>
<select name="sltac_type">
<option value="0"';
    if($de["account_type"]==0){
        echo "selected='selected'";
    }else if(isset($_POST["sltac_type"]) && $_POST["sltac_type"]==0){
         echo "selected='selected'";
    }
echo '>普通</option>
<option value="1"';
    if($de["account_type"]==1){
        echo "selected='selected'";
    }else if(isset($_POST["sltac_type"]) && $_POST["sltac_type"]==1){
         echo "selected='selected'";
    }
echo '>当座</option>';
echo "</select>";
echo "<input type='hidden' id='txtac_type' value='";
    if(isset($ac_type)){
        echo $ac_type;
    }
echo "'>" ;   
echo '</td>
</tr>

<tr>
<td>口座番号（通帳番号）</td>
<td><input type="text" name="txtacountno" id="txtacountno" size="50" value="';
    if(isset($ac_no)){
        echo $ac_no;
    }else if (isset($cc)){
        echo set_value("txtacountno");
    }else{
       echo $de["account_no"];
    }
echo '"></td>
</tr>
<tr>
<td>名義</td>
<td><input type="text" name="txtaccountname" id="txtaccountname" size="50" value="';
  if(isset($ac_name)){
        echo $ac_name;
    }else if (isset($cc)){
        echo set_value("txtaccountname");
    }else{
       echo $de["account_name"];
    }
echo '"></td>
</tr>

<tr>
<td>配信停止</td>
<td>
<select name="txtgetmail">
<option value="1"';
    if(!isset($cc)){
         if($de["magazine_status"]==1){
                echo "selected='selected'";
         }
    }
   else{
       if($_POST["txtgetmail"]==1){
         echo "selected='selected'";
       }
    }
echo '>配信OK</option>
<option value="0"';
    if(!isset($cc)){
         if($de["magazine_status"]==0){
                echo "selected='selected'";
         }
    }
   else{
       if($_POST["txtgetmail"]==0){
         echo "selected='selected'";
       }
    }
echo '>配信NG</option>
</select>　※realtimeの状態をデフォで表示';
echo "<input type='hidden' id='txtgetmail' value='";
    if(isset($getmail)){
        echo $getmail;
    }
echo "'>" ;   
echo '</td>
</tr>
<tr>
<td>メモ</td>
<td>
<textarea name="txtmemo" id="txtmemo" cols="90" rows="15">
';
    if(isset($memo)){
        echo $memo;
    }else if (isset($cc)){
        echo set_value("txtmemo");
    }
    else{
       echo $de["memo"];
    } 
echo'
</textarea></td>
</tr>
<tr>
    <td>電話対応記録</td>
    <td>
    <textarea name="txttelrecord" id="txttelrecord" cols="90" rows="15">';
    if(isset($telephone_record)){
        echo $telephone_record;
    } else if(isset($cc)) {
        echo set_value("txttelrecord");
    } else{
        echo $de["telephone_record"];
    }

echo '</textarea>
    </td>
</tr>
</table>

<center>
<p><input type="submit" value="登録" name="btnupdateus"  /></p>
</center>


<center>';
echo '<p>画像選択：<input type="file" name="txtimg" accept="image/jpeg" id="iupload"></p>';
if($de["image1"]==null || $de["image1"]==""){
    if(isset($image1) && $image1!=""){
            echo '<p><img src="'.base_url().'public/user/uploads/tmp/'.$image1.'" width="400px" height="300" id="idp_img" /></p>';
    }else{
           echo '<p><img src="'.base_url().'public/admin/image/no_image.jpg" width="400px" height="300" id="idp_img" /></p>'; 
    }
}else{
    if(isset($image1) && $image1!=""){
        if($image1==$de["image1"]){
             echo '<p><img src="'.base_url().'public/user/uploads/images/'.$image1.'" width="400px" height="300" id="idp_img" /></p>';           
        }else{
            echo '<p><img src="'.base_url().'public/user/uploads/tmp/'.$image1.'" width="400px" height="300" id="idp_img" /></p>';
        }
    }else if(isset($image1) && $image1==""){
      echo '<p><img src="'.base_url().'public/admin/image/no_image.jpg" width="400px" height="300" id="idp_img" /></p>'; 
    }
    else{
            echo '<p><img src="'.base_url().'public/user/uploads/images/'.$de["image1"].'" width="400px" height="300" id="idp_img" /></p>';
    }   
}

echo '<p><input type="button" value="　写真を削除　" id="btndel1"></p>';
echo '</center>';
echo '<center>

<p>画像選択：<input type="file" name="txtimg1" accept="image/jpeg" id="iupload1"></p>';
if($de["image2"]==null || $de["image2"]==""){
    if(isset($image2) && $image2!=""){
            echo '<p><img src="'.base_url().'public/user/uploads/images/'.$image2.'" width="400px" height="300" id="idp_img1" /></p>';
    }else{
        echo '<p><img src="'.base_url().'public/admin/image/no_image.jpg" width="400px" height="300" id="idp_img1" /></p>';
    }
}else{
    if(isset($image2) && $image2!=""){
        if($image2==$de["image2"]){
             echo '<p><img src="'.base_url().'public/user/uploads/images/'.$image2.'" width="400px" height="300" id="idp_img1" /></p>';
        }else{
             echo '<p><img src="'.base_url().'public/user/uploads/tmp/'.$image2.'" width="400px" height="300" id="idp_img1" /></p>';
        }    
    }else if(isset($image2) && $image2==""){
         echo '<p><img src="'.base_url().'public/admin/image/no_image.jpg" width="400px" height="300" id="idp_img1" /></p>';
    }
    else{
            echo '<p><img src="'.base_url().'public/user/uploads/images/'.$de["image2"].'" width="400px" height="300" id="idp_img1" /></p>';
    }
}
echo '<p><input type="button" value="   写真を削除   " id="btndel2"/></p>';
echo '<input type="hidden" id="img1" name ="img1" value="';
    if(isset($image1)){
        echo $image1;
    }else{
        echo $de["image1"];   
    }
echo '" >';
echo '<input type="hidden" id="img2" name ="img2" value="';
      if(isset($image2)){
        echo $image2;
    }else{
        echo $de["image2"];   
    }
echo '" >'; 
echo "</form>";

echo '

<p>
お祝い申請一覧
</p>';


}

echo '<div style="margin:0px;padding:0px;" align="center">
<table style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>

<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">申請日&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">承認日&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">入金状態&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">採用金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">お祝い金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">利益&nbsp;</th>
</tr>';
foreach($apscout as $k=>$item){
    echo '<tr>
    <td style="border:1px solid #000000;text-align:center;">'.$item["email_address"].'&nbsp;</td>
    <td style="border:1px solid #000000;text-align:center;">'.$item["storename"].'&nbsp;</td>
    <td style="border:1px solid #000000;text-align:center;">'.date("Y/m/d H:i",  strtotime($item["request_money_date"])).'&nbsp;</td>';
    if($item["approved_date"]==""){
        echo '<td style="border:1px solid #000000;text-align:center;"> ---- &nbsp;</td>';
    }else{
        echo '<td style="border:1px solid #000000;text-align:center;">'.date("Y/m/d H:i",  strtotime($item["approved_date"])).'&nbsp;</td>';
    }
    if($item["user_payment_status"]<6){
        echo '<td style="border:1px solid #000000;text-align:center;">未&nbsp;</td>';
    }elseif($item["user_payment_status"]=6){
        echo '<td style="border:1px solid #000000;text-align:center;">済&nbsp;</td>';
    }elseif($item["user_payment_status"]=7){
        echo '<td style="border:1px solid #000000;text-align:center;">非承認 &nbsp;</td>';
    }
     if($item["approved_date"]==""){
    echo '<td style="border:1px solid #000000;text-align:center;"> ---- &nbsp;</td>
    <td style="border:1px solid #000000;text-align:center;"> ---- &nbsp;</td>
    <td style="border:1px solid #000000;text-align:center;"> ---- &nbsp;</td>';
     }else{
            echo '<td style="border:1px solid #000000;text-align:right;">'.number_format($item["joyspe_happy_money"], 0, '.', ',').'&nbsp;</td>
    <td style="border:1px solid #000000;text-align:right;">'.number_format(($item["joyspe_happy_money"]*40/100), 0, '.', ',').'&nbsp;</td>
    <td style="border:1px solid #000000;text-align:right;">'.number_format(($item["joyspe_happy_money"]*60/100), 0, '.', ',').'&nbsp;</td>'; 
     }
    echo '</tr>';
}
echo '</tbody>
</table>
</div><br/><br/>
'
?>
