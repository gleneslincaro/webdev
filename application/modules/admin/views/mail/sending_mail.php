<style type="text/css">
    div {
        padding: 5px;
    }
</style>
<script type="text/javascript">
    $(window).load(function () {
        var id = <?php echo $id; ?>;
        var email_address = $('#email_address').val();
        var count = 0;
        var success_count = 0;
        email_address = email_address.split(',');
        for (var i = 0; email_address.length > i; i++) {
            var em = email_address[i];
            var group_id = 1;
            $.ajax({
                url: "<?php echo base_url(); ?>admin/mail/sendingMail",
                type:"post",
                data:{"id" : id, 'email_address' : em},
                async:true,
                dataType: 'json',
                success:function(ret){
                    kq = ret.email;
                    if (ret.err == false) {
                        kq = ret.email + ' <span style="color: red;">エラー</span>';
                    } else if (ret.err == true)  {
                        success_count++;
                    } else {
                        kq = ret.email + ' <span style="color: blue;">' + ret.err + '</span>';
                        success_count++;
                    }

                    var ret = '';
                    if (count % 500 == 0 && count != 0) {
                        group_id = count;
                        $('#box_mail_process').append('<div id="group_' + group_id + '"" style="margin-top: 20px; border: 1px solid #555; min-height: 100px;"></div>');
                    }

                    ret += kq + ', ';
                    $('#group_' + group_id).append(ret);
                    $('#total_sent').html(success_count + '/'+ email_address.length);
                    if (count == email_address.length - 1) {
                        $('#btn_back').css({'display': 'block'});
                    }
                    count++;
                }
            });
        }
    });
</script>
<center><p>メール送信状況</p></center>
<textarea id="email_address" style="display: none;"><?php echo $queue_mail; ?></textarea>
<div id="box_mail_process">
    <p style="color: red;">現在まで送信した件数 <span id="total_sent">0</span></p>
    <div id="group_1" style="border: 1px solid #555; min-height: 100px;"></div>
</div>
<p id="btn_back" style="display: none; padding-left: 5px;"><a href="<?php echo base_url() . $url; ?>">&lt;&lt; 戻る</a></p>