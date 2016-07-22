<center>
  <div style="color:red;">
    <?php echo validation_errors();?>
    <p><?php echo (($this->session->flashdata('success'))) ? $this->session->flashdata('success') : ''?></p>
    <p><?php echo (isset($upload_error)) ? $upload_error : ''?></p>
    <p><?php echo (isset($no_upload)) ? $no_upload : ''?></p>
    <p><?php echo (isset($condition_empty)) ? $condition_empty : ''?></p>
    <p><?php echo (isset($user_site_empty)) ? $user_site_empty : ''?></p>
  </div>
  <p>モーダルセットアップ</p>
  <form method="POST" enctype="multipart/form-data">
    <table cellspacing="10" border="0">
      <tbody>
        <tr>
          <td>初期ログインユーザ</td>
          <td><input type="checkbox" name="first_time_login" value="1"></td>
        </tr>
        <tr>
          <td>モーダルの表示時間設定</td>
          <td>
            <input type="text" onkeypress="return isNumber(event)"  value="<?php echo set_value('reappear_time_modal')?>" size="40" id="reappear_time" name="reappear_time_modal">
          </td>
        </tr>
        <tr>
          <td>ボタンにテキスト</td>
          <td>
           <input type="text"  value="<?php echo set_value('text_button')?>" size="40" id="text_button" name="text_button">
          </td>
        </tr>
        <tr>
          <td>リンク</td>
          <td>
            <input type="text"  value="<?php echo set_value('link')?>" size="40" id="link" name="link">
          </td>
        </tr>
        <tr>
          <td>優先度</td>
          <td><input type="text" onkeypress="return isNumber(event)" name="priority" value="<?php echo set_value('priority')?>"></td>
        </tr>
      </tbody>
    </table>

    <p>
        最終ログイン &nbsp;
        開始日&nbsp;
        <input type="text" maxlength="100" size="40" value="<?php echo set_value('txtStartDateLastVisit')?>" id="txtStartDateLastVisit" name="txtStartDateLastVisit" class="txtdatePicker">
        〜
        終了日&nbsp;
        <input type="text" maxlength="100" size="40" value="<?php echo set_value('txtEndDateLastVisit')?>" id="txtEndDateLastVisit" name="txtEndDateLastVisit" class="txtdatePicker">
    </p>
    <p>
        ジョイスペ認証日 &nbsp;
        開始日&nbsp;
        <input type="text" maxlength="100" size="40" value="<?php echo set_value('txtStartDateAuth') ?>" id="txtStartDateAuth" name="txtStartDateAuth" class="txtdatePicker">
        〜
        終了日&nbsp;
        <input type="text" maxlength="100" size="40" value="<?php echo set_value('txtEndDateAuth')?>" id="txtEndDateAuth" name="txtEndDateAuth" class="txtdatePicker">
    </p>

    <p>
        最小ボーナス金額
        <input type="text" size="20" onkeypress="return isNumber(event)" value="<?php echo set_value('minimum_bonus_money') ?>" id="minimum_bonus_money" name="minimum_bonus_money"> 円
        〜
        最大ボーナス金額
        <input type="text" size="20" onkeypress="return isNumber(event)" value="<?php echo set_value('maximum_bonus_money') ?>" id="maximum_bonus_money" name="maximum_bonus_money"> 円
    </p>
    <p>
      ボーナス付与:
      完了<input type="radio" name="bonus_grant" <?php echo set_radio('bonus_grant','1') ?> value="1">
      未完了<input type="radio" name="bonus_grant" <?php echo set_radio('bonus_grant','0')?> value="0">

    </p>
    <p>
      登録状態　：
      <select name="status_registration" id="status_registration">
      <option value="">選択して下さい</option>
      <option value="0" <?php echo set_select('status_registration','0')?>>仮登録</option>
      <option value="1" <?php echo set_select('status_registration','1')?>>本登録</option>
      <option value="2" <?php echo set_select('status_registration','2')?>>無効</option>
      <option value="3" <?php echo set_select('status_registration','3')?>>ステルス</option>
      <option value="4" <?php echo set_select('status_registration','4')?>>確認待ち</option>

      </select>  
    </p>
    <p>ユーザー属性：Joyspe <input type="checkbox" <?php echo set_checkbox('user_from_site','1')?>  value="1" name="user_from_site">
        マシェモバ <input type="checkbox" value="2" <?php echo set_checkbox('user_from_machemoba','2')?>  name="user_from_machemoba">
        マキア  <input type="checkbox" value="3" <?php echo set_checkbox('user_from_makia','3')?> name="user_from_makia">
    </p>

  <div id="uploads">
  <?php for($i=0;$i<5;$i++):?>
      <div class="images">
        <dt>
          <div class="preview_img<?php echo $i?>"></div>
        </dt>
        <dd>
          <span><?php echo '('.($i+1).')'?></span> <input type="file" data-val="<?php echo $i?>" id="dialog_pic<?php echo $i?>" class="dialog_pic" name="dialog_pic[]" accept="image/jpg/jpeg">
          <button class="btn-delete" data-val="<?php echo $i?>">X</button> 
        </dd>
      </div>
  <?php endfor;?>
  </div>
  <input type="hidden" name="edit_flag" value="0">    
 
