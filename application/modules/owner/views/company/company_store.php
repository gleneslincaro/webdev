<script type="text/javascript">

    $(document).ready(function() {
      $("#th5").addClass("visited");
			$('#scout_pr_text').hide();
      displayPopupError();
      loadImage();
      happyPayMoney();

    $('#update_info').click(function(){
        var happyMoneyType = '';
        var txthappyMoney = $('#txthappyMoney').val();
        if (!$('input:radio[name=happyMoneyType]:checked').val() && txthappyMoney != 0) {
            alert('入店か体入を選択してください。');
            return false;
        }
    });

      $("#areas").find("option").each(function () {
        if ($(this).val() == "<?php echo $owner_recruit['city_group_id']; ?>") {
          $(this).prop("selected", "selected");
        }
      });

      $('#areas').change();
      <?php if(isset($owner_recruit['city_id'])): ?>
        cityValue = "<?php echo $owner_recruit['city_id']; ?>";
        var value = {value:cityValue, id: 'cities'};
        getList(value);
      <?php endif ?>

    });

    function getList(e) {
      var cityValue = '';
      var townValue = '';
      <?php if(isset($owner_recruit['city_id'])): ?>
        cityValue = "<?php echo $owner_recruit['city_id']; ?>";
      <?php endif ?>
      <?php if(isset($owner_recruit['town_id'])): ?>
        townValue = "<?php echo $owner_recruit['town_id']; ?>";
      <?php endif ?>
      if(e.id == 'areas') {
        var output = 'cities';
        var type = 'city_group';
        $('#towns').html("<option value=''></option>");
      }
      else if (e.id == 'cities') {
        var output = 'towns';
        var type = 'city';
      }
      $.ajax({
        url: '<?php echo base_url().'owner/company/getDataList'?>',
          type:'POST',
          dataType: 'json',
          data: {id: e.value, type: type},
          success: function(data){
            var optionList = "<option value=''></option>";
            for (var i = 0; i < data.length; i++) {
              if((output == 'cities' && cityValue == data[i]['id']) || (output == 'towns' && townValue == data[i]['id'])) {
                selected = 'selected = "selected"';
              } else {
                selected = '';
              }
              optionList = optionList+"<option "+selected+"value='"+data[i]['id']+"'>"+data[i]['name']+"</option>"
            }

            $('#'+output).html(optionList);
          }
      });
    }


    function loadImage()
    {
        path = baseUrl + "/public/owner/uploads/tmp/";
        if($('#hdError').val()==1)
        {
            for (i = 1; i <= 6; i++)
            {
                if ($("#hdImage" + i).val() != '')
                {
                  $("#image" + i).attr("src", $("#hdImage" + i).val());
                }

            }
        }


    }

    function displayPopupError() {
        var div_error = $(".hide-error");
        if (div_error.length > 0) {
            var error = div_error.text();
            var arr = error.split('● ');
            var strErr = "";
            for (i = 1; i < arr.length; i++)
            {
                strErr += '● ' + arr[i] + "\n";
            }
            alert(strErr);
        }
    }

    function chooseImage()
    {
        var noImage = "no_image.jpg";
        var upload_action = baseUrl + "owner/login/fileUploadAjx";

        $('#myForm').ajaxSubmit({
            url: upload_action,
            dataType: 'json',
            success: function(responseText, statusText, xhr, $form) {

                if (responseText.error != null)
                {
                    alert(responseText.error);
                }
                else
                {
                    if ($("#image1").attr("src").substr($("#image1").attr("src").lastIndexOf("/") + 1) == noImage)
                    {
                        $("#image1").attr("src", responseText.url);
                        $("#hdImage1").val(responseText.url);
                    }
                    else if ($("#image2").attr("src").substr($("#image2").attr("src").lastIndexOf("/") + 1) == noImage)
                    {
                        $("#image2").attr("src", responseText.url);
                        $("#hdImage2").val(responseText.url);
                    }
                    else if ($("#image3").attr("src").substr($("#image3").attr("src").lastIndexOf("/") + 1) == noImage)
                    {
                        $("#image3").attr("src", responseText.url);
                        $("#hdImage3").val(responseText.url);
                    }
                    else if ($("#image4").attr("src").substr($("#image4").attr("src").lastIndexOf("/") + 1) == noImage)
                    {
                        $("#image4").attr("src", responseText.url);
                        $("#hdImage4").val(responseText.url);
                    }
                    else if ($("#image5").attr("src").substr($("#image5").attr("src").lastIndexOf("/") + 1) == noImage)
                    {
                        $("#image5").attr("src", responseText.url);
                        $("#hdImage5").val(responseText.url);
                    }
                    else if ($("#image6").attr("src").substr($("#image6").attr("src").lastIndexOf("/") + 1) == noImage)
                    {
                        $("#image6").attr("src", responseText.url);
                        $("#hdImage6").val(responseText.url);
                    }
                }
            }
        });
    }

    function deleteImage()
    {

        var path = baseUrl + "/public/owner/images/no_image.jpg";
        var imageArr = new Array();
        var imagePath = new Array();
        var checkDel = new Array()
        var n = 0;
        var flag = false;

        $.each($("input[name='ckImage[]']:checked"), function() {

            i = $(this).attr('value');
            checkDel[i] = i;
            flag = true;

        });

        if (!flag)
        {
            alert('チェックボックスが選択されておりません。対象を選択して下さい。');
            return false;
        }

        if (!confirm('削除しますか？'))
        {
            return false;
        }


        for (i = 1; i <= 6; i++)
        {
            if (!checkDel[i] && ($("#image" + i).attr("src") != path))
            {
                imageArr[n] = $("#image" + i).attr("src");
                imagePath[n++] = $("#hdImage" + i).val();

            }
        }

        for (i = imageArr.length; i < 6; i++)
        {
            imageArr[i] = path;
            imagePath[i] = '';

        }

        for (i = 1; i <= 6; i++)
        {
            $("#image" + i).attr("src", imageArr[i - 1]);
            $("#hdImage" + i).val(imageArr[i - 1]);
        }

        return true;
    }

    function happyPayMoney() {
        //alert(value);
        var id = $("#happy_money").val();

        var action = baseUrl + "owner/login/happyMoneyPayUser";

        $.ajax({
                type: "POST",
		dataType : "json",
	        async : true,
		url: action,
		data: { id: id },
		datatyle: 'json',
		success:function(data){
		if(data != null){
                    $("#lbHappyPayMoney").html(data.user_happy_money + '円');
		}

               }
              });
    }
