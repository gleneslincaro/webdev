<style>
.analysis_box{
overflow:hidden;
width: 98%;
}

.lock_box{
float:left;
width: 104px;
margin-bottom: 20px;
}

.x_scroll_box{
overflow-x:scroll;
margin-bottom: 20px;
}

table#analysis_head{
margin-left: auto;
margin-right: auto;
}

table#analysis_head tr{
width: 100px;
height: 30px;
}

table#analysis_head tr td{
width: 100px;
background-color:#FFF;
}
table#analysis_head tr td span{
color:#FF0000;
}

table#analysis{
margin-left: auto;
margin-right: auto;
float: left;
}

table#analysis tr{
height: 30px;
}

table#analysis tr td{
width: 65px;
background-color:#FFF;
text-align: right;
}
table#analysis tr td span{
color:#FF0000;
}
</style>

<center>
<p>店舗詳細</p>
<p>
下記「本登録ボタン」ですが、仮登録状態の場合に表示される。「本登録ボタン」をクリックすると状態が「本登録」へ切り替わる。<br>
また、全体図【　ow02本登録　】自動配信メールが飛ぶ。　※メール文言設定・オーナー側・ow02_本登録</p>

<!--search -->
<form class="historical-data-form" name="myForm" method ="post" style="width:250px;float:left;margin-bottom:10px;">
  期間指定
  <select name="from_date">
  <?php
  end($select_date_from);
  $lastkey = key($select_date_from);
  foreach($select_date_from as $key=>$value): ?>
  <option <?php if($key == $lastkey){echo " selected='selected' ";}?>><?php echo $value;?></option>
  <?php endforeach; ?>
  </select>~
  <select name="to_date">
  <?php
  end($select_date_to);
  $lastkey = key($select_date_to);
  foreach($select_date_to as $key=>$value): ?>
  <option <?php if($key == $lastkey){echo " selected='selected' ";}?>><?php echo $value;?></option>
  <?php endforeach; ?>
  </select>
</form>
<!--end search -->
</center>
<div class="analysis_box">
    <div class="lock_box">
        <table id = "analysis_head" border cellpadding="5" width="100%" style="">
        <tr class="head">
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>スカウト送信</td>
        </tr>
        <tr>
            <td>開封数</td>
        </tr>
        <tr>
            <td>開封率</td>
        </tr>
        <tr>
            <td>アクセス</td>
        </tr>
        <tr>
            <td>HP</td>
        </tr>
        <tr>
            <td>クチコミ</td>
        </tr>
        <tr>
            <td>電話</td>
        </tr>
        <tr>
            <td>Email</td>
        </tr>
        <tr>
            <td>匿名質問</td>
        </tr>
        <tr>
            <td>面接</td>
        </tr>
        <tr>
            <td>体験入店</td>
        </tr>
        </table>
    </div>
    <div class="x_scroll_box">
        <?php if(isset($analysis_data)): ?>
        <table id = "analysis" border cellpadding="5" width="100%" style="">
        <tr class="head">
            <td style="text-align:left;"><?php echo $analysis_data['nowmonth'];?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['scout_mail_send'];?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['scout_mail_open'];?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo round($analysis_data['scout_open_rate'] * 100 ,1); ?>%</td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['shop_access_num']; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['hp_click_num']; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['kuchikomi_click_num']; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['tel_click_num']; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['mail_click_num']; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['question_num']; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['travel_num']; ?></td>
        </tr>
        <tr>
            <td style="text-align:left;"><?php echo $analysis_data['campaign_bonus_num']; ?></td>
        </tr>
        </table>
        <?php endif; ?>
    </div>
