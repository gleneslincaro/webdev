<script language='javascript'>
    $(document).ready(function(){
        $("#date_interview").datepicker({ dateFormat: "yy/mm/dd" });

        $('#submit').click(function(){
            var base_url = "<?php echo base_url()?>";
            var unique_id = $('#unique_id').val();
            var date_interview = $('#date_interview').val();
            $.post(base_url+'admin/campaign/insertInterviewReport',
                  {unique_id:unique_id,date_interview:date_interview},
                  function(data){
                      if (data == true) {
                          alert('入力内容が正常に保存されました。');
                          $(':input').val('');
                      } else {
                          alert('入力内容をご確認ください。');
                      }
                  }
            );
        });

        $('#date_interview').change(function(){
            var date = $('#date_interview').val();
            if(!date.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $('#date_interview').val("");
            }
        });
    })
</script>
<div style="margin-top:3%;">
    <center>
        <table>
            <tr>
                <td>ユニークＩＤ</td>
                <td><input type="text" name="unique_id" id="unique_id"/></td>
            </tr>
            <tr>
                <td>面接日付</td>
                <td><input type="text" id="date_interview" name="date_interview" /></td>
            </tr>
            <tr>
                <td></td>
                <td><button id='submit'>作成</button></td>
            </tr>
        </table>
    </center>
</div>
