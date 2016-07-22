<!-- <script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/signup.js?v=20150511" ></script>  -->
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
            <form name="registration" action="" method="post" id="registration">
                <input type="hidden" name="backurl" value="<?php echo $backurl; ?>" />
                <section class="section section--signup">
                <div class="box_white">
                    <h2 class="ttl_style_1">新規会員登録</h2>
                    <div class="form_wrap">
                        <div class="form_item_wrap">
                            <div class="email_wrap m_b_20">
                                <h3 class="t_1">メールアドレス</h3>
                                <?php echo form_error('email_address'); ?>
                                <!-- <div class="ui_msg ui_msg-error"><p>バリデーションエラーを表示する。</p></div> -->
                                <p><input placeholder="" maxlength="100" type="email" required name="email_address" value="<?php echo set_value('email_address'); ?>"></p>
                            </div>
                            <div class="password_wrap">
                                <h3 class="t_1">パスワード</h3>
                                <?php echo form_error('password'); ?>
                                <!-- <div class="ui_msg ui_msg-error"><p>バリデーションエラーを表示する。</p></div> -->
                                <p><input placeholder="" type="password" required name="password" value="<?php echo set_value('password'); ?>"></p>
                                <p class="m_t_10">※半角英数字4文字以上20文字以内</p>
                            </div>
                        </div>
                        <p class="t_center m_t_30">ご登録には利用規約に同意して頂く必要があります。<br>
                        利用規約は必ずお読みください。</p>
                        <div class="btn_wrap t_center m_b_10">
                            <ul>
                                <li>
<!--                                    <button type="submit" class="ui_btn btn_style ui_btn--bg_magenta m_t_10">利用規約に同意して登録</button>  -->
                                    <input type="submit" class="ui_btn btn_style ui_btn--bg_magenta m_t_10" id="btn" value="利用規約に同意して登録" name="btn" />
                                </li>
                            </ul>
                        </div>
                        
                        <p class="t_center"><a class="t_link" href="<?php echo base_url(); ?>user/tos/">利用規約はこちら</a></p>
                        <!--
                        <div class="sec_other_cases p_t_20">
                            <h3 class="t_1 t_center">すでに登録済の方はこちら</h3>
                            <div class="btn_wrap t_center">
                                <ul>
                                    <li><a href="./login.html" class="ui_btn btn_style ui_btn--bg_green">ログイン</a></li>
                                </ul>
                            </div>
                        </div>
                        -->
                        <div class="sec_conditions m_t_30">
                            <ul>
                                <li>※18歳未満（高校生含む）の登録は行えません。<br>
                                ご理解の程よろしくお願い致します。</li>
                            </ul>
                        </div>

                        <div class="sec_discription m_t_30">
                            <h3 class="t_1">【登録前にご確認下さい】</h3>
                            <dl>
                                <dt>■メールの設定をご確認ください</dt>
                                <dd>
                                    <p>メールが正しく届かない場合がございます。</p>
                                    <ul>
                                        <li>・docomo、au、softbankなど各キャリアのセキュリティ設定で、ユーザー受信拒否と設定されている場合</li>
                                        <li>・お客様が迷惑メール対策で、ドメイン指定受信を設定している場合</li>
                                    </ul>
                                    <p>上記の設定の方は、以下ドメインを受信できるように設定をお願いいたします。</p>
                                    <p class="m_t_10"><input type="text" value="@joyspe.com" readonly></p>
                                </dd>
                            </dl>
                        </div>

                    </div>
                    </div>
                </section>
            </form>
        </div>
        <!-- // .container -->
    </section>