</div><!-- / .analysis_box -->
<form action="" id="frmComDetail" method="post" enctype="multipart/form-data">
<input type="hidden" name="hrId" id="hrId" value="<?php echo $records["id"]; ?>" />
<input type="hidden" name="hrOwnerStatus" id="hrOwnerStatus" value="<?php echo $records["owner_status"]; ?>" />
<?php
if($records['owner_status']==0){?>
<p><input type="button" value="　本登録ボタン　" onClick="res=confirm('本登録に切り替えますか？');
    if(res==true){doAction('<?php echo base_url(); ?>index.php/admin/search/update_owner_register')}"></p>
<?php } ?>
<table border width="98%">
<tr>
<td width="15%">アドレス</td>
<td width="85%"><input type="text" name="txtEmail" maxlength="200" id="txtEmail" size="50" value="<?php echo $records["email_address"]; ?>">
メール送信
<input type="radio" name="uMonthSendFlag"  id="uMonthSendFlag" value="1" <?php if($records['month_send_flag']==1){echo 'checked';} ?>> オン
<input type="radio" name="uMonthSendFlag"  id="uMonthSendFlag" value="0" <?php if($records['month_send_flag']==0){echo 'checked';} ?>> オフ
</td>
</tr>
<td>パスワード</td>
<td><input type="text" name="txtPassword" maxlength="20" id="txtPassword" size="50" value="<?php echo base64_decode($records['password']); ?>"></td>
<tr>
<td>状態</td>
<td>
<select name="cbOwnerStatus" id="cbOwnerStatus">
 <?php
if($records['owner_status']==0){?>
<option value="0" <?php if($records['owner_status']==0) echo 'selected'; ?>>仮登録</option>
<?php } ?>
<option value="1" <?php if($records['owner_status']==1) echo 'selected'; ?>>ステルス</option>
<option value="5" <?php if($records['owner_status']==5) echo 'selected'; ?>>リクエスト</option>
<option value="2" <?php if($records['owner_status']==2) echo 'selected'; ?>>本登録</option>
<?php if($records['owner_status']!=0){?>
<option value="3" <?php if($records['owner_status']==3) echo 'selected'; ?>>ペナルティ</option>
<?php } ?>
<option value="4" <?php if($records['owner_status']==4) echo 'selected'; ?>>無効</option>
</select>
※realtimeの状態をデフォで表示
</td>
<tr>
<td>代理店アドレス</td>
<td width="85%"><input type="text" name="txtAgEmail" maxlength="200" id="txtAgEmail" size="50" value="<?php echo $records["ag_email_address"]; ?>">
メール送信
<input type="radio" name="uAgMonthSendFlag" id="uAgMonthSendFlag" value="1" <?php if($records['ag_month_send_flag']==1){echo 'checked';} ?>> オン
<input type="radio" name="uAgMonthSendFlag" id="uAgMonthSendFlag" value="0" <?php if($records['ag_month_send_flag']==0){echo 'checked';} ?>> オフ
</td>
</tr>
<tr>
<td>最終ログイン</td>
<td><?php echo $records["last_visit_date"]==null ? '' : date("Y/m/d H:i",  strtotime($records['last_visit_date'])); ?>
<input type="hidden" name="hrLastVisitDate" id="hrLastVisitDate" value="<?php echo $records["last_visit_date"]; ?>" /></td>
</tr>
<tr>
<td>仮登録日</td>
<td><?php echo $records["temp_reg_date"]==null ? '' : date("Y/m/d H:i",  strtotime($records['temp_reg_date'])); ?>
<input type="hidden" name="hrTempRegDate" id="hrTempRegDate" value="<?php echo $records["temp_reg_date"]; ?>" /></td>
</tr>

