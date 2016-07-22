<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/jquery-ui_new.css" type="text/css" media="screen" />
<style>
	th.col_state {
		text-align: center;
		width: 100px;
	}
</style>
<!--<script type="text/javascript" src="<?php echo base_url() ?>public/owner/js/jquery-ui.js"></script> -->
<script type="text/javascript">
	$(function() {
		pagination_first_messsage_bonus_list();   
		
		$('.submit_button').click(function(e) {        
			e.preventDefault();
			var id = $(this).attr('id');
			if (id == 'sort_bonus_list') {
				var action = "<?php echo base_url().'admin/request/firstMessageBonusList/'; ?>";
			} else {
				var action = "<?php echo base_url().'admin/request/downloadFirstMessageCsv/'; ?>";
			}
			
			$('#form_bonus_list').attr('action', action);
			$('#form_bonus_list').submit();    
		});
	
		$('#dialog-form').hide();
		$(".non_approval").click(function() {
			var confirm_flag = confirm("このユーザーの初回メッセージボーナスポイントを非承認してもよろしいでしょうか？");
			if (confirm_flag == false) {
				return false;
			}
			var msg_id  = $(this).data('msgid');
			var user_id = $(this).data('userid');
			var noneuserid = $(this).data('noneuserid');
			var fmf = $(this).data('fmf');
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>admin/request/declineMsgBonus",
				data:{ msgid: msg_id, noneuserid, userid: user_id, first_message_flag: fmf},
				dataType: 'json',
				success: function(data) {
					if (data == true) {
						$("#decline_state_"+msg_id).html("非承認済み");
						alert("非承認が完了しました。");
					} else {
						alert("非承認が失敗しました。");
					}
				}
			});
		});

		autoheight($(".message_content"));

		$(".message_content").keyup(function (e) {
			autoheight(this);
		});

		$(".edit_msg_content").click(function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			var msg_title = $('#title'+id).text();
			var msg_content = $('#content'+id).text();
			var html = "<div>件名: "+msg_title+"</div><hr><p id='validateTips' style='color: red'>メセッジを入力してください。</p><div class='mb10'>本文：</div>";
			html  = html+"<textarea class='edit_message_content' style='width: 562px; resize: none;'>"+msg_content+"</textarea>";
			$('#dialog-form').html(html);
			$('#validateTips').hide();
			$("#dialog-form").dialog({
				width: $('.msg_bonus_list').width() - 500,
				modal: true,
				closeOnEscape: true,
				buttons: {
					"更新": function() {
						if ($('.edit_message_content').val().length > 0) {
							$.post("<?php echo base_url(); ?>admin/request/editUserMessage", { msg_id: id, content: $('.edit_message_content').val()}, function(data) {
								$('#content'+id).html(nl2br($('.edit_message_content').val()));
								alert('メッセージを更新しました。');
							});
							$( this ).dialog( "close" );
						} else
						$('#validateTips').show();
					},
					"キャッセル": function() {
						$( this ).dialog( "close" );
					}
				}
			});
			autoheight($(".edit_message_content"));reply_id
		});

	  $(".cate_select").change(function(){
	  	console.log('SSSSSS');
			var id = $(this).attr('data-id');
			var msgid = $(this).attr('data-msgid');
			var category_id = $(this).val();
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>admin/request_ajax/cate_select",
				data:{ id:id, msgid:msgid, category_id:category_id},
				dataType: 'json',
				success: function(res) {
					if (res.flag == true) {
						alert("カテゴリー更新しました。");
					} else {
						alert("失敗しました。");
					}
				}
			});
	  });

		$(".public_select").change(function(){
	  		console.log('public_selectSSSSSS');
			var id = $(this).attr('data-id');
			var msgid = $(this).attr('data-msgid');
			var public_flag = $(this).val();
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>admin/request_ajax/public_select",
				data:{ id:id, msgid:msgid, public_flag:public_flag},
				dataType: 'json',
				success: function(res) {
					if (res.flag == true) {
						alert("設定更新しました。");
					} else {
						alert("失敗しました。");
					}
				}
			});
	  	});
	})

	function nl2br (str, is_xhtml) {
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}

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
</script>
<center>
  <form method="post" action="" name="form_bonus_list" id="form_bonus_list">      
	  <p class="mb20">ユーザーからの問い合わせ一覧</p>
	  <table>
		  <tr>
			<td>初回メッセージ</td>
			<td class="center"><input type="checkbox" value="1"  name="chkbox_first_message" id="chkbox_first_message" <?php echo (isset($chkbox_first_message) && $chkbox_first_message)?' checked':''; ?>></td>            
		  </tr>
		  <tr>
			<td>会員名</td>
			<td><input size="40" input="text" value="<?php echo isset($_POST['txt_member_name'])?$_POST['txt_member_name']:''; ?>" name="txt_member_name" id="txt_member_name"></td>
		  </tr>
		  <tr>
			<td>店舗名</td>
			<td><input size="40" input="text" value="<?php echo isset($_POST['txt_storename'])?$_POST['txt_storename']:''; ?>" name="txt_storename" id="txt_storename"></td>
		  </tr>

		  <tr>
			<td>非公開</td>
			<td class="center"><input type="checkbox" value="1"  name="chkbox_public_message" id="chkbox_public_message" <?php echo (isset($chkbox_public_message) && $chkbox_public_message)?' checked':''; ?>></td>            
		  </tr>

		  <tr>
			<td colspan="2" class="center p20">
				<BUTTON type="submit" id="sort_bonus_list" class="submit_button">　検索　</BUTTON>
				<?php if (count($messages) > 0) : ?>
					<button type="submit" id="download_csv" class="submit_button">ダウンロード</button>
				<?php endif; ?>
			</td>
		  </tr>
	  </table>  
  </form>    
  <div class="msg_bonus_list">      
	<table style="width:100%;">
	  <tbody>
		<tr>
		  <th class="col_id">ID</th>
		  <th class="col_date">会員名前</th>
		  <th class="col_date">日時</th>
		  <th class="col_owner_id">店舗ＩＤ</th>
		  <th class="col_storename">店舗名</th>
		  <th class="col_content">内容</th>
		  <th class="col_state">状態</th>
		  <th class="col_state">返事</th>
		  <th class="col_edit">編集</th>
		  <th class="col_decline">非承認</th>
		  <th class="col_decline">カテゴリ</th>
		  <th class="col_decline">店舗<br>承認<br>非承認</th>
		  <th class="col_decline">公開</th>
		</tr>
		<?php if(count($messages) > 0): ?>
		<?php foreach ($messages as $one_message) { ?>
		  <tr <?php echo ($one_message['public_flag_style'])? 'style="background-color:#CCC;"':''; ?> >
			<td><?php echo ($one_message['unique_id']? $one_message['unique_id']:"非会員"); ?></td>
			<td style=" width: 9%;"><?php echo ($one_message['users_name'] ? $one_message['users_name'] : $one_message['none_member_name']); ?></td>
			<td style=" width: 9%;"><?php echo $one_message['created_date']; ?></td>
			<td class="col_owner_id"><?php echo $one_message['owner_id']; ?></td>
			<td class="col_storename"><?php echo $one_message['storename']; ?></td>
			<td>
			  <?php if($one_message['first_message_flag'] == 1): ?>
				  <div style="text-align: right; margin: 10px 10px 0 0"><span class="first_message">初回メッセージ</span></div>
			  <?php endif; ?>
			  <dl>
				<dt id="title<?php echo $one_message['msg_id']; ?>"><?php echo $one_message['title']; ?></dt>
				<dd id="content<?php echo $one_message['msg_id']; ?>"><?php echo nl2br($one_message['content']); ?></dd>
			  </dl>
			</td>
			<td>
				<?php if ($one_message['is_read_flag'] == 0 && $one_message['is_replied_flag'] == 0):?>
				  <div style="text-align: center; margin: 10px 10px 0 0"><span class="open_message">開封済み</span></div>
				<?php elseif($one_message['is_read_flag'] == 0 && $one_message['is_replied_flag'] == 1):?>
				  <div style="text-align: center; margin: 10px 10px 0 0"><span class="replied_message">返事済み</span></div>
				<?php endif;?>
			</td>
			<td style="width: 20%; word-wrap: break-word; word-break: break-all;">
				<?php if ($one_message['reply_content']) : ?>
				<dl>
					<dt><?php echo $one_message['reply_title']; ?></dt>
					<dd><?php echo nl2br($one_message['reply_content']); ?></dd>
				</dl>
				<?php endif; ?>
			</td>
			<td class="col_edit edit_msg_content" data-id="<?php echo $one_message['msg_id'];?>"><button>編集</button></td>
			<td id="decline_state_<?php echo $one_message['msg_id'];?>" class="center">
				<?php if ($one_message['display_flag']){ ?>
				<button class="non_approval" data-msgid="<?php echo $one_message['msg_id'];?>" data-noneuserid ="<?php echo $one_message['none_member_id']; ?>" data-userid="<?php echo $one_message['user_id'];?>" data-fmf="<?php echo $one_message['first_message_flag']; ?>">非承認する</button>
				<?php } else { ?>
				非承認済み
				<?php } ?>
			</td>
			<td class="" >
				<?php if ($one_message['is_read_flag'] == 0 && $one_message['is_replied_flag'] == 0):?>
				<?php elseif($one_message['is_read_flag'] == 0 && $one_message['is_replied_flag'] == 1 && $one_message['owner_res_flag'] == 1) :?>
					<?php
						if (!array_key_exists('reply_category_id', $one_message)) {
							$reply_category_id = 0;
						} else {
							$reply_category_id = $one_message['reply_category_id'];
						}
				  	?>
			  <select class="cate_select" data-id="<?php echo $one_message['reply_id'];?>" data-msgid="<?php echo $one_message['msg_id'];?>">
				<option value="0" <?php if($reply_category_id == 0){echo "selected='selected'";} ?> >選択して下さい</option>
				<option value="6" <?php if($reply_category_id == 6){echo "selected='selected'";} ?> >仕事内容</option>
				<option value="1" <?php if($reply_category_id == 1){echo "selected='selected'";} ?> >報酬</option>
				<option value="2" <?php if($reply_category_id == 2){echo "selected='selected'";} ?> >待遇</option>
				<option value="3" <?php if($reply_category_id == 3){echo "selected='selected'";} ?> >面接・体験入店</option>
				<option value="4" <?php if($reply_category_id == 4){echo "selected='selected'";} ?> >休暇</option>
				<option value="5" <?php if($reply_category_id == 5){echo "selected='selected'";} ?> >未経験</option>
				<option value="100" <?php if($reply_category_id == 100){echo "selected='selected'";} ?> >その他</option>
			  </select>
<!--
			  <select class="cate_select" data-id="<?php echo $one_message['reply_id'];?>" data-msgid="<?php echo $one_message['msg_id'];?>">
				<option value="0" <?php if($one_message['reply_category_id'] == 0 && $one_message){echo "selected='selected'";} ?> >選択して下さい</option>
				<option value="6" <?php if($one_message['reply_category_id'] == 6 && $one_message){echo "selected='selected'";} ?> >仕事内容</option>
				<option value="1" <?php if($one_message['reply_category_id'] == 1 && $one_message){echo "selected='selected'";} ?> >報酬</option>
				<option value="2" <?php if($one_message['reply_category_id'] == 2 && $one_message){echo "selected='selected'";} ?> >待遇</option>
				<option value="3" <?php if($one_message['reply_category_id'] == 3 && $one_message){echo "selected='selected'";} ?> >面接・体験入店</option>
				<option value="4" <?php if($one_message['reply_category_id'] == 4 && $one_message){echo "selected='selected'";} ?> >休暇</option>
				<option value="5" <?php if($one_message['reply_category_id'] == 5 && $one_message){echo "selected='selected'";} ?> >未経験</option>
				<option value="100" <?php if($one_message['reply_category_id'] == 100 && $one_message){echo "selected='selected'";} ?> >その他</option>
			  </select>
-->
			  <?php endif;?>
			</td>
			<td class="" >
			  <?php if ($one_message['is_read_flag'] == 0 && $one_message['is_replied_flag'] == 0):?>
			  <?php elseif($one_message['is_read_flag'] == 0 && $one_message['is_replied_flag'] == 1):?>
				  <?php if ($one_message['owner_res_flag'] == 0 ):?>
				  不承認
				  <?php else:?>
				  承認
				  <?php endif;?>
			  <?php endif;?>
			</td>
			<td class="" >
			  <?php if ($one_message['is_read_flag'] == 0 && $one_message['is_replied_flag'] == 0):?>
			  <?php elseif($one_message['is_read_flag'] == 0 && $one_message['is_replied_flag'] == 1 && $one_message['owner_res_flag'] == 1) :?>
				<select class="public_select" data-id="<?php echo $one_message['reply_id'];?>" data-msgid="<?php echo $one_message['msg_id'];?>">
					<option value="0" <?php if($one_message['public_flag'] == 0){echo "selected='selected'";} ?> >非公開</option>
					<option value="1" <?php if($one_message['public_flag'] == 1){echo "selected='selected'";} ?> >公開</option>
				</select>
			  <?php endif;?>
			</td>
		  </tr>
		<?php } ?>
		<?php else: ?>
		  <tr><td colspan="7" >現在、メッセージがありません。</td></tr>
		<?php endif; ?>
	  </tbody>
	</table>
  </div>
  <div id="pagination_first_messsage_bonus_list"><?php echo $this->pagination->create_links() ?></div>
</center>
<div id="dialog-form"></div>
