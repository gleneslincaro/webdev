<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/signup.js?v=20150511" ></script>   
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
<section class="section section--signup cf">
    <h3 class="ttl_1">新規会員登録</h3>
    <?php if(isset($message)) : ?>
        <?php echo Helper::print_error($message); ?>
    <?php endif; ?>
    <form name="registration" action="" method="post" id="registration">
        <div class="box_inner pt_15 pb_7 cf">
            <div class="signup_form_wrap cf">
                <dl class="dl_1 cf">
                    <dt><span>メールアドレス</span></dt>
                    <dd class="mail_form pb_20">
                        <input type="email" class="size_max bg_fff" name="email_address" value="<?php echo set_value('email_address'); ?>" placeholder="例：sample@joyspe.com"  />
                    </dd>
                    <dt class="pt_15"><span>パスワード</span></dt>
                    <dd class="pass_form">
                        <input type="password" class="size_max bg_fff" name="password" value="<?php echo set_value('password'); ?>" placeholder="パスワードを入力してください" />
                        <p class="pt_10">※半角英数字4文字以上20文字以内</p>
                    </dd>
                    <?php if(isset($makia)): ?>
                        <?php echo $this->load->view('user/template/makia'); ?>
                    <?php endif; ?>
                    <dd class="mt_10">
                        <p class="t_center">ご登録には利用規約に同意して頂く必要があります。<br />
                          利用規約は必ずお読みください。</p>
                        <!--<label><input type="checkbox" />利用規約に同意する</label>--> 
                    </dd>
                    <!--<dd>ご登録には利用規約に同意して頂く必要があります。利用規約は必ずお読み下さい。<br>
                        <div id="center_text">
                        <input type="checkbox" name="ok" id="ok" value="[<?php //echo '1'?>]" <?php //if(isset($_POST['ok'])) echo 'checked'; ?> onclick="showBtnRegist();">利用規約に同意する</div>
                    </dd> -->
                </dl>
            </div>
            <div class="ui_btn_wrap ui_btn_wrap--center mb_15 cf">
    <ul>
      <li class="mb_10"><input type="submit" class="ui_btn ui_btn--magenta ui_btn--large_liquid fsize_16 fw_bold"  id="btn" value="利用規約に同意して登録" name="btn" /></li>
      <li><a href="<?php echo base_url(); ?>user/tos/">利用規約はこちら</a></li>
      <li class="mb_5"><a href="<?php echo base_url(); ?>user/login/">すでに登録済の方はこちら</a></li>
    </ul>
            </div>
  <p class="btn_wrap_note mb_20">※18歳未満（高校生含む）の登録は行えません。<br />
    ご理解の程よろしくお願い致します。</p>
  <div class="signup_note">
    <p class="signup_note_ttl">【登録前にご確認下さい】</p>
    <p>■メールの設定をご確認ください<br />
      メールが正しく届かない場合がございます。</p>
    <ul>
      <li class="mt_10"><span>・</span>docomo、au、softbankなど各キャリアのセキュリティ設定で、ユーザー受信拒否と設定されている場合</li>
      <li class="mt_10 mb_10"><span>・</span>お客様が迷惑メール対策で、ドメイン指定受信を設定している場合</li>
    </ul>
    <p class="mb_10">上記の設定の方は、以下ドメインを受信できるように設定をお願いいたします。</p>
    <p class="mb_10">
      <input type="text" value="@joyspe.com" readonly onclick="this.select()" class="copy_txt" >
    </p>
            </div>
        </div><!-- // .box_inner -->
        <input type="hidden" name="linkemail" value="<?php echo base_url(); ?>user/certificate/certificate_after"/>
        <input type="hidden" value="<?php echo $webside?>" name="webside"/>
    </form>
</section>