<tr>
<td>本登録日</td>
<td><?php echo $records["offcial_reg_date"]==null ? '' : date("Y/m/d H:i",  strtotime($records['offcial_reg_date'])); ?>
<input type="hidden" name="hrOffcialRegDate" id="hrOffcialRegDate" value="<?php echo $records["offcial_reg_date"]; ?>" /></td>
</tr>
<tr>
<td>新着店舗</td>
<td>
<input id="NewStoreDateForm" class="hesDatepicker" type="text" value="<?php echo $records["new_store_date"]==null ? '' : date("Y/m/d",  strtotime($records['new_store_date'])); ?>" size="30" name="NewStoreDate">
</td>
</tr>
<tr>
<td>広告サイト</td>
<td><?php echo $records['websitename']; ?>
<input type="hidden" name="hrWebsiteName" id="hrWebsiteName" value="<?php echo $records["websitename"]; ?>" /></td>
</tr>
<tr>
<td>応募数</td>
<td><?php echo $countApplicants; ?>
<input type="hidden" name="hrCountApplicants" id="hrCountApplicants" value="<?php echo $countApplicants; ?>" /></td>
</tr>
<tr>
<td>スカウト送信数</td>
<td><?php echo $countScoutSent; ?>
<input type="hidden" name="hrCountScountSent" id="hrCountScountSent" value="<?php echo $countScoutSent; ?>" /></td>
</tr>
<tr>
<td>情報公開数</td>
<td><?php echo $countPublicInfo; ?>
<input type="hidden" name="hrCountPublicInfo" id="hrCountPublicInfo" value="<?php echo $countPublicInfo; ?>" /></td>
</tr>
<tr>
<td>勤務承認数</td>
<td><?php echo $countWorkingApprove; ?>
<input type="hidden" name="hrCountWorkingApprove" id="hrCountWorkingApprove" value="<?php echo $countWorkingApprove; ?>" /></td>
</tr>
<tr>
<td>見送り数</td>
<td><?php echo $countSendNumber; ?>
<input type="hidden" name="hrCountSendNumber" id="hrCountSendNumber" value="<?php echo $countSendNumber; ?>" /></td>
</tr>
<tr>
<td>累計購入金額</td>
<td>\<?php echo number_format($records['total_amount'], 0, '.', ','); ?>
<input type="hidden" name="hrTotalAmount" id="hrTotalAmount" value="<?php echo $records["total_amount"]; ?>" /></td>
</tr>
<tr>
<td>保有ポイント</td>
<td><?php echo number_format($records['total_point'], 0, '.', ','); ?> pt
<input type="hidden" name="hrTotalPoint" id="hrTotalPoint" value="<?php echo $records["total_point"]; ?>" /></td>
</tr>
<tr>
<td>配信停止</td>
<td>
<select name="cbMagazineStatus" id="cbMagazineStatus">
<option value="1" <?php if($records['magazine_status']==1) echo'selected'; ?>>配信OK</option>
<option value="0" <?php if($records['magazine_status']==0) echo'selected'; ?>>配信NG</option>
</select>　※realtimeの状態をデフォで表示
</td>
</tr>
<tr>
<td>メモ</td>
<td>
<textarea name="txtMemo" id="txtMemo" maxlength="100000" cols="80" rows="10"><?php echo $records['memo']; ?></textarea></td>
</tr>
<tr>
<td>IPアドレス</td>
<td><?php echo $records['ip_address']; ?>　　※登録時のIPアドレスを取得してその後は取得しない。
<input type="hidden" name="hrIpAddress" id="hrIpAddress" value="<?php echo $records["ip_address"]; ?>" /></td>
</tr>
<tr>
<td>店舗情報</td>
<td>
<input type="radio" name="rdPublicFlag"  id="rdPublicFlag" value="1" <?php if($records['public_info_flag']==1) echo 'checked'; ?>> 公開
<input type="radio" name="rdPublicFlag"  id="rdPublicFlag" value="0" <?php if($records['public_info_flag']==0) echo 'checked'; ?>> 非公開
</td>
</tr>
<tr>
<td>自動更新設定</td>
<td>
<input type="radio" name="autoSendFlag" id="autoSendFlag" value="1" <?php echo (count($autoSendFlag) !=0 ? 'checked' : ''); ?>> オン
<input type="radio" name="autoSendFlag" id="autoSendFlag" value="0" <?php echo (count($autoSendFlag) == 0? 'checked' : ''); ?>> オフ
</td>
</tr>
<tr>
<td>急募</td>
<td>
<input type="radio" name="uRecruitmentFlag"  id="uRecruitmentFlag" value="1" <?php if($records['urgent_recruitment_flag']==1) echo 'checked'; ?>> オン
<input type="radio" name="uRecruitmentFlag"  id="uRecruitmentFlag" value="0" <?php if($records['urgent_recruitment_flag']==0) echo 'checked'; ?>> オフ
</td>
</tr>
<tr>
<td>メールアドレスエラー設定</td>
<td>
<input type="radio" name="email_error_flag"  id="email_error_flag" value="1" <?php if($records['email_error_flag']==1) echo 'checked'; ?>> オン
<input type="radio" name="email_error_flag"  id="email_error_flag" value="0" <?php if($records['email_error_flag']==0) echo 'checked'; ?>> オフ
</td>
</tr>
<tr>
    <td>無料店舗</td>
    <td><input type="radio" name="free_owner_flag"  id="free_owner_flag" value="1" <?php if($records['free_owner_flag']==1) echo 'checked'; ?>> オン
        <input type="radio" name="free_owner_flag"  id="free_owner_flag" value="0" <?php if($records['free_owner_flag']==0) echo 'checked'; ?>> オフ</td>
