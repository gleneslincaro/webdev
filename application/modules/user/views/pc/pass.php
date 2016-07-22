<?php $this->load->view('user/pc/header/header'); ?>
  <section class="section--main_content_area m_b_40">
    <div class="container cf">
<!--      <form action="/joyspe/static/pc/pass_page.html">  -->
        <section class="section section--forgot">
          <div class="box_white">
            <h2 class="ttl_style_1">パスワードを忘れた場合</h2>
            <p>パスワード再送をご希望の方は、下記フォームに登録メールアドレスを入力し再送ボタンを押してください。<br>
              登録メールアドレスにパスワードが記載されたメールが届きます。</p>
            <form name="resendpassword" action=""  method="post">
            <div class="form_wrap">
              <div class="form_item_wrap m_t_20">
                <div class="email_wrap m_b_20">
                  <?php //if (isset($message)) : ?>
                    <?php //echo Helper::print_error($message); ?>
                  <?php //endif; ?>
                  <h3 class="t_1">登録メールアドレス</h3>
                  <?php echo form_error('email'); ?>
                  <input placeholder="" maxlength="100" name="email" type="email" required value="<?php echo set_value('email'); ?>">
                </div>
              </div>
              <div class="btn_wrap t_center m_b_10">
                <ul>
                  <li>
<!--                    <button type="submit" class="ui_btn btn_style ui_btn--bg_magenta m_t_10">送信</button>  -->
                    <input type="submit" class="ui_btn btn_style ui_btn--bg_magenta m_t_10" value="送信" name="btn"/></input>
                  </li>
                </ul>
              </div>
              <div class="sec_other_cases">
                <p class="m_t_30 m_b_10">再送メールが届かない方は下記よりお問い合わせください。</p>
                <div class="btn_wrap t_center">
                  <ul>
                    <li><a href="<?php echo base_url(); ?>user/contact/" class="ui_btn btn_style ui_btn--bg_green">お問い合わせ</a></li>
                  </ul>
                </div>
              </div>
            </div>
            </form>
          </div>
        </section>
<!--      </form>  -->
    </div>
    <!-- // .container --> 
  </section>