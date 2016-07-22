<center>
<p>認証一覧・プロフィール非認証</p>
</center>

<center>
    <table border width="40%">

        <tr>
            <td><span>アドレス</span></td>
            <td><?php echo $ownerInfo['email_address']; ?></td>
        </tr>
        <tr>
            <td>店舗名</td>
            <td><?php echo $ownerInfo['storename']; ?></td>
        </tr>

    </table>
</center>


<center>
    <p>オリジナル文章<br>
        ※非認証ページでは、オリジナル文章も編集可能です。<br>
    </p>

    <table border width="90%">
        <tr>
            <td>店舗名</td>
            <td><?php echo $ownerInfo['storename']; ?></td>
        </tr>
        <tr>
            <td>求人担当</td>
            <td><?php echo $ownerInfo['pic']; ?></td>
        </tr>
        <tr>
            <td>イメージ写真</td>
            <td align="center">
                <div class="photo_box">
                    <?php if($ownerInfo['image1']==''){ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg" /></div>
                    <?php }else{ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image1" name="image1" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $ownerInfo["image1"];?>" /></div>
                    <?php }
                    if($ownerInfo['image2']==''){ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg" /></div>
                    <?php }else{ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image2" name="image2" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $ownerInfo["image2"];?>" /></div>                   
                    <?php }
                    if($ownerInfo['image3']==''){ ?>
                        <div class="photo"><img id="image3" name="image3" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg"></div>
                    <?php }else{ ?>
                        <div class="photo"><img id="image3" name="image3" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $ownerInfo["image3"];?>" /></div>
                    <?php } ?>
                    <br style="clear:both;">
                </div>
                <div class="photo_box">
                    <?php if($ownerInfo['image4']==''){ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg"></div>
                    <?php }else{ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image4" name="image4" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $ownerInfo["image4"];?>"/></div>
                    <?php }
                    if($ownerInfo['image5']==''){ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg"></div>
                    <?php }else{ ?>
                        <div class="photo" style="margin-right:25px;"><img id="image5" name="image5" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $ownerInfo["image5"];?>"></div>
                    <?php }
                    if($ownerInfo['image6']==''){ ?>
                        <div class="photo"><img id="image6" name="image6" width="100" height="60" src="<?php echo base_url();?>public/owner/images/no_image.jpg"></div>
                    <?php }else{ ?>
                        <div class="photo"><img id="image6" name="image6" width="100" height="60" src="<?php echo base_url();?>public/owner/uploads/images/<?php echo $ownerInfo["image6"];?>"></div>
                    <?php } ?>
                    <br style="clear:both;">
                </div>
            </td>
        </tr>
        <tr>
            <td>会社情報</td>
            <td width="85%">
                <?php echo $ownerInfo['company_info']; ?>
            </td>
        </tr>
        <tr>
            <td>最寄駅</td>
            <td><?php echo $ownerInfo['nearest_station']; ?></td>
        </tr>
        <tr>
            <td>出勤スタイル</td>
            <td><?php echo $ownerInfo['working_style_note']; ?></td>
        </tr>
    </table>
</center>


<center>
<p>不備内容記入欄<br>
※ココに記載した内容がオーナー側の不備欄に表示されます。<br>
<textarea name="example2" cols="70" rows="15">
<?php echo $ownerInfo['error_recruit_content']; ?>
</textarea></p>
</center>

<center>
<p>スタッフ記入欄<br>

<textarea name="example2" cols="70" rows="15">
<?php echo $ownerInfo['error_recruit_note']; ?>
</textarea></p>
</center>
