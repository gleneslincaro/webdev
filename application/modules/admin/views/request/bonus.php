<script type="text/javascript">
  $(function() {
    pagination_request();

    $("#txtBonusAppDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtBonusAppDateTo").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtBonusGrantDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtBonusGrantDateTo").datepicker({ dateFormat: "yy/mm/dd" });

    $("#txtBonusAppDateFrom").change(function(){
        var dateFrom = $("#txtBonusAppDateFrom").val();
        var dateTo = $("#txtBonusAppDateTo").val();
        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtBonusAppDateFrom').val("");
        }
        else if(dateTo!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtBonusAppDateFrom").value = "";
            return false;
            }
        }
    });

    $("#txtBonusAppDateTo").change(function(){
        var dateFrom = $("#txtBonusAppDateFrom").val();
        var dateTo = $("#txtBonusAppDateTo").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtBonusAppDateTo').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtBonusAppDateTo").value = "";
            return false;
            }
        }
    });

    $("#txtBonusGrantDateFrom").change(function(){
        var dateFrom = $("#txtBonusGrantDateFrom").val();
        var dateTo = $("#txtBonusGrantDateTo").val();
        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtBonusGrantDateFrom').val("");
        }
        else if(dateTo!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtBonusGrantDateFrom").value = "";
            return false;
            }
        }
    });
    $("#txtBonusGrantDateTo").change(function(){
        var dateFrom = $("#txtBonusGrantDateFrom").val();
        var dateTo = $("#txtBonusGrantDateTo").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtBonusGrantDateTo').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtBonusGrantDateTo").value = "";
            return false;
            }
        }
    });
    $("#checkall").change(function(){
      if ( this.checked ){
        $("input:checkbox[class=chkbox]").each(function()
        {
          $(this).attr("checked",true);
        });
      }else{
        $("input:checkbox[class=chkbox]").each(function()
        {
          $(this).attr("checked",false);
        });
      }
    });
  });

  function changeReceivedBonusFlag(e, smbId, request_date, uid) {
    var rbf = e.getAttribute('rbf');
    $.ajax({
      url: '<?php echo base_url(); ?>admin/request/updateUserReceivedBonus',
      type:'POST',
      dataType: 'json',
      data: {smbReceivedBonusFlag: rbf, smbId: smbId, type: 'bonus', user_id: uid, requested_date: request_date},
      success: function(data) {
        if(data.rbDate == '' || data.rbDate == null)
          var rbDate = '-----';
        else
          var rbDate = data.rbDate;
        if(rbf == 0) {
          document.getElementById("rbf"+smbId).childNodes[0].nodeValue= "済";
          $('#rbf'+smbId).attr("rbf", 1);
        }
        else {
          document.getElementById("rbf"+smbId).childNodes[0].nodeValue= "未";
          $('#rbf'+smbId).attr("rbf", 0);
        }
        document.getElementById("rbdt"+smbId).childNodes[0].nodeValue= rbDate;
        alert('ボーナス付与状態の更新が完了しました。');
      }
    });
  }

  function changeAllUsersReceivedBonusFlag(rbfType, number, start) {
    var $users = new Array();
    $("input:checkbox[class=chkbox]:checked").each(function()
    {
      $users.push($(this).attr("name"));
    });
    if ( $users.length > 0){
      $.ajax({
        url: '<?php echo base_url(); ?>admin/request/updateUsersReceivedBonus',
        type:'POST',
        dataType: 'json',
        data: {smbReceivedBonusFlag: rbfType, users: $users, number: number, start: start, type: 'bonus'},
        success: function(data) {
          if ( data != null && data.data != null){
            for(var i=0; i < data.data.length; i++) {
              var smbId = data.data[i]['id'];
              if(data.data[i]['received_bonus_date'] == '' || data.data[i]['received_bonus_date'] == null)
                var rbDatetime = '-----';
              else
                var rbDatetime = data.data[i]['received_bonus_date'];
              if(rbfType == 0) {
                document.getElementById("rbf"+smbId).childNodes[0].nodeValue= "済";
                $('#rbf'+smbId).attr("rbf", 1);
              }
              else {
                document.getElementById("rbf"+smbId).childNodes[0].nodeValue= "未";
                $('#rbf'+smbId).attr("rbf", 0);
              }
              document.getElementById("rbdt"+smbId).childNodes[0].nodeValue= rbDatetime;
            }
            alert('ボーナス付与状態の更新が完了しました。');
          }
        }
      });
    }
  }

