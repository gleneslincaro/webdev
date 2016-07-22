<script>
    $(document).ready(function(){
        $("#th10").addClass("visited");
        $(".btn_delete_spec_photo").on('click', function(e){
            e.preventDefault();
            var inputfile = $(this).parent('td');
            $(inputfile).find(".prev_pic").html("");
            $(inputfile).find(".img_prev").val("");
            $(inputfile).find('.interviewer_pic').val("");
        });
        $(".interviewer_pic, .working_day_pic").live('change', function(){
            var inputfile = $(this).parent('td');
            var files = !!this.files ? this.files : [];
            $(inputfile).find(".prev_pic").html("");
            $(inputfile).find(".img_prev").val("");
            $('#temp-val').val(files.length);
            if (!files.length || !window.FileReader) return;
            if (/^image/.test( files[0].type) && files[0].name.toLowerCase().match(/(?:jpg|jpeg|png|bmp)$/)){
                var reader = new FileReader();
                reader.readAsDataURL(files[0]);
                imageName = files[0].name;
                reader.onloadend = function(){
                    $(inputfile).find(".prev_pic").show();
                    $(inputfile).find(".prev_pic p").remove();
                    $(inputfile).find(".prev_pic").html("<img id='interviewer_photo' src='" + this.result + "'  alt=''><br>");
                    $(inputfile).find(".img_prev").val(this.result);
                }
            } else {
                $(inputfile).find(".prev_pic p").remove()
                $(inputfile).find(".prev_pic").prepend('<p class="errors err">画像ではありません。画像を選択してください。</p>');
                $(inputfile).find(".prev_pic img").hide();
            }

        });

        if ($('#flag_success').val()==1 && $('#error_upload').val() != 1) {
            var base_url = "<?php echo base_url()?>";
        }

        $('.edit_faq').live('click', function(){
            var msg_id = $(this).parent('div').find('input').data('msg-id');
            var q_content = $(this).parent('div').find('.q_content').val();
            var ans_content = $(this).parent('div').find('.ans_content').val();
            $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>owner/interviewer/faq_user_owner_update',
              data: {
                      msg_id: msg_id,
                      q_content: q_content,
                      ans_content: ans_content
                    },
              dataType: 'json',
              success: function(data){
                if (data) {
                    alert('FAQの更新が完了しました。');
                    location.reload();
                }
              }
            });

            return false;
        });

        $('.delete_faq').live('click', function(){
            var msg_id = $(this).parent('div').find('input').data('msg-id');
            $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>owner/interviewer/faq_user_owner_delete',
              data: {
                      msg_id: msg_id,
                    },
              dataType: 'json',
              success: function(data){
                if (data) {
                    alert('FAQの削除が完了しました。');
                    location.reload();
                }
              }
            });

            return false;

        });

        var working_days_info_count = '<?php echo count($working_days_info); ?>';
        $('.add_working_day button').click(function(){
            if (working_days_info_count > 3) {
                working_days_info_count++;
            } else {
                working_days_info_count = 4;
            }

            $('.box_working_days table').append(
                '<tr><td><div class="prev_pic"><img src=""></div>' +
                working_days_info_count + '. <input type="file" name="working_day_pic[]" class="working_day_pic"><br><br>' +
                '<textarea name="working_day_description[]"></textarea>' +
                '<br><br></td></tr>');
            return false;
        });

        var benefits = '<?php echo count($benefits); ?>';
        $('.benefits button').click(function(){
            if (benefits > 3) {
                benefits++;
            } else {
                benefits = 4;
            }

            $('.box_benefits').append(
                '<tr>' +
                    '<td>タイトル</td>' +
                    '<td><input type="text" name="benefits_title[]"></td>' +
                '</tr>' +
                '<tr>' +
                    '<td>文章</td>' +
                    '<td><textarea name="benefits_content[]"></textarea></td>' +
                '</tr>');
            return false;
        });

        $('form').submit(function(e){
            $('#success').remove();
            var this_click = $(this);
            var form_confirm = new FormData($(this)[0]);
            var ret = false;
            var pos = 0;
            if ($(this).find('p').hasClass('err')){
                pos = $(this).find('.err').position()['top'];
                ret = true;
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>owner/interviewer/validation_interview" ,
                    data: form_confirm,
                    dataType: "json",
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        var msg = '';
                        for(var x = 0; x < data.length; x++) {
                            msg += '<p>' + data[x] + '</p>';
                            ret = true;
                        }

                        pos = $(this_click).find('.errors').position()['top'];
                        $(this_click).find('.errors').html(msg);
                        return ret;
                    }
                });
            }
            if (ret) {
                $('html, body').animate({scrollTop:pos}, 'slow');
                return false;
            }

        });

        $('.question_answer').click(function(){
            var thistop = $(this).parents('div').children('table').height();
            var qnada = $(this).parents('div').children('table').position().top;
            $('.box_qanda').remove();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>owner/interviewer/question_answer" ,
                data: '',
                async: false,
                success: function(data){
                    $('.box_modal').show();
                    var body_height = $('body').height();
                    var body_width = $('body').width();
                    $('.box_modal_bg').css({'height': body_height, 'width': body_width});
                    $('.box_modal_bg').show();
                    $('.box_modal').append(data);
                    $('.box_modal').css({'top': qnada});
                    var pos = $('.box_modal').position()['top'];
                    $('html, body').animate({scrollTop:pos}, 'slow');
                }
            });
            return false;
        });

        $('.box_qanda li > a').live('click', function(){
            var page_id = $(this).data('page-id');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>owner/interviewer/question_answer" ,
                data: {'page_id': page_id},
                async: false,
                success: function(data){
                    $('.box_qanda').remove();
                    $('.box_modal').append(data);
                }
            });
            return false;
        });

        $('.close').click(function(){
            $('.box_modal_bg').hide();
            $('.box_modal').hide();
        });

        $('.insert_faq').live('click', function(){
            var msg_id = $(this).data('msg-id');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>owner/interviewer/owner_faq_update',
                data: {
                      msg_id: msg_id
                    },
                dataType: 'json',
                success: function(data){
                    if (data) {
                        alert('本質門をFAQに追加しました。');
                        location.reload();
                    }
                }
            });
        });

        $('.add_faq').click(function(){
            $('.qanda_info').append('<div>Q. <textarea type="text" class="q_content"></textarea>' +
                                        '<input type="hidden" data-msg-id="">' +
                                        '<br><br>' +
                                    'A. <textarea type="text" class="ans_content"></textarea>' +
                                        '<br><br>&nbsp;&nbsp;&nbsp;<button class="edit_faq">更新</button></div>');
        });

        $('#interviewer .save_all_button').click(function(){
            var form_count = $('form').length;
            var count = 1;
            var ret = false;
            var pos = 0;
            $("form").each(function(){
                $('#success').remove();
                var this_click = $(this);
                var form_confirm = new FormData($(this)[0]);
                if ($(this).find('p').hasClass('err')){
                    pos = $(this).find('.err').position()['top'];
                    ret = true;
                } else {
                    if (count != (form_count)) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>owner/interviewer/validation_interview" ,
                            data: form_confirm,
                            dataType: "json",
                            async: false,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(data){
                                var msg = '';
                                for(var x = 0; x < data.length; x++) {
                                    msg += '<p>' + data[x] + '</p>';
                                    ret = true;
                                    pos = $(this_click).find('.errors').position()['top'];
                                }

                                $(this_click).find('.errors').html(msg);
 
                                count++;
                                return ret;
                            }
                        });
                    }
                }
            });

            if (!ret) {
                $("form").each(function(){
                    var form_confirm = new FormData($(this)[0]);
                    form_confirm.append('save_all_data', true);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>owner/interviewer/" ,
                        data: form_confirm,
                        dataType: "json",
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data){
                            window.location.replace("<?php base_url(); ?>interviewer");
                        }
                    });
                });
            } else {
                $('html, body').animate({scrollTop:pos}, 'slow');
            }

            return false;
        });

        // <!-- script for back-to-top  button
        var offset   = 1000; // starting point for back-to-top button
        var duration = 300;
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('#interviewer .back-to-top').fadeIn(duration);
            } else {
                jQuery('#interviewer .back-to-top').fadeOut(duration);
            }
        });

        jQuery('#interviewer .back-to-top').click(function(event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        })
        // script for back-to-top button -->
    });

    function userstat(){
        var total = 0;
        $('#women_data select').each(function(){
            total = parseInt($(this).val()) + parseInt(total);
        });
        $('#women_data_err').remove();
        if (total > 100) {
            $('#women_data').before('<p id="women_data_err" class="errors err">100%を超えています。</p>');
            return false;
        } else if (total < 100) {
            $('#women_data').before('<p id="women_data_err" class="errors err">100%になるように、再度選択ください。</p>');
            return false;
        }
    }
