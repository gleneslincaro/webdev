<script type="text/javascript">
  $(function() {
    pagination_request();

    $("#txtAgreementDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtAgreementDateTo").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtReceiveBonusDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtReceiveBonusDateTo").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtLastVisitDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtLastVisitDateTo").datepicker({ dateFormat: "yy/mm/dd" });

    $("#txtAgreementDateFrom").change(function(){
        var dateFrom = $("#txtAgreementDateFrom").val();
        var dateTo = $("#txtAgreementDateTo").val();
        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtAgreementDateFrom').val("");
        }
        else if(dateTo!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtAgreementDateFrom").value = "";
            return false;
            }
        }
    });

    $("#txtAgreementDateTo").change(function(){
        var dateFrom = $("#txtAgreementDateFrom").val();
        var dateTo = $("#txtAgreementDateTo").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtAgreementDateTo').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtAgreementDateTo").value = "";
            return false;
            }
        }
    });

    $("#txtReceiveBonusDateFrom").change(function(){
        var dateFrom = $("#txtReceiveBonusDateFrom").val();
        var dateTo = $("#txtReceiveBonusDateTo").val();
        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtReceiveBonusDateFrom').val("");
        }
        else if(dateTo!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtReceiveBonusDateFrom").value = "";
            return false;
            }
        }
    });
    $("#txtReceiveBonusDateTo").change(function(){
        var dateFrom = $("#txtReceiveBonusDateFrom").val();
        var dateTo = $("#txtReceiveBonusDateTo").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtReceiveBonusDateTo').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtReceiveBonusDateTo").value = "";
            return false;
            }
        }
    });
    $("#txtLastVisitDateFrom").change(function(){
        var dateFrom = $("#txtLastVisitDateFrom").val();
        var dateTo = $("#txtLastVisitDateTo").val();
        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtLastVisitDateFrom').val("");
        }
        else if(dateTo!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtLastVisitDateFrom").value = "";
            return false;
            }
        }
    });
    $("#txtLastVisitDateTo").change(function(){
        var dateFrom = $("#txtLastVisitDateFrom").val();
        var dateTo = $("#txtLastVisitDateTo").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtLastVisitDateTo').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtLastVisitDateTo").value = "";
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

  function changeReceivedBonusFlag(e, userId) {
    var rbf = e.getAttribute('rbf');
    $.ajax({
        url: '<?php echo base_url(); ?>admin/request/updateUserReceivedBonus',
          type:'POST',
          dataType: 'json',
          data: {userReceivedBonusFlag: rbf, userId: userId, type: 'uAuthentication'},
          success: function(data) {
            if(data.rbDatetime == '' || data.rbDatetime == null)
              var rbDatetime = '-----';
            else
              var rbDatetime = data.rbDatetime;
            if(rbf == 0) {
              document.getElementById("rbf"+userId).childNodes[0].nodeValue= "済";
              $('#rbf'+userId).attr("rbf", 1);
            }
            else {
              document.getElementById("rbf"+userId).childNodes[0].nodeValue= "未";
              $('#rbf'+userId).attr("rbf", 0);
            }
            document.getElementById("rbdt"+userId).childNodes[0].nodeValue= rbDatetime;
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
        data: {userReceivedBonusFlag: rbfType, users: $users, number: number, start: start, type: 'uAuthentication'},
        success: function(data) {
          if ( data != null && data.data != null ){
            for(var i=0; i < data.data.length; i++) {
              var userId = data.data[i]['id'];
              if(data.data[i]['received_bonus_datetime'] == '' || data.data[i]['received_bonus_datetime'] == null)
                var rbDatetime = '-----';
              else
                var rbDatetime = data.data[i]['received_bonus_datetime'];
              if(rbfType == 0) {
                document.getElementById("rbf"+userId).childNodes[0].nodeValue= "済";
                $('#rbf'+userId).attr("rbf", 1);
              }
              else {
                document.getElementById("rbf"+userId).childNodes[0].nodeValue= "未";
                $('#rbf'+userId).attr("rbf", 0);
              }
              document.getElementById("rbdt"+userId).childNodes[0].nodeValue= rbDatetime;
            }
            alert('ボーナス付与更新が完了しました。');
          }
        }
      });
    }
  }

  function changeTeleRecord(e,id) {
    var tel_record_flag = e.getAttribute('tr');
    $.ajax({
      url : "<?php echo base_url()?>admin/request/changeTelephoneRecord",
      type: "POST",
      data: {id:id,tel_record_flag:tel_record_flag},
      success : function(data) {
        if(tel_record_flag == 1){
          $('#tel_record_'+id).text('済');
          $('#tel_record_'+id).attr('tr',0);
        } else {
          $('#tel_record_'+id).text('未');
          $('#tel_record_'+id).attr('tr',1);
        }
        alert('電話対応更新が完了しました。');
      }

    });
  }

</script>
<center>
  <p>スカウト認証申込一覧</p>
  <form id="frmAuthentication" action="<?php echo base_url().'admin/request/authentication'; ?>" method="post" enctype="multipart/form-data">
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
        <option value="1" <?php echo (isset($siteType))?(($siteType == 1)? 'selected': ''):''; ?>>マシェモバ</option>
        <option value="2" <?php echo (isset($siteType))?(($siteType == 2)? 'selected': ''):''; ?>>マキア</option>
      </select>

      &nbsp;電話対応:
      <select name="phoneDealing" id="phoneDealing">
        <option value="-1" <?php echo(isset($phoneDealing)&& $phoneDealing == -1) ? 'selected':'';?>>選択して下さい</option>
        <option value="0" <?php echo(isset($phoneDealing)&& $phoneDealing == 0) ? 'selected':'';?>>未</option>
        <option value="1" <?php echo(isset($phoneDealing)&& $phoneDealing == 1) ? 'selected':'';?>>済</option>
      </select>
      &nbsp;ボーナス付与　：
      <select name="bunosReceivingFlag" id="bunosReceivingFlag">
        <option value="-1" <?php echo (isset($bunosReceivingFlag))?(($bunosReceivingFlag == -1)? 'selected': ''):''; ?>>選択して下さい</option>
        <option value="1" <?php echo (isset($bunosReceivingFlag))?(($bunosReceivingFlag == 1)? 'selected': ''):''; ?>>済</option>
        <option value="0" <?php echo (isset($bunosReceivingFlag))?(($bunosReceivingFlag == 0)? 'selected': ''):''; ?>>未</option>
      </select>
    </p>
    ジョイスペ認証日&nbsp;<input type="text" name="txtAgreementDateFrom" id="txtAgreementDateFrom" size="30" value="<?php echo (isset($txtAgreementDateFrom))? $txtAgreementDateFrom: '';?>"> ～
    <input type="text" name="txtAgreementDateTo" id="txtAgreementDateTo" size="30" value="<?php echo (isset($txtAgreementDateTo))? $txtAgreementDateTo: '';?>"></td></tr><br>
    ボーナス付与日付&nbsp;<input type="text" name="txtReceiveBonusDateFrom" id="txtReceiveBonusDateFrom" size="30" value="<?php echo (isset($txtReceiveBonusDateFrom))? $txtReceiveBonusDateFrom: '';?>"> ～
    <input type="text" name="txtReceiveBonusDateTo" id="txtReceiveBonusDateTo" size="30" value="<?php echo (isset($txtReceiveBonusDateTo))? $txtReceiveBonusDateTo: '';?>"></td></tr><br>
    最終ログイン日 &nbsp;<input type="text" name="txtLastVisitDateFrom" id="txtLastVisitDateFrom" size="30" value="<?php echo (isset($txtLastVisitDateFrom))?$txtLastVisitDateFrom:''?>">～
    <input type="text" name="txtLastVisitDateTo" id="txtLastVisitDateTo" size="30" value="<?php echo (isset($txtLastVisitDateTo))?$txtLastVisitDateTo:''?>">
    <p>※日付検索は　yyyy/mm/dd　で検索して下さい。</p>
    <p><a href="authentication"><BUTTON type="submit">　検索　</BUTTON></a></p>
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
          <th>ジョイスペ認証日&nbsp;</th>
          <th>最終ログイン日</th>
          <th>電話対応</th>
          <th>ボーナス付与&nbsp;</th>
          <th>ボーナス付与日付&nbsp;</th>
        </tr>
        <?php foreach ($records as $row): ?>
          <tr>
            <td><input class="chkbox" type="checkbox"name = "<?php echo $row['unique_id']; ?>">&nbsp;</td>
            <td><?php echo $row['unique_id']; ?></td>
            <td><?php echo $row['old_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo ($row['user_from_site'] == 1)?'マシェモバ':'マキア'; ?></td>
            <td><?php echo ($row['accept_remote_scout_datetime'] != '')?$row['accept_remote_scout_datetime']:'-----'; ?></td>
            <td><?php echo $row['last_visit_date']; ?></td>
            <td><button type="button" tr="<?php echo ($row['telephone_record_flag'] == 0) ? 1 : 0?>" id="tel_record_<?php echo $row['id']?>" onclick="changeTeleRecord(this,<?php echo $row['id']?>)"><?php echo ($row['telephone_record_flag'] == 0) ? '未' : '済'?></button></td>
            <td><BUTTON type="button" rbf="<?php echo $row['received_bonus_flag']; ?>" onclick="changeReceivedBonusFlag(this, <?php echo $row['id']; ?>)" id="rbf<?php echo $row['id']; ?>"><?php echo ($row['received_bonus_flag'] == 1)?'済':'未'; ?></BUTTON>&nbsp;</td>
            <td id="rbdt<?php echo $row['id']; ?>"><?php echo ($row['received_bonus_datetime'] == '' || $row['received_bonus_datetime'] == null)?'-----':$row['received_bonus_datetime']; ?></td>
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
