<script type="text/javascript">
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

  $("#banner_path").change(function(){
      var files = !!this.files ? this.files : [];
      if (!files.length || !window.FileReader) return;

      if (/^image/.test( files[0].type)){ 
          var reader = new FileReader();
          reader.readAsDataURL(files[0]);
          imageName = files[0].name;
          reader.onloadend = function(){ 
              $("#prevBanner").html("<img src='" + this.result + "' alt='' >");
          }
      }
  });

  $("#create_banner").click(function(){
      if ( !confirm("この設定でキャンペーンを作成してもよろしいでしょうか？") ) {
        return false;
      }
  });
});
</script>

<center>
<div class="expense-request-list" >
  <p>体験入店お祝いキャンペーン</p>
  <p><a href="<?php echo base_url(); ?>admin/campaign/bonusrequestall">キャンペーン一覧はこちら</a></p>
  <p style="color:red">【ご注意】上記のリンクで現在、実施中のキャンペーンがあるかどうかをチェックしてから、作成してください。</p>
  <div class="validation"><?php echo validation_errors(); ?></div>
  <p style="color: blue;"><?php echo $this->session->flashdata('create_message'); ?></p>
  <form method="POST" enctype="multipart/form-data">
    <div>
      <table>
      <tr>
        <td>ボーナス金額</td>
        <td><input type="text" name="bonus_money"
                   value="<?php echo set_value("bonus_money"); ?>"/> 円</td>
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

      <tr>
        <td>デフォルトバナー</td>
        <td>
          <div id="prevBanner" style="min-width: 620px; min-height: 100px;"></div>
          <input type="file" id="banner_path" value="banner_path" name="banner_path" />
        </td>
      </tr>

      <tr>
        <td colspan="2">
          <input id="create_banner" type="submit" style="width:200px; height:50px;" value="作成"/>
        </td>
      </tr>
    </div>
  </form>
</div>
</center>
