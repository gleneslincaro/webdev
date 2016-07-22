<script type="text/javascript">
  $(document).ready(function(){
    $('#areas').change();
    <?php if(isset($city)): ?>
      cityValue = "<?php echo $city; ?>";
      var value = {value:cityValue, id: 'cities'};
      getList(value);
    <?php endif ?>


    displayPopupError();
    loadImage();
    happyPayMoney();

    if($('#ckAccept').is(':checked'))
    {
      $('#btnRegist').attr('disabled',false);
      $("#btnRegist").removeAttr('disabled');
    }
    else{
      $('#btnRegist').attr("disabled",true);
    }

    if ($.browser.msie){
      if($.browser.version == 8){
         $('#txtPassword').attr('size',61);
      } else if($.browser.version == 9){
         $('#txtPassword').attr('size',61);
      } else if($.browser.version == 10){
         $('#txtPassword').attr('size',61);
      }
    }

    $('.file_attachment').change(function(){
        $('#fileAttachment').val('');
        var upload_action = baseUrl + "owner/login/documentCheckAjx";
        $('#loginCompany').ajaxSubmit({
            url: upload_action,
            dataType:'json',
            success: function(responseText, statusText, xhr, $form){
                if (responseText.err) {
                    alert(responseText.err);
                }

                $('#fileAttachment').val(responseText.err);
            }
        });
    });

    $('#btnRegist').click(function(){
        if ($('#fileAttachment').val()) {
            alert($('#fileAttachment').val());
            return false;
        }
    });

  });

  function getList(e) {
    var cityValue = '';
    var townValue = '';
    <?php if(isset($city)): ?>
      cityValue = "<?php echo $city; ?>";
    <?php endif ?>
    <?php if(isset($town)): ?>
      townValue = "<?php echo $town; ?>";
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
      url: '<?php echo base_url().'owner/login/getDataList'?>',
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

  function displayPopupError(){
      var div_error = $(".hide-error");
      if(div_error.length > 0){
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

  function showBtnRegist() {
    if($('#ckAccept').is(':checked')) {
      $('#btnRegist').attr('disabled',false);
      $("#btnRegist").removeAttr('disabled');
    }
    else {
      $('#btnRegist').attr("disabled",true);
    }
  }

  function loadImage() {
    path = baseUrl + "/public/owner/uploads/tmp/";
    if($('#hdError').val()==1) {
      for(i=1; i<=6; i++) {
        if($("#hdImage" + i).val()!='') {
          $("#image" + i).attr("src", $("#hdImage" + i).val());
        }
      }
    }
  }

  function chooseImage() {

    var noImage = "no_image.jpg";
    var upload_action = baseUrl + "owner/login/fileUploadAjx";

    $('#loginCompany').ajaxSubmit({
      url: upload_action,
      dataType:'json',
      success: function(responseText, statusText, xhr, $form){
        if(responseText.error !=null) {
          alert(responseText.error);
        }
        else {
          if($("#image1").attr("src").substr($("#image1").attr("src").lastIndexOf("/") +1) == noImage) {
            $("#image1").attr("src", responseText.url);
            $("#hdImage1").val(responseText.url);
          }
          else if($("#image2").attr("src").substr($("#image2").attr("src").lastIndexOf("/") +1) == noImage) {
            $("#image2").attr("src", responseText.url);
            $("#hdImage2").val(responseText.url);
          }
          else if($("#image3").attr("src").substr($("#image3").attr("src").lastIndexOf("/") +1) == noImage) {
            $("#image3").attr("src", responseText.url);
            $("#hdImage3").val(responseText.url);
          }
          else if($("#image4").attr("src").substr($("#image4").attr("src").lastIndexOf("/") +1) == noImage) {
            $("#image4").attr("src", responseText.url);
            $("#hdImage4").val(responseText.url);
          }
          else if($("#image5").attr("src").substr($("#image5").attr("src").lastIndexOf("/") +1) == noImage) {
            $("#image5").attr("src", responseText.url);
            $("#hdImage5").val(responseText.url);
          }
          else if($("#image6").attr("src").substr($("#image6").attr("src").lastIndexOf("/") +1) == noImage) {
            $("#image6").attr("src", responseText.url);
            $("#hdImage6").val(responseText.url);
          }
        }
      }
    });
  }

  function deleteImage() {
    var path = baseUrl + "/public/owner/images/no_image.jpg";
    var imageArr = new Array();
    var imagePath = new Array();
    var checkDel = new Array()
    var n=0;
    var flag = false;

    $.each($("input[name='ckImage[]']:checked"), function() {
      i = $(this).attr('value');
      checkDel[i]=i;
      flag = true;
    });

    if(!flag){
      alert('チェックボックスが選択されておりません。対象を選択して下さい。');
      return false;
    }

    if(!confirm('削除しますか？')) {
      return false;
    }

    for(i=1 ; i<=6; i++) {
      if(!checkDel[i] && ($("#image" + i).attr("src")!= path) ) {
        imageArr[n] = $("#image" + i).attr("src");
        imagePath[n++] = $("#hdImage" + i).val();
      }
    }

    for(i = imageArr.length; i<6; i++) {
      imageArr[i] = path;
      imagePath[i] = '';
    }

    for(i=1; i<=6; i++) {
      $("#image" + i).attr("src",imageArr[i-1]);
      $("#hdImage" + i).val(imageArr[i - 1]);
    }
    return true;
  }

  function happyPayMoney() {
    var id = $("#sltHappyMoney").val();
    var action = baseUrl + "owner/login/happyMoneyPayUser";

    $.ajax({
      type: "POST",
      dataType : "json",
      async : true,
      url: action,
      data: { id: id },
      datatyle: 'json',
      success:function(data) {
        if(data != null) {
          $("#lbHappyPayMoney").html(data.user_happy_money + '円');
        }

      }
    });
  }
</script>

<div class="list-box"><!-- list-box ここから -->


    <div class="list-title">■掲載お申し込みフォーム</div>
    <?php echo Helper::print_error($message); ?>
    <div class="list-t-center">
	<br >
	joyspe　ご利用にあたり下記情報を登録して頂く必要が御座います。全てご記入下さい。<br ><br >
    </div>

    <form id="loginCompany" name="loginCompany" method="post" action="<?php echo base_url(); ?>owner/login/login_company" enctype="multipart/form-data">

    <div class="sign_up_box">
	<table class="sign_up">
            <tr>
                <td>*メールアドレス</td><td>
                    <input type="text" id="txtEmailAddress" name="txtEmailAddress" size="60"
                           value="<?php echo set_value('txtEmailAddress'); ?>"><br >
                ※ログインする際とサイトからのメッセージを受け取るためのメールアドレスをご入力ください。<br >
                </td>
            </tr>
            <tr>
                <td>*パスワード</td>
                <td>
                    <input type="password" id="txtPassword" name="txtPassword" size="60"
                           value="<?php echo set_value('txtPassword'); ?>">
                </td>
            </tr>
            <tr>
              <td>*エリア地域</td>
              <td>
                <select name="city_group_id" id="areas" onchange="getList(this)" style="min-width: 150px;">
                  <option value=""></option>
                  <?php foreach ($city_groups as $key => $value) { ?>
                      <option
                        value="<?php echo $value['id'] ?>" <?php echo set_select('city_group_id', $value['id']); ?>><?php echo $value['name'] ?>
                      </option>
                  <?php } ?>
                </select>
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
                <input type="text" id="txtTitle" name="txtTitle" size="60" value ="<?php echo set_value('txtTitle'); ?>">
              </td>
            </tr>
            <tr>
                <td>*店舗名</td>
                <td>
                    <input type="text" id ="txtStoreName" name="txtStoreName" size="60"
                           value ="<?php echo set_value('txtStoreName'); ?>">
                </td>
            </tr>
            <tr>
              <td>*住所</td><td><input type="text" id="txtAddress" name="txtAddress" size="60" value ="<?php echo set_value('txtAddress'); ?>"><br >
                  ※都道府県、区市町村、番地、建物名、階数　全てご記入下さい。
              </td>
            </tr>
            <tr>
              <td>*業種</td>
              <td>
                <select name="ckJobType" id="ckJobType">
                  <?php foreach ($jobTypes as $key => $value): ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo set_select('ckJobType', $value['id']); ?>><?php echo $value['name']; ?>　</option>
                  <?php endforeach ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>*勤務地</td>
              <td>
                <input type="text" id ="txtWorkPlace" name="txtWorkPlace" size="60" value ="<?php echo set_value('txtWorkPlace'); ?>">
              </td>
            </tr>
            <tr>
              <td>*勤務日</td>
              <td>
                <input type="text" id ="txtWorkingDay" name="txtWorkingDay" size="60" value ="<?php echo set_value('txtWorkingDay'); ?>">
              </td>
            </tr>
            <tr>
              <td>*勤務時間</td>
              <td>
                <input type="text" id ="txtWorkingTime" name="txtWorkingTime" size="60" value ="<?php echo set_value('txtWorkingTime'); ?>">
              </td>
            </tr>
            <tr>
              <td>*交通</td>
              <td>
                <textarea id ="txtHowToAccess" name="txtHowToAccess" cols="60" rows="4"><?php echo set_value('txtHowToAccess'); ?></textarea>
              </td>
            </tr>
            <tr>
              <td>*給与</td>
              <td>
                <textarea id ="txtSalary" name="txtSalary" cols="60" rows="4"><?php echo set_value('txtSalary');?></textarea>
              </td>
            </tr>
            <tr>
              <td>*応募資格</td>
              <td>
                <textarea id ="txtConToApply" name="txtConToApply" cols="60" rows="4"><?php echo set_value('txtConToApply'); ?></textarea>
              </td>
            </tr>
            <tr>
                <td>入店特典</td>
                <td>
                    <p style="text-align:left;">タイトル <input type="text" name="visiting_benefits_title_1" value="<?php echo set_value('visiting_benefits_title_1'); ?>"></p>
                    <p style="text-align:left;">テキスト <textarea name="visiting_benefits_content_1" style="resize:none; width: 440px; height:50px; vertical-align: top;"><?php echo set_value('visiting_benefits_content_1'); ?></textarea></p>
                    <p style="text-align:left;">タイトル <input type="text" name="visiting_benefits_title_2" value="<?php echo set_value('visiting_benefits_title_2'); ?>"></p>
                    <p style="text-align:left;">テキスト <textarea name="visiting_benefits_content_2" style="resize:none; width: 440px; height:50px; vertical-align: top;"><?php echo set_value('visiting_benefits_content_2'); ?></textarea></p>
                    <p style="text-align:left;">タイトル <input type="text" name="visiting_benefits_title_3" value="<?php echo set_value('visiting_benefits_title_3'); ?>"></p>
                    <p style="text-align:left;">テキスト <textarea name="visiting_benefits_content_3" style="resize:none; width: 440px; height:50px; vertical-align: top;"><?php echo set_value('visiting_benefits_content_3'); ?></textarea></p>
                </td>
            </tr>
              <tr>
              <td>待遇</td>
              <td>
                <center>
                <div class="check_box">
                <?php
                  $n = 0;
                  foreach($treatments as $key => $value) { ?>
                    <input type="checkbox" name="ckTreatMents[]" value="<?php echo $value['id']; ?>" <?php echo set_checkbox('ckTreatMents[]', $value['id']); ?>><?php echo $value['name']; ?>　
                <?php
                  $n++;
                  if($n >=4)
                  {
                    $n=0;
                    echo "<br />";
                  }
                }?>
                </div>
                </center>
              </td>
            </tr>
            <tr>
              <td>*お店からのメッセージ</td>
              <td>
              <textarea name="txtShopInfo" rows="10" cols="53" ><?php echo set_value('txtShopInfo'); ?></textarea>
              </td>
            </tr>
            <tr>
              <td>*応募時間</td>
              <td>
                <input type="text" id="txtTimeOfApply" name="txtTimeOfApply" size="60" value ="<?php echo set_value('txtTimeOfApply'); ?>">
              </td>
            </tr>
            <tr>
              <td>*応募用電話番号</td>
              <td>
                <input type="text" id="txtTelForApp" name="txtTelForApp" size="60" value ="<?php echo set_value('txtTelForApp'); ?>">
              </td>
            </tr>
            <tr>
              <td>*応募用メールアドレス</td>
              <td>
                <input type="text" id="txtMailForApp" name="txtMailForApp" size="60" value ="<?php echo set_value('txtMailForApp'); ?>"><br >
                ※店舗情報にて公開されます。ユーザーが応募してくるメールアドレスになります。<br >
              </td>
            </tr>
            <tr>
                <td>お問い合わせ通知用のメールアドレス</td>
                <td>
                    <input type="text" id="txtMailForReply" name="txtMailForReply" size="60" value ="<?php echo set_value('txtMailForReply'); ?>">
                </td>
            </tr>
            <tr>
              <td>*オフィシャルHP</td>
              <td>
                <input type="text" id="txtHomePageUrl" name="txtHomePageUrl" size="60" value ="<?php echo set_value('txtHomePageUrl'); ?>">
              </td>
            </tr>
            <tr>
              <td>LINEID</td>
              <td>
                <input type="text" id="txtLineId" name="txtLineId" size="60" value ="<?php echo set_value('txtLineId'); ?>">
              </td>
            </tr>
            <tr>
                <td>LINE URL登録</td>
                <td>
                    <input type="text" id="txt_line_url" name="txt_line_url" size="60" value ="<?php echo set_value('txt_line_url'); ?>">
                </td>
            </tr>
            <tr>
              <td>イメージ写真</td>
              <td>
                <center>
                  <div class="photo_box">
                      <div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" src="<?php  $url = '';
                            empty($image1)?
                                          $url = $imagePath . '/no_image.jpg' :
                                          $url = $image1;
                            echo $url; ?>"></div>
                      <div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" src="<?php $url = '';
                            empty($image2)?
                                          $url = $imagePath . '/no_image.jpg' :
                                          $url = $image2;
                            echo $url; ?>"></div>
                      <div class="photo"><img id="image3" name="image3" width="100" src="<?php $url = '';
                            empty($image3)?
                                          $url = $imagePath . '/no_image.jpg' :
                                          $url = $image3;
                            echo $url; ?>"></div>
                      <br style="clear:both;">
                  </div>
                  <div class="photo_box">
                      <div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" src="<?php $url = '';
                            empty($image4)?
                                          $url = $imagePath . '/no_image.jpg' :
                                          $url = $image4;
                            echo $url; ?>"></div>
                      <div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" src="<?php $url = '';
                            empty($image5)?
                                          $url = $imagePath . '/no_image.jpg' :
                                          $url = $image5;
                            echo $url; ?>"></div>
                      <div class="photo"><img id="image6" name="image6" width="100" src="<?php $url = '';
                            empty($image6)?
                                          $url = $imagePath . '/no_image.jpg' :
                                          $url = $image6;
                            echo $url; ?>"></div>
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
                  <b>画像サイズは、横350px 縦150pxでお願いします。</b>
                  <p>JPEGファイル：<input type="file" id="flUpload" name="flUpload" onchange="chooseImage();"></p>
                  <input type="hidden" id="hdImage1" name ="hdImage1" value="<?php echo set_value('hdImage1',$image1);?>" >
                  <input type="hidden" id="hdImage2" name ="hdImage2" value="<?php echo set_value('hdImage2',$image2);?>">
                  <input type="hidden" id="hdImage3" name ="hdImage3" value="<?php echo set_value('hdImage3',$image3);?>">
                  <input type="hidden" id="hdImage4" name ="hdImage4" value="<?php echo set_value('hdImage4',$image4);?>">
                  <input type="hidden" id="hdImage5" name ="hdImage5" value="<?php echo set_value('hdImage5',$image5);?>">
                  <input type="hidden" id="hdImage6" name ="hdImage6" value="<?php echo set_value('hdImage6',$image6);?>">

                  <p>メイン画像：
                      <select name="sltImageDefault">
                      <option value="1" <?php echo set_select('sltImageDefault', '1'); ?>>写真1</option>
                      <option value="2" <?php echo set_select('sltImageDefault', '2'); ?>>写真2</option>
                      <option value="3" <?php echo set_select('sltImageDefault', '3'); ?>>写真3</option>
                      <option value="4" <?php echo set_select('sltImageDefault', '4'); ?>>写真4</option>
                      <option value="5" <?php echo set_select('sltImageDefault', '5'); ?>>写真5</option>
                      <option value="6" <?php echo set_select('sltImageDefault', '6'); ?>>写真6</option>
                      </select>
                  </p>
                </center>
             </td>
            </tr>
            <tr>
              <td>届出書</td>
              <td>
                <div class="fileDisplay" style="display: none;">
                    1. <span></span>
                </div>
                <input type="hidden" id="fileAttachment" name ="fileAttachment" value="<?php echo set_value('fileAttachment'); ?>" >
                <input type="file" name="file_attachment" class="file_attachment"><br>
                提出可能ファイルタイプ: pdf, doc, docx, xlsx , xls , xlw, jpg, gif, png
              </td>
              <!--
			  <tr>
                <td>ご紹介店舗名</td>
                <td><input type="text" name="campaign_note" value="<?php echo set_value('campaign_note'); ?>" style="width: 450px;"></td>
              </tr>
			  -->
            </tr>
    </table>
    </div>
    <br >
    <div class="list-t-center">
	※ご登録には、規約に同意して頂く必要があります。<br >
        <input type="checkbox" id="ckAccept" name="ckAccept" <?php if(isset($_POST['ckAccept'])) echo "checked"; ?> onclick="showBtnRegist();">規約に同意する<br ><br >

	<input type="submit" id="btnRegist" name="btnRegist" value="登録" style="width:150px; height:40px;"></button>

    </div>
    <div class="sign_up_box">

        <p><iframe src="<?php echo $frame; ?>" class="example1"></iframe></p>

    </div>
    </form>
</div><!-- list-box ここまで -->