</script>
<center>
  <p>ボーナス申請リスト</p>
  <form id="frmAuthentication" action="<?php echo base_url().'admin/request/bonus'; ?>" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="10">
      <tr>
        <td>システムID&nbsp;<input id="txtUserUniqueId" type="text" name="txtUserUniqueId" size="40" value="<?php echo (isset($txtUserUniqueId))? $txtUserUniqueId: '';?>"></td>
        <td>元ID&nbsp;<input id="txtOldId" type="text" name="txtOldId" size="20" value="<?php echo (isset($txtOldId))? $txtOldId: '';?>"></td>
        <td>氏名&nbsp;<input id="txtUsersName" type="text" name="txtUserName" size="40" value="<?php echo (isset($txtUserName))? $txtUserName: '';?>"></td>
      </tr>
    </table>
    <p>
      登録媒体　：
      <select name="siteType" id="siteType">
        <option value="-1" <?php echo (isset($siteType))?(($siteType == -1)? 'selected': ''):''; ?>>選択して下さい</option>
        <option value="0" <?php echo (isset($siteType))?(($siteType == 0)? 'selected': ''):''; ?>>JOYSPE内</option>
        <option value="1" <?php echo (isset($siteType))?(($siteType == 1)? 'selected': ''):''; ?>>マシェモバ</option>
        <option value="2" <?php echo (isset($siteType))?(($siteType == 2)? 'selected': ''):''; ?>>マキア</option>
      </select>
      ボーナス付与　：
      <select name="bunosReceivingFlag" id="bunosReceivingFlag">
        <option value="-1" <?php echo (isset($bunosReceivingFlag))?(($bunosReceivingFlag == -1)? 'selected': ''):''; ?>>選択して下さい</option>
        <option value="1" <?php echo (isset($bunosReceivingFlag))?(($bunosReceivingFlag == 1)? 'selected': ''):''; ?>>済</option>
        <option value="0" <?php echo (isset($bunosReceivingFlag))?(($bunosReceivingFlag == 0)? 'selected': ''):''; ?>>未</option>
      </select>
    </p>
    ボーナス　申請日&nbsp;<input type="text" name="txtBonusAppDateFrom" id="txtBonusAppDateFrom" size="30" value="<?php echo (isset($txtBonusAppDateFrom))? $txtBonusAppDateFrom: '';?>"> ～
    <input type="text" name="txtBonusAppDateTo" id="txtBonusAppDateTo" size="30" value="<?php echo (isset($txtBonusAppDateTo))? $txtBonusAppDateTo: '';?>"></td></tr><br>
    ボーナス付与日付&nbsp;<input type="text" name="txtBonusGrantDateFrom" id="txtBonusGrantDateFrom" size="30" value="<?php echo (isset($txtBonusGrantDateFrom))? $txtBonusGrantDateFrom: '';?>"> ～
    <input type="text" name="txtBonusGrantDateTo" id="txtBonusGrantDateTo" size="30" value="<?php echo (isset($txtBonusGrantDateTo))? $txtBonusGrantDateTo: '';?>"></td></tr><br>
    <p>※日付検索は　yyyy/mm/dd　で検索して下さい。</p>
    <p><a href="authentication.html"><BUTTON type="submit">　検索　</BUTTON></a></p>
  </form>
</center>
<?php if(isset($records)): ?>
  <div id="request-authentication">
    <table>
      <tbody>
        <tr>
          <th><input type="checkbox" id="checkall">&nbsp;</th>
          <th>システムID&nbsp;</th>
          <th>元ID&nbsp;</th>
          <th>氏名&nbsp;</th>
          <th>登録媒体&nbsp;</th>
          <th>ボーナス申請日&nbsp;</th>
          <th>ボーナス金額&nbsp;</th>
          <th>ボーナス付与&nbsp;</th>
          <th>ボーナス付与日付&nbsp;</th>
        </tr>
        <?php foreach ($records as $row): ?>
          <tr>
            <td><input class="chkbox" type="checkbox" name = "<?php echo $row['unique_id']; ?>">&nbsp;</td>
            <td><?php echo $row['unique_id']; ?></td>
            <td><?php echo $row['old_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php $user_from_site_str = '不明';
            switch( $row['user_from_site'] ) {
                case 0: $user_from_site_str = "JOYSPE内"; break;
                case 1: $user_from_site_str = "マシェモバ"; break;
                case 2: $user_from_site_str = "マキア"; break;
                default: $user_from_site_str = "不明"; break;
            }
            echo $user_from_site_str; ?></td>
            <td><?php echo ($row['bonus_requested_date'] != '')?$row['bonus_requested_date']:'-----'; ?></td>
            <td><?php echo Helper::numberToMoney($row['bonus_money']);?></td>
            <td><BUTTON type="button" rbf="<?php echo $row['received_bonus_flag']; ?>" onclick="changeReceivedBonusFlag(this, <?php echo $row['id']; ?>, '<?php echo $row['bonus_requested_date'] ?>', <?php echo $row['user_id'] ?>)" id="rbf<?php echo $row['id']; ?>"><?php echo ($row['received_bonus_flag'] == 1)?'済':'未'; ?></BUTTON>&nbsp;</td>
            <td id="rbdt<?php echo $row['id']; ?>"><?php echo ($row['received_bonus_date'] == '' || $row['received_bonus_date'] == null)?'-----':$row['received_bonus_date']; ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <div class="pagination-user-from-site1or2" id="pagination_request"><?php echo $this->pagination->create_links() ?></div>
  <center>
    <p>
      <BUTTON type="button" onclick="changeAllUsersReceivedBonusFlag(0, <?php echo $number ?>, <?php echo $start ?>)">　一括・済へ　</BUTTON>
      <BUTTON type="button" onclick="changeAllUsersReceivedBonusFlag(1, <?php echo $number ?>, <?php echo $start ?>)">　一括・未へ　</BUTTON>
    </p>
  </center>
<?php endif ?>
