<?php $this->load->view('user/pc/header/header'); ?>
    <section class="section--main_content_area m_b_40">
        <div class="container">
            <form name="registration" action="" method="post" id="registration">
                <section class="section section--signup">
                <div class="box_white">
                    <h2 class="ttl_style_1">新規会員登録</h2>
                        <div class="box_inner pt_15 pb_7 cf t_center">
                            <p>
                                ご登録されたメールアドレス宛に<br >
                                登録情報をお送りさせて頂きました。<br ><br >                   
                                下記より次のステップへお進み下さい。
                            </p>
                            <div class="ui_btn_wrap ui_btn_wrap--half mt_15 mb_25 cf">
                                <ul>
                                    <li class="float_none">
                                        <a class="ui_btn" href="<?php echo base_url(); ?>user/settings/#form_age_verification">次のステップへ進む　</a>
                                    </li>                      
                                </ul>
                            </div>
                        </div>
                        <h3 class="ttl_1">【登録メールが届かない場合】</h3>
                        <div class="box_inner pt_15 pb_7 cf">
                            <p class="mb_10">docomo、au、softbankなど各キャリアのセキュリティ設定のためユーザー受信拒否と認識されているか、お客様が迷惑メール対策等で、ドメイン指定受信を設定されている場合に、メー ルが正しく届かないことがございます。以下のドメインを受信できるように設定してください。</p>
                            <p class="mb_10">以下ドメインを受信できるように設定をお願い致します。お手数ですが、再度ご登録の程よろしくお願い致します。</p>
                            <p class="fsize_16">@joyspe.com</p>
                        </div>
                    </div>
                </section>
            </form>
        </div>
        <!-- // .container -->
    </section>