</tr>
<tr>
<td>1日スカウト送信数</td>
<td>
<select name="txtDefaultScoutMailsPerDay" id="txtDefaultScoutMailsPerDay">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="40">40</option>
<option value="50">50</option>
<option value="60">60</option>
<option value="70">70</option>
<option value="80">80</option>
<option value="90">90</option>
<option value="100">100</option>
<option value="150">150</option>
<option value="200">200</option>
<option value="250">250</option>
<option value="300">300</option>
<option value="350">350</option>
<option value="400">400</option>
<option value="450">450</option>
<option value="500">500</option>
<option value="550">550</option>
<option value="600">600</option>
<option value="650">650</option>
<option value="700">700</option>
<option value="750">750</option>
<option value="800">800</option>
<option value="850">850</option>
<option value="900">900</option>
<option value="950">950</option>
<option value="1000">1000</option>
</select>　※デフォはスカウト送信画面で設定した数値　※変更した際はプルダウンで変更した数値が優先される
</td>
</tr>
<tr>
<td>クチコミリンク</td>
<td><input type="text" name="txtKuchikomiUrl" maxlength="200" id="txtKuchikomiUrl" size="100" value="<?php echo $records['kuchikomi_url']; ?>"></td>
</tr>
<tr>
<td height="50" rowspan="2">外部サイト情報</td>
<td><input type="text" name="kameLoginId" placeholder="ユーザー名" id="kameLoginId" value="<?php echo (isset($kameLoginId)) ? $kameLoginId : $records['kame_login_id'];?>"></td>
</tr>
<tr>
<td><input type="text" name="kamePassword" placeholder="パスワード" id="kamePassword" value="<?php echo (isset($kamePassword)) ? $kamePassword : base64_decode($records['kame_password']);?>"></td>
</tr>
<tr>
  <td>交通費金額設定</td>
  <td><input type="text" name="travel_expense_bonus_point" id="travel_expense_bonus_point" value="<?php echo (isset($_POST['travel_expense_bonus_point']))?$_POST['travel_expense_bonus_point'] : $records['travel_expense_bonus_point'] ?>"/></td>
</tr>
<tr>
  <td>体験入店ボーナスポイント</td>
  <td><input type="text" name="txtNewTrialWorkBonus" id="txtNewTrialWorkBonus" value="<?php echo (isset($_POST['txtNewTrialWorkBonus']))?$_POST['txtNewTrialWorkBonus'] : $records['trial_work_bonus_point'] ?>"/></td>
</tr>
</table>

<center>
<p><input id="reg_submit" type="button" value="　登録　" ></p>
</center>

<center>
<p>画像選択：<input type="file" name="txtImgComDetail" accept="image/jpeg" id="idUploadComDetail"></p>

<?php
if($records['kanri_image'] != null || $records['kanri_image'] != ''){
    echo '<p><img src="'.base_url().'public/admin/uploads/images/'.$records["kanri_image"].'" width="400px" height="300" id="idImgComDetail" /></p>';
    echo '<p><input type="button" value="　写真を削除　" id="idDelImageComDetail"></p>';
}else{
    echo '<p><img src="'.base_url('public/admin/image/no_image_owner.jpg').'" width="400px" height="300" id="idImgComDetail" /></p>';
    echo '<p><input type="button" value="　写真を削除　" disabled="disabled" id="idDelImageComDetail"></p>';
}
echo '<input type="hidden" id="hrImgComDetail" name ="hrImgComDetail" value="'.$records["kanri_image"].'" >
      <input type="hidden" id="hrImgComDetail2" name ="hrImgComDetail2" value="'.$records["kanri_image"].'" >';
