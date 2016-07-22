<script type="text/javascript">
  $(function() {
    pagination_request_makia_user();

    $("#txtReceiveBonusDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
    $("#txtReceiveBonusDateTo").datepicker({ dateFormat: "yy/mm/dd" });

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
          data: {smbReceivedBonusFlag: rbf, smbId: userId, type: 'makia_bonus'},
          success: function(data) {
            if(data.rbDate == '' || data.rbDate == null)
              var rbDatetime = '-----';
            else
              var rbDatetime = data.rbDate;
            if(rbf == 0) {
              document.getElementById("rbf"+userId).childNodes[0].nodeValue= "済み";
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
        data: {smbReceivedBonusFlag: rbfType, users: $users, number: number, start: start, type: 'makia_bonus'},
        success: function(data) {
          if ( data != null && data.data != null ){
            for(var i=0; i < data.data.length; i++) {
              var userId = data.data[i]['id'];
              if(data.data[i]['received_bonus_datetime'] == '' || data.data[i]['received_bonus_datetime'] == null)
                var rbDatetime = '-----';
              else
                var rbDatetime = data.data[i]['received_bonus_datetime'];
              if(rbfType == 0) {
                document.getElementById("rbf"+userId).childNodes[0].nodeValue= "済み";
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

</script>
<center>
  <p>マキアユーザー</p>
  <form id="frmAuthentication" action="<?php echo base_url().'admin/request/makia_user'; ?>" method="post" enctype="multipart/form-data">
    <table border="0" cellspacing="10">
      <tr>
        <td>Unique ID&nbsp;<input id="txtUserUniqueId" type="text" name="txtUserUniqueId" size="40" value="<?php echo (isset($txtUserUniqueId))? $txtUserUniqueId: '';?>"></td>
        <td>名前&nbsp;<input id="txtUserName" type="text" name="txtUserName" size="40" value="<?php echo (isset($txtUserName))? $txtUserName: '';?>"></td>
        <!--<td>お問い合わせ回数&nbsp;<input id="txtUserInquiryAmount" type="text" name="txtUserInquiryAmount" size="40" value="<?php //echo (isset($txtUserInquiryAmount))? $txtUserInquiryAmount: '';?>"></td> -->
      </tr>
    </table>
    <p>
      利用サービス&nbsp;
      <select name="websiteType" id="websiteType">
        <option value="-1" <?php echo (isset($websiteType))?(($websiteType == -1)? 'selected': ''):''; ?>>選択して下さい</option>
        <option value="44" <?php echo (isset($websiteType))?(($websiteType == 44)? 'selected': ''):''; ?>>AMM</option>
        <option value="45" <?php echo (isset($websiteType))?(($websiteType == 45)? 'selected': ''):''; ?>>ZIP</option>
        <option value="46" <?php echo (isset($websiteType))?(($websiteType == 46)? 'selected': ''):''; ?>>アマンテ</option>
      </select>
      &nbsp;&nbsp;&nbsp;ボーナス付与管理&nbsp;
      <select name="receivedBonusFlag" id="receivedBonusFlag">
        <option value="-1" <?php echo (isset($receivedBonusFlag))?(($receivedBonusFlag == -1)? 'selected': ''):''; ?>>選択して下さい</option>
        <option value="0" <?php echo (isset($receivedBonusFlag))?(($receivedBonusFlag == 0)? 'selected': ''):''; ?>>未</option>
        <option value="1" <?php echo (isset($receivedBonusFlag))?(($receivedBonusFlag == 1)? 'selected': ''):''; ?>>済み</option>
      </select>
    </p>

    ボーナス付与日付&nbsp;<input type="text" name="txtReceiveBonusDateFrom" id="txtReceiveBonusDateFrom" size="30" value="<?php echo (isset($txtReceiveBonusDateFrom))? $txtReceiveBonusDateFrom: '';?>"> ～
    <input type="text" name="txtReceiveBonusDateTo" id="txtReceiveBonusDateTo" size="30" value="<?php echo (isset($txtReceiveBonusDateTo))? $txtReceiveBonusDateTo: '';?>"></td></tr><br>
    <p>※日付検索は　yyyy/mm/dd　で検索して下さい。</p>
    <p><a href="authentication"><BUTTON type="submit">　検索　</BUTTON></a></p>
    <div class="pagination-user-from-site1or2" id="pagination_request"><?php echo $this->pagination->create_links() ?></div>
    <br />
  </form>
</center>
<?php if(isset($records)): ?>
  <div id="request-authentication">
    <table>
      <tbody>
        <tr>
          <th><input type="checkbox" id="checkall">&nbsp;</th>
          <th>Unique ID&nbsp;</th>
          <th>名前&nbsp;</th>
          <th>メモ</th>
          <th>利用サービス&nbsp;</th>
          <th>登録日付&nbsp;</th>
          <th>お問い合わせ回数&nbsp;</th>
          <th>ボーナス付与管理&nbsp;</th>
          <th>ボーナス付与日付&nbsp;</th>
        </tr>
        <?php foreach ($records as $row): ?>
          <tr>
            <td><input class="chkbox" type="checkbox"name = "<?php echo $row['unique_id']; ?>">&nbsp;</td>
            <td><?php echo $row['unique_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['memo']; ?></td>
            <td><?php echo $row['website_type']; ?></td>
            <td><?php echo $row['created_date']; ?></td>
            <td><?php echo $row['inquiry_amount']; ?></td>
            <td><BUTTON type="button" rbf="<?php echo $row['received_bonus_flag']; ?>" onclick="changeReceivedBonusFlag(this, <?php echo $row['id']; ?>)" id="rbf<?php echo $row['id']; ?>"><?php echo ($row['received_bonus_flag'] == 1)?'済み':'未'; ?></BUTTON>&nbsp;</td>
            <td id="rbdt<?php echo $row['id']; ?>"><?php echo ($row['received_bonus_datetime'] == '' || $row['received_bonus_datetime'] == null)?'-----':$row['received_bonus_datetime']; ?></td>
          </tr>
         <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <div class="pagination-user-from-site1or2" id="pagination_request"><?php echo $this->pagination->create_links() ?></div>
<!--
  <center>
    <p>
      <BUTTON type="button" onclick="changeAllUsersReceivedBonusFlag(0, <?php echo $number ?>, <?php echo $start ?>)">　一括・済みへ　</BUTTON>
      <BUTTON type="button" onclick="changeAllUsersReceivedBonusFlag(1, <?php echo $number ?>, <?php echo $start ?>)">　一括・未へ　</BUTTON>
    </p>
  </center>
-->
<?php endif ?>
