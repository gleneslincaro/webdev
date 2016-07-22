<ul class="mybreadcrumb pagebody--white">
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url();?>" itemprop="url"><span itemprop="title">TOP</span></a></li>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../../" itemprop="url"><span itemprop="title">groupCity_info</span></a></li>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../" itemprop="url"><span itemprop="title">city_info</span></a></li>
    <li class="active">breadText</li>
</ul>
<section class="section section-consultation cf">
        <div class="content_box consultation">
            <div class="content_wrap">
                <?php if(isset($validation_error)): ?>
                <?php echo $validation_error; ?>
                <?php endif; ?>
                <div class="form_name"> <span class="consultation_ttl">ニックネーム：</span><span>ニックネームさん</span>
                    <p class="additional_info">ニックネームは公開されるので、個人が特定されるようなお名前はお控えください。<span>変更する方は</span><a class="go_user_my_page" href="private.html">マイページ</a>から再設定をお願いします。</p>
                </div>
                <div class="form_name"><span class="consultation_ttl">相談するカテゴリを選択　（必須）</span></div>
                <form method="post" class="firstpulldown" id="consultation" action="<?php echo base_url(); ?>user/consultation/posting/" >
                    <select class="select_basic" onchange="SetSubMenu(value);" name="big_category">
                        <option value="">選択してください</option>
                        <?php foreach ($big_category_ar as $key => $entry): ?>
                        <option value="<?php echo $entry['id']; ?>"><?php echo $entry['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                <?php foreach ($category_ar as $key => $entry): ?>
                <select class="select_basic" id="big_category<?php echo $key; ?>" name="">
                    <?php foreach ($entry as $key2 => $entry2): ?>
                    <option value="<?php echo $key2; ?>"><?php echo $entry2; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php endforeach; ?>

                    <h3>相談内容</h3>
                    <div class="form_name"><span class="consultation_ttl">タイトル（必須）</span><span class="count_input">50</span></div>
                    <input type="text" class="input_basic" placeholder="50文字以内で相談の内容が分かるように入力してください" name="consultation_title">
                    <div class="form_name"> <span class="consultation_ttl">内容（必須）</span><span class="count_textarea">1000</span></div>
                    <label>
                        <textarea class="input_basic textarea" id="" placeholder="30文字～1000文字までの間で入力してください。" name="consultation_message"></textarea>
                    </label>

                </form>

                    <ul class="btn_wrap m_t_20">
<!--                        <li><a href="consultation_confirmation.html" class="green_btn btn_x_small m_t_20">確認</a></li> -->
                        <li><a href="javascript:void(0);" id="category_submit" class="green_btn btn_x_small m_t_20">確認</a></li>
                    </ul>
            </div>
        </div>

</section>
<script src="/public/user/js/jquery.count.min.js" type="text/javascript"></script> 
<script type="text/javascript">
   AllHide();

$(function(){
    $('#category_submit').click(function() {
        $('#consultation').submit();
    });
});


function AllHide() {
    <?php foreach ($big_category_ar as $key => $entry): ?>
    $("#big_category<?php echo $entry['id']; ?>").hide();
    <?php endforeach; ?>
}
function SetSubMenu(idname) {
    AllHide();
    if(idname != "") {
        $("#big_category"+idname).show();
    }
/*   if( idname != "" ) {
      document.getElementById(idname).style.display = 'block';
   }*/
}
</script>