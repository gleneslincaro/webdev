<?php if (isset($site_type) && $site_type == 'aruaru') : ?>
<style>
.header {
    border-bottom: 2px solid #3765a1;
    background-image: none;
}
.header .breadcrumb {
    background: #3765a1 none repeat scroll 0 0;
}

.page_wrap {
    background: #3765a1 none repeat scroll 0 0;
}
</style>
<?php endif; ?>
<section class="section section--login cf">
    <h3 class="ttl_1">ログイン</h3>
    <?php if (isset($message)) : ?>
        <?php echo Helper::print_error($message); ?>
    <?php endif; ?>
    <form action="" method="post" name="login">
<div class="box_inner pt_15 pb_7 cf">
  <div class="login_form_wrap cf">
    <dl class="dl_1 cf">
      <dt><span>メールアドレス</span></dt>
      <dd class="mail_form pb_20">
        <input type="text" name="email" class="size_max bg_fff" value="<?php echo set_value('email'); ?>" placeholder="例：sample@joyspe.com">
      </dd>
      <dt class="mt_15"><span>パスワード</span></dt>
      <dd class="pass_form">
        <input type="password" name="password"  class="size_max bg_fff" value="<?php echo set_value('password'); ?>" placeholder="パスワードを入力してください">
        <p class="mt_10">※半角英数字4文字以上20文字以内</p>
      </dd>
      <?php if (isset($captcha_img)) : ?>
      <dt class="mt_15"><span>下記の文字を入力してください。</span></dt>
      <dd class="pass_form">
        <?php echo $captcha_img; ?>
        <input type="text" name="captcha" value="" class="size_max bg_fff mt_10" placeholder="文字を入力してください。" />
        <input type="hidden" name="has_captcha" value="true" />
      </dd>
      <?php endif; ?>
    </dl>
  </div>
  <div class="ui_btn_wrap ui_btn_wrap--center mt_20 mb_5 cf">
    <ul>
      <li>
        <input type="submit" class="ui_btn ui_btn--green ui_btn--large_liquid fsize_16 fw_bold" value="ログイン" name="btn"/></input>
      </li>
      <li><a href="<?php echo base_url(); ?>user/pass/pass_page">パスワードを忘れた方はこちら</a></li>
      <li class="mb_5"><a href="<?php echo base_url(); ?>user/signup/">未登録の方はこちら</a></li>
    </ul>
  </div>
</div>
    </form>
    <!-- <p class="tocenter_text"><a href="<?php echo base_url(); ?>user/pass/pass_page">&gt;&gt;パスワードを忘れた方はコチラ</a><br>※joyspeに登録した際のメールアドレスにてログインが行えます。</p> -->
</section>
