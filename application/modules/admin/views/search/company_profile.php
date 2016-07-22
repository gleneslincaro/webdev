<script type="text/javascript">
    //$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
    $(document).ready(function(){
        $( "#txtDatePickerCreatedDate" ).datepicker({ dateFormat: "yy/mm/dd" });
        var flag =$("#txtflag").val();
        var base = $("#base").attr("value");
        var owid = $('#txtowid').val();
        var orid = $('#txtorid').val();
        var image1 = $('#hdImage1').val();
        var image2 = $('#hdImage2').val();
        var image3 = $('#hdImage3').val();
        var image4 = $('#hdImage4').val();
        var image5 = $('#hdImage5').val();
        var image6 = $('#hdImage6').val();
        var city_group_id = "<?php echo $city_group_id; ?>";
        var city_id = "<?php echo $city_id; ?>";
        var town_id = "<?php echo $town_id; ?>";

        var title = $("#txtTitle").val();
        var storename = encodeURIComponent($("#txtStoreName").val());
        var address = $("#txtAddress").val();
        var set_send_mail = $('[name="set_send_mail"]:radio:checked').val();
        var public_info_flag = $('[name="public_info_flag"]:radio:checked').val();
        var txtjobtype = $("#ckJobType").val();
        var work_place = $("#txtWorkPlace").val();
        var working_day = $("#txtWorkingDay").val();
        var working_time = $("#txtWorkingTime").val();
        var how_to_access = $("#txtHowToAccess").val();
        var salary = $("#txtSalary").val();
        var con_to_apply = $("#txtConToApply").val();
        var treat = $("#txttreat").val();
        var company_info = $("#txtShopInfo").val();
        var apply_time = $("#txtTimeOfApply").val();
        var apply_tel = $("#txtTelForApp").val();
        var apply_emailaddress = $("#txtMailForApp").val();
        var new_msg_notify_email = $("#txtMailForReply").val();
        var home_page_url = $("#txtHomePageUrl").val();
        var line_id = $("#txtLineId").val();
        var sltmainimg = $('#txtmainimg').val();
        var scout_pr_text = $("#txtScoutPrText").val();
        var category_group_city = $("#category_group_city").val();
        var created_date = $("#txtDatePickerCreatedDate").val();
        var all_category = '';
        $('.box_category_town').find('input:hidden').each(function() {
            all_category += $(this).val() + ',';
        });
        if (flag!=null && flag!=""){
            //alert(flag);
            bol=window.confirm("登録しますか？");
            if(bol==true){
                $("#txtflag").val("");
                $.ajax({
                    url:base+"admin/search/updateComPro",
                    type:"post",
                    data:"txtowid="+owid+"&txtorid="+orid+"&hdImage1="+image1+"&hdImage2="+image2+"&hdImage3="+image3+"&hdImage4="+image4
                    +"&hdImage5="+image5+"&hdImage6="+image6+"&txtmainimg="+sltmainimg+"&txtjobtype="+txtjobtype+"&txttreat="+treat
                    +"&city_group_id="+city_group_id+"&city_id="+city_id+"&town_id="+town_id+"&title="+title+"&storename="+storename
                    +"&address="+address+"&set_send_mail="+set_send_mail+"&public_info_flag="+public_info_flag+"&work_place="+work_place
                    +"&working_day="+working_day+"&working_time="+working_time+"&how_to_access="+how_to_access+"&salary="+salary
                    +"&con_to_apply="+con_to_apply+"&company_info="+company_info+"&apply_time="+apply_time+"&apply_tel="+apply_tel
                    +"&apply_emailaddress="+apply_emailaddress+"&home_page_url="+home_page_url+"&line_id="+line_id
                    +"&scout_pr_text="+scout_pr_text+"&new_msg_notify_email="+new_msg_notify_email+"&created_date="+created_date+"&all_category="+all_category,
                    async:true,
                    success:function(kq){
                        window.location=base+"admin/search/complete";
                    },
                })
            }
        }

        $("#txtDatePickerCreatedDate").change(function() {
            var createdDate = $("#txtDatePickerCreatedDate").val();            
            if(createdDate!="" && !createdDate.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $('#txtDatePickerCreatedDate').val("");
            }
        });

        $('.category_delete').live('click', function(){
            $(this).parent('div').remove();
            return false;
        });

        $('#category_add').click(function(){
            var category_selected = $('.selected_category_town').val();
            var owner_town = $('#towns').val();
            var err = false;

            $('.box_category_town').find('input:hidden').each(function() {
                if (category_selected == $(this).val()) {
                    err = true;
                }
            });

            if (category_selected == owner_town) {
                err = true;
            }

            if (err) {
                alert('既に登録済のエリア都市です。');
                return false;
            }

            var cityValue = $('.selected_category_town').val();
            var city_text = $(".selected_category_town option:selected").text();
            if (!cityValue || !city_text) {
                alert('エリア都市を選択してください。');
            } else {
                $('.box_category_town').append('<div style="float:left; padding-left: 5px;"><input type="hidden" name="category_town[]" value="' + cityValue + '"><input class="category_town" style="width: 134px;" value="' + city_text + '" disabled> <button class="category_delete">X</button></div>');    
            }

            return false;
        });
    })
    function deleteImage()
    {
        var base = $("#base").attr("value");
        var path = base + "/public/owner/images/no_image.jpg";
        var imageArr = new Array();
        var imagePath = new Array();
        var checkDel = new Array()
        var n=0;
        var flag = false;
        $.each($("input[name='cknImage[]']:checked"), function() {
            i = $(this).attr('value');
            checkDel[i]=i;
            flag = true;
        });

        if (!flag) {
            alert('チェックボックスが選択されておりません。対象を選択して下さい。');
            return false;
        }

        if(!confirm('削除しますか？'))
        {
            return false;
        }

        for(i=1 ; i<=6; i++)
        {
           if(!checkDel[i] && ($("#image" + i).attr("src")!= path) )
            {
                imageArr[n] = $("#image" + i).attr("src");
                imagePath[n++] = $("#hdImage" + i).val();
            }
        }

        for(i = imageArr.length; i<6; i++)
        {
            imageArr[i] = path;
            imagePath[i] = '';
        }

        for(i=1; i<=6; i++)
        {
            $("#image" + i).attr("src",imageArr[i-1]);
            $("#hdImage" + i ).val(imagePath[i-1]);
        }
        return true;
    }

    $(document).ready(function() {
        $("#areas").find("option").each(function () {
            if ($(this).val() == "<?php echo $city_group_id; ?>") {
              $(this).prop("selected", "selected");
            }
          });

          $('#areas').change();
          <?php if(isset($city_id)): ?>
            cityValue = "<?php echo $city_id; ?>";
            var value = {value:cityValue, id: 'cities'};
            getList(value);
          <?php endif ?>
    });
    function getList(e) {
        var cityValue = '';
        var townValue = '';
        <?php if(isset($city_id)): ?>
          cityValue = "<?php echo $city_id; ?>";
        <?php endif ?>
        <?php if(isset($town_id)): ?>
          townValue = "<?php echo $town_id; ?>";
        <?php endif ?>
        if(e.id == 'areas') {
            var output = 'cities';
            var type = 'city_group';
            $('#towns').html("<option value=''></option>");
        }
        else if (e.id == 'cities') {
            var output = 'towns';
            var type = 'city';
        } else if(e.id == 'category_group_city') {
            var output = 'category_city';
            var type = 'city_group';
            $('.category_town').html("<option value=''></option>");
            $('.selected_category_town').html("<option value=''></option>");
        }else if(e.id == 'category_city') {
            var output = 'selected_category_town';
            var type = 'city';
        }

        $.ajax({
            url: '<?php echo base_url().'admin/search/getDataList'?>',
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

              if (e.id == 'category_group_city' ||  e.id == 'category_city') {
                $('.' + output).html(optionList);
              } else {
                $('#'+output).html(optionList);
              }

            }
        });
    }
