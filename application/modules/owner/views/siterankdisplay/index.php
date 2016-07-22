<script language="javascript" src="<?php echo base_url() ?>public/owner/js/timepicker/jquery.ui.widget.min.js"></script>
<script language="javascript" src="<?php echo base_url() ?>public/owner/js/timepicker/jquery.ui.position.min.js"></script>
<script language="javascript" src="<?php echo base_url() ?>public/owner/js/timepicker/jquery.ui.timepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/jquery-ui-1.10.0.custom.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/jquery.ui.timepicker.css" type="text/css" media="screen" />

<script type="text/javascript">
    $("#th13").addClass("visited");
    $(function() {
        $('#time1').timepicker({
            showPeriodLabels: false,
            showLeadingZero: true,
            minutes: { interval: 1 },
        });

        $('#time2').timepicker({
            showPeriodLabels: false,
            showLeadingZero: true,
            minutes: { interval: 1 },
        });

        $('#time3').timepicker({
            showPeriodLabels: false,
            showLeadingZero: true,
            minutes: { interval: 1 },
        });

        $('#time4').timepicker({
            showPeriodLabels: false,
            showLeadingZero: true,
            minutes: { interval: 1 },
        });

        $('#time5').timepicker({
            showPeriodLabels: false,
            showLeadingZero: true,
            minutes: { interval: 1 },
        });

        var remaining_update = <?php echo isset($data['remaining_update'])?$data['remaining_update']:5; ?>;
        if (remaining_update == 0) {
            for (i = 1; i<=5; i++) {
                $('#time'+i).prop('disabled', true);
            }
            $('#update_rank_setting').prop('disabled', true);
            alert('申し訳ありませんが、1日５回しかボタンを押すことができません.');
        }

        $('.rank_time').change(function() {
            var time = $('#'+this.id).val();
            if ( time!="" && !time.match(/^(([0-1][0-9])|(2[0-3])):[0-5][0-9]$/)) {
                alert("時間が正しくありません。再入力してください。");
                $('#'+this.id).val("");
            }
        });
    });
</script>
<style>
    .site_auto_update_setting {
        border: 1px solid #1db6b6;
        border-radius: 4px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
        width: 50%;;
    }

    .error_message, .success_message { width: 900px; margin: 0 auto; color: red; }
</style>
<div class="crumb">TOP ＞ サイト上位表示</div>
<div style="float:right;"><a style="color:#2595F8;" target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-25.html">登録方法</a></div>
<div class="list-box">
    <div class="list-title">自動更新設定</div>
    <div class="contents-box-wrapper">
        <?php if (isset($error_message)) : ?>
            <p class="error_message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)) : ?>
            <p class="success_message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <div id="list_container">
            <form method="post">
                <div class="site_auto_update_setting">
                    <?php for ($i = 1; $i<=5; $i++) :?>
                        <?php
                            $time = isset($data['time_'.$i])?$data['time_'.$i]:'';
                        ?>
                        <p>
                            <label class="mr_10 fw_bold"><?php echo $i;?>回目</label><input class="mb10 rank_time" type="text" value="<?php echo !isset($rank_setting[$i])?substr($time,0,5):$rank_setting[$i]; ?>" id="time<?php echo $i; ?>" name="time<?php echo $i; ?>">
                        </p>
                    <?php endfor; ?>
                    <input type="submit" value="更新" id="update_rank_setting">
                </div>
            </form>
        </div>
    </div>
</div>
