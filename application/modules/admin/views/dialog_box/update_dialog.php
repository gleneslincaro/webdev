<div id="main_wrapper">
<a href="<?php echo base_url().'admin/dialog_box/'?>">バック</a>
<?php if(isset($dialog_detail)):?>
  <center>
    <div id="alert_messages">
      <?php echo validation_errors();?>
      <?php echo (isset($success)) ? $success : ''?>
      <p><?php echo (isset($condition_empty)) ? $condition_empty : ''?></p>
      <p><?php echo (isset($no_upload))?$no_upload:''?></p>
      <p><?php echo (isset($user_site_empty)) ? $user_site_empty : ''?></p>
    </div>
    <p>モーダルセットアップ</p>
    <form method="POST" enctype="multipart/form-data">
      <table cellspacing="10" border="0">
        <tbody>
          <tr>
            <td>初期ログインユーザ</td>
            <td><input type="checkbox" name="first_time_login" onkeypress="return isNumber(event)" value="1" <?php echo ($dialog_detail['first_login_flag'] == 1 && !isset($first_time_login))? 'checked' : (isset($first_time_login)&& $first_time_login == 1) ? 'checked' : '' ?> ></td>
          </tr>
          <tr>
            <td>モーダルの表示時間設定</td>
            <td>
              <input type="text"  value="<?php echo (isset($reappear_time_modal)) ? $reappear_time_modal : $dialog_detail['time_to_display']?>" size="40" id="reappear_time" name="reappear_time_modal">
            </td>
          </tr>
          <tr>
            <td>ボタンにテキスト</td>
            <td><input type="text" name="text_button" value="<?php echo (isset($text_button)) ? $text_button : $dialog_detail['text_button']?>" size="40"></td>
          </tr>
          <tr>
            <td>リンク</td>
            <td>
              <input type="text"  value="<?php echo (isset($link)) ? $link : $dialog_detail['link']?>" size="40" id="link" name="link">
            </td>
          </tr>
          <tr>
            <td>優先度</td>
            <td><input type="text" onkeypress="return isNumber(event)" name="priority" value="<?php echo (isset($priority))? $priority: $dialog_detail['priority']?>"></td>
          </tr>
        </tbody>
      </table>

      <p>
          最終ログイン &nbsp;
          開始日&nbsp;
          <input type="text" maxlength="100" size="40" value="<?php echo (isset($txtStartDateLastVisit))? $txtStartDateLastVisit: $dialog_detail['start_date_last_visit']?>" id="txtStartDateLastVisit" name="txtStartDateLastVisit" class="txtdatePicker">
          〜
          終了日&nbsp;
          <input type="text" maxlength="100" size="40" value="<?php echo (isset($txtEndDateLastVisit))?$txtEndDateLastVisit:$dialog_detail['end_date_last_visit']?>" id="txtEndDateLastVisit" name="txtEndDateLastVisit" class="txtdatePicker">
      </p>
      <p>
          ジョイスペ認証日 &nbsp;
          開始日&nbsp;
          <input type="text" maxlength="100" size="40" value="<?php echo (isset($txtStartDateAuth))? $txtStartDateAuth: $dialog_detail['start_date_auth']?>" id="txtStartDateAuth" name="txtStartDateAuth" class="txtdatePicker">
          〜
          終了日&nbsp;
          <input type="text" maxlength="100" size="40" value="<?php echo (isset($txtEndDateAuth))?$txtEndDateAuth:$dialog_detail['end_date_auth']?>" id="txtEndDateAuth" name="txtEndDateAuth" class="txtdatePicker">
      </p>

      <p>
          最小ボーナス金額
          <input type="text" onkeypress="return isNumber(event)" size="20" value="<?php echo (isset($minimum_bonus_money))?$minimum_bonus_money:$dialog_detail['minimum_bonus_money']?>" id="minimum_bonus_money" name="minimum_bonus_money"> 円
          〜
          最大ボーナス金額
          <input type="text" onkeypress="return isNumber(event)" size="20" value="<?php echo (isset($maximum_bonus_money)) ? $maximum_bonus_money: $dialog_detail['maximum_bonus_money']?>" id="maximum_bonus_money" name="maximum_bonus_money"> 円
      </p>
      <p>
        <?php
          $bonus_grant_complete='';
          $bonus_grant_inc='';
          if(isset($bonus_grant)&&$bonus_grant == 1){
            $bonus_grant_complete = 'checked';
          } elseif (isset($bonus_grant)&&$bonus_grant == 0) {
            $bonus_grant_inc = 'checked';
          }
        ?>
        ボーナス付与:
        完了<input type="radio" name="bonus_grant" value="1" <?php echo ($dialog_detail['bonus_grant'] == 1 && !isset($bonus_grant))? 'checked' : $bonus_grant_complete ?>>
        未完了<input type="radio" name="bonus_grant" value="0" <?php echo ($dialog_detail['bonus_grant'] == 0 && !isset($bonus_grant))  ? 'checked' : $bonus_grant_inc ?>> 

      </p>
      <p>
        登録状態　：
        <select name="status_registration" id="status_registration">
        <option value="">選択して下さい</option>
        <option value="0" <?php echo ($dialog_detail['status_registration'] == 0 || (isset($status_registration) && $status_registration == 0)) ? 'selected':''?>>仮登録</option>
        <option value="1" <?php echo ($dialog_detail['status_registration'] == 1 || (isset($status_registration) && $status_registration == 1)) ? 'selected':'' ?>>本登録</option>
        <option value="2" <?php echo ($dialog_detail['status_registration'] == 2 || (isset($status_registration) && $status_registration == 2)) ? 'selected':''?>>無効</option>
        <option value="3" <?php echo ($dialog_detail['status_registration'] == 3 || (isset($status_registration) && $status_registration == 3)) ? 'selected':'' ?>>ステルス</option>
        <option value="4" <?php echo ($dialog_detail['status_registration'] == 4 || (isset($status_registration) && $status_registration == 4)) ? 'selected':'' ?>>確認待ち</option>
        </select>  
      </p>
      <p>ユーザー属性：Joyspe 
          <input type="checkbox" value="1" name="user_from_site" id="user_from_site" <?php echo (isset($user_from_site)&&$user_from_site == 1&&$user_from_site!= 0) ? 'checked' : ($dialog_detail['user_from_site']==1 && !isset($user_from_site)) ? 'checked' : '' ?>>
          マシェモバ <input type="checkbox" value="2" name="user_from_machemoba" <?php echo (isset($user_from_machemoba)&&$user_from_machemoba == 1&&$user_from_machemoba!= 0)? 'checked' : ($dialog_detail['user_from_machemoba'] ==1 && !isset($user_from_machemoba)) ? 'checked' : '' ?>>
          マキア  <input type="checkbox" value="3" name="user_from_makia" <?php echo (isset($user_from_makia)&&$user_from_makia==1&&$user_from_makia!= 0) ? 'checked' : ($dialog_detail['user_from_makia'] ==1 && !isset($user_from_makia)) ? 'checked' : '' ?> >
      </p>
      <p>
        <input type="hidden" name="to_update" value="1">
      </p>
  <div id="uploads">
    <?php for($i=1;$i<=5;$i++):?>
        <div class="images">
          <dt>
            <div class="preview_img<?php echo $i?>">
              <?php if(isset($dialog_detail['image_'.$i])):?>
                <img src="<?php echo base_url().$dialog_detail['image_'.$i]?>">  
              <?php endif;?>
            </div>
          </dt>
          <dd>
             <span><?php echo '('.$i.')'?></span> <input type="file" data-val="<?php echo $i?>" id="dialog_pic<?php echo $i?>" class="dialog_pic" name="dialog_pic[]" accept="image/jpg/jpeg"> 
             <button class="btn-delete " data-val="<?php echo $i?>" data-id="<?php echo $dialog_detail['id']?>">X</button> 
          </dd>
        </div>
    <?php endfor;?>
  </div>

  <input type="hidden" name="edit_flag" value="1">
  <input type="hidden" name="id" value="<?php echo $dialog_detail['id']?>">
  <div id="btn_submit"> 
      <p><input type="submit" value="アップデート"></p>
  </div> 
