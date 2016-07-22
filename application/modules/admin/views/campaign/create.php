<script type="text/javascript">
    $(document).ready(function(){
        $("#banner_pic_file").change(function(){
            var files = !!this.files ? this.files : [];
            $('#temp-val').val(files.length);
            if (!files.length || !window.FileReader) return;
            if (/^image/.test( files[0].type)){
                var reader = new FileReader();
                reader.readAsDataURL(files[0]);
                imageName = files[0].name;
                reader.onloadend = function(){ 
                    $("#prevBanner").html("<img id='banner_pic' height='90' width='620' src='" + this.result + "' height='90' alt=''  style='margin-bottom:15px;' >");
                    $('#temp-path').val(this.result);
                }
                if (files.length > 0 && $('#temp-val').val() == 1) {
                    $('#option_default_banner').removeClass('hide');
                }  
            }else{
                $('#option_default_banner').addClass('hide');
                $('#prevBanner').html("<img id='banner_pic' name='banner_pic' src='<?php echo base_url()?>public/user/image/default_trvl_expen_campn_banner.jpg' height='90' alt=''  style='margin-bottom:15px;'>");
                alert('画像ファイルを選択して下さい。');
            }
        });
        $('#option_default_banner').change(function(){
            var base_url = "<?php echo base_url()?>";
            var default_pic = 'public/user/image/default_trvl_expen_campn_banner.jpg';
            var temp_path = $('#temp-path').val();
            if ($('#option_default_banner').val()==1) {
                $('#banner_pic').attr('src',base_url+default_pic);
            } else if ($('#option_default_banner').val()==2) {
                $('#banner_pic').attr('src',temp_path);
            }
        });
    });
$(function() {
  $("#start_date").datepicker({ dateFormat: "yy/mm/dd" });
  $("#end_date").datepicker({ dateFormat: "yy/mm/dd" });

  $("#start_date").change(function(){
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();

    if( start_date!="" && !start_date.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
      alert("日付が正しくありません。再入力してください。");
      $('#start_date').val("");
    }
    else if( end_date != null ){
      if (Date.parse(start_date) > Date.parse(end_date)) {
        alert("日付範囲は無効です。終了日は開始日より後になります。")
        $("#start_date").val("");
        return false;
      }
    }
  });

  $("#end_date").change(function(){
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();

    if( end_date != "" && !end_date.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
      alert("日付が正しくありません。再入力してください。");
      $('#end_date').val("");
    }
    else if( start_date != null ){
      if ( Date.parse(start_date) > Date.parse(end_date) ) {
        alert("日付範囲は無効です。終了日は開始日より後になります。")
        $("#start_date").val("");
        return false;
      }
    }
  });

  // 作成ボタンの動作
  $("#create_banner").click(function(){
      if ( !confirm("この設定でキャンペーンを作成してもよろしいでしょうか？") ) {
        return false;
      }else{
        $('#campaign_create_form').submit();
      }
  });
});

</script>
<style>
  .hide{
    display:none;
  }

</style>
<center>
<div class="expense-request-list" >
  <p>面接交通費支援キャンペーン作成</p>
  <p><a href="<?php echo base_url(); ?>admin/campaign/all">キャンペーン一覧はこちら</a></p>
  <p style="color:red">【ご注意】上記のリンクで現在、実施中のキャンペーンがあるかどうかをチェックしてから、作成してください。</p>
  <div class="validation"><?php echo validation_errors(); ?></div>
  <p style="color: blue;"><?php echo $this->session->flashdata('create_message'); ?></p>
  <form method="POST" id="campaign_create_form" enctype="multipart/form-data">
    <div>
      <table>
      <tr>
        <td>面接交通費</td>
        <td><input type="text" name="travel_expense"
                   value="<?php echo set_value("travel_expense"); ?>"/> 円</td>
      </tr>

      <tr>
        <td>上限額(予算)</td>
        <td><input type="text" name="budget_money"
                   value="<?php echo set_value("budget_money"); ?>"/> 円</td>
      </tr>

      <tr>
        <td>開始日</td>
        <td><input type="text" name="start_date" id="start_date"
          value="<?php echo set_value("start_date"); ?>"/></td>
      </tr>

      <tr>
        <td>終了日</td>
        <td><input type="text" name="end_date" id="end_date"
          value="<?php echo set_value("end_date"); ?>"/></td>
      </tr>

      <tr>
        <td>申請上限回数(一人当たり)</td>
        <td><input type="text" name="max_request_times"
          value="<?php echo set_value("max_request_times"); ?>" /></td>
      </tr>

      <tr>
        <td>複数回で同店舗に申請可能か</td>
        <td><input type="checkbox" name="multi_request_per_owner_flag"
          value="1" <?php echo set_checkbox("multi_request_per_owner_flag", '1'); ?> /></td>
      </tr>
          <input type="hidden" name="temp-path" id="temp-path" value=""/>
          <input type="hidden" name="temp-val" id="temp-val" value=""/>
      
      <tr>
        <td>デフォルトバナー</td>
        <td>
          <br />
          <div class="box_in">
              <center>
                  <div id="prevBanner"><img id="banner_pic" name="banner_pic" src="<?php echo base_url()?>public/user/image/default_trvl_expen_campn_banner.jpg" height="90" alt=""  style="margin-bottom:15px;"></div>
                  <div>デフォルトバナーパス：/public/user/image/default_trvl_expen_campn_banner.jpg</div>
              </center>
            </div>
            <center>
                <p>JPEGファイル：<br >
                    <input type="file" name="banner_pic_file" accept="image/jpg/jpeg" id ="banner_pic_file">             
                </p>
                <p>
                    <select name="option_default_banner" id="option_default_banner" class="hide">
                        <option value="">--バナーの写真を選択してください。--</option>
                        <option value="1">デフォルトバナーの画像</option>
                        <option value="2">アップロードされたバナーの画像</option>
                    </select>
                </p>
                
            </center>
            <br >
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input id="create_banner" type="button" style="width:200px; height:50px;" value="作成"/>
        </td>
      </tr>
      </form>
    </div>
  
</div>
</center>
