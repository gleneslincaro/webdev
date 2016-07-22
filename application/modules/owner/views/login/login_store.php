<script type="text/javascript">

    $(document).ready(function(){       
       displayPopupError();
       loadImage();
       happyPayMoney();
    });
    
    function loadImage()
    {
        path = baseUrl + "/public/owner/uploads/tmp/";
        if($('#hdError').val()==1){
            for(i=1; i<=6; i++)
            {
                if($("#hdImage" + i).val()!='')
                {                   
                     $("#image" + i).attr("src", $("#hdImage" + i).val());
                }

            }
         }      
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

    function chooseImage()
    {    
       var noImage = "no_image.jpg";
       var upload_action = baseUrl + "owner/login/fileUploadAjx";

       $('#loginStore').ajaxSubmit({
            url: upload_action,
            dataType:'json',
            success: function(responseText, statusText, xhr, $form){
                  
            if(responseText.error !=null)
            {
                alert(responseText.error); 
            }
            else
            {
                if($("#image1").attr("src").substr($("#image1").attr("src").lastIndexOf("/") +1) == noImage)
                {
                     $("#image1").attr("src", responseText.url);    
                     $("#hdImage1").val(responseText.url); 
                }
                else if($("#image2").attr("src").substr($("#image2").attr("src").lastIndexOf("/") +1) == noImage)
                {
                     $("#image2").attr("src", responseText.url);                
                     $("#hdImage2").val(responseText.url);  
                }
                else if($("#image3").attr("src").substr($("#image3").attr("src").lastIndexOf("/") +1) == noImage)
                {
                     $("#image3").attr("src", responseText.url);               
                     $("#hdImage3").val(responseText.url);
                }
                else if($("#image4").attr("src").substr($("#image4").attr("src").lastIndexOf("/") +1) == noImage)
                {
                     $("#image4").attr("src", responseText.url);            
                     $("#hdImage4").val(responseText.url); 
                }
                else if($("#image5").attr("src").substr($("#image5").attr("src").lastIndexOf("/") +1) == noImage)
                {
                     $("#image5").attr("src", responseText.url);            
                     $("#hdImage5").val(responseText.url);  
                }
                else if($("#image6").attr("src").substr($("#image6").attr("src").lastIndexOf("/") +1) == noImage)
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
        var n=0;
        var flag = false;
       
        $.each($("input[name='ckImage[]']:checked"), function() {
            
            i = $(this).attr('value');
            checkDel[i]=i;
            flag = true;
        
        });
        
        if(!flag)
        {   
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
            $("#hdImage" + i).val(imageArr[i - 1]);
        } 
        return true;
    }
    
    function happyPayMoney()
    {    
        var id = $("#sltHappyMoney").val();
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

<div class="list-box"><!-- list-box ここから -->

    <div class="list-title">■求人情報登録</div>
    <?php echo Helper::print_error($message); ?> 
    <div class="list-t-center">
        <br >
        求人情報の登録をお願い致します。<br >
        ※「求人情報」とはお仕事を探している方（ユーザー様）へ表示される内容になります。(*)マークは必須項目です。<br ><br >

    </div>

    <form id="loginStore" name="loginStore" method="post" action ="<?php echo base_url(); ?>owner/login/login_store" enctype="multipart/form-data" >
        <div class="information_box">

            <table class="information">
                <tr>
                    <td>イメージ写真</td>
                    <td>
                        <center>
                        <div class="photo_box">
                            <div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="150" height="113" src="<?php  $url = '';                              
                                  empty($image1)?
                                                $url = $imagePath . '/no_image.jpg' :
                                                $url = $image1;
                                  echo $url; ?>"></div>
                            <div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="150" height="113" src="<?php $url = '';                              
                                  empty($image2)?
                                                $url = $imagePath . '/no_image.jpg' :
                                                $url = $image2;
                                  echo $url; ?>"></div>
                            <div class="photo"><img id="image3" name="image3" width="150" height="113" src="<?php $url = '';                              
                                  empty($image3)?
                                                $url = $imagePath . '/no_image.jpg' :
                                                $url = $image3;
                                  echo $url; ?>"></div>
                            <br style="clear:both;">
                        </div>
                        <div class="photo_box">
                            <div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="150" height="113" src="<?php $url = '';                              
                                  empty($image4)?
                                                $url = $imagePath . '/no_image.jpg' :
                                                $url = $image4;
                                  echo $url; ?>"></div>
                            <div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="150" height="113" src="<?php $url = '';                              
                                  empty($image5)?
                                                $url = $imagePath . '/no_image.jpg' :
                                                $url = $image5;
                                  echo $url; ?>"></div>
                            <div class="photo"><img id="image6" name="image6" width="150" height="113" src="<?php $url = '';                              
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
                    <td>*会社情報</td>
                    <td>
                    <textarea placeholder="ユーザー様へ店舗紹介メッセージを記入して下さい。（400文字以内）※店舗様の連絡先が記載されていると非承認となります。" name="txtCompanyInfo" rows="10" cols="53" ><?php echo set_value('txtCompanyInfo'); ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td>職種</td>
                    <td>
                    <center>
                    <div class="check_box">                       
                         <?php 
                            $n = 0;                        
                            foreach($jobTypes as $key => $value) { ?>
                   
                            <input type="checkbox" name="ckJobTypes[]"  
                              value="<?php echo $value['id']; ?>" <?php echo set_checkbox('ckJobTypes[]', $value['id']); ?> ><?php echo $value['name']; ?>　              
                          
                        <?php 
                        
                        $n++; 
                        if($n >=4)
                        {
                            $n=0;
                            echo "<br >";
                        }
                        }?>                       
                   
                    </div>
                    </center>
                    </td>
                </tr>
                
                <tr>
                    <td>*地域</td>
                    <td>                                
                        <select name="sltCity">
                            <?php foreach ($cities as $key => $value){ ?>
                            <option value="<?php echo $value['id'] ?>" <?php echo set_select('sltCity', $value['id']); ?>><?php echo $value['name'] ?></option>
                            <?php }?>                           
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>*最寄駅</td><td><input type="text" placeholder="渋谷駅、原宿駅　等を記入して下さい。" name="txtStation" size="60" value="<?php echo set_value('txtStation') ?>"></td>
                    </tr>
                    <tr>
                    <td>*時給目安</td>
                    <td>
                        <select name="sltHourlySalary">
                            <?php foreach ($hourlySalaries as $key => $value){ ?>
                            <option value="<?php echo $value['id'] ?>" <?php echo set_select('sltHourlySalary', $value['id']); ?>><?php echo $value['amount'] ?></option>                            
                            <?php } ?>
                        </select>
                        円〜
                    </td>
                </tr>
                
                <tr>
                    <td>*月給目安</td>
                    <td>
                        <select name="sltMonthlySalary">
                            <?php foreach ($monthlySalaries as $key => $value){ ?>
                            <option value="<?php echo $value['id'] ?>" <?php echo set_select('sltMonthlySalary', $value['id']); ?>><?php echo $value['amount'] ?></option>                            
                            <?php } ?>
                        </select>
                    万円〜
                    </td>
                </tr>
                
                <tr>
                    <td>*出勤スタイル</td>
                    <td>
                        <select name="sltWorkingHourFrom">
                            <option value="0:00" <?php echo set_select('sltWorkingHourFrom', '0:00'); ?>>0:00</option>
                            <option value="1:00" <?php echo set_select('sltWorkingHourFrom', '1:00'); ?>>1:00</option>
                            <option value="2:00" <?php echo set_select('sltWorkingHourFrom', '2:00'); ?>>2:00</option>
                            <option value="3:00" <?php echo set_select('sltWorkingHourFrom', '3:00'); ?>>3:00</option>
                            <option value="4:00" <?php echo set_select('sltWorkingHourFrom', '4:00'); ?>>4:00</option>
                            <option value="5:00" <?php echo set_select('sltWorkingHourFrom', '5:00'); ?>>5:00</option>
                            <option value="6:00" <?php echo set_select('sltWorkingHourFrom', '6:00'); ?>>6:00</option>
                            <option value="7:00" <?php echo set_select('sltWorkingHourFrom', '7:00'); ?>>7:00</option>
                            <option value="8:00" <?php echo set_select('sltWorkingHourFrom', '8:00'); ?>>8:00</option>
                            <option value="9:00" <?php echo set_select('sltWorkingHourFrom', '9:00'); ?>>9:00</option>
                            <option value="10:00" <?php echo set_select('sltWorkingHourFrom', '10:00'); ?>>10:00</option>
                            <option value="11:00" <?php echo set_select('sltWorkingHourFrom', '11:00'); ?>>11:00</option>
                            <option value="12:00" <?php echo set_select('sltWorkingHourFrom', '12:00'); ?>>12:00</option>
                            <option value="13:00" <?php echo set_select('sltWorkingHourFrom', '13:00'); ?>>13:00</option>
                            <option value="14:00" <?php echo set_select('sltWorkingHourFrom', '14:00'); ?>>14:00</option>
                            <option value="15:00" <?php echo set_select('sltWorkingHourFrom', '15:00'); ?>>15:00</option>
                            <option value="16:00" <?php echo set_select('sltWorkingHourFrom', '16:00'); ?>>16:00</option>
                            <option value="17:00" <?php echo set_select('sltWorkingHourFrom', '17:00'); ?>>17:00</option>
                            <option value="18:00" <?php echo set_select('sltWorkingHourFrom', '18:00'); ?>>18:00</option>
                            <option value="19:00" <?php echo set_select('sltWorkingHourFrom', '19:00'); ?>>19:00</option>
                            <option value="20:00" <?php echo set_select('sltWorkingHourFrom', '20:00'); ?>>20:00</option>
                            <option value="21:00" <?php echo set_select('sltWorkingHourFrom', '21:00'); ?>>21:00</option>
                            <option value="22:00" <?php echo set_select('sltWorkingHourFrom', '22:00'); ?>>22:00</option>
                            <option value="23:00" <?php echo set_select('sltWorkingHourFrom', '23:00'); ?>>23:00</option>                           
                        </select>
                        〜
                        <select name="sltWorkingHourTo">
                            <option value="1:00" <?php echo set_select('sltWorkingHourTo', '1:00'); ?>>1:00</option>
                            <option value="2:00" <?php echo set_select('sltWorkingHourTo', '2:00'); ?>>2:00</option>
                            <option value="3:00" <?php echo set_select('sltWorkingHourTo', '3:00'); ?>>3:00</option>
                            <option value="4:00" <?php echo set_select('sltWorkingHourTo', '4:00'); ?>>4:00</option>
                            <option value="5:00" <?php echo set_select('sltWorkingHourTo', '5:00'); ?>>5:00</option>
                            <option value="6:00" <?php echo set_select('sltWorkingHourTo', '6:00'); ?>>6:00</option>
                            <option value="7:00" <?php echo set_select('sltWorkingHourTo', '7:00'); ?>>7:00</option>
                            <option value="8:00" <?php echo set_select('sltWorkingHourTo', '8:00'); ?>>8:00</option>
                            <option value="9:00" <?php echo set_select('sltWorkingHourTo', '9:00'); ?>>9:00</option>
                            <option value="10:00" <?php echo set_select('sltWorkingHourTo', '10:00'); ?>>10:00</option>
                            <option value="11:00" <?php echo set_select('sltWorkingHourTo', '11:00'); ?>>11:00</option>
                            <option value="12:00" <?php echo set_select('sltWorkingHourTo', '12:00'); ?>>12:00</option>
                            <option value="13:00" <?php echo set_select('sltWorkingHourTo', '13:00'); ?>>13:00</option>
                            <option value="14:00" <?php echo set_select('sltWorkingHourTo', '14:00'); ?>>14:00</option>
                            <option value="15:00" <?php echo set_select('sltWorkingHourTo', '15:00'); ?>>15:00</option>
                            <option value="16:00" <?php echo set_select('sltWorkingHourTo', '16:00'); ?>>16:00</option>
                            <option value="17:00" <?php echo set_select('sltWorkingHourTo', '17:00'); ?>>17:00</option>
                            <option value="18:00" <?php echo set_select('sltWorkingHourTo', '18:00'); ?>>18:00</option>
                            <option value="19:00" <?php echo set_select('sltWorkingHourTo', '19:00'); ?>>19:00</option>
                            <option value="20:00" <?php echo set_select('sltWorkingHourTo', '20:00'); ?>>20:00</option>
                            <option value="21:00" <?php echo set_select('sltWorkingHourTo', '21:00'); ?>>21:00</option>
                            <option value="22:00" <?php echo set_select('sltWorkingHourTo', '22:00'); ?>>22:00</option>
                            <option value="23:00" <?php echo set_select('sltWorkingHourTo', '23:00'); ?>>23:00</option> 
                            <option value="24:00" <?php echo set_select('sltWorkingHourTo', '24:00'); ?>>24:00</option>            
                        </select>
                        or
                        <input type="checkbox" id="ckWorkingHour24" name="ckWorkingHour24" <?php if(isset($_POST['ckWorkingHour24'])) echo "checked"; ?>>24時間OK<br ><br >
                        <textarea placeholder="週に１回、３時間からでもＯＫ☆　等を記載してください。" name="txtWorkingStyleNote" rows="5" cols="53"><?php echo set_value('txtWorkingStyleNote'); ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td>*待遇</td>
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
             </table>
        </div>
        
        <br><br>
        
        <div class="information_box">
            <table class="information">
                <tr>
                    <th colspan="2">採用金額設定</th>
                </tr>
                <tr>
                    <td>*採用金額</td>
                    <td>
                        <select id="sltHappyMoney" name="sltHappyMoney" onchange="happyPayMoney();">
                        <?php foreach ($happyMoneys as $key => $value) {  ?>                      
                            <option  <?php echo ($defaltMoney == $value['id'])  ? 'selected' :'' ; ?>  value="<?php echo $value['id'] ?>" <?php echo set_select('sltHappyMoney', $value['id']); ?>><?php echo $value['joyspe_happy_money'];?></option>   
                        <?php } ?>
                    </select>円
                    </td>
                 </tr>
                 <tr>
                     <td>お祝い金</td><td><label id="lbHappyPayMoney" name="lbHappyPayMoney"/>2000円</td>
                 </tr>
                 <tr>
                    <td>*お祝い金・達成条件</td>
                    <td>
                        初日　
                        <select name="sltCondition">
                            <option value="1" <?php echo set_select('sltCondition', '1'); ?>>1</option>
                            <option value="2" <?php echo set_select('sltCondition', '2'); ?>>2</option>
                            <option value="3" <?php echo set_select('sltCondition', '3'); ?>>3</option>
                            <option value="4" <?php echo set_select('sltCondition', '4'); ?>>4</option>
                            <option value="5" <?php echo set_select('sltCondition', '5'); ?>>5</option>
                        </select>　時間以上　勤務（研修）
                    </td>
                </tr>
            </table>
	</div>
        
        <br >
	<center>
	※採用金は5,000円～200,000円まで設定が可能です。<br >
	※お祝い金は採用金の「20％」が自動的に設定されます。</center><br >

	<br >
          <input type="hidden" id="hdError" name="hdError" value="<?php echo $hdError;?>" />
	<div class="list-t-center"><input type="submit" name="" value="登録" style="width:150px; height:40px;"></button></div>
        
    </form>

</div><!-- list-box ここまで -->