?>
</center>
</form>
<script type="text/javascript">
function doAction(action){
    var form=document.getElementById('frmComDetail');
    form.action=action;
    form.submit();
}

$(function(){

    $("#reg_submit").on('click', function(event){
        var update_data = $("#frmComDetail").serialize();
        $.ajax({
            url:"<?php echo base_url();?>admin/search/validate_update_owner",
            type:"post",
            data:update_data,
            dataType:"json",
            async:true
        }).done(function(data){
            if(!data.success){
                alert($('<p>').html(data.message).text());
                return false;
            }
            if (!confirm('登録してもいいでしょうか？')){
                return false;
            }
            $.ajax({
                url:"<?php echo base_url();?>admin/search/update_owner",
                type:"post",
                data:update_data,
                async:true
            }).done(function(data){
                window.location="<?php echo base_url();?>admin/search/update_owner_completed";
            }).fail(function(data){
                alert('error!!!');
            });
        }).fail(function(data){
            alert('error!!!');
        });
    });

    $('[name=from_date],[name=to_date]').change(function(){
        var owner_id = <?php echo $records["id"]; ?>;
        var fromdate = $('[name=from_date] option:selected').text();
        var todate = $('[name=to_date] option:selected').text();
        $('#sort_in_progress').show();
        $.post("<?php echo base_url();?>admin/analysis/result_of_analysis",{from_date:fromdate,to_date:todate,owner_id:owner_id}, function(data){
          $('#analysis').html(data);
          $('#sort_in_progress').hide();
          var size = $('#analysis tr.head td').length * 67;
          $('#analysis').css('width',size+'px');
        });
    });

    var dsmpd = "<?php echo $records["default_scout_mails_per_day"]; ?>";
    var select = document.getElementById("txtDefaultScoutMailsPerDay");
    for (var i = 0; i < select.options.length; i++)
    {
        if (select.options[i].value == dsmpd) {
          select.options[i].selected = true;
          break;
        }
    }

    $("#idDelImageComDetail").click(function(){
        res=confirm('削除しますか？');
        if(res==true){
            var path = "<?php echo base_url();?>public/admin/image/no_image_owner.jpg";
            var iupload = $("#idUploadComDetail");
            $("#idImgComDetail").attr("src",path);
            $("#hrImgComDetail").attr("value","");
            iupload.clearInputs();
            $("#idDelImageComDetail").attr("disabled","disabled");
        }
    });

    $('#idUploadComDetail').change(function(){
        var id=$("#hrId").val();
        var upload_action = "<?php echo base_url();?>admin/search/file_upload_com_detail";
        $('#frmComDetail').ajaxSubmit({
            url: upload_action,
            type:"post",
            async:true,
            data: { id: id },
            dataType:'json',
            success: function(responseText, statusText, xhr, $form){
                $("#idImgComDetail").attr("src", responseText.url);
                $("#hrImgComDetail").attr("value", responseText.fileName);
                if(responseText.error !=null){
                    alert(responseText.error);
                }
                if(responseText.fileName==null){
                    var iupload = $("#idUploadComDetail");
                    iupload.clearInputs();
                }else{
                    $("#idDelImageComDetail").removeAttr("disabled");
                }
            }
        });
        return false;
    });
});
</script>
<script type="text/javascript">
    $( "#NewStoreDateForm" ).datepicker({ dateFormat: "yy/mm/dd" });

//    $( "#NewStoreDateForm" ).datepicker({ dateFormat: "yy-mm-dd" });

/*
// Dateオブジェクトを生成
now = new Date();
 
// 年を取得
//y = now.getYear();
y = now.getFullYear();
 
// 月を取得
m = now.getMonth() + 1;
 
// 日を取得
d = now.getDate();
 
// 時を取得
h = now.getHours();
 
// 分を取得
i = now.getMinutes();
 
// 秒を取得
s = now.getSeconds();
 
alert(y + '年' + m + '月' + d + '日 ' + h + '時' + i + '分' + s + '秒');
*/
//    pagination_company_kanri();
    
    $("#NewStoreDateForm").change(function(){
        var dateFrom = $("#NewStoreDateForm").val();
        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
//        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\-(0\d|1[012])\-(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#NewStoreDateForm').val("");
        }
    });
</script>