</script>

<?php foreach ($cominfo as $k=>$com) : ?>
  <form action="<?php echo base_url().'admin/search/company_Profile/'.$com['orid']; ?>" method='post'  enctype='multipart/form-data' id='form_ow2'>
    <input type="hidden" value="<?php echo $com['oid']; ?>" id="txtowid" name="txtowid" />
    <input type="hidden" value="<?php echo $com['orid']; ?>" id="txtorid" name="txtorid" />
    <input type="hidden" id='txtflag' value="<?php if(isset($flag)) echo $flag; ?>" />
    <center>
      <table width="40%" border="">
        <tr>
          <td>メールアドレス</td>
          <td><?php echo $com['email_address']; ?></td>
        </tr>
        <tr>
          <td>店舗名</td>
          <td><?php echo $com['storename']; ?></td>
        </tr>
      </table>
      <p>プロフィール</p>
    </center>
    <table width="90%" border="">
      <tr>
        <td>*作成日（表示順関連）</td>
        <td><input type="text" name="txtDatePickerCreatedDate" size="30" id="txtDatePickerCreatedDate" value="<?php echo isset($txtDatePickerCreatedDate)?$txtDatePickerCreatedDate:$com['orc_created_date']; ?>" maxlength="20"></td>
      </tr>
      <tr>
        <td>*エリア地域</td>
        <td>
          <select name="city_group_id" id="areas" onchange="getList(this)" style="min-width: 150px;">
            <option value=""></option>
            <?php foreach ($city_groups as $key => $value) { ?>
                <option
                  value="<?php echo $value['id'] ?>" <?php echo set_select('city_group_id', $com['city_group_id']); ?>><?php echo $value['name'] ?>
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
          <input type="text" id="txtTitle" name="txtTitle" size="60" value ="<?php echo set_value('txtTitle', $com['title']); ?>">
        </td>
      </tr>
      <tr>
        <td>*店舗名</td>
        <td>
          <input type="text" id="txtStoreName" name="txtStoreName" size="60" value ="<?php echo set_value('txtStoreName', $com['storename']); ?>">
        </td>
      </tr>
      <tr>
        <td>*住所</td>
        <td>
          <input type="text" id="txtAddress" name="txtAddress" size="60" value ="<?php echo set_value('txtAddress', $com['address']); ?>"><br >
        </td>
      </tr>
      <tr>
        <td>*転送設定</td>
        <td>
          <input type="radio" name="set_send_mail" id="set_send_mail" value="1" <?php if ($com['set_send_mail'] == 1) echo "checked"; ?>> ON
          <input type="radio" name="set_send_mail" id="set_send_mail" value="0" <?php if ($com['set_send_mail'] == 0) echo "checked"; ?>> OFF
        </td>
      </tr>
      <tr>
        <td>店舗情報公開</td>
        <td>
          <input type="radio" name="public_info_flag" id="public_info_flag" value="1" <?php if ($com['public_info_flag'] == 1) echo "checked"; ?>>公開
          <input type="radio" name="public_info_flag" id="public_info_flag" value="0" <?php if ($com['public_info_flag'] == 0) echo "checked"; ?>>非公開
        </td>
      </tr>
      <tr>
        <td>*業種</td>
        <td>
          <select name="ckJobType" id="ckJobType">
            <?php foreach ($job as $key => $value): ?>
              <option
                <?php if($value['id'] == $ckjobTypeOwnerRecruit) echo "selected"; ?>
                value="<?php echo $value['id']; ?>" <?php echo set_select('ckJobType', $value['id']); ?>><?php echo $value['name']; ?>　</option>
            <?php endforeach ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>*勤務地</td>
        <td>
          <input type="text" id ="txtWorkPlace" name="txtWorkPlace" size="60" value ="<?php echo set_value('txtWorkPlace', $com['work_place']); ?>">
        </td>
      </tr>
      <tr>
        <td>*勤務日</td>
        <td>
          <input type="text" id ="txtWorkingDay" name="txtWorkingDay" size="60" value ="<?php echo set_value('txtWorkingDay', $com['working_day']); ?>">
        </td>
      </tr>
      <tr>
        <td>*勤務時間</td>
        <td>
          <input type="text" id ="txtWorkingTime" name="txtWorkingTime" size="60" value ="<?php echo set_value('txtWorkingTime', $com['working_time']); ?>">
        </td>
      </tr>
      <tr>
      <td>*交通</td>
        <td>
          <textarea rows="4" id ="txtHowToAccess" name="txtHowToAccess" cols="60"><?php echo set_value('txtHowToAccess', $com['how_to_access']);?></textarea>
        </td>
      </tr>
      <tr>
        <td>*給与</td>
        <td>
          <textarea rows="4" id ="txtSalary" name="txtSalary" cols="60"><?php echo set_value('txtSalary', $com['salary']); ?></textarea>
        </td>
      </tr>
      <tr>
        <td>*応募資格</td>
        <td>
          <textarea rows="4"id ="txtConToApply" name="txtConToApply" cols="60"><?php echo set_value('txtConToApply', $com['con_to_apply']); ?></textarea>
        </td>
      </tr>
      <tr>
        <td>待遇</td>
        <td>
          <center>
            <?php
              $cou = 0;
              foreach($alltre as $k=>$all){
                $cou++;
                echo "<input type='checkbox' name='cbkalltre[]' value='".$all["id"]."'";
                if(isset($treatarray)){
                     foreach ($treatarray as $k=>$tr2){
                        if($all["id"]==$tr2){
                            echo "checked='checked'";
                        }
                        }
                }else{
                    foreach ($tre as $k=>$tr){
                        if($all["id"]==$tr["id"]){
                            echo "checked='checked'";
                        }
                    }
                }

                echo ">".$all["name"];
                if ($cou == 4) {
                  echo "<br/>";
                  $cou = 0;
                }
              }
              echo "<input type='hidden' id='txttreat' value='";
                if(isset($treat)){
                    echo $treat;
                }
              echo"' >";
            ?>
          </center>
        </td>
      </tr>
      <tr>
        <td>*お店からのメッセージ</td>
        <td>
        <textarea name="txtShopInfo" id="txtShopInfo" rows="10" cols="53" ><?php echo set_value('txtShopInfo', $com['company_info']); ?></textarea>
        </td>
      </tr>
      <tr>
        <td>*応募時間</td>
        <td>
          <input type="text" id="txtTimeOfApply" name="txtTimeOfApply" size="60" value ="<?php echo set_value('txtTimeOfApply', $com['apply_time']); ?>">
        </td>
      </tr>
      <tr>
        <td>*応募用電話番号</td>
        <td>
          <input type="text" id="txtTelForApp" name="txtTelForApp" size="60" value ="<?php echo set_value('txtTelForApp', $com['apply_tel']); ?>">
        </td>
      </tr>
      <tr>
        <td>*応募用メールアドレス</td>
        <td>
          <input type="text" id="txtMailForApp" name="txtMailForApp" size="60" value ="<?php echo set_value('txtMailForApp', $com['apply_emailaddress']); ?>">
        </td>
      </tr>
      <tr>
          <td>お問い合わせ通知用のメールアドレス</td>
          <td>
              <input type="text" id="txtMailForReply" name="txtMailForReply" size="60" value ="<?php echo set_value('txtMailForReply', $com['new_msg_notify_email']); ?>">
          </td>
      </tr>

      <tr>
        <td>*オフィシャルHP</td>
        <td>
          <input type="text" id="txtHomePageUrl" name="txtHomePageUrl" size="60" value ="<?php echo set_value('txtHomePageUrl', $com['home_page_url']); ?>">
        </td>
      </tr>
      <tr>
        <td>LINEID</td>
        <td>
          <input type="text" id="txtLineId" name="txtLineId" size="60" value ="<?php echo set_value('txtLineId', $com['line_id']); ?>">
        </td>
      </tr>
      <tr>
        <td width="100px"><span class="scolum">イメージ写真</span></td>
        <td align="center">
          <?php echo '<div class="photo_box">';
            if($com["image1"]=="" && $com["image1"]==null){
                if(isset($image1) && $image1!=""){
                    echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image1.'" /></div>';
                }else{
                    echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
            }else{
                if(isset($image1)&& $image1!=""){
                    if($image1==$com["image1"]){
                        echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" src="'. base_url()."public/owner/uploads/images/".$image1.'" /></div>';
                    }else{
                        echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image1.'" /></div>';
                    }
                }else if(isset($image1)&& $image1==""){
                     echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
                else{
                    echo '<div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" src="'. base_url()."public/owner/uploads/images/".$com["image1"].'" /></div>';
                }
            }
            if($com["image2"]=="" && $com["image2"]==null){
               if(isset($image2) && $image2!=""){
                    echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image2.'" /></div>';
                }else{
                    echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
            }else{
                if(isset($image2) && $image2!=""){
                    if($image2==$com["image2"]){
                         echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" src="'. base_url()."public/owner/uploads/images/".$image2.'" /></div>';
                    }else{
                        echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image2.'" /></div>';
                    }
                }else if(isset($image2) && $image2==""){
                    echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
                else{
                    echo '<div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" src="'.  base_url()."public/owner/uploads/images/".$com["image2"].'" /></div>';
                }
            }
            if($com["image3"]=="" && $com["image3"]==null){
               if(isset($image3) && $image3!=""){
                    echo '<div class="photo"><img id="image3" name="image3" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image3.'" /></div>';
                }else{
                    echo '<div class="photo"><img id="image3" name="image3" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
            }else{
                if(isset($image3) && $image3!=""){
                    if($image3==$com["image3"]){
                        echo '<div class="photo"><img id="image3" name="image3" width="100" src="'. base_url()."public/owner/uploads/images/".$image3.'" /></div>';
                    }else{
                        echo '<div class="photo"><img id="image3" name="image3" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image3.'" /></div>';
                    }
                }else if(isset($image3) && $image3==""){
                    echo '<div class="photo"><img id="image3" name="image3" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
                else{
                   echo '<div class="photo"><img id="image3" name="image3" width="100" src="'.  base_url()."public/owner/uploads/images/".$com["image3"].'"></div>';
                }
            }
            echo '<br style="clear:both;">
            </div>
            <div class="photo_box">';
            if($com["image4"]=="" && $com["image4"]==null){
                if(isset($image4) && $image4!=""){
                    echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image4.'" /></div>';
                }else{
                    echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }

            }else{
                if(isset($image4) && $image4!=""){
                     if($image4==$com["image4"]){
                        echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" src="'. base_url()."public/owner/uploads/images/".$image4.'" /></div>';
                    }else{
                        echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image4.'" /></div>';
                    }
                }else if(isset($image4) && $image4==""){
                    echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
                else{
                   echo '<div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" src="'.  base_url()."public/owner/uploads/images/".$com["image4"].'"></div>';
                }
            }
            if($com["image5"]=="" && $com["image5"]==null){
                 if(isset($image5) && $image5!=""){
                    echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image5.'" /></div>';
                }
                else{
                    echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
            }else{
                  if(isset($image5) && $image5!=""){
                     if($image5==$com["image5"]){
                        echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" src="'. base_url()."public/owner/uploads/images/".$image5.'" /></div>';
                    }else{
                        echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image5.'" /></div>';
                    }
                }else if(isset($image5) && $image5==""){
                    echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
                else{
                   echo '<div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" src="'.  base_url()."public/owner/uploads/images/".$com["image5"].'"></div>';
                }
            }
            if($com["image6"]=="" && $com["image6"]==null){
             if(isset($image6) && $image6!=""){
                    echo '<div class="photo"><img id="image6" name="image6" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image6.'" /></div>';
                }else{
                    echo '<div class="photo"><img id="image6" name="image6" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }

            }else{
                if(isset($image6) && $image6!=""){
                     if($image6==$com["image6"]){
                        echo '<div class="photo"><img id="image6" name="image6" width="100" src="'. base_url()."public/owner/uploads/images/".$image6.'" /></div>';
                    }else{
                        echo '<div class="photo"><img id="image6" name="image6" width="100" src="'. base_url()."public/owner/uploads/tmp/".$image6.'" /></div>';
                    }
                }else if(isset($image6) && $image6==""){
                     echo '<div class="photo"><img id="image6" name="image6" width="100" src="'.  base_url().'public/owner/images/no_image.jpg" /></div>';
                }
                else{
                  echo '<div class="photo"><img id="image6" name="image6" width="100" src="'.  base_url()."public/owner/uploads/images/".$com["image6"].'"></div>';
                }

            }
            echo '<br style="clear:both;">
            </div>
            <p>
                <input type="checkbox" id="cknImage[]" name="cknImage[]" value="1"> 写真1
                <input type="checkbox" id="cknImage[]" name="cknImage[]" value="2"> 写真2
                <input type="checkbox" id="cknImage[]" name="cknImage[]" value="3"> 写真3
                <input type="checkbox" id="cknImage[]" name="cknImage[]" value="4"> 写真4
                <input type="checkbox" id="cknImage[]" name="cknImage[]" value="5"> 写真5
                <input type="checkbox" id="cknImage[]" name="cknImage[]" value="6"> 写真6
            </p>
            <input type="button" value="　削除　" onclick="deleteImage()"><br>
            <p>JPEGファイル：<input type="file" name="flUpload" accept="image/jpeg" id="iuploadow2"></p>';
            if($com["image1"]==""){
            echo ' <input type="hidden" id="hdImage1" name ="hdImage1" value="';
                if(isset($image1)){
                    echo $image1;
                }
            echo '" >';
            }else{
            echo ' <input type="hidden" id="hdImage1" name ="hdImage1" value="';
                if(isset($image1)){
                    echo $image1;
                }else{
                    echo $com["image1"];
                }
                echo '" >';
            }
            if($com["image2"]==""){
                echo ' <input type="hidden" id="hdImage2" name ="hdImage2" value="';
                     if(isset($image2)){
                        echo $image2;
                     }
                echo'">';
            }else{
                echo ' <input type="hidden" id="hdImage2" name ="hdImage2" value="';
                 if(isset($image2)){
                    echo $image2;
                }else{
                    echo $com["image2"];
                }
                echo'">';
            }
            if($com["image3"]==""){
                echo ' <input type="hidden" id="hdImage3" name ="hdImage3" value="';
                      if(isset($image3)){
                        echo $image3;
                      }
                echo'">';
            }else{
                echo ' <input type="hidden" id="hdImage3" name ="hdImage3" value="';
                if(isset($image3)){
                    echo $image3;
                }else{
                    echo $com["image3"];
                }
                echo'">';
            }
            if($com["image4"]==""){
                echo ' <input type="hidden" id="hdImage4" name ="hdImage4" value="';
                     if(isset($image4)){
                        echo $image4;
                      }
                echo'">';
            }else{
                echo ' <input type="hidden" id="hdImage4" name ="hdImage4" value="';
                 if(isset($image4)){
                    echo $image4;
                }else{
                    echo $com["image4"];
                }
                echo'">';
            }
            if($com["image5"]==""){
                echo ' <input type="hidden" id="hdImage5" name ="hdImage5" value="';
                     if(isset($image5)){
                        echo $image5;
                    }
                echo'">';
            }else{
                echo ' <input type="hidden" id="hdImage5" name ="hdImage5" value="';
                     if(isset($image5)){
                        echo $image5;
                    }else{
                        echo $com["image5"];
                    }
                echo'">';
            }
            if($com["image6"]==""){
                echo ' <input type="hidden" id="hdImage6" name ="hdImage6" value="';
                    if(isset($image6)){
                        echo $image6;
                    }
                echo'">';
            }else{
                echo ' <input type="hidden" id="hdImage6" name ="hdImage6" value="';
                    if(isset($image6)){
                        echo $image6;
                    }else{
                        echo $com["image6"];
                    }
                echo'">';
            }
            echo '<p>メイン画像：
            <select name="sltmainimg">
            <option value="1"';
            if($com["main_image"]==1){
                echo "selected='selected'";
            }else if(isset($main) && $main==1){
                echo "selected='selected'";
            }
            echo '>写真1</option>
            <option value="2"';
            if($com["main_image"]==2){
                echo "selected='selected'";
            }else if(isset($main) && $main==2){
                echo "selected='selected'";
            }else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==2){
                 echo "selected='selected'";
            }
            echo '>写真2</option>
            <option value="3"';
            if($com["main_image"]==3){
                echo "selected='selected'";
            }else if(isset($main) && $main==3){
                echo "selected='selected'";
            }else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==3){
                 echo "selected='selected'";
            }
            echo '>写真3</option>
            <option value="4"';
            if($com["main_image"]==4){
                echo "selected='selected'";
            }else if(isset($main) && $main==4){
                echo "selected='selected'";
            }else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==4){
                 echo "selected='selected'";
            }
            echo '>写真4</option>
            <option value="5"';
            if($com["main_image"]==5){
                echo "selected='selected'";
            }else if(isset($main) && $main==5){
                echo "selected='selected'";
            }else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==5){
                 echo "selected='selected'";
            }
            echo '>写真5</option>
            <option value="6"';
            if($com["main_image"]==6){
                echo "selected='selected'";
            }else if(isset($main) && $main==6){
                echo "selected='selected'";
            }else if(isset($_POST["sltmainimg"]) && $_POST["sltmainimg"]==6){
                 echo "selected='selected'";
            }
            echo '>写真6</option>
            </select>';
            echo "<input type='hidden' name='txtmainimg' id='txtmainimg' value='";
                if(isset($sltmainimg)){
                    echo $sltmainimg;
                }
            echo"'>";
            echo '</p>';
            ?>
          </td>
      </tr>
        <td>スカウトメール自己PR文</td>
        <td>
          <textarea cols="60" rows="5" name="txtScoutPrText" id="txtScoutPrText"><?php echo set_value('txtScoutPrText', $com['scout_pr_text']); ?></textarea>
        </td>
      </tr>
      <tr>
            <th colspan="2">検索地域追加</th>
        </tr>
        <tr>
            <td width="100px">エリア地域</td>
            <td>
                <select id="category_group_city" name="category_group_city" onchange="getList(this)" style="min-width: 150px;">
                    <option></option>
                    <?php foreach ($all_citygroup as $value) : ?>
                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>エリア都道府県</td>
            <td>
                <select id="category_city" class="category_city" name="category_city" onchange="getList(this)" style="min-width: 150px;">
                    <option></option>
                    <?php foreach ($all_city as $value) : ?>
                        <?php if ($com['category_group_city_id'] == $value['city_group_id']) : ?>
                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>エリア都市</td>
            <td><select class="selected_category_town" name="selected_category_town" style="min-width: 150px;"></select> <button id="category_add">追加</button></td>
        <tr>
            <td colspan="2" height="25" class="box_category_town">
                <?php 
                    if ($_POST) {
                        $owner_category = array();
                        if (isset($_POST['category_town'])) {
                            foreach ($_POST['category_town'] as $key => $value) {
                                $owner_category[] = array('category_id' => $value);
                            }
                        }
                    }
                ?>
                <?php foreach ($owner_category as $cate) : ?>
                    <?php foreach ($all_towns as $value) : ?>
                        <?php if ($cate['category_id'] == $value['id']) : ?>
                            <div style="float:left; padding-left: 5px;">
                                <input type="hidden" name="category_town[]" value="<?php echo $value["id"]; ?>" >
                                <input class="category_town" style="width: 134px;" value="<?php echo $value['name']; ?>" disabled="disabled"> <button class="category_delete">X</button>
                            </div>
                        <?php break;
                            endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>
    <center>
      <p><input type="submit" value="　登録　" name="btnupown" /></p>
    </center>
  </form>
  <br>
  <br>
<?php endforeach ?>
