<style type="text/css">
.section--settings .settings_profile_data .changeProfileForm dl dd p.hide{
	position: absolute;
	display: block;
	margin-top: 0px;
	margin-left: 2px;
}

.changeProfileForm dl dd p.hide input{
	font-size: 24px;
	cursor: pointer;
	opacity: 0.0;
	width: 93px;
}
</style>
<h3><span>プロフィール設定</span></h3>
<div class="settings_profile_data">
    <div class="profTitleWrap">
        <span>ニックネーム（お悩み相談のみで使用されます）</span> 
    </div>
    <div class="profileNick_wrap">
        <div class="profileNick">
            <input type="text" name="nickname" id="nick_Name" value="<?php echo !empty($Uniqueid)? $Uniqueid['nick_name'] : ''; ?>">
        </div>
    </div>
    <?php 
    if(!empty($Uniqueid) && ($Uniqueid['user_from_site'] == 3 || $Uniqueid['user_from_site'] == 4)): 
    ?>
    <div class="profTitleWrap">
        <span>求人サービスを利用する（スカウトメールを受け取ることができます）</span> 
    </div>
    <div class="mgs-wrap scout_mail_accept">
        <!-- <input type="checkbox" name="scoutMailStatus" id="scoutMailStatus" <?php echo ($Uniqueid['scout_target_flag'] != 1)? 'checked="checked"' : ''; ?>> 求人サービスをご利用になる場合はチェックしてください。 -->
        <ul>
            <li>
                <label>
                    <input id="scout_mail" type="radio" name="scout_mail_accept" value="0" <?php echo set_radio('scout_mail_accept','0'); ?> <?php if ($Uniqueid['scout_target_flag'] == 0 || $Uniqueid['scout_target_flag'] == NULL) echo "checked"; ?>>
                    利用する 
                </label>
            </li>
            <li>
                <label>
                    <input id="scout_mail" type="radio" name="scout_mail_accept" value="1" <?php echo set_radio('scout_mail_accept','1'); ?> <?php if ($Uniqueid['scout_target_flag'] == 1) echo "checked"; ?>>
                    利用しない 
                </label>
            </li>
        </ul>
    </div>
    <?php endif; ?> 
	<div class="profTitleWrap">
        <span>プロフィール写真</span> 
    </div>
	<div class="form_wrap">
		<form method="post" name="changeProfileForm" id="changeProfileForm1" class="changeProfileForm" enctype="multipart/form-data">
			<p>メイン写真</p>
			<dl>
				<dt class="pic_area"> <img id="profile_pic" name="profile_pic" src="<?php
                            $data_from_site = $Uniqueid['user_from_site'];
                            if (!$Uniqueid['profile_pic']) {
                                echo base_url()."public/user/pc/image/no_image.png";
                            } else {
                                $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$Uniqueid['profile_pic'];
                                if (file_exists($pic_path)) {
                                    echo base_url().$this->config->item('upload_userdir').'images/'.$Uniqueid['profile_pic'];
                                } else {
                                    if ($data_from_site == 1) {
                                        echo $this->config->item('machemoba_pic_path').$Uniqueid['profile_pic'];
                                    } else {
                                        echo $this->config->item('aruke_pic_path').$Uniqueid['profile_pic'];
                                    }
                                }
                            }
                        ?>">
                </dt>
				<dd>
					<p class="hide"></p>
						<input type="file" name="profile_pic_file" accept="image/jpg/jpeg" class="profile_pic_file" id="profile_pic_file">
					<div class="btn_change_pic update_profile_pic" id="update_profile_pic">
						<button>写真を変更</button>
					</div>
					<!--<div class="btn_delete_pic delete_profile_pic" id="delete_profile_pic">
						<button>削除</button>
					</div>-->
					<input type="hidden" name="profile_pic_num" value="1">
					<input type="hidden" name="profile_pic_file_path" id="profile_pic_file_path" value="">
				</dd>
			</dl>
		</form>
		<form method="post" name="changeProfileForm" id="changeProfileForm2" class="changeProfileForm" enctype="multipart/form-data">
			<p>サブ写真：01</p>
			<dl>
				<dt class="pic_area"><img id="profile_pic2" name="profile_pic2" src="<?php
                            $data_from_site = $Uniqueid['user_from_site'];
                            if (!$Uniqueid['profile_pic2']) {
                                echo base_url()."public/user/pc/image/no_image.png";
                            } else {
                                $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$Uniqueid['profile_pic2'];
                                if (file_exists($pic_path)) {
                                    echo base_url().$this->config->item('upload_userdir').'images/'.$Uniqueid['profile_pic2'];
                                } else {
                                    if ($data_from_site == 1) {
                                        echo $this->config->item('machemoba_pic_path').$Uniqueid['profile_pic2'];
                                    } else {
                                        echo $this->config->item('aruke_pic_path').$Uniqueid['profile_pic2'];
                                    }
                                }
                            }
                        ?>">
                </dt>
				<dd>
					<p class="hide"></p>
						<input type="file" name="profile_pic_file2" accept="image/jpg/jpeg" class="profile_pic_file" id="profile_pic_file2">
					<div class="btn_change_pic update_profile_pic" id="update_profile_pic2">
						<button>写真を変更</button>
					</div>
					<div class="btn_delete_pic delete_profile_pic" id="delete_profile_pic2">
						<button>削除</button>
					</div>
					<input type="hidden" name="profile_pic_num" value="2">
					<input type="hidden" name="profile_pic_file_path2" id="profile_pic_file_path2" value="">
				</dd>
			</dl>
		</form>
		<form method="post" name="changeProfileForm" id="changeProfileForm3" class="changeProfileForm" enctype="multipart/form-data">
			<p>サブ写真：02</p>
			<dl>
				<dt class="pic_area"> <img id="profile_pic3" name="profile_pic3" src="<?php
                            $data_from_site = $Uniqueid['user_from_site'];
                            if (!$Uniqueid['profile_pic3']) {
                                echo base_url()."public/user/pc/image/no_image.png";
                            } else {
                                $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$Uniqueid['profile_pic3'];
                                if (file_exists($pic_path)) {
                                    echo base_url().$this->config->item('upload_userdir').'images/'.$Uniqueid['profile_pic3'];
                                } else {
                                    if ($data_from_site == 1) {
                                        echo $this->config->item('machemoba_pic_path').$Uniqueid['profile_pic3'];
                                    } else {
                                        echo $this->config->item('aruke_pic_path').$Uniqueid['profile_pic3'];
                                    }
                                }
                            }
                        ?>">
                </dt>
				<dd>
					<p class="hide"></p>
						<input type="file" name="profile_pic_file3" accept="image/jpg/jpeg" class="profile_pic_file" id="profile_pic_file3">
					<div class="btn_change_pic update_profile_pic" id="update_profile_pic3">
						<button>写真を変更</button>
					</div>
					<div class="btn_delete_pic delete_profile_pic" id="delete_profile_pic3">
						<button>削除</button>
					</div>
					<input type="hidden" name="profile_pic_num" value="3">
					<input type="hidden" name="profile_pic_file_path3" id="profile_pic_file_path3" value="">
				</dd>
			</dl>
		</form>
	</div>
	<h4>詳細プロフィール</h4>
	<form method="post" action="" name="form_job_info" id="form_job_info">
		<input type="hidden" value="do_user_change" name="do_user_recruitslist_change">
		<div class="form_profile_list form_profile_list_1 cf">
			<table>
				<tr>
					<th>希望収入</th>
					<td>
                        <select class="size_max" name="hope_salary_id">
                            <option value="">希望収入</option>
                            <?php
                            if (!empty($uprofile)) {
                                foreach ($salary_range_list as $item) {
                                    ?>
                                    <option <?php
                                    if ($item['id'] == $uprofile['hope_salary_id']) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $item['id'] ?>"<?php echo set_select('hope_salary_id', $item['id']); ?>>
                                        <?php
                                              if ($item['range1']!=0 && $item['range2']!=0) {
                                                  echo $item['range1'].'万～'.$item['range2'].'万';
                                              }
                                              if ($item['range2']==0) {
                                                  echo $item['range1'].'万以上';
                                              }
                                         ?>
                                    </option>

                                    <?php
                                }
                            } if (empty($uprofile)) {
                                foreach ($salary_range_list as $item) {
                                ?>
                                <option value="<?php echo $item['id'] ?>"<?php echo set_select('hope_salary_id', $item['id']); ?>>
                                    <?php
                                        if ($item['range1']!=0 && $item['range2']!=0) {
                                            echo $item['range1'].'万～'.$item['range2'].'万';
                                        }
                                        if ($item['range2']==0) {
                                            echo $item['range1'].'万以上';
                                        }
                                     ?>
                                </option>
                                <?php
                                }
                            }
                            ?>
                        </select>
					</td>
				</tr>
				<tr>
					<th>身長</th>
					<td>
                        <select class="size_max" name="height_id">
                            <option value="" selected>選択してください</option>
                            <?php
                                if (!empty($uprofile)) {
                                    foreach ($heightlist as $item) {
                                        ?>
                                        <option <?php
                                            if ($item['id'] == $uprofile['height_id']) {
                                                echo "selected";
                                            }
                                            ?> value="<?php echo $item['id'] ?>"<?php echo set_select('height_id', $item['id']); ?>>
                                            <?php
                                                if ($item['name1']==0 && $item['name2']!=0) {
                                                    echo '～'.$item['name2'].'cm';
                                                } else {
                                                    if ($item['name2']==0 && $item['name1']!=0) {
                                                        echo $item['name1'].'cm～';
                                                    } else {
                                                        if ($item['name1']!=0 && $item['name2']!=0) {
                                                            echo $item['name1'].'cm～'.$item['name2'].'cm';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </option>
                                        <?php
                                    }
                                }
                                if (empty($uprofile)) {
                                    foreach ($heightlist as $item) {
                                        ?>
                                        <option value="<?php echo $item['id'] ?>"<?php echo set_select('height_id', $item['id']); ?>>
                                            <?php
                                                if ($item['name1']==0 && $item['name2']!=0) {
                                                    echo '～'.$item['name2'].'cm';
                                                } else {
                                                    if ($item['name2']==0 && $item['name1']!=0) {
                                                        echo $item['name1'].'cm～';
                                                    } else {
                                                        if ($item['name1']!=0 && $item['name2']!=0) {
                                                            echo $item['name1'].'cm～'.$item['name2'].'cm';
                                                        }
                                                    }
                                                }
                                             ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                        </select>
					</td>
					<th>年齢</th>
					<td>
                        <select class="size_max" name="age_id">
                            <option value="">選択してください</option>
                            <?php
                            if (!empty($uprofile)) {
                                foreach ($agelist as $item) {
                                    ?>
                                    <option <?php
                                    if ($item['id'] == $uprofile['age_id']) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $item['id'] ?>"<?php echo set_select('age_id', $item['id']); ?>>
                                        <?php
                                              if ($item['name1']!=0 && $item['name2']!=0) {
                                                  echo $item['name1'].'歳～'.$item['name2'].'歳';
                                              }
                                              if ($item['name2']==0) {
                                                  echo $item['name1'].'歳以上';
                                              }
                                         ?>
                                    </option>

                                    <?php
                                }
                            } if (empty($uprofile)) {
                                foreach ($agelist as $item) {
                                ?>
                                <option value="<?php echo $item['id'] ?>"<?php echo set_select('age_id', $item['id']); ?>>
                                    <?php
                                        if ($item['name1']!=0 && $item['name2']!=0) {
                                            echo $item['name1'].'歳～'.$item['name2'].'歳';
                                        }
                                        if ($item['name2']==0) {
                                            echo $item['name1'].'歳以上';
                                        }
                                     ?>
                                </option>
                                <?php
                                }
                            }
                            ?>
                        </select>
					</td>
				</tr>
				<tr>
					<th>住所</th>
					<td>
                        <select class="size_max" name="city_id">
                            <option value="">選択してください</option>
                            <?php
                            if (!empty($uprofile)) {
                                foreach ($citylist as $item) {
                                    ?>
                                    <option <?php
                                    if ($item['id'] == $uprofile['city_id']) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $item['id'] ?>"<?php echo set_select('city_id', $item['id']); ?>><?php echo $item['name'].$item['district'] ?></option>
                                    <?php
                                }
                            } else {
                                foreach ($citylist as $item) {
                                    ?>
                                    <option value="<?php echo $item['id'] ?>"<?php echo set_select('city_id', $item['id']); ?>><?php echo $item['name'].$item['district'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
					</td>
					<th>バスト</th>
					<td>
                        <select class="size_max" name="bust_size">
                            <option value="">選択してください</option>
                            <?php
                             if (!empty($Uniqueid)) {
                                foreach ($bustlist as $item) {
                                    ?>
                                    <option <?php
                                    if ($item['size'] == $Uniqueid['bust']) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $item['size'] ?>"<?php echo set_select('bust_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                                    <?php
                                }
                            } else {
                                 foreach ($bustlist as $item) {
                                    ?>
                                    <option value="<?php echo $item['size'] ?>"<?php echo set_select('bust_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
					</td>
				</tr>
				<tr>
					<th>ウエスト</th>
					<td>
                        <select class="size_max" name="waist_size">
                            <option value="">選択してください</option>
                            <?php
                            if (!empty($Uniqueid)) {
                                foreach ($waistlist as $item) {
                                    ?>
                                    <option <?php
                                    if ($item['size'] == $Uniqueid['waist']) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $item['size'] ?>"<?php echo set_select('waist_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                                    <?php
                                }
                            } else {
                                foreach ($waistlist as $item) {
                                    ?>
                                    <option value="<?php echo $item['size'] ?>"<?php echo set_select('waist_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
					</td>
					<th>ヒップ</th>
						<td>
                            <select class="size_max" name="hip_size">
                                <option value="">ヒップ</option>
                                <?php
                                if (!empty($Uniqueid)) {
                                    foreach ($hiplist as $item) {
                                        ?>
                                        <option <?php
                                        if ($item['size'] == $Uniqueid['hip']) {
                                            echo "selected";
                                        }
                                        ?> value="<?php echo $item['size'] ?>"<?php echo set_select('hip_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                                        <?php
                                    }
                                } else {
                                    foreach ($hiplist as $item) {
                                        ?>
                                        <option value="<?php echo $item['size'] ?>"<?php echo set_select('hip_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
						</td>
				</tr>
				<tr>
					<th>風俗経験</th>
					<td colspan="3">
                        <ul>
                            <li>
                                <label><input type="radio" name="working_exp" value="0" <?php echo set_radio('working_exp','0'); ?> <?php if ($uprofile['working_exp'] == 0) echo "checked"; ?>>未選択</label>
                            </li>
                            <li>
                                <label><input type="radio" name="working_exp" value="2" <?php echo set_radio('working_exp','2'); ?> <?php if ($uprofile['working_exp'] == 2) echo "checked"; ?>>風俗経験あり</label>
                            </li>
                            <li>
                                <label><input type="radio" name="working_exp" value="1" <?php echo set_radio('working_exp','1'); ?> <?php if ($uprofile['working_exp'] == 1) echo "checked"; ?>>風俗経験なし</label>
                            </li>
                        </ul>
					</td>
				</tr>
			</table>
            <input type="hidden" name="nickName" id="inputNickname" value="">
            <?php if(!empty($Uniqueid) && ($Uniqueid['user_from_site'] == 3 || $Uniqueid['user_from_site'] == 4)): ?>
            <input type="hidden" name="bbsAcceptScoutMail" id="bbsAcceptScoutMail" value="0">
            <?php endif; ?>
			<div class="btn_wrap t_center m_t_20">
				<ul>
					<li><button class="ui_btn ui_btn--large ui_btn--bg_magenta" id="submit_profile_change" disabled>登録・変更</button></li>
				</ul>
			</div>
		</div>
	</form>
</div>
<script>
$(function(){
	/*------------------------------------------*/
	// change button enable / disable
	/*------------------------------------------*/
	$('#form_job_info select, #form_job_info :radio').on('change', function(){
		var scope = $(this).closest('form');
		var disabled = false;
		$('option:selected', scope).each(function(){
			if($(this).val() <= 0){
				disabled = true;
			}
		});
/*		$(':radio:checked', scope).each(function(){
			if($(this).val() <= 0){
				disabled = true;
			}
		});*/
		if(disabled){
			$('#submit_profile_change', scope).prop('disabled', true);
		}else{
			$('#submit_profile_change', scope).prop('disabled', false);
		}
	});
    $('#inputNickname').val($('#nick_Name').val());
    $('#nick_Name').on('input',function(){   
        $('#inputNickname').val($(this).val());
        var disabled = false;
        $('#form_job_info option:selected').each(function(){
            if($(this).val() <= 0){ 
                disabled = true;
            }
        });
        if(disabled){
            $('#submit_profile_change').prop('disabled', true);
        }else{
            $('#submit_profile_change').prop('disabled', false);
        }
    });
    checkb =  $('#scout_mail');
    if (typeof checkb !== "undefined")  {
        var scout_val = $("input[name='scout_mail_accept']:checked").val();
        $('#bbsAcceptScoutMail').val(scout_val);
        $(".scout_mail_accept input[type='radio']").change(function () {
            var disabled = false;
            var scout_val = $("input[name='scout_mail_accept']:checked").val();
            $('#bbsAcceptScoutMail').val(scout_val);
            $('#form_job_info option:selected').each(function(){
                if($(this).val() <= 0){ 
                    disabled = true;
                }
            });
            if(disabled){
                $('#submit_profile_change').prop('disabled', true);
            }else{
                $('#submit_profile_change').prop('disabled', false);
            }
        });
    }
	/*------------------------------------------*/
	// confirm dialog
	/*------------------------------------------*/
	$('#submit_profile_change').on('click', function(e){
		e.preventDefault();
		if($(this).prop('disabled') == true || $(this).hasClass('disabled') == true){
			return;
		}
		var modal_conf = $('<div>').dialog(modal_setting);
		modal_conf.dialog('option', {
			title: '登録・変更します',
			buttons: [
				{
					text: 'いいえ',
					class: 'btn-gray',
					click: function(){
						$(this).dialog('close');
					}
				},
				{
					text: 'はい',
					class: 'btn-t_green',
					click: function(){
						$(this).dialog('close');

						/* update data */
                        //var nickname = $('#nickName').val();
				        var upload_action = base_url + "user/profile_change/do_user_recruitslist_change_pc";
				        $('#form_job_info').ajaxSubmit({
				            type:'post',
				            url: upload_action,
                            //data: { 'nick_name': nickname},
				            dataType: 'json',
				            success: function(responseValues, statusText, xhr, $form) {
				                if (!responseValues.success) {
				                    alert('登録・変更エラーが発生しました');
				                } else {
                                    var modal_comp = $('<div>').dialog(modal_setting);
                                    modal_comp.dialog('option', {
                                        title: '登録・変更が完了しました',
                                        buttons: [
                                            {
                                                text: 'OK',
                                                class: 'btn-t_green',
                                                click: function(){
                                                    <?php 
                                                    //if user from external then redirect to external site
                                                    if (isset($external_ref)) {
                                                    ?>
                                                        window.location = '<?php echo $external_ref; ?>';
                                                    <?php } ?>
                                                    $(this).dialog('close');
                                                }
                                            }
                                        ]
                                    });
                                    modal_comp.html('').dialog('open');
				                }
				            }
				        });

					}
				}
			]
		});
		modal_conf.html('よろしいですか？').dialog('open');
	});
});
</script>