<?php
$id = 0;
?>
TOP ＞ メッセージ ＞ 承認中一覧 ＞ 承認中 プロフィール
<!--
<div style="float:right"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<a  href="<?php if($recruit_status != 3) echo base_url() . 'owner/settlement/settlement'; else echo "#"; ?>" target="_blank">▼ポイント購入</a></div><br >
-->
<div class="list-box"><!-- list-box ここから -->
    <div class="list-title">■承認中　プロフィール</div>

    <br ><br>


    <div class="message_box">
        <table class="message">
            <tr>
                <th colspan="2"></th>
            </tr>
            <?php
            if (count($data) > 0) {
                $id = $data['id'];
                ?>
                <tr>
                    <td>お知らせ</td>
                    <td>joyspeサポートセンターです。不備が御座いました。</td>
                </tr>

                <tr>
                    <td>不備内容</td>
                    <td>
                        <?php echo str_replace(array("\r\n", "\n", "\r"), "<br/>",  $data['error_recruit_content']); ?>
                    </td>
                </tr>

                <tr>
                    <td>求人会社名 or 求人店舗名</td>
                    <td><?php echo $data['storename']; ?></td>
                </tr>
                <tr>
                    <td>イメージ写真</td>
                    <td>
                <center>
                    <div class="photo_box">
                        <div class="photo" style="margin-right:25px;"><img width="150" height="113" src="<?php
                        $url = '';
                        empty($data['image1']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $data['image1'];
                        echo $url;
                        ?>"></div>
                        <div class="photo" style="margin-right:25px;"><img width="150" height="113" src="<?php
                        $url = '';
                        empty($data['image2']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $data['image2'];
                        echo $url;
                        ?>"></div>
                        <div class="photo"><img width="150" height="113" src="<?php
                        $url = '';
                        empty($data['image3']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $data['image3'];
                        echo $url;
                        ?>"></div>
                        <br style="clear:both;">
                    </div>
                    <div class="photo_box">
                        <div class="photo" style="margin-right:25px;"><img width="150" height="113" src="<?php
                        $url = '';
                        empty($data['image4']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $data['image4'];
                        echo $url;
                        ?>"></div>
                        <div class="photo" style="margin-right:25px;"><img width="150" height="113" src="<?php
                        $url = '';
                        empty($data['image5']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $data['image5'];
                        echo $url;
                        ?>"></div>
                        <div class="photo"><img width="150" height="113" src="<?php
                        $url = '';
                        empty($data['image6']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $data['image6'];
                        echo $url;
                        ?>"></div>
                        <br style="clear:both;">
                    </div>

                </center>
                </td>
                </tr>
                <tr>
                    <td>会社情報</td>
                    <td>
                        <?php echo $data['company_info']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div><br ><br >
    <div class="list-t-center">
        <input type="button" name="" value="編集" style="width:150px; height:40px;" onClick="javascript:location.href = '<?php echo base_url() . 'owner/message/message_approval_profileedit/' ?>';"></button></a></div>
</div><!-- list-box ここまで -->
