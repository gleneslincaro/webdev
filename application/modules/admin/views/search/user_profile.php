<style type="text/css">
.upload_form_box{
width: 33%;
float: left;    
}    
</style>
<script type="text/javascript">
var form_name;
var baseUrl = '<?php echo base_url(); ?>';
$(document).ready(function() {      
    $('#profile_pic').bind('contextmenu', function(e){
        return false;
    });

    $('.profile_pic_file').change(function () {
        var noImage = "no_image.jpg";
        var upload_action = baseUrl + "admin/search/fileUploadAjxPic/<?php echo $uprofile['user_id']; ?>";
        var val = $(this).val();
        var id = $(this).attr('id');

        if('profile_pic_file' == id){
            form_name = 'changeProfileFormPic1';
        }else if('profile_pic_file2' == id){
            form_name = 'changeProfileFormPic2';
        }else if('profile_pic_file3' == id){
            form_name = 'changeProfileFormPic3';
        }

        $('#'+form_name).ajaxSubmit({
            type:'post',
            url: upload_action,
            dataType: 'json',
            success: function(responseText, statusText, xhr, $form) {
                if (responseText.error != null) {
                    alert(responseText.error);
                } else {
                    if('profile_pic_file' == id){
                        $("#profile_pic").attr("src", responseText.url);
                        $("#profile_pic_file_path").val(responseText.url);
                    }else if('profile_pic_file2' == id){
                        $("#profile_pic2").attr("src", responseText.url);
                        $("#profile_pic_file_path2").val(responseText.url);
                    }else if('profile_pic_file3' == id){
                        $("#profile_pic3").attr("src", responseText.url);
                        $("#profile_pic_file_path3").val(responseText.url);
                    }
                }
            }
        });
    });

    $('.update_profile_pic').click(function() {
        var id = $(this).attr('id');
        if('update_profile_pic' == id){
            var file = $("#profile_pic_file_path").val();
            if ( file == "" ){
                alert("プロファイル写真を選択してください。");
                return false;
            }
            form_name = 'changeProfileFormPic1';
        }else if('update_profile_pic2' == id){
            var file = $("#profile_pic_file_path2").val();
            if ( file == "" ){
                alert("プロファイル写真を選択してください。");
                return false;
            }
            form_name = 'changeProfileFormPic2';
        }else if('update_profile_pic3' == id){
            var file = $("#profile_pic_file_path3").val();
            if ( file == "" ){
                alert("プロファイル写真を選択してください。");
                return false;
            }
            form_name = 'changeProfileFormPic3';
        }
        var upload_action = baseUrl + "admin/search/updateProfilePic/<?php echo $uprofile['user_id']; ?>";
        $('#'+form_name).ajaxSubmit({
            type:'post',
            url: upload_action,
            dataType: 'json',
            success: function(responseValues, statusText, xhr, $form) {
                if (responseValues.error != null) {
                    alert(responseValues.error);
                } else {
                    alert("プロフィル写真の更新が完了しました。");
                    $("#"+responseValues.img_id).attr("src",responseValues.src);
                    $('#'+responseValues.name).val('');
                    $('#'+responseValues.path).val('');
                }
            }
        });
    });

    $('.delete_profile_pic').click(function() {
        if ( !confirm("削除してよろしいでしょうか？") ){
            return false;
        }
        var id = $(this).attr('id');
        if('delete_profile_pic' == id){
            form_name = 'changeProfileFormPic1';
        }else if('delete_profile_pic2' == id){
            form_name = 'changeProfileFormPic2';
        }else if('delete_profile_pic3' == id){
            form_name = 'changeProfileFormPic3';
        }
        var upload_action = baseUrl + "admin/search/deleteProfilePic/<?php echo $uprofile['user_id']; ?>";
        $('#'+form_name).ajaxSubmit({
            type:'post',
            url: upload_action,
            dataType: 'json',
            success: function(responseValues, statusText, xhr, $form) {
                if (responseValues.error != null) {
                    alert(responseValues.error);
                } else {
                    alert("プロフィル写真の削除が完了しました。");
                    if('delete_profile_pic' == id){
                        $("#profile_pic").attr("src", responseValues.url);
                        $("#profile_pic_file_path").val("");
                    }else if('delete_profile_pic2' == id){
                        $("#profile_pic2").attr("src", responseValues.url);
                        $("#profile_pic_file_path1").val("");
                    }else if('delete_profile_pic3' == id){
                        $("#profile_pic3").attr("src", responseValues.url);
                        $("#profile_pic_file_path2").val("");
                    }
                }
            }
        });
    });    
});
</script>
<form id="frmUserChange" action="<?php echo base_url(); ?>index.php/admin/search/update_user_profile" method="post" enctype="multipart/form-data">

