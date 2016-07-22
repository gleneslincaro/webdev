<script type="text/javascript">
    $(document).ready(function() {
        $('#dialog_unapproved').click(function() {
            var strURL = baseUrl + "owner/dialog/checkDialogPenalty";
            $.ajax({
                url: strURL,
                type: 'POST',
                cache: false,
                success: function(string) {
                    var data = $.parseJSON(string);
                    if (data.count_penalty == 0){
                        window.location.replace(baseUrl + "owner/index");
                    } else {
                        window.location.replace(baseUrl + "owner/index/index03");
                    }
                },
                error: function() {
                    alert('Errors happen');
                }
            });

        });
    });

</script>
<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■非承認</div>

    <br ><br ><br >



    <div class="message_box">
        <table class="message">
            <tr>

                非承認が完了しました。<br>
            </tr>
        </table>
    </div>

    <br><br>
    <center>
        <p><a id="dialog_unapproved" href="#">TOPページへ戻る</a></p>
    </center>

</div><!-- list-box ここまで -->