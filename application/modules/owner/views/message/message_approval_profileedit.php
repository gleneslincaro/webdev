<script type="text/javascript">  
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
    $(document).ready(function() {
        displayPopupError();
        loadImage();
    });

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
            alert(error);
        } else 
        {
            var hdflag = $('#hdflag').val();
            var action = baseUrl + "owner/message/do_edit/"+<?php echo $owner_id;?>;
            if(hdflag == 1)
            {
               if(window.confirm("承認依頼をしますか？"))
               {
                   $('#formMain').ajaxSubmit({
                       url: action,
                       type: 'post',
                       dataType:'text',                      
                       success: function(result){
                           $('#hdflag').val(0);
                           if(<?php echo $count_profiles;?> == 1) {
                           window.location=baseUrl + "owner/dialog/dialog_request/0";
                           } else {
                               window.location=baseUrl + "owner/dialog/dialog_request/1";
                           }
                       }
                   });                
               }               
            }
        }
    }

    function chooseImage()
    {
        var noImage = "no_image.jpg";
        var upload_action = baseUrl + "owner/login/fileUploadAjx";

        $('#formMain').ajaxSubmit({
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

</script>

TOP ＞ メッセージ ＞ 承認中一覧 ＞ 承認中 プロフィール ＞ 編集
	<div style="float:right"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">▼ポイント購入</a></div><br >
<form id="formMain" name="formMain" action="<?php echo base_url() . 'owner/message/message_approval_profileedit'; ?>" method="post" enctype="multipart/form-data" >
     <?php echo Helper::print_error($message); ?> 
    <div class="list-box"><!-- list-box ここから -->
        <input type="hidden" value="<?php echo $data['orid']; ?>" name="orid" id="baseurl"/>
        <div class="list-title">■承認中　プロフィール</div>

        <br/><br/>


        <div class="message_box">
            <?php if(count($data)>0) {?>
            <table class="message">
                <tr>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <td>お知らせ</td>
                    <td>joyspeサポートセンターです。不備が御座いました。</td>
                </tr>

                <tr>
                    <td>不備内容</td>
                    <td>
                        <?php echo str_replace(array("\r\n", "\n", "\r"), "<br/>",$data['error_recruit_content']); ?>
                    </td>
                </tr>

                <tr>
                    <td>求人会社名 or 求人店舗名</td>
                    <td><input type="text" name="storename" size="50" value="<?php echo set_value('storename',$data['storename'] ); ?>"></td>
                </tr>                
                <tr>
                    <td>イメージ写真</td>
                    <td>
                        <!-- PHOTO Field -->
                <center>
                    <div class="photo_box">
                        <div class="photo" style="margin-right:25px;">
                            <img id="image1" name="image1" width="150" height="113" src="<?php
                             $url = '';                              
                                empty($image1)?
                                                $url = $imagePath . 'images/no_image.jpg' :
                                                $url = $image1;
                                echo $url;       
                            ?>">
                        </div>
                        <div class="photo" style="margin-right:25px;">
                            <img id="image2" name="image2" width="150" height="113" src="<?php
                           $url = '';                             
                                empty($image2)?
                                                $url = $imagePath . 'images/no_image.jpg' :
                                                $url = $image2;
                                echo $url;
                            ?>">
                        </div>
                        <div class="photo">
                            <img id="image3" name="image3" width="150" height="113" src="<?php
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
                            <img id="image4" name="image4" width="150" height="113" src="<?php
                           $url = '';                           
                                empty($image4)?
                                                $url = $imagePath . 'images/no_image.jpg' :
                                                $url = $image4;
                                echo $url;
                            ?>">
                        </div>
                        <div class="photo" style="margin-right:25px;">
                            <img id="image5" name="image5" width="150" height="113" src="<?php
                            $url = '';                              
                                empty($image5)?
                                                $url = $imagePath . 'images/no_image.jpg' :
                                                $url = $image5;
                                echo $url;
                            ?>">
                        </div>
                        <div class="photo">
                            <img id="image6" name="image6" width="150" height="113" src="<?php
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
                    <input type="hidden" id="hdImage1" name ="hdImage1" value="<?php echo set_value('hdImage1',$image1);?>"/> 
                    <input type="hidden" id="hdImage2" name ="hdImage2" value="<?php echo set_value('hdImage2',$image2);?>"/> 
                    <input type="hidden" id="hdImage3" name ="hdImage3" value="<?php echo set_value('hdImage3',$image3);?>"/> 
                    <input type="hidden" id="hdImage4" name ="hdImage4" value="<?php echo set_value('hdImage4',$image4);?>"/> 
                    <input type="hidden" id="hdImage5" name ="hdImage5" value="<?php echo set_value('hdImage5',$image5);?>"/> 
                    <input type="hidden" id="hdImage6" name ="hdImage6" value="<?php echo set_value('hdImage6',$image6);?>"/> 

                    <p>メイン画像：
                        <select name="sltImageDefault" id="sltImageDefault">
                  
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
                <!-- END PHOTO Field -->
                </td>
                </tr>
                <tr>
                    <td>会社情報</td>
                    <td>
                        <textarea style="" name="company_info" rows="10" cols="60" ><?php echo set_value('company_info',$data['company_info'] ); ?></textarea>
                    </td>
                </tr>                
            </table>
            <?php } ?>
        </div>

        <br ><br >
        <input type="hidden" id="hdError" name="hdError" value="<?php echo $hdError;?>" />
        <input type="hidden" id="hdflag" name="hdflag" value="<?php echo set_value('hdflag', $hdflag); ?>" />
        <div class="list-t-center"><input type="submit" value="　承認依頼　"/>        
        </div>
    </div><!-- list-box ここまで -->
</form>