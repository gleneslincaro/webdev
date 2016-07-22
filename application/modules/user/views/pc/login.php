<style>
.pass_form img{
float: left;
}  
.pass_form input{
margin-left:10px;
}  
</style>
<?php //$this->load->view('user/pc/header/header'); ?>
<?php //$this->load->view('user/pc/header/header_aruaru'); ?>
  <?php
    if (isset($site_type)) {
      if ($site_type == 'aruaru') {
        $this->load->view('user/pc/header/header_aruaru');
      } elseif ($site_type == 'onayami') {
        $this->load->view('user/pc/header/header_onayami');
      }
    } else {
      $this->load->view('user/pc/header/header');
    }
  ?>
  <section class="section--main_content_area m_b_40">
    <div class="container">
      <form action="" method="post" name="login">
        <section class="section section--login">
        <div class="box_white">
          <h2 class="ttl_style_1">ログイン</h2>
          <div class="form_wrap">
          
            <div class="form_item_wrap">
              <div class="email_wrap m_b_20">
                  <?php if (isset($message)) : ?><?php echo Helper::print_error($message); ?><?php endif; ?>
                <h3 class="t_1">メールアドレス</h3>
                <p><input name="email" placeholder="" maxlength="100" type="email" required value="<?php echo set_value('email'); ?>"></p>
              </div>
              
              <div class="password_wrap">
                <h3 class="t_1">パスワード</h3>
<!--                <div class="ui_msg ui_msg-error">
                  <p>バリデーションエラーを表示する。</p>
                </div>-->
                <p><input name="password" placeholder="" type="password" required value="<?php echo set_value('password'); ?>"></p>
                <p class="m_t_10">※半角英数字4文字以上20文字以内</p>
              </div>
              <?php if (isset($captcha_img)) : ?>
              <p class="m_t_10">下記の文字を入力してください。</p>
              <div class="pass_form">
                <?php echo $captcha_img; ?>
                <input type="text" name="captcha" value="" placeholder="文字を入力してください。"/>
                <input type="hidden" name="has_captcha" value="true"/>
              </div>
              <?php endif; ?>
            <input type="hidden" name="backurl" value="<?php echo $backurl; ?>" />
            </div>
            
            <div class="btn_wrap t_center m_t_30 m_b_10">
              <ul>
                <li>
                  <input type="submit" class="ui_btn btn_style ui_btn--bg_green" value="ログイン" name="btn"/></input>
                </li>
              </ul>
            </div>
            
            <p class="t_center"><a class="t_link" href="<?php echo base_url(); ?>user/pass/pass_page">パスワードを忘れた方はこちら</a></p>
            <!--
            <div class="sec_other_cases">
              <h3 class="t_1 t_center m_t_20">お得な情報は会員登録後にご確認いただけます</h3>
              <div class="btn_wrap t_center">
                <ul>
                  <li><a href="./signup.html" class="ui_btn btn_style ui_btn--bg_magenta m_t_10">新規会員登録</a></li>
                </ul>
              </div>
            </div>
            -->
          </div>
          </div>
        </section>
      </form>
    </div>
    <!-- // .container --> 
  </section>