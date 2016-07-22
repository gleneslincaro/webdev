<?php $this->load->view('user/pc/header/header'); ?>
    <section class="section--main_content_area m_b_40">
        <div class="container">
            <form name="registration" action="" method="post" id="registration">
                <section class="section section--signup">
                    <div class="box_white">
                        <h2 class="ttl_style_1">新規会員登録</h2>
                          <div class="box_inner pt_15 pb_7 cf">
                            <div class="signup_complete_wrap pt_15 cf">
                               <?php if (isset($makia)) : ?>
                                <p>
                                    登録すると<span class="fc_red">ボーナス付きのスカウトメール</span>をもらえる確率がグ～んとあがります！<br />
                                    求人情報もたくさん来るので高条件を探すこともできます！<br /><br /><br />   
                                </p>
                               <?php else : ?>
                               <p>登録が完了しました！</p>                 
                               <h4>プロフィール登録のすすめ</h4>
                               <p>プロフィールはなるべく詳しく書いておこう！プロフィールをたくさん書いておくと色々なお店からスカウトメールが届くよ。<br />たくさんのオファーをもうらうことで最高の条件の求人情報を受け取ることが出来るよ！！</p>
                               <?php endif; ?>
                            </div>
                            <section class="section--denial">
                                <div class="select_btn">
                                    <ul>
                                        <?php 
                                            $link = 'href="'.$to_url.'"';
                                            if (HelperApp::aruaru_or_onayami($to_url) !== false) { 
                                                $link = "href='javascript:void(0);' onclick='clearExternalSession(\"$to_url\");'";
                                            }
                                        ?>
                                        <li> <a class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta" <?php echo $link; ?>>あとで</a> </li>
                                        <li> <a class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta" href="<?php echo base_url()."user/settings/"; ?>">プロフィール登録をする</a> </li>
                                    </ul>
                                </div>
                            </section>
                          </div><!-- // .box_inner -->
                    </div>
                </section>
            </form>
        </div>
        <!-- // .container -->
    </section>
    <script type="text/javascript">
    function clearExternalSession(backUrl) {
        $.ajax({
            type : 'POST',
            dataType : 'json',
            url: '/user/registration/unsetExternalSession',
            success: function (response) {
                window.location = backUrl;
            }
        });
    } 
    </script>