</script>

<div class="crumb">TOP ＞ 基本情報 ＞ 求人情報変更</div>
<!--
  <div class="owner-box"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a></div><br >
-->

<?php
//$data = array();
if (count($data) > 0) {
    //$data = $data_company_store[0];
    ?>
    <?php echo Helper::print_error($message); ?>
    <div class="list-box"><!-- list-box ここから -->
        <div class="list-title">■求人情報変更　(*)は必須項目です</div>
    <div class="contents-box-wrapper">
        <form id="myForm" name="myForm" method="post" action ="<?php echo base_url().'owner/company/company_store'?>" enctype="multipart/form-data" >
            <div class="information_box">
                <input type="hidden" value="<?php echo $data['orid']; ?>" name="orid" id="orid"/>
                <input type="hidden" value="<?php echo $data['oid']; ?>" name="oid" id="oid"/>
                <input type="hidden" value="<?php echo $data['scout_pr_text']; ?>" name="scout_pr_text" id="scout_pr_text"/>
                <table class="information">
                    <tr>
                      <td>*メールアドレス</td><td>
                        <input type="text" id="txtEmailAddress" name="txtEmailAddress" size="60" value="<?php echo set_value('txtEmailAddress', $owner_data['email_address']); ?>"><br >
                      </td>
                    </tr>
                    <tr>
                    <td>*パスワード</td>
                      <td>
                        <input type="text" id="txtPassword" name="txtPassword" size="60" value="<?php echo set_value('txtPassword', base64_decode($owner_data['password'])); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>*エリア地域</td>
                      <td>
                        <center>
                          <select name="city_group_id" id="areas" onchange="getList(this)" style="min-width: 150px;">
                            <option value=""></option>
                            <?php foreach ($city_groups as $key => $value) { ?>
                                <option
                                  value="<?php echo $value['id'] ?>" <?php echo set_select('city_group_id', $owner_recruit['city_group_id']); ?>><?php echo $value['name'] ?>
                                </option>
                            <?php } ?>
                          </select>
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td>*エリア都道府県</td>
                      <td>
                        <select name="city_id" id="cities" onchange="getList(this)" style="min-width: 150px;">
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>*エリア都市</td>
                      <td>
                        <select name="town_id" id="towns" style="min-width: 150px;">
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>*タイトル</td>
                      <td>
                        <input type="text" id="txtTitle" name="txtTitle" size="60" value ="<?php echo set_value('txtTitle', $owner_recruit['title']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>*店舗名</td>
                      <td>
                        <input type="text" id ="txtStoreName" name="txtStoreName" size="60" value ="<?php echo set_value('txtStoreName', $owner_data['storename']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>*住所</td>
                      <td>
                        <input type="text" id="txtAddress" name="txtAddress" size="60" value ="<?php echo set_value('txtAddress', $owner_data['address']); ?>"><br >
                      </td>
                    </tr>
                    <tr>
                      <td>*転送設定</td>
                      <td>
                        <input type="radio" name="set_send_mail" value="1" <?php if ($set_send_mail == 1) echo "checked"; ?>> ON
                        <input type="radio" name="set_send_mail" value="0" <?php if ($set_send_mail == 0) echo "checked"; ?>> OFF
                      </td>
                    </tr>
                    <tr>
                      <td>店舗情報公開</td>
                      <td>
                        <input type="radio" name="public_info_flag" value="1" <?php if ($public_info_flag == 1) echo "checked"; ?>>公開
                        <input type="radio" name="public_info_flag" value="0" <?php if ($public_info_flag == 0) echo "checked"; ?>>非公開
                      </td>
                    </tr>
                    <tr>
                      <td>*業種</td>
                      <td>
                        <select name="ckJobType" id="ckJobType">
                          <?php foreach ($jobType as $key => $value): ?>
                            <option
                              <?php if($value['id'] == $ckjobTypeOwnerRecruit[0]) echo "selected"; ?>
                              value="<?php echo $value['id']; ?>" <?php echo set_select('ckJobType', $value['id']); ?>><?php echo $value['name']; ?>　</option>
                          <?php endforeach ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>*勤務地</td>
                      <td>
                        <input type="text" id ="txtWorkPlace" name="txtWorkPlace" size="60" value ="<?php echo set_value('txtWorkPlace', $owner_recruit['work_place']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>*勤務日</td>
                      <td>
                        <input type="text" id ="txtWorkingDay" name="txtWorkingDay" size="60" value ="<?php echo set_value('txtWorkingDay', $owner_recruit['working_day']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>*勤務時間</td>
                      <td>
                        <input type="text" id ="txtWorkingTime" name="txtWorkingTime" size="60" value ="<?php echo set_value('txtWorkingTime', $owner_recruit['working_time']); ?>">
                      </td>
                    </tr>
                    <tr>
                    <td>*交通</td>
                      <td>
                        <textarea id ="txtHowToAccess" name="txtHowToAccess" cols="60" rows="4"><?php echo set_value('txtHowToAccess', $owner_recruit['how_to_access']); ?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>*給与</td>
                      <td>
                        <textarea id ="txtSalary" name="txtSalary" cols="60" rows="4"><?php echo set_value('txtSalary', $owner_recruit['salary']); ?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>*応募資格</td>
                      <td>
                        <textarea id ="txtConToApply" name="txtConToApply" cols="60" rows="4"><?php echo set_value('txtConToApply', $owner_recruit['con_to_apply']); ?></textarea>
                      </td>
                    </tr>
                    <tr>
                    <td>入店特典</td>
                    <td>
                        <p style="text-align:left;">タイトル <input type="text" name="visiting_benefits_title_1" value="<?php echo set_value('visiting_benefits_title_1', $owner_recruit['visiting_benefits_title_1']); ?>" ></p>
                        <p style="text-align:left;">テキスト <textarea name="visiting_benefits_content_1" style="resize:none; width: 440px; height:50px; vertical-align: top;"><?php echo set_value('visiting_benefits_content_1', $owner_recruit['visiting_benefits_content_1']); ?></textarea></p>
                        <p style="text-align:left;">タイトル <input type="text" name="visiting_benefits_title_2" value="<?php echo set_value('visiting_benefits_title_2', $owner_recruit['visiting_benefits_title_2']); ?>" ></p>
                        <p style="text-align:left;">テキスト <textarea name="visiting_benefits_content_2" style="resize:none; width: 440px; height:50px; vertical-align: top;"><?php echo set_value('visiting_benefits_content_2', $owner_recruit['visiting_benefits_content_2']); ?></textarea></p>
                        <p style="text-align:left;">タイトル <input type="text" name="visiting_benefits_title_3" value="<?php echo set_value('visiting_benefits_title_3', $owner_recruit['visiting_benefits_title_3']); ?>" ></p>
                        <p style="text-align:left;">テキスト <textarea name="visiting_benefits_content_3" style="resize:none; width: 440px; height:50px; vertical-align: top;"><?php echo set_value('visiting_benefits_content_3', $owner_recruit['visiting_benefits_content_3']); ?></textarea></p>
                    </td>
                  </tr>
                    <tr>
                      <td>*待遇</td>
                      <td>
                        <center>
                          <div class="check_box">
                            <?php
                            $cou = 0;
                            foreach ($allTreatments as $c) {
                              $cou++;
                              ?>
                              <input type="checkbox" name="cktreatment[]" <?php
                              if (count($ckownerTreatment) > 0) {
                                if (in_array($c['id'], $ckownerTreatment)) {
                                  echo "checked";
                                }
                              }
                              ?> value="<?php echo $c['id']; ?>"> <?php
                                echo $c['name'];
                                if ($cou == 4) {
                                  echo "<br/>";
                                  $cou = 0;
                                }
                              ?>
                            <?php } ?>
                          </div>
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td>その他待遇</td>
                      <td>
                        <textarea name="other_service" style="resize:none; vertical-align: top;" rows="10" cols="53" ><?php echo set_value('other_service', $owner_recruit['other_service']); ?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>*お店からのメッセージ</td>
                      <td>
                      <textarea name="txtShopInfo" rows="10" cols="53" ><?php echo set_value('txtShopInfo', $owner_recruit['company_info']); ?></textarea>
                      </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                      <td>*応募時間</td>
                      <td>
                        <input type="text" id="txtTimeOfApply" name="txtTimeOfApply" size="60" value ="<?php echo set_value('txtTimeOfApply', $owner_recruit['apply_time']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>*応募用電話番号</td>
                      <td>
                        <input type="text" id="txtTelForApp" name="txtTelForApp" size="60" value ="<?php echo set_value('txtTelForApp', $owner_recruit['apply_tel']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>*応募用メールアドレス</td>
                      <td>
                        <input type="text" id="txtMailForApp" name="txtMailForApp" size="60" value ="<?php echo set_value('txtMailForApp', $owner_recruit['apply_emailaddress']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>*オフィシャルHP</td>
                      <td>
                        <input type="text" id="txtHomePageUrl" name="txtHomePageUrl" size="60" value ="<?php echo set_value('txtHomePageUrl', $owner_recruit['home_page_url']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>LINEID</td>
                      <td>
                        <input type="text" id="txtLineId" name="txtLineId" size="60" value ="<?php echo set_value('txtLineId', $owner_recruit['line_id']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>LINE URL登録</td>
                      <td>
                        <input type="text" id="txt_line_url" name="txt_line_url" size="60" value ="<?php echo set_value('txt_line_url', $owner_recruit['line_url']); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>お問い合わせ通知用のメールアドレス</td>
                      <td>
                        <input type="text" id="txtNewMsgNotifyEmail" name="txtNewMsgNotifyEmail" size="60" value ="<?php echo set_value('txtNewMsgNotifyEmail', $owner_recruit['new_msg_notify_email']); ?>">
                       </td>
                    </tr>
                    <tr>
                        <td>区別<?php echo $happyMoneyType; ?></td>
                        <td>入店<input type="radio" name="happyMoneyType" value="入店" <?php  echo $happyMoneyType == '入店'? 'checked': ''; ?> >  体入<input type="radio" name="happyMoneyType" value="体入" <?php echo $happyMoneyType == '体入'? 'checked': ''; ?>></td>
                    </tr>
                    <tr>
                      <td>お祝い金額</td>
                      <td>
                        <!--input type="text" id="txthappyMoney" name="txthappyMoney" size="60" value ="<?php echo set_value('txtNewMsgNotifyEmail', $owner_data['happy_money']); ?>"-->
                        <select id="txthappyMoney" name="txthappyMoney">
                            <?php for ( $x = 0; $x <= 100000; $x += 5000) : ?>
                            <option <?php echo ($x == $txthappyMoney? 'selected': ''); ?>><?php echo $x;?></option>
                            <?php endfor; ?>
                        </select> 円
                       </td>
                    </tr>
                    <tr>
                      <td>イメージ写真</td>
                      <td>
                        <center>
                          <div class="photo_box">
                            <div class="photo" style="margin-right:25px;">
                              <img id="image1" name="image1" width="100" src="<?php
                              $url = '';
                                empty($image1)?
                                              $url = $imagePath . 'images/no_image.jpg' :
                                              $url = $image1;
                              echo $url;
                              ?>">
                            </div>
                            <div class="photo" style="margin-right:25px;">
                              <img id="image2" name="image2" width="100" src="<?php
                              $url = '';
                              empty($image2)?
                                              $url = $imagePath . 'images/no_image.jpg' :
                                              $url = $image2;
                              echo $url;
                              ?>">
                            </div>
                            <div class="photo">
                                <img id="image3" name="image3" width="100" src="<?php
                                $url = '';
                                empty($image3)?
                                                $url = $imagePath . 'images/no_image.jpg' :
                                                $url = $image3;
                                echo $url;
                                ?>">
                            </div>
                            <br style="clear:both;">
                          </div>
                          <div class="photo_box">
                            <div class="photo" style="margin-right:25px;">
                              <img id="image4" name="image4" width="100" src="<?php
                              $url = '';
                               empty($image4)?
                                              $url = $imagePath . 'images/no_image.jpg' :
                                              $url = $image4;
                              echo $url;
                              ?>">
                            </div>
                            <div class="photo" style="margin-right:25px;">
                              <img id="image5" name="image5" width="100" src="<?php
                              $url = '';
                              empty($image5)?
                                              $url = $imagePath . 'images/no_image.jpg' :
                                              $url = $image5;
                              echo $url;
                              ?>">
                            </div>
                            <div class="photo">
                              <img id="image6" name="image6" width="100" src="<?php
                              $url = '';
                               empty($image6)?
                                              $url = $imagePath . 'images/no_image.jpg' :
                                              $url = $image6;
                              echo $url;
                              ?>">
                            </div>
                            <br style="clear:both;">
                          </div>
                          <br >
                          <p>
                            <input type="checkbox" id="ckImage[]" name="ckImage[]" value="1" <?php echo set_checkbox('ckImage[]', '1'); ?>> 写真1
                            <input type="checkbox" id="ckImage[]" name="ckImage[]" value="2" <?php echo set_checkbox('ckImage[]', '2'); ?>> 写真2
                            <input type="checkbox" id="ckImage[]" name="ckImage[]" value="3" <?php echo set_checkbox('ckImage[]', '3'); ?>> 写真3
                            <input type="checkbox" id="ckImage[]" name="ckImage[]" value="4" <?php echo set_checkbox('ckImage[]', '4'); ?>> 写真4
                            <input type="checkbox" id="ckImage[]" name="ckImage[]" value="5" <?php echo set_checkbox('ckImage[]', '5'); ?>> 写真5
                            <input type="checkbox" id="ckImage[]" name="ckImage[]" value="6" <?php echo set_checkbox('ckImage[]', '6'); ?>> 写真6
                          </p>
                          <p><input type="button" id="btnDelete" value="　写真を削除　" onclick="deleteImage()"></p>
                          <p>JPEGファイル：<input type="file" id="flUpload" name="flUpload" onchange="chooseImage();"></p>
                          <b>画像サイズは、横350px 縦150pxでお願いします。</b>
                          <input type="hidden" id="hdImage1" name ="hdImage1" value="<?php echo set_value('hdImage1',$image1);?>" />
                          <input type="hidden" id="hdImage2" name ="hdImage2" value="<?php echo set_value('hdImage2',$image2);?>"/>
                          <input type="hidden" id="hdImage3" name ="hdImage3" value="<?php echo set_value('hdImage3',$image3);?>"/>
                          <input type="hidden" id="hdImage4" name ="hdImage4" value="<?php echo set_value('hdImage4',$image4);?>"/>
                          <input type="hidden" id="hdImage5" name ="hdImage5" value="<?php echo set_value('hdImage5',$image5);?>"/>
                          <input type="hidden" id="hdImage6" name ="hdImage6" value="<?php echo set_value('hdImage6',$image6);?>"/>
                          <p>メイン画像：
                            <select name="main_image" id="main_image" >
                              <?php for($i=1; $i<=6; $i=$i+1) { ?>
                                <option <?php
                                if ($i == $hdmain_image) {
                                    echo 'selected';
                                }
                                ?> value="<?php echo $i ?>" <?php echo set_select('mainImage', $i); ?>><?php echo '写真'.$i ?></option>
                               <?php } ?>
                            </select>
                          </p>
                        </center>
                      </td>
                </tr>
              </table>
            </div>
            <br>
            <input type="hidden" id="hdError" name="hdError" value="<?php echo $hdError;?>" />
            <div class="list-t-center"><input type="submit" id="update_info" value="　登録　" /></div>
<br >
        </form>
    </div><!-- / .contents-box-wrapper -->
    </div><!-- list-box ここまで -->
<?php } ?>
