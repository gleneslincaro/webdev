<script language="javascript">
    $(document).ready(function(){
         var base = $("#base").attr("value");
        $("#btApprove").click(function(){
            window.location=base+"admin/authentication/ok_Profile01/"+$("#txtowid").val();        
        });
        $("#btUnapprove").click(function(){
            window.location=base+"admin/authentication/non_Profile/"+$("#txtowid").val();        
        });   
    });
    
</script>
<center>
<p>承認履歴・詳細</p>
</center>

<center>
    <table border width="40%">

        <tr>
            <td>アドレス</td>
            <td><?php echo $owinfo['email_address']; ?></td>
            <input type='hidden' value="<?php echo $owner_id;?>" id="txtowid" name='txtowid' />
        </tr>
        <tr>
            <td>店舗名</td>
            <td><?php echo $owinfo['storename']; ?></td>
        </tr>

    </table>
</center>


<center>
    <p>オリジナル文章<br>        
※連絡先が記載されていた場合は　更新（修正）　から編集を行ってください。写真も注意！<br>
    </p>

    <table border width="90%">
        <tr>
            <td>店舗名</td>
            <td><?php echo $owinfo['storename']; ?></td>
        </tr>
        <tr>
            <td>求人担当</td>
            <td><?php echo $owinfo['pic']; ?></td>
        </tr>
        <tr>
            <td>イメージ写真</td>
            <td align="center">
                <div class="photo_box">
                   <?php if($owinfo['image1']==''){ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image2" name="image1" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg" /></div>
                    <?php }else{ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image2" name="image1" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $owinfo["image1"];?>" /></div>
                    <?php }
                    if($owinfo['image2']==''){ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg" /></div>
                    <?php }else{ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $owinfo["image2"];?>" /></div>                   
                    <?php }
                    if($owinfo['image3']==''){ ?>
                        <div class="photo"><img id="image3" name="image3" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg"></div>
                    <?php }else{ ?>
                        <div class="photo"><img id="image3" name="image3" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $owinfo['image3'];?>" /></div>
                    <?php } ?>
                    <br style="clear:both;">
                </div>
                <div class="photo_box">
                    <?php if($owinfo['image4']==''){ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg"></div>
                    <?php }else{ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $owinfo['image4'];?>"/></div>
                    <?php }
                    if($owinfo['image5']==''){ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg"></div>
                    <?php }else{ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $owinfo["image5"];?>"></div>
                    <?php }
                    if($owinfo['image6']==''){ ?>
                        <div class="photo"><img id="image6" name="image6" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg"></div>
                    <?php }else{ ?>
                        <div class="photo"><img id="image6" name="image6" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $owinfo["image6"];?>"></div>
                    <?php } ?>
                    <br style="clear:both;">
                </div>
            </td>
        </tr>
        <tr>
            <td width="15%">会社情報</td>
            <td width="85%">
                <?php echo $owinfo['company_info']; ?>
            </td>
        </tr>
        <tr>
            <td>最寄駅</td>
            <td><?php echo $owinfo['nearest_station']; ?></td>
        </tr>
        <tr>
            <td>出勤スタイル</td>
            <td><?php echo $owinfo['working_style_note']; ?></td>
        </tr>
    </table>
</center>


<center>
    <p><button type="button" id="btApprove">　承認（修正）　</button>
       <button type="button" id="btUnapprove">　非承認　</button></p>
</center>