<div id="btn_submit">
  <p><input type="submit" value="作成"></p>
</div>  
</form>
</center>
<div id="dialog_list" >
<!-- LIST HERE -->
<?php if($dialog_box):?>
  <table class="template1">
    <thead>
      <tr>
        <th>優先度</th>
        <th>開始日最終訪問</th>
        <th>終了日最終訪問</th>
        <th>日付の認証を開始</th>
        <th>終了日認証</th>
        <th>最小ボーナス金額</th>
        <th>最大ボーナス金額 </th>
        <th>ボタンにテキスト</th>
        <th>リンク</th>
        <th>初期ログインユーザ</th>
        <th> ボーナス付与</th>
        <th>モーダルの表示時間設定</th>
        <th>ステータス登録</th>
        <th>アクション</th>
        
      </tr>
    </thead>
    <tbody>
    <?php foreach($dialog_box as $db):?>
      <tr>
        <td><?php echo $db['priority']?></td>
        <td><?php echo $db['start_date_last_visit']?></td>
        <td><?php echo $db['end_date_last_visit']?></td>
        <td><?php echo $db['start_date_auth']?></td>
        <td><?php echo $db['end_date_auth']?></td>
        <td><?php echo $db['minimum_bonus_money']?></td>
        <td><?php echo $db['maximum_bonus_money']?></td>
        <td><?php echo $db['text_button']?></td>
        <td><?php echo $db['link']?></td>
        <td><?php echo ($db['first_login_flag'] == 1) ?'はい':'いいえ';?></td>
        <td><?php echo ($db['bonus_grant'] == 1)? 'はい': 'いいえ'?></td>
        <td><?php echo $db['time_to_display']?></td>
        <td>
            <?php
              switch ($db['status_registration']) {
                case 1:
                  echo '本登録';
                  break;
                case 2:
                  echo '無効';
                  break;
                case 3:
                  echo 'ステルス';
                  break;
                
                default:
                  echo '仮登録';
                  break;
              }

            ?>
        </td>
        <td>
          <a href="/admin/dialog_box/update_dialog/<?php echo $db['id']?>"><button>編集</button></a>
          <button onclick="deleteDialog(<?php echo $db['id']?>)">削除</button>
        </td>
      </tr>
    <?php endforeach;?> 
    </tbody>
  </table>
  
  
<?php endif;?>
</div>

<style type="text/css">
  #dialog_list {
    padding-bottom: 150px;
    clear:both;
  }
  #btn_submit{
    clear: both;
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
      var id = $(this).attr('data-val');
      if(confirm('削除してもよろしいですか？')) {
        $('.preview_img'+id).empty();
        $('#dialog_pic'+id).val('');
        return false;
      }
    });

  });

  function deleteDialog(id) {
    if(confirm('このダイアログボックスを削除してもよろしいですか？')){
      $.post('/admin/dialog_box/delete_dialog',{id:id},function(data){
        if(data == 'true') {
          window.location.reload();
        }
      });
    }
    
  }
  function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      }
      return true;
  }



</script>