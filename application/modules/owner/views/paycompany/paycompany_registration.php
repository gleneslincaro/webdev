<script>
    $(document).ready(function(){
        $('span').hide();
        $('#areas').change()
        <?php if(isset($city)): ?>
          cityValue = "<?php echo $city; ?>";
          var value = {value:cityValue, id: 'cities'};
          getList(value);
        <?php endif ?>

        $("#confirm").click(function(){
            var upload_action = baseUrl + "owner/paycompany/checkinput";
            $('#paycompany').ajaxSubmit({
                url: upload_action,
                dataType:'json',
                success: function(responseText, statusText, xhr, $form){
                    $('.validation').html(responseText.err);
                    $('#box_send').hide();
                    $('#storename').parent('td').children('span').html($('#storename').val());
                    $('#tel').parent('td').children('span').html($('#tel').val());
                    $('#email').parent('td').children('span').html($('#email').val());
                    $('#person_in_charge').parent('td').children('span').html($('#person_in_charge').val());
                    $('#campaign_note').parent('td').children('span').html($('#campaign_note').val());

                    if (responseText.err == '') {
                        $('select, input[type=text]').hide();
                        $('#confirm').hide();
                        $('#box_send').show();
                        $('span').show();
                    }

                }
            });

            return false;
        });

        $('#send').click(function(){
            $(this).css({'pointer-events': 'none'});
        });

        $("#back").click(function(){
            $('select, input[type=text]').show();
            $('span').hide();
            $('#confirm').show();
            $('#box_send').hide();

            return false;
        });

        $('select').change(function(){
            $(this).parent('td').children('span').html($(this).find("option:selected").text());
            $(this).parent('td').children('input').val($(this).find("option:selected").text());
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
        if (e.id == 'areas') {
            var output = 'cities';
            var type = 'city_group';
            $('#towns').html("<option value=''></option>");
        } else if (e.id == 'cities') {
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
</script>
<div class="list-box">
    <div class="list-title">■掲載お申し込みフォーム</div>

    <div class="list-t-center">
    <br >
    joyspe　ご利用にあたり下記情報を登録して頂く必要が御座います。全てご記入下さい。<br ><br >
    </div>
    <form id="paycompany" method="post">
        <div class="validation" style="text-align: center; color: red;"></div>
        <div class="sign_up_box">
            <table class="sign_up">
                <tr>
                    <td width="134">*エリア地域</td>
                    <td>
                        <select name="city_group_id" id="areas" onchange="getList(this)" style="min-width: 150px;">
                            <option value=""></option>
                            <?php foreach ($city_groups as $key => $value) { ?>
                            <option value="<?php echo $value['id'] ?>" <?php echo set_select('city_group_id', $value['id']); ?>><?php echo $value['name'] ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="city_group"><span></span>
                    </td>
                </tr>
                <tr>
                    <td>*エリア都道府県</td>
                    <td>
                        <select name="city_id" id="cities" onchange="getList(this)" style="min-width: 150px;"></select>
                        <input type="hidden" name="city"><span></span>
                    </td>
                </tr>
                <tr>
                    <td>*エリア都市</td>
                    <td>
                        <select name="town_id" id="towns" style="min-width: 150px;"></select>
                        <input type="hidden" name="town"><span></span>
                    </td>
                </tr>
                <tr>
                    <td>*店舗名</td>
                    <td>
                        <input type="text" id ="storename" name="storename" size="60" value ="<?php echo set_value('storename'); ?>">
                        <span></span>
                    </td>
                </tr>
                <tr>
                    <td>*業種</td>
                    <td>
                        <select name="job_type" id="job_type">
                            <option value=""></option>
                            <?php foreach ($jobTypes as $key => $value): ?>
                            <option value="<?php echo $value['id']; ?>" <?php echo set_select('job_type', $value['id']); ?>><?php echo $value['name']; ?>　</option>
                            <?php endforeach ?>
                        </select>
                        <input type="hidden" name="jobtype"><span></span>
                    </td>
                </tr>
                <tr>
                    <td>*電話番号</td>
                    <td>
                        <input type="text" id="tel" name="tel" size="60" value ="<?php echo set_value('tel'); ?>">
                        <span></span>
                    </td>
                </tr>
                <tr>
                    <td>*メールアドレス</td>
                    <td>
                        <input type="text" id="email" name="email" size="60" value ="<?php echo set_value('email'); ?>">
                        <span></span>
                    </td>
                </tr>
                <tr>
                    <td>*ご担当者様氏名</td>
                    <td>
                        <input type="text" id="person_in_charge" name="person_in_charge" size="60" value ="<?php echo set_value('person_in_charge'); ?>">
                        <span></span>
                    </td>
                </tr>
				<tr>
                    <td>ご紹介店舗名</td>
                    <td>
                        <input type="text" id="campaign_note" name="campaign_note" value="<?php echo set_value('campaign_note'); ?>" style="width: 450px;">
                        <span></span>
                    </td>
                </tr>
            </table>

        </div>
        <div class="list-t-center">
            <br><br>
            <input type="submit" id="confirm" name="confirm" value="入力内容を確認" style="width:150px; height:40px;">
            <div id="box_send" style="display: none;">
                <input type="submit" id="back" name="back" value="戻る" style="width:150px; height:40px;">
                <input type="submit" id="send" name="send" value="送信" style="width:150px; height:40px;">
            </div>
        </div>
    </form>
</div>