</script>
<div class="crumb">TOP ＞ 未経験者向け登録</div>
<br >
<center>
    <div id='interviewer'>
        <?php if ($interviewer_success) : ?>
        <p id="success">保存が完了しました。</p>
        <?php endif; ?>
        <!-- 全項目保存ボタン -->
<!--         <a href="#" class="save_all_button">全項目保存</a>  -->
        <!-- 当店はここが違う -->
        <form method="post" enctype="multipart/form-data">
            <div class="errors"></div>
            <div class="page_link"><a target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-43.html">ワンポイント講座</a></div>
            <table cellspacing="10">
                <tr>
                    <td width="182">当店はここが違う</td>
                    <td>
                        <div class="prev_pic"><img src="<?php
                        $has_photo = $speciality && isset($speciality['photo']) && $speciality['photo'] ? true: false;
                        echo $has_photo ? base_url() . $speciality['photo'] : '' ?>" <?php $has_photo ? '' : 'style="display: none;"' ?>></div>
                        <button class="btn_delete_spec_photo">削除</button>
                        <input type="hidden" class="img_prev" name="prev_pic[]" value="<?php echo ($speciality && isset($speciality['photo'])) ? base_url().$speciality['photo'] : '' ?>">
                        <input type="file" name="speciality_photo" class="interviewer_pic"> <br/><br/>
                        <textarea maxlength="150" name="speciality_content"><?php echo $speciality ? $speciality['content'] : ''; ?></textarea>
                        <p>
                            150文字以内<br>
                            ※画像サイズは、横100px 縦100pxでお願いします。
                        </p>
                    </td>
                </tr>
            </table>
            <input class="confirm" type="submit" value="保存" >
            <input type="hidden" name="speciality">
        </form>

        <!-- 先輩登録 -->
        <form method="post" enctype="multipart/form-data">
            <div class="errors"></div>
            <div  class="page_link"><a target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-42.html">ワンポイント講座</a></div>
            <table cellspacing="10">
                <tr>
                    <th colspan="2">先輩登録</th>
                </tr>
                <?php for ($x=0; $x < $total_senior_profile; $x++) : ?>
                <tr>
                    <td width="180"></td>
                    <td>
                        <div class="prev_pic"><img src="<?php echo (isset($senior_profile_info[$x]['senior_photo'])) ? base_url().$senior_profile_info[$x]['senior_photo'] : '' ?>" <?php echo (isset($senior_profile_info[$x]['senior_photo'])) ? '' : 'style="display: none;"' ?>></div>
                        <input type="hidden" class="img_prev" name="prev_pic[]" value="<?php echo (isset($senior_profile_info[$x]['senior_photo'])) ? base_url().$senior_profile_info[$x]['senior_photo'] : '' ?>">
                        <input type="file" name="senior_photo[]" class="senior_photo interviewer_pic">
                        <p>※画像サイズは、横100px 縦100pxでお願いします。</p>
                    </td>
                </tr>
                <tr>
                    <td>月収</td>
                    <td>
                        <select name="monthly_income[]">
                            <option value=""></option>
                            <?php for($i=10;$i<=100;$i++) :?>
                                <option value="<?php echo $i?>" <?php echo (isset($senior_profile_info[$x]) && $senior_profile_info[$x]['monthly_income'] == $i ? 'selected': ''); ?>><?php echo $i?>万円</option>
                            <?php endfor;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>勤続期間</td>
                    <td>
                        <select name="service_length[]">
                            <option value=""></option>
                            <?php for($i=0; $i<=36; $i++) :?>
                                <?php $display_text = "";
                                if ($i == 0) {
                                    $display_text = "1ヶ月未満";
                                } else if ($i >= 36 ) {
                                    $display_text = "3年以上";
                                } else if ($i >= 12) {
                                    $display_text = (int)($i/12). "年";
                                    if ($i%12 != 0) {
                                        $display_text .= ($i%12) . "ヶ月";
                                    }
                                } else {
                                    $display_text = $i . "ヶ月";
                                }
                                ?>
                                <option <?php echo (isset($senior_profile_info[$x]) && $senior_profile_info[$x]['service_length'] == $i? 'selected': ''); ?> value="<?php echo $i?>">
                                    <?php echo $display_text; ?></option>
                                <?php endfor;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>年齢</td>
                        <td>
                            <select name="senior_age[]">
                                <option value=""></option>
                                <?php for($i=18;$i<=50;$i++) :?>
                                    <option <?php echo (isset($senior_profile_info[$x]) && $senior_profile_info[$x]['senior_age'] == $i? 'selected': ''); ?>><?php echo $i;?></option>
                                <?php endfor;?>
                            </select> 才
                        </td>
                    </tr>
                    <tr>
                        <td>月間勤務日数</td>
                        <td>
                            <select name="monthly_work_days[]">
                                <option value=""></option>
                                <?php for($i=1;$i<=31;$i++) :?>
                                    <option <?php echo (isset($senior_profile_info[$x]) && $senior_profile_info[$x]['monthly_work_days'] == $i? 'selected': ''); ?>><?php echo $i;?></option>
                                <?php endfor;?>
                            </select> 文字数10文字
                        </td>
                    </tr>
                    <tr>
                        <td>風俗勤務経験</td>
                        <td>
                            <select name="work_experience[]">
                                <option value=""></option>
                                <option <?php echo (isset($senior_profile_info[$x]) && $senior_profile_info[$x]['work_experience'] == '経験者'? 'selected': ''); ?>>経験者</option>
                                <option <?php echo (isset($senior_profile_info[$x]) && $senior_profile_info[$x]['work_experience'] == '未経験者'? 'selected': ''); ?>>未経験者</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>コメント</td>
                        <td>
                            <textarea name="senior_comment[]"><?php echo (isset($senior_profile_info[$x]) ? $senior_profile_info[$x]['comment'] : ''); ?></textarea>
                            <p>※30文字～150文字</p>
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
            <input class="confirm" type="submit" value="保存" >
            <input type="hidden" name="senior_profile">
        </form>

        <!-- 在籍女性データ -->
        <form method="post" enctype="multipart/form-data">
            <div class="errors"></div>
            <div class="page_link"><a target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-44.html">ワンポイント講座</a></div>
            <table id="women_data" cellspacing="10">
                <tr>
                    <th colspan="2">在籍女性データ</th>
                </tr>
                <tr>
                    <td width="182">10代</td>
                    <td>
                        <select name="user_percent[]">
                            <?php for($i=0;$i<=100;$i += 10) :?>
                                <option <?php echo ($statistics && $statistics[0]['user_percent'] == $i? 'selected': ''); ?>><?php echo $i;?></option>
                            <?php endfor;?>
                        </select> %
                    </td>
                </tr>
                <tr>
                    <td>20代</td>
                    <td>
                        <select name="user_percent[]">
                            <?php for($i=0;$i<=100;$i += 10) :?>
                                <option <?php echo ($statistics && $statistics[1]['user_percent'] == $i? 'selected': ''); ?>><?php echo $i;?></option>
                            <?php endfor;?>
                        </select> %
                    </td>
                </tr>
                <tr>
                    <td>30代</td>
                    <td>
                        <select name="user_percent[]">
                            <?php for($i=0;$i<=100;$i += 10) :?>
                                <option <?php echo ($statistics && $statistics[2]['user_percent'] == $i? 'selected': ''); ?>><?php echo $i;?></option>
                            <?php endfor;?>
                        </select> %
                    </td>
                </tr>
                <tr>
                    <td>40代</td>
                    <td>
                        <select name="user_percent[]">
                            <?php for($i=0;$i<=100;$i += 10) :?>
                                <option <?php echo ($statistics && $statistics[3]['user_percent'] == $i? 'selected': ''); ?>><?php echo $i;?></option>
                            <?php endfor;?>
                        </select> %
                    </td>
                </tr>
                <tr>
                    <td>50代以上</td>
                    <td>
                        <select name="user_percent[]">
                            <?php for($i=0;$i<=100;$i += 10) :?>
                                <option <?php echo ($statistics && $statistics[4]['user_percent'] == $i? 'selected': ''); ?>><?php echo $i;?></option>
                            <?php endfor;?>
                        </select> %
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>※合計で100%にしてください</td>
                </tr>
                <tr>
                    <td>補足文章</td>
                    <td>
                        <textarea name="data_content"><?php echo $statistics ? $statistics[5]['content'] : ''; ?></textarea>
                        <p>※5０文字以内</p>
                    </td>
                </tr>
            </table>
            <input class="confirm" type="submit" value="保存" onclick="userstat()">
            <input type="hidden" name="statistics">
        </form>

        <!-- 1日の流れ」店舗登録画面 -->
        <form method="post" enctype="multipart/form-data">
            <div class="errors"></div>
            <div class="page_link"><a target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-45.html">ワンポイント講座</a></div>
            <table cellspacing="10">
                <tr>
                    <th colspan="2">「1日の流れ」店舗登録画面</th>
                </tr>
                <tr>
                    <td width="182">お仕事説明</td>
                    <td>
                        <textarea name="job_description"><?php echo $job_explanation ? $job_explanation['content'] : ''; ?></textarea>
                        ※200文字以内
                    </td>
                </tr>
                <tr>
                    <td>1日のお仕事の流れ</td>
                    <td class="box_working_days">
                        <table>
                            <?php
                                $count = 1;
                                foreach ($working_days_info as $key => $value) : ?>
                                <tr>
                                    <td>
                                    <div class="prev_pic"><img style="<?php echo ($value['working_day_pic'] == null) ? 'display:none;':'';?>" src="<?php echo (isset($value['working_day_pic'])) ? base_url().$value['working_day_pic'] : ''; ?>" ></div>
                                    <input type="hidden" class="img_prev" name="prev_pic[]" value="<?php echo (isset($value['working_day_pic'])) ? base_url().$value['working_day_pic'] : ''; ?>">
                                    <?php echo $count; $count++;?>. <input type="file" name="working_day_pic[]" class="working_day_pic"><br><br>
                                    <textarea name="working_day_description[]"><?php echo $value['working_day_description']; ?></textarea>
                                    <br><br>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            for ($x=$count;$count <= 3 && $x <= 3 ;$x++): ?>
                            <tr>
                                <td>
                                <div class="prev_pic"><img src="" style="display:none;"></div>
                                <input type="hidden" class="img_prev" name="prev_pic[]" >
                                <?php echo $x; ?>. <input type="file" name="working_day_pic[]" class="working_day_pic" ><br><br>
                                <textarea name="working_day_description[]"></textarea>
                                <br><br>
                                </td>
                            </tr>
                            <?php endfor; ?>
                        </table>
                    </td>
                <tr>
                    <td></td>
                    <td>
                        <p class="add_working_day"><button>追加</button></p>
                        ※5０文字以内<br>
                        ※画像サイズは、横100px 縦100pxでお願いします。<br>
                        ※１つだけの登録でも表示されます</td>
                </tr>
                <tr>
                    <td>お仕事動画</td>
                    <td id="youtube_embed">
                        <p>youtubeタグ<br>
                        <input type="text" name="youtube_embed" value="<?php echo $job_explanation ? htmlentities($job_explanation['youtube_embed']) : ''; ?>"><br>
                        youtubeから動画の引用方法は<a href="http://joyspe1.blog.fc2.com/blog-entry-45.html">こちら</a></p>
                    </td>
                </tr>

                </tr>
            </table>
            <input class="confirm" type="submit" value="保存" >
            <input type="hidden" name="jobexplanation">
        </form>

        <div class="wrapper_qanda">
            <div class="page_link"><a target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-46.html">ワンポイント講座</a></div>
            <div>
                <table cellspacing="10">
                    <tr>
                        <th>よくある質問</th>
                    </tr>
                    <tr>
                        <td class="qanda_info">
                            <?php
                                foreach ($faq_messages as $key) {
                                            echo '<div>
                                                Q. <textarea type="text" class="q_content">' . $key['question'] . '</textarea>
                                                <input type="hidden" data-msg-id="' . $key['id']. '">
                                                <br><br>
                                                ';
                                            echo 'A. <textarea type="text" class="ans_content">' . $key['answer'] . '</textarea>
                                            <br><br>&nbsp;&nbsp;&nbsp;<button class="edit_faq">更新</button>
                                            <button class="delete_faq">削除</button></div>';
                                }
                            ?>
                        </td>
                    </tr>
                </table>
                <button class="question_answer">引用</button>
                <button class="add_faq">追加</button><br>
                <div class="box_modal_bg"></div>
                <div class="box_modal">
                    <div class="close">
                        <button>X</button>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" enctype="multipart/form-data">
            <div class="errors"></div>
            <div class="page_link"><a target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-48.html">ワンポイント講座</a></div>
            <table class="box_benefits" cellspacing="10">
                <tr>
                    <th colspan="2">入店までの流れ</th>
                </tr>
            <?php
                $count = 1;
                foreach ($benefits as $key => $value) : ?>
                    <tr>
                        <td width="182">タイトル</td>
                        <td><input width="100%" type="text" name="benefits_title[]" value="<?php echo $value['title']?>"></td>
                    </tr>
                    <tr>
                        <td>文章</td>
                        <td><textarea name="benefits_content[]"><?php echo $value['content']?></textarea></td>
                    </tr>
                <?php $count++;
                endforeach;
                for ($x=$count;$count <= 3 && $x <= 3 ;$x++): ?>
                    <tr>
                        <td>タイトル</td>
                        <td><input width="100%" type="text" name="benefits_title[]"></td>
                    </tr>
                    <tr>
                        <td>文章</td>
                        <td><textarea name="benefits_content[]"></textarea></td>
                    </tr>
                <?php endfor; ?>
            </table>
            <p class="p_200">
                ※タイトルは10文字以内です<br>
                ※文章は50文字以内です<br>
                ※1つだけの登録でも可能です。<br>
            </p>
            <p class="benefits"><button>追加</button></p>
            <input class="confirm" type="submit" value="保存" >
            <input type="hidden" name="benefits">
        </form>

        <form method="post" enctype="multipart/form-data">
            <div class="errors"></div>
            <div class="page_link"><a target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-22.html">登録方法</a></div>
            <table cellspacing="10">
                <tr>
                    <th colspan="2">私が面接します</th>
                </tr>
                <tr>
                  <td width="182"></td>
                  <td>
                    <div class="prev_pic"><img src="<?php echo (isset($interviewer['interviewer_photo'])) ? base_url().$interviewer['interviewer_photo'] : '' ?>" <?php echo (isset($interviewer['interviewer_photo'])) ? '' : 'style="display: none;"' ?>></div>
                    <input type="hidden" class="img_prev" name="prev_pic[]" value="<?php echo (isset($interviewer['interviewer_photo'])) ? base_url().$interviewer['interviewer_photo'] : '' ?>">
                    <input type="file" name="interviewer_pic" class="interviewer_pic"> <br/><br/>
                    <span>画像サイズは、横100px 縦100pxでお願いします。</span>
                  </td>
                </tr>
                <tr>
                    <td>名前</td>
                    <td><input type="text" name="name" id="name" value="<?php echo $interviewer ? $interviewer['interviewer_name'] : ''; ?>"></td>
                </tr>
                <tr>
                    <td>簡単な説明/コメント </td>
                    <td><textarea name="description"><?php echo $interviewer ? $interviewer['description'] : ''; ?></textarea></td>
                </tr>
                <tr>
                    <td>年齢</td>
                    <td><input type="text" name="age" value="<?php echo $interviewer ? $interviewer['age'] : ''; ?>"/></td>
                </tr>
                <tr>
                    <td>性別</td>
                  <td>
                      <select name="gender[]">
                           <option value="">--性別を選択する--</option>
                           <option value="男性" <?php echo ($interviewer && $interviewer['gender'] == '男性'? 'selected': ''); ?>>男性</option>
                           <option value="女性" <?php echo ($interviewer && $interviewer['gender'] == '女性'? 'selected': ''); ?>>女性</option>
                      </select>
                  </td>
                </tr>
                <tr>
                    <td>趣味</td>
                    <td><textarea name="hobby"><?php echo $interviewer ? $interviewer['hobby'] : ''; ?></textarea></td>
                </tr>

            </table>
            <input class="confirm" type="submit" value="保存" >
            <input type="hidden" name="interviewer">
        </form>

        <form method="post" enctype="multipart/form-data">
            <div class="page_link"><a target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-47.html">ワンポイント講座</a></div>
            <table cellspacing="10">
                <tr>
                    <td width="182">こんな方も大丈夫</td>
                    <td>
                    <ul>
                        <?php foreach ($all_user_characters as $key => $value) :?>
                            <li>
                            <input type="checkbox" name="treatments[]" value="<?php echo $value['id']; ?>" <?php echo isset($user_character[$value['id']]) ? 'checked': ''; ?>><?php echo $value['name']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    </td>
                </tr>
            </table>
            <input class="confirm" type="submit" value="保存" >
            <input type="hidden" name="treatment">
        </form>
        <!-- <a href="#" class="save_all_button">全項目保存</a>  -->
        <a href="#" class="back-to-top">
            <i class="fa fa-arrow-circle-up"></i>
        </a>
    </div>
</center>
