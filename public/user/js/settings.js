
/*
 * settings javascript
 *
 */
$(function() {      
    $('#profile_pic').bind('contextmenu', function(e) {
        return false;
    });            
    $('#user_name_and_birth').hide();
    
    $('#submit_user_change').click(function() {
        $('#form_user_change').submit();
    });    
      
    $('#job_info').click(function() {
        $('#form_job_info').submit();
    });        
    
    $('#bank_account').click(function() {
        $('#form_bank_account').submit();
    });
    
    $('#age_verification').click(function() {
        $('#form_age_verification').submit();
    });
    
    $('#transfer_change').click(function() {
        $('#form_transfer_change').submit();
    });
    
    $('.profile_pic_file').change(function () {
        var noImage = "no_image.jpg";
        var upload_action = base_url + "user/profile_change/fileUploadAjx";
        var val = $(this).val();
        var id = $(this).attr('id');

        if('profile_pic_file' == id){
            form_name = 'changeProfileForm1';
        }else if('profile_pic_file2' == id){
            form_name = 'changeProfileForm2';
        }else if('profile_pic_file3' == id){
            form_name = 'changeProfileForm3';
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
            form_name = 'changeProfileForm1';
        }else if('update_profile_pic2' == id){
            var file = $("#profile_pic_file_path2").val();
            if ( file == "" ){
                alert("プロファイル写真を選択してください。");
                return false;
            }
            form_name = 'changeProfileForm2';
        }else if('update_profile_pic3' == id){
            var file = $("#profile_pic_file_path3").val();
            if ( file == "" ){
                alert("プロファイル写真を選択してください。");
                return false;
            }
            form_name = 'changeProfileForm3';
        }
        var upload_action = base_url + "user/profile_change/updateProfilePic";
        $('#'+form_name).ajaxSubmit({
            type:'post',
            url: upload_action,
            dataType: 'json',
            success: function(responseValues, statusText, xhr, $form) {
                if (responseValues.error != null) {
                    alert(responseValues.error);
                } else {
                    alert("プロフィル写真の更新が完了しました。");
                    $.each(responseValues.url,function(i,v) {
                       $("#"+i).attr("src",v);
                    });
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
            form_name = 'changeProfileForm1';
        }else if('delete_profile_pic2' == id){
            form_name = 'changeProfileForm2';
        }else if('delete_profile_pic3' == id){
            form_name = 'changeProfileForm3';
        }

        var upload_action = base_url + "user/profile_change/deleteProfilePic";
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
