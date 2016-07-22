<style type="text/css">
.pic_area{
margin-bottom: 10px;
}
.pic_area img{
height:90px;
}
</style>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/settings.js?v=20150511" ></script>
<section class="section section--settings cf">
    <div class="settings_data_wrap cf">
        <h3 class="ttl_1 mb_15">プロフィール設定</h3>
        <dl class="dl_1 cf">
            <div class="prof_nickname">
                <div class="scout_heading sh1">ニックネーム</div>
                <input type="text" name="nickname" id="nick_Name" value="<?php echo !empty($Uniqueid)? $Uniqueid['nick_name'] : ''; ?>">   
                <?php 
                if(!empty($Uniqueid) && ($Uniqueid['user_from_site'] == 3 || $Uniqueid['user_from_site'] == 4)): 
                ?>
                <div class="scout_heading sh2">求人サービス利用可否</div>
                <div class="mgs-wrap scout_mail_accept">
                    <!-- <input type="checkbox" name="scoutMailStatus" id="scoutMailStatus" <?php echo ($Uniqueid['scout_target_flag'] != 1)? 'checked="checked"' : ''; ?>> 求人サービスをご利用になる場合はチェックしてください。 -->
                    <ul>
                        <li>
                            <label>
                                <input id="scout_mail_use" type="radio" name="scout_mail_accept" value="0" <?php echo set_radio('scout_mail_accept','0'); ?> <?php if ($Uniqueid['scout_target_flag'] == 0 || $Uniqueid['scout_target_flag'] == NULL) echo "checked"; ?>>
                                利用する 
                            </label>
                        </li>
                        <li>
                            <label>
                                <input id="scout_mail_notuse" type="radio" name="scout_mail_accept" value="1" <?php echo set_radio('scout_mail_accept','1'); ?> <?php if ($Uniqueid['scout_target_flag'] == 1) echo "checked"; ?>>
                                利用しない 
                            </label>
                        </li>
                    </ul>

                </div>
                <div class="service_note">求人サービス用情報</div>
                <?php endif; ?> 
            </div>
                <dt id="top_profile_photo" class="ttl_3 ttl_3--salmon"><span>プロフィール写真</span></dt>
                <dd class="cf">
            <form method="post" name="changeProfileForm" id="changeProfileForm1" enctype="multipart/form-data">
                    <div class="pic_area">
                        <img id="profile_pic" name="profile_pic" src="<?php
                            $data_from_site = $Uniqueid['user_from_site'];
                            if (!$Uniqueid['profile_pic']) {
                                echo base_url()."public/user/image/no_image.jpg";
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
                    <input type="file" name="profile_pic_file" accept="image/jpg/jpeg" class="profile_pic_file" id = "profile_pic_file">
                    <div class="ui_btn ui_btn--small update_profile_pic" id="update_profile_pic">登録</div>
                    <!--<div class="ui_btn ui_btn--small delete_profile_pic" id="delete_profile_pic">削除</div>-->
                    </div>
                <input type="hidden" name = "profile_pic_num" value="1">
                <input type="hidden" name = "profile_pic_file_path" id="profile_pic_file_path" value="">
            </form>
            <form method="post" name="changeProfileForm" id="changeProfileForm2" enctype="multipart/form-data">

                    <div class="pic_area">
                        <img id="profile_pic2" name="profile_pic2" src="<?php
                            $data_from_site = $Uniqueid['user_from_site'];
                            if (!$Uniqueid['profile_pic2']) {
                                echo base_url()."public/user/image/no_image.jpg";
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
                    <input type="file" name="profile_pic_file2" accept="image/jpg/jpeg" class="profile_pic_file" id = "profile_pic_file2">
                    <div class="ui_btn ui_btn--small update_profile_pic" id="update_profile_pic2">登録</div>
                    <div class="ui_btn ui_btn--small delete_profile_pic" id="delete_profile_pic2">削除</div>
                    </div>
                <input type="hidden" name = "profile_pic_num" value="2">
                <input type="hidden" name = "profile_pic_file_path2" id="profile_pic_file_path2" value="">
            </form>

            <form method="post" name="changeProfileForm" id="changeProfileForm3" enctype="multipart/form-data">
                    <div class="pic_area">
                        <img id="profile_pic3" name="profile_pic3" src="<?php
                            $data_from_site = $Uniqueid['user_from_site'];
                            if (!$Uniqueid['profile_pic3']) {
                                echo base_url()."public/user/image/no_image.jpg";
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
                    <input type="file" name="profile_pic_file3" accept="image/jpg/jpeg" class="profile_pic_file" id = "profile_pic_file3">
                    <div class="ui_btn ui_btn--small update_profile_pic" id="update_profile_pic3">登録</div>
                    <div class="ui_btn ui_btn--small delete_profile_pic" id="delete_profile_pic3">削除</div>
                    </div>
                <input type="hidden" name = "profile_pic_num" value="3">
                <input type="hidden" name = "profile_pic_file_path3" id="profile_pic_file_path3" value="">
            </form>
                </dd>
            <form method="post" action="" name="form_job_info" id="form_job_info">
				<dl id="top_pr" class="dl_1 cf">
					<dd>
					自己紹介文
					<textarea name="pr_message" cols=42 rows=4 style="width:100%;"><?php if(!empty($uprofile)){echo $uprofile['pr_message'];} ?></textarea>
					</dd>
				</dl>
            <dt class="ttl_3 ttl_3--salmon"><span>プロフィール詳細</span></dt>
                <input type="hidden" value="do_user_change" name="do_user_recruitslist_change"/>
                <dd>
                    <div class="form_item_list form_item_list_1 cf">
                        <ul>
                            <li>
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
                            </li>
                            <li>
                                <select class="size_max" name="height_id">
                                    <option value="">*身長</option>
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
                            </li>
                            <li>
                                <select class="size_max" name="age_id">
                                    <option value="">*年齢</option>
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
                            </li>
                            <li>
                                <select class="size_max" name="city_id">
                                    <option value="">*地域</option>
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
                            </li>
                            <li>
                                <select class="size_max" name="bust_size">
                                    <option value="">バスト</option>
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
                            </li>
                            <li>
                                <select class="size_max" name="waist_size">
                                    <option value="">ウエスト</option>
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
                            </li>
                            <li>
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
                            </li>


                        </ul>
                        <div class="form_item_list form_item_list_3--half cf">
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
                        </div>
                    </div>
                </dd>
                <input type="hidden" name="nickName" id="inputNickname" value="">
                <?php if(!empty($Uniqueid) && ($Uniqueid['user_from_site'] == 3 || $Uniqueid['user_from_site'] == 4)): ?>
                <input type="hidden" name="bbsAcceptScoutMail" id="bbsAcceptScoutMail" value="0">
                <?php endif; ?>
                <div class="ui_btn_wrap ui_btn_wrap--center mt_15 mb_25 cf">
                    <ul>
                        <li>
                            <a class="ui_btn ui_btn--magenta ui_btn--large_liquid" href="javascript:void(0)" id="job_info">登録・変更</a>
                        </li>
                    </ul>
                </div>
            </form>
        </dl>
    </div>
    <form method="post" action="" name="form_user_change" id="form_user_change">
        <div class="settings_data_wrap cf">
            <h3 class="ttl_1 mb_15">基本設定</h3>
            <input type="hidden" value="do_user_change" name="do_user_change"/>
            <?php if (isset($message)) : ?>
                <div><?php echo Helper::print_error($message); ?></div>
            <?php endif; ?>
            <?php if (isset($divsuccessa) && $divsuccessa != '') : ?>
                <div class="message_success"><?php echo $divsuccessa; ?></div>
            <?php elseif (isset($divsuccessb) && $divsuccessb != '') : ?>
                <div class="message_success"><?php echo $divsuccessb; ?></div>
            <?php elseif(isset($divsuccessc) && $divsuccessc != '') : ?>
                <div class="message_success"><?php echo $divsuccessc; ?></div>
            <?php elseif(isset($divsuccessd) && $divsuccessd != '') : ?>
                <div class="message_success"><?php echo $divsuccessd; ?></div>
            <?php elseif(isset($divsuccesse) && $divsuccesse != '') : ?>
                <div class="message_success"><?php echo $divsuccesse; ?></div>
            <?php endif; ?>
            <dl class="dl_1 cf">
                <dt class="ttl_3 ttl_3--salmon"><span>メールアドレス</span></dt>
                <dd><input type="email" class="size_max" name="email_address" placeholder="メールアドレス" value="<?php echo set_value('email_address',$Uniqueid['email_address']); ?>" /></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>現在のパスワード</span></dt>
                <dd><input type="password" class="size_max" name="oldpassword" placeholder="現在のパスワード" /></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>新パスワード</span></dt>
                <dd><input type="password" class="size_max" name="newpassword" placeholder="新パスワード" /></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>新パスワードを確認</span></dt>
                <dd><input type="password" class="size_max" name="confirmpassword" placeholder="新パスワードを確認"/></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>ユーザーID</span></dt>
                <dd><input type="text" class="size_max" name="name" placeholder="ユーザーID" value="<?php echo set_value('name',($Uniqueid['unique_id'])); ?>" disabled /></dd>
            </dl>
        </div>
        <div class="ui_btn_wrap ui_btn_wrap--center mt_15 mb_25 cf">
            <ul>
                <li>
                    <a class="ui_btn ui_btn--magenta ui_btn--large_liquid" href="javascript:void(0)" id="submit_user_change">登録・変更</a>
                </li>
            </ul>
        </div>
    </form>
    <?php if (isset($data_from_site) && $data_from_site == 0) { ?>
    <form method="post" action="" name="form_bank_account" id="form_bank_account">
        <input type="hidden" value="do_user_change" name="do_user_recruits_change"/>
        <div class="settings_data_wrap cf">
            <h3 class="ttl_1 mb_15">銀行口座</h3>
            <dl class="dl_1 cf">
                <dt class="ttl_3 ttl_3--salmon"><span>金融機関名</span></dt>
                <dd><input type="text" class="size_max" name="bank_name" placeholder="○○銀行" value="<?php echo set_value('bank_name',$Uniqueid['bank_name']); ?>"></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>支店名</span></dt>
                <dd><input type="text" class="size_max" name="bank_agency_name" placeholder="新宿支店" value="<?php echo set_value('bank_agency_name',$Uniqueid['bank_agency_name']); ?>"></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>支店名カナ</span></dt>
                <dd><input type="text" class="size_max" name="bank_agency_kara_name" placeholder="シンジュクシテン" value="<?php echo set_value('bank_agency_kara_name',$Uniqueid['bank_agency_kara_name']); ?>"></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>口座種別</span></dt>
                <dd>
                    <div class="form_item_list form_item_list_2--half cf">
                        <ul>
                            <li>
                                <label><input type="radio" name="account_type" value="0" <?php echo set_radio('account_type','0'); ?> <?php if ($Uniqueid['account_type'] == 0) echo "checked"; ?>> 普通 </label>
                            </li>
                            <li>
                                <label><input type="radio" name="account_type" value="1" <?php echo set_radio('account_type','1'); ?> <?php if ($Uniqueid['account_type'] == 1) echo "checked"; ?>> 当座 </label>
                            </li>
                        </ul>
                    </div>
                </dd>
                <dt class="ttl_3 ttl_3--salmon"><span>口座番号</span></dt>
                <dd><input type="text" class="size_max" name="account_no" placeholder="12345678" value="<?php echo set_value('account_no',$Uniqueid['account_no']); ?>"></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>口座名義</span></dt>
                <dd><input type="text" class="size_max" name="account_name" placeholder="ジョイスペタロウ" value="<?php echo set_value('account_name',$Uniqueid['account_name']); ?>"></dd>
            </dl>
        </div>
        <div class="ui_btn_wrap ui_btn_wrap--center mt_15 mb_25 cf">
            <ul>
                <li>
                    <a class="ui_btn ui_btn--magenta ui_btn--large_liquid" href="javascript:void(0)" id="bank_account">登録・変更</a>
                </li>
            </ul>
        </div>
    </form>
    <?php } ?>
    <form method="post" name="form_age_verification" id="form_age_verification" enctype="multipart/form-data">
        <input type="hidden" value="do_form_age_verification" name="do_form_age_verification"/>
        <input type="hidden" value="0" name="linkid">
        <div class="settings_data_wrap cf">
          <h3 class="ttl_1 mb_15">ご本人様確認</h3>
          <dl class="dl_1 cf">
              <dt class="ttl_3 ttl_3--salmon"><span>身分証明書</span></dt>
			  <dd><dd class="ml_5">※交通費・体験入店申請の際に必要です。</dd>
              <dd><input type="file" accept="image/jpg/jpeg/png" name="img"></dd>
          </dl>
        </div>
        <div class="ui_btn_wrap ui_btn_wrap--center mt_15 mb_25 cf">
            <ul>
                <li>
                    <a class="ui_btn ui_btn--magenta ui_btn--large_liquid" href="javascript:void(0)" id="age_verification">身分証明書の提出</a>
                </li>
            </ul>
            <ul class="pt_20">
                <li>
                    <a class="fc_00F" href="mailto:info@joyspe.com?subject=joyspe年齢認証&body=撮っていただいたお写真を添付しそのままお送りくださいませ">
                        >> 年齢認証メールを送る <<
                    </a>
                </li>
            </ul>
        </div>
    </form>
    <form method="post" id="form_transfer_change" name="form_transfer_change">
        <input type="hidden" value="do_transfer_change" name="do_transfer_change"/>
        <div class="settings_data_wrap cf">
            <h3 class="ttl_1 mb_15">お知らせ通知設定</h3>
            <dl class="dl_1 cf">
                <dt class="ttl_3 ttl_3--salmon"><span>登録メールアドレスへ転送</span></dt>
                <dd>
                  <div class="form_item_list form_item_list_2--half cf">
                        <ul>
                            <li>
                                <label><input type="radio" name="set_send_mail" value="1" <?php echo set_radio('set_send_mail','1'); ?> <?php if ($radiosetsendmail['set_send_mail'] == 1) echo "checked"; ?>> 転送する</label>
                            </li>
                            <li>
                                <label><input type="radio" name="set_send_mail" value="0" <?php echo set_radio('set_send_mail','0'); ?> <?php if ($radiosetsendmail['set_send_mail'] == 0) echo "checked"; ?>> 転送しない</label>
                            </li>
                        </ul>
                    </div>
                </dd>
            </dl>
        </div>
        <div class="ui_btn_wrap ui_btn_wrap--center mt_15 mb_25 cf">
            <ul>
                <li>
                    <a class="ui_btn ui_btn--magenta ui_btn--large_liquid" href="javascript:void(0)" id="transfer_change">登録・変更</a>
                </li>
            </ul>
        </div>
    </form>
</section>
<script type="text/javascript">
    $('#inputNickname').val($('#nick_Name').val());
    $('#nick_Name').on('input',function(){ 
        $('#inputNickname').val($(this).val());
    });
    checkb =  $('#scout_mail');
    if (typeof checkb !== "undefined") {
        var scout_val = $("input[name='scout_mail_accept']:checked").val();
        $('#bbsAcceptScoutMail').val(scout_val);
        $(".scout_mail_accept input[type='radio']").change(function () {
            var scout_val = $("input[name='scout_mail_accept']:checked").val();
            $('#bbsAcceptScoutMail').val(scout_val);
        });
    }
</script>