<center>
<p>ユーザープロフィール</p></center>
<input type="hidden" name="user_id" value="<?php echo $uprofile['user_id']; ?>" />
<table border width="98%">
    <tr>
    <td width="21%">サイト内ID</td>
    <td width="77%"><?php echo $unique_id; ?></td>
    </tr>
    <tr>
    <td>年齢</td>
    <td>
        <select class="sign_up" name="age_id">
            <?php foreach ($agelist as $item) { ?> 
                <option <?php if ($item['id'] == $uprofile['age_id']) echo "selected"; ?> 
                    value="<?php echo  $item['id'] ; ?>"><?php echo  $item['name1'].'歳〜'; echo $item['name2'] == 0 ? '' : $item['name2'].'歳'; ?></option>
            <?php } ?>
        </select>
    </td>
    </tr>

    <tr>
    <td>身長</td>
    <td>
        <select class="sign_up" name="height_id">
            <?php foreach ($heightlist as $item) { ?> 
                <option <?php if ($item['id'] == $uprofile['height_id']) echo "selected"; ?> 
                    value="<?php echo  $item['id'] ; ?>"><?php echo  $item['name1'].'cm〜'; echo $item['name2'] == 0 ? '' : $item['name2'].'cm'; ?></option>
            <?php } ?>
        </select></td>
    </tr>


    <tr>
    <td>地域</td>
    <td>
        <select class="sign_up" name="city_id">
            <?php foreach ($citylist as $item) { ?> 
                <option <?php if ($item['id'] == $uprofile['city_id']) echo "selected"; ?> 
                    value="<?php echo  $item['id']  ;?>"><?php echo  $item['name']  ;?></option>
            <?php } ?>
        </select>
    </td>
    </tr>
    <tr>
    <td>バスト</td>
    <td>
        <select class="sign_up" name="bust_size">
            <option placeholder="バスト" value="">*バスト</option>
            <?php
             if (!empty($uprofile)) {
                foreach ($bustlist as $item) {
                    ?>
                    <option <?php
                    if ($item['size'] == $uprofile['bust']) {
                        echo "selected";
                    }
                    ?> value="<?php echo $item['size'] ?>"<?php echo set_select('bust_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                    <?php
                }
            }else{
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
    <td>ウェスト</td>
    <td>
        <select class="sign_up" name="waist_size">
            <option placeholder="ウェスト" value="">*ウェスト</option>
            <?php
             if (!empty($uprofile)) {
                foreach ($waistlist as $item) {
                    ?>
                    <option <?php
                    if ($item['size'] == $uprofile['waist']) {
                        echo "selected";
                    }
                    ?> value="<?php echo $item['size'] ?>"<?php echo set_select('waist_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                    <?php
                }
            }else{
                 foreach ($waistlist as $item) {
                    ?>
                    <option value="<?php echo $item['size'] ?>"<?php echo set_select('waist_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </td>
    </tr>
    <tr>
    <td>ヒップ</td>
    <td>
        <select class="sign_up" name="hip_size">
            <option placeholder="ヒップ" value="">*ヒップ</option>
            <?php
             if (!empty($uprofile)) {
                foreach ($hiplist as $item) {
                    ?>
                    <option <?php
                    if ($item['size'] == $uprofile['hip']) {
                        echo "selected";
                    }
                    ?> value="<?php echo $item['size'] ?>"<?php echo set_select('hip_size', $item['size']); ?>><?php echo $item['size'].CONST_CENTIMET ?></option>
                    <?php
                }
            }else{
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
    <td>希望収入</td>
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
    <td>風俗経験</td>
    <td>
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
    <tr>
    <td>自己紹介文</td>
    <td>
        <textarea name="pr_message" cols=42 rows=4 style="width:100%;"><?php if(!empty($uprofile)){echo $uprofile['pr_message'];} ?></textarea>
    </td>
    </tr>
</table>
</form>
<center>
<p><input type="button" value="　登録　" onClick="doSubmit();" /></p>
</center>
<br />
<table border width="98%">
  <tr>
    <td>プロフ写真</td>
    <td>
        <div class="box"><br />
            <div class="box_in">
                <form method="post" name="changeProfileFormPic1" id="changeProfileFormPic1" enctype="multipart/form-data">
                <div class="upload_form_box">
                    <img id="profile_pic" name="profile_pic" src="<?php
                        $data_from_site = $userData['user_from_site'];
                        if ( !$userData['profile_pic'] ){
                            echo base_url()."public/user/image/no_image.jpg";
                        }else{
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$userData['profile_pic'];
                            if ( file_exists($pic_path) ){
                                echo base_url().$this->config->item('upload_userdir').'images/'.$userData['profile_pic'];
                            }else{
                                if ( $data_from_site == 1 ){
                                    echo $this->config->item('machemoba_pic_path').$userData['profile_pic'];
                                }else{
                                    echo $this->config->item('aruke_pic_path').$userData['profile_pic'];
                                }
                            }
                        }
                    ?>" height="90" alt=""  style="margin-bottom:15px;">
                    <p>JPEGファイル：<br >
                        <input type="file" name="profile_pic_file" accept="image/jpg/jpeg" class = "profile_pic_file" id = "profile_pic_file">
                        <br>
                        <div class="btn50"><a class="btn update_profile_pic" id="update_profile_pic" >登録する</a></div>                
                        <div class="btn50"><a class="btn delete_profile_pic" id="delete_profile_pic" >削除する</a></div>                  
                        <input type="hidden" name = "profile_pic_file_path" id="profile_pic_file_path" >
                        <input type="hidden" name = "profile_pic_num" value="1">
                    </p>
                </div>
                </form>
                <form method="post" name="changeProfileFormPic2" id="changeProfileFormPic2" enctype="multipart/form-data">
                <div class="upload_form_box">
                    <img id="profile_pic2" name="profile_pic2" src="<?php
                        $data_from_site = $userData['user_from_site'];
                        if ( !$userData['profile_pic2'] ){
                            echo base_url()."public/user/image/no_image.jpg";
                        }else{
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$userData['profile_pic2'];
                            if ( file_exists($pic_path) ){
                                echo base_url().$this->config->item('upload_userdir').'images/'.$userData['profile_pic2'];
                            }else{
                                if ( $data_from_site == 1 ){
                                    echo $this->config->item('machemoba_pic_path').$userData['profile_pic2'];
                                }else{
                                    echo $this->config->item('aruke_pic_path').$userData['profile_pic2'];
                                }
                            }
                        }
                    ?>" height="90" alt=""  style="margin-bottom:15px;">
                    <p>JPEGファイル：<br >
                        <input type="file" name="profile_pic_file2" accept="image/jpg/jpeg" class = "profile_pic_file" id = "profile_pic_file2">
                        <br>
                        <div class="btn50"><a class="btn update_profile_pic" id="update_profile_pic2" >登録する</a></div>                
                        <div class="btn50"><a class="btn delete_profile_pic" id="delete_profile_pic2" >削除する</a></div>                  
                        <input type="hidden" name = "profile_pic_file_path2" id="profile_pic_file_path2" >
                        <input type="hidden" name = "profile_pic_num" value="2">
                    </p>
                </div>
                </form>
                <form method="post" name="changeProfileFormPic3" id="changeProfileFormPic3" enctype="multipart/form-data">
                <div class="upload_form_box">
                    <img id="profile_pic3" name="profile_pic3" src="<?php
                        $data_from_site = $userData['user_from_site'];
                        if ( !$userData['profile_pic3'] ){
                            echo base_url()."public/user/image/no_image.jpg";
                        }else{
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$userData['profile_pic3'];
                            if ( file_exists($pic_path) ){
                                echo base_url().$this->config->item('upload_userdir').'images/'.$userData['profile_pic3'];
                            }else{
                                if ( $data_from_site == 1 ){
                                    echo $this->config->item('machemoba_pic_path').$userData['profile_pic3'];
                                }else{
                                    echo $this->config->item('aruke_pic_path').$userData['profile_pic3'];
                                }
                            }
                        }
                    ?>" height="90" alt=""  style="margin-bottom:15px;">
                    <p>JPEGファイル：<br >
                        <input type="file" name="profile_pic_file3" accept="image/jpg/jpeg" class = "profile_pic_file" id = "profile_pic_file3">
                        <br>
                        <div class="btn50"><a class="btn update_profile_pic" id="update_profile_pic3" >登録する</a></div>                
                        <div class="btn50"><a class="btn delete_profile_pic" id="delete_profile_pic3" >削除する</a></div>                  
                        <input type="hidden" name = "profile_pic_file_path3" id="profile_pic_file_path3" >                  
                        <input type="hidden" name = "profile_pic_num" value="3">
                    </p>
                </div>
                </form>
            </div>
        </div>
    </td>
  </tr>
</table>
<script type="text/javascript">

function doSubmit(){
    res=confirm('登録してもいいでしょうか？'); 
    if(res==true){
        $("#frmUserChange").submit();
    }
}

</script>