</form>
<?php else:?>
  <center>
    <h3>Failed to retrieve data </h3>
  </center>
<?php endif;?>
<div>
 </center>
<style type="text/css">
  #alert_messages {
    color:red;
  }
  #main_wrapper {
    padding-top: 50px;
    padding-bottom: 50px;
  }
  #btn_submit{
    clear: both;
  }
  #dialog_list {
    padding-bottom: 150px;
    clear:both;
  }


</style>

  
<script type="text/javascript">
  $(document).ready(function(){
    $('.txtdatePicker').datepicker({dateFormat:'yy/mm/dd'});
    $("#txtStartDateLastVisit").change(function(){
      var dateFrom = $("#txtStartDateLastVisit").val();
      var dateTo = $("#txtEndDateLastVisit").val();
      if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
          alert("日付が正しくありません。再入力してください。");
          $('#txtStartDateLastVisit').val("");
      }
      else if(dateTo!=null){
          if (Date.parse(dateFrom) > Date.parse(dateTo)) {
          alert("日付範囲は無効です。終了日は開始日より後になります。")
          $('#txtStartDateLastVisit').val('');
          return false;
          } 
      }
    });
    $("#txtEndDateLastVisit").change(function(){
        var dateFrom = $("#txtStartDateLastVisit").val();
        var dateTo = $("#txtEndDateLastVisit").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtEndDateLastVisit').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            $('#txtEndDateLastVisit').val('');
            return false;
            } 
        }
    });
    $("#txtStartDateAuth").change(function(){
      var dateFrom = $("#txtStartDateAuth").val();
      var dateTo = $("#txtEndDateAuth").val();
      if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
          alert("日付が正しくありません。再入力してください。");
          $('#txtStartDateAuth').val("");
      }
      else if(dateTo!=null){
          if (Date.parse(dateFrom) > Date.parse(dateTo)) {
          alert("日付範囲は無効です。終了日は開始日より後になります。")
          $('#txtStartDateAuth').val('');
          return false;
          } 
      }
    });
    $("#txtEndDateAuth").change(function(){
        var dateFrom = $("#txtStartDateAuth").val();
        var dateTo = $("#txtEndDateAuth").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtEndDateAuth').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            $('#txtEndDateAuth').val('');
            return false;
            } 
        }
    });
    $(".dialog_pic").change(function(){
      var id = $(this).attr('data-val');
      var files = !!this.files ? this.files : [];
      if (!files.length || !window.FileReader) return;
      if(Math.ceil(files[0].size / 1024, 2) <= 4096) {
        if ((/^image/.test( files[0].type))){
          var reader = new FileReader();
          reader.readAsDataURL(files[0]);
          imageName = files[0].name;
          reader.onloadend = function(){ 
              $(".preview_img"+id).html("<img id='dialog_pic' height='700' width='640' src='" + this.result + "' alt=''  style='margin-bottom:15px;' >");
          }
         
        }else{
          alert('画像ファイルを選択して下さい。');
        }
      } else {
        alert('ファイルサイズは4Mb以下でアップしてください。');
      }
    });
    $('.btn-delete').click(function(){
      var base_url = "<?php echo base_url()?>";
      var image_id = $(this).attr('data-val');
      var id = $(this).attr('data-id');
      if(confirm('削除してもよろしいですか？')) {
        $.post('/admin/dialog_box/delete_image',{image_id:image_id,id:id},function(data){
          $('.preview_img'+image_id).empty();
          $('#dialog_pic'+image_id).val('');
        });
       
        return false;
      }
      return false;
     
    });

  });
  function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      }
      return true;
  }

</script>
