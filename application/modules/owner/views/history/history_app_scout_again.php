<script type="text/javascript">
    function showPopup()
    {
        var t = $("#spam").val();//document.getElementById('spam');
        var u = $("#unique_id").val();
        var base = $("#base_url").val();//document.getElementById('unique_id');
        if (t==1)
        {
            var text = "ID: " + u + " \n" + "がブロックしているためスカウトできません。";
            alert(text);
            window.location = base + 'owner/history/history_scout';
            return false;

        }
        else
            return true;
    }
</script>

<div id="container">

    TOP ＞ スカウト機能 ＞ スカウトメッセージ
<!--
    <div style="float:right"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">▼ポイント購入</a></div><br >
-->
    <div class="list-box"><!-- list-box ここから -->

        <div class="list-title">■スカウトメッセージ</div><br >

        ※下記ユーザーさんは前回のスカウトメッセージより7日間経過しているので送信が可能となっております。<br>

        <?php
        $id = 0;
        if (count($user_data) > 0) { ?>
        <div class="img-prof in_new">
        <ul>
        <?php
            $cnt = 0;
            foreach ($user_data as $key => $value) {
                if ( ($cnt != 0) && ($cnt % 3) == 0 ){ echo "</ul><ul>"; }
                if ( ($cnt % 3) != 2 ){
                    echo ' <li class="right_m">';
                }else{
                    echo ' <li>';
                }
                ?>
               <img src="<?php
                        $data_from_site = $value['user_from_site'];
                        if ( $value['profile_pic'] ){
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                            if ( file_exists($pic_path) ){
                                $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                            }else{
                                if ( $data_from_site == 1 ){
                                    $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                                }else{
                                    $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                                }
                            }
                            echo $src;
                            //echo base_url().$this->config->item('upload_userdir')."images/".$value['profile_pic'];
                        }else{
                            echo base_url().'/public/user/image/no_image.jpg';
                        }
                        ?>" height="90" alt="">
                        <p>地域：<?php echo $value['cityname']; ?>
                        <br>年齢：<?php echo (($value['name1'] != 0)? $value['name1'] : '')  . '~' . (($value['name2']!=0) ? $value['name2'] : '') ?>
                        <br>身長：<?php echo $value['height_l'] . "~". $value['height_h']; ?>
                        <br><?php echo "B".$value['bust'] . " W". $value['waist']. " H". $value['hip']; ?></p>
                        <input type="hidden" name="array_user_id[]" value="<?php echo $value['id']; ?>">

                </li>
        <?php
        $cnt++;
        } ?>
        </ul>
        </div>
        <?php } ?>


        <div class="list-t-center">
            <br >

            ※送信されるスカウトメッセージ内容は、下記のものとなります。

            <br >



            <div class="message_box">
                <table class="message" style="text-align: left">
                    <tr>
                        <th></th>
                    </tr>

                    <tr>
                        <td>件名：<?php echo $title_mail; ?></td>
                    </tr>
                    <tr>

                        <td>

                            <?php echo $body; ?>

                        </td>
                    </tr>
                </table>
            </div>


            <br ><br >

            <div class="list-t-center">

                <input type="hidden" name="spam" id="spam" value="<?php echo $spam; ?>">
                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
                <form method="GET" action="<?php echo base_url() . 'owner/dialog/dialog_scout/' . $id . '/3' ?>" onSubmit="return showPopup();">
                    <input type="submit" name="" value="送信"  style="width:150px; height:40px;"></button>
                </form>
            </div>


        </div><!-- list-box ここまで -->


    </div><!-- container ここまで -->
