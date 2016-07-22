<link rel="stylesheet" type="text/css" href="<?php echo base_url()."public/owner/css/jquery-ui.css";?> ">
<script src="<?php echo base_url()."public/owner/js/jquery-ui.min.js"; ?>" type="text/javascript"></script>
<script src="<?php echo base_url()."public/owner/js/jquery.ui.datepicker-ja.min.js"; ?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#th2").addClass("visited");

    $( "#create-user" ).button().on( "click", function() {
        if (!confirm("このテンプレートをベースにして、新しいテンプレートを作成します。よろしいでしょうか？")) {
            return;
        }
        if($('#scout_title').val() != '' && $('#scout_title').val() != 'undefined') {
            if ($('#scout_pr_ttle').val() == '') {
                alert('件名は必須項目です。');
                $('#scout_pr_ttle').focus();
                return;
            }
            $('#scout_mail_register').val(1);
            $('#history_app_message_temp').submit();
        }
        else {
            alert('テンプレート名前は必須項目です。');
            $('#scout_title').focus();
        }
    });


    $( "#edit-user" ).button().on( "click", function() {
        if (!confirm("このテンプレートの修正を行います。よろしいでしょうか？")) {
            return;
        }
        if($('#scout_title').val() != '' && $('#scout_title').val() != 'undefined')    {
            if ($('#scout_pr_ttle').val() == '') {
                alert('件名は必須項目です。');
                $('#scout_pr_ttle').focus();
                return;
            }
            $('#history_app_message_temp').submit();
        }
        else {
            alert('テンプレート名前は必須項目です。');
            $('#scout_title').focus();
        }
    });

	 var disp_pr_text = "<?php echo isset($disp_pr_text)?$disp_pr_text:''; ?>";
	 var str = $('#scout_pr_text').val();
	 var res1 = '';
	 if(disp_pr_text != '') {
		$('#scout_pr_text').show();
		$('#scout_pr_text').css('border', '1px solid #ccc');
		$('#scout_pr_text').css('resize', 'none');
		$('#scout_pr_text').attr("readonly", false);
		$('#scout_pr_text').attr("placeholder", '自由入力フォーム');
	 }
	 else {
		if(str == '')
			$('#scout_pr_text').val("");
	 }

	if(str!='')
		res = str.split("<br/>");
	else
		res = '';
	for(var i=0;i<res.length;i++) {
		if(res[i] !='') {
			res1 = res1+res[i];
			if(res.length > 1 && i != res.length - 1)
				res1 = res1+'\n';
		}
		else
			res1 = res1+'\n';
	}

	$('#scout_pr_text').text(res1);

	$("#scout_pr_text").keyup(function (e) {
			autoheight(this);
	});

	function autoheight(a) {
        if (!$(a).prop('scrollTop')) {
    		do {
                var b = $(a).prop('scrollHeight');
                var h = $(a).height();
                $(a).height(h - 5);
    		}
    		while (b && (b != $(a).prop('scrollHeight')));
        };
        $(a).height($(a).prop('scrollHeight') + 17);
	}

	autoheight($("#scout_pr_text"));

	var scout_mail = "<?php echo isset($scout_mail)?$scout_mail:''; ?>";
	if(scout_mail != '') {
		alert(scout_mail);
	}

    $('#ownerScoutPrText').change(function() {
        var id = $('#ownerScoutPrText').val();
        $.ajax({
            url: '<?php echo base_url().'owner/history/getOwnerScoutPrText'?>',
            type:'GET',
            dataType: 'json',
            data: {id: id},
            success: function(data){
              $('#scout_pr_text').val(data['pr_text']);
              $('#scout_pr_ttle').html(data['pr_title']);
              $('#scout_pr_id').val(data['id']);
              autoheight($("#scout_pr_text"));
            }
        });
    });
});
</script>
<div class="crumb">TOP ＞ テンプレート</div>
<!--
	<div class="owner-box"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="settlement" target="_blank"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a></div><br >
-->
<div class="list-box"><!-- list-box ここから -->
<div class="list-title">メッセージ・ テンプレート確認</div>
<div class="contents-box-wrapper">
    <div class="list-t-center">
        <br >
        送信メッセージの編集は行えませんご了承下さいませ。<br >
	メッセージ内の　/--○○--/　部分につきましては、オーナー様・ユーザー様の情報が反映されます。<br >
    </div> <!-- list-t-center ここまで -->
    <br >
    <div class="information_list">スカウト・メッセージ　※スカウト時に送信されるメッセージになります。</div>
    <br >
<?php if(!isset($disp_pr_text)): ?>
        <div class="taleft-wrapper">
    <?php if($o_s_pr_text_total > 1): ?>
        <br >
        <div class="taleft pl100">
          スカウトメールテンプレート：
          <select name="ownerScoutPrText" id="ownerScoutPrText">
            <?php foreach($owner_scout_pr_text_data as $value): ?>
            <option value="<?php echo $value['id']?>" <?php if($value['id'] == ($scout_mail_template_id)) echo " selected"; ?>><?php echo $value['title']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
    <?php else: ?>
        <div class="taleft pl100">
          テンプレート名前: <input placeholder="名前" type="text" name="scout_title" id="scout_title" value="<?php echo (isset($scout_title))?$scout_title:''?>" readonly>
        </div>
    <?php endif; /*-- if($o_s_pr_text_total > 1) --*/?>
		<div class="information_list">
			<a href="<?php echo base_url()."owner/history/history_app_message_temp/1"; ?>">編集</a>&nbsp;&nbsp;&nbsp;
			<a href="../help#template_toroku">テンプレート登録について</a>
		</div>
        </div><!-- /. taleft-wrapper -->
		<br />
<?php endif; ?>

<?php if(isset($disp_pr_text)): ?>
        <form id="history_app_message_temp" name="history_app_message_temp" action="<?php echo base_url(); ?>owner/history/history_app_message_temp" method="post"   >
        <br >
        <div class="taleft pl100 mb10">
            テンプレート名前: <input placeholder="名前" type="text" name="scout_title" id="scout_title" value="<?php echo (isset($scout_title))?$scout_title:''?>" >
        </div>
<?php endif ?>
        <div class="message_box">
        <table class="message">
            <tr>
<?php if(isset($disp_pr_text)) { ?>
                <td>件名：<input type="text" name="scout_pr_ttle" id="scout_pr_ttle" value="<?php echo isset($scout_pr_ttle) ? $scout_pr_ttle : ''; ?>" maxlength="100" size="100"></td>
<?php } else { ?>
                <td style="background: #FFC9C9;">件名：<span id="scout_pr_ttle"><?php echo $scout_pr_ttle; ?></span></td>
<?php } ?>
            </tr>
            <tr><td><br/></td></tr>
            <tr>
                <td>
                    <?php echo $content03; ?>
                </td>
            </tr>
        </table>
        </div>
<?php if(isset($disp_pr_text)): ?>
        <br />
        <div class="list-t-center">
          <?php if($o_s_pr_text_total < 5): ?>
            <div id="create-user" class="c-button">登録する</div>
          <?php endif; ?>
          <div id="edit-user" class="c-button">更新する</div>
          <input type="hidden" name="scout_mail_register" id="scout_mail_register" value="">
          <input type="hidden" name="scout_pr_id" id="scout_pr_id" value="<?php echo (isset($scout_mail_template_id))?$scout_mail_template_id:''; ?>">
        </div>
        </form>
        <br>
<?php endif ?>
</div><!-- / .contents-box-wrapper -->
</div><!-- container ここまで -->
