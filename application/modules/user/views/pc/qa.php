<script type="text/javascript" src="<?php echo base_url(); ?>public/user/pc/js/faq.js" ></script>
<?php $this->load->view('user/pc/header/header'); ?>
    <section class="section--main_content_area">
        <div class="container cf">
            <div class="box_white">
                <section class="section--feature_faq">
                    <div class="feature_faq">
                        <h2 class="ttl_style_1">FAQ</h2>
                        <dl id="travel_expense_1">
                            <dt>面接の時に交通費の承認をお願いしてもよいのですか？</dt>
                            <dd>面接の時に『ジョイスペを見て来ました。承認よろしくお願いします。』と笑顔でお願いしてきてください。<br>
                                店舗様も毎日に沢山の女の子を面接したりしていますので対応が遅れてしまうこともあります。<br>
								一言お願いするだけで対応がより早くなると思いますよ！</dd>
                        </dl>
                        <dl>
                            <dt>面接交通費はどのようにしてもらうことができますか？</dt>
                            <dd> 面接に行かれましたら各店舗に設置された申請ボタンより申請を行ってください。 <br>
                                申請されますと店舗へ通知が行きますので承認を受けることで受け取ることができます。</dd>
                        </dl>
                        <dl>
                            <dt>面接交通費の申請ボタンが無くなりました。</dt>
                            <dd> こちらはキャンペーンですので告知無く終了する場合がございます。</dd>
                        </dl>
                        <dl>
                            <dt>お友達と面接に行ってもいいですか？</dt>
                            <dd> 体験入店を前提とした場合に限り可能とします。</dd>
                        </dl>
                        <dl>
                            <dt>面接交通費が支給されません</dt>
                            <dd> 店舗から承認が取れていない場合や身分証明書が登録されていない場合はお支払いできません。<br>
                                その他には
                                <ul>
                                    <li>1.店舗から「ひやかし」と判断されてしまった場合</li>
                                    <li>2.プロフィール画像が無いために店舗側で会員を把握できず承認されない場合</li>
                                    <li>3.店舗がログインをしていないために承認されない場合</li>
                                    <li>4.サイトご登録から3日以内の申請は無効とさせて頂きます。</li>
                                    <li>5.サイト内での求職活動履歴の無いアカウントの場合</li>
                                    <li>6.当社調査により不正アカウントの疑いがある場合</li>
                                    <li>7.LINEでの面接の場合</li>

                                </ul>
                                ※これらの理由の場合、運営からお支払いをすることが一切出来ませんのでご注意ください。</dd>
                        </dl>
                        <dl id="trial_work_1">
                            <dt>体験入店お祝い金申請はいつもらえますか？</dt>
                            <dd>お店で体験入店が終わりましたらジョイスペから申請ボタンを押してください。<br>
                                お店から承認をもらうことでお祝い金をお支払いいたします。<br>
								体験入店を終えた後にお店を出る際は『本日はありがとうございました！ジョイスペの承認よろしくお願いします。』と一言添えて帰って来てくださいね。</dd>
                        </dl>
                        <dl>
                            <dt>体験入店のお祝い金は本入店した場合はもらえないのですか？</dt>
                            <dd> いいえ。本入店の場合でも問題ありません。是非ご申請ください。</dd>
                        </dl>
                        <dl>
                            <dt>体験入店の回数に制限はありますか？</dt>
                            <dd> いいえ。何店舗でも可能です。</dd>
                        </dl>
                        <dl>
                            <dt>体験入店の申請と交通費の申請を同時にできますか？</dt>
                            <dd> はい。同時に申請を頂いても問題ありません。合計の金額をお支払いいたします。</dd>
                        </dl>
                    </div>
                </section>
            </div>
            <div class="box_white" id="form_contact">
                <section class="section--contact">
                    <form method="post" action="#form_contact" name="form_contact_us" id="form_contact_us">
                    <div class="infomation">
                        <h2 class="ttl_style_1">お問い合わせ</h2>
                        <dl class="form_style_1">
                            <dt>メールアドレス</dt>
                            <dd>
                                <?php echo form_error('email'); ?>
                                <input type="email" name="email" class="size_max" value="<?php echo set_value('email', $email)?>" placeholder="" />
                            </dd>
                            <dt>件名</dt>
                            <dd>
                                <?php echo form_error('subject'); ?>
                                <input type="text" name="subject" class="size_max" value="<?php echo set_value('subject')?>" placeholder="" />
                            </dd>
                            <dt>本文</dt>
                            <dd>
                                <?php echo form_error('body'); ?>
                                <textarea name="body" class="size_max"><?php echo set_value('body')?></textarea>
                            </dd>
                        </dl>
                    </div>
                    <div class="btn_wrap m_t_20">
                        <ul>
                            <li>
                                <a class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta" href="javascript:void(0)" name="btnqa" id="contact_us">送信する</a>
                            </li>
                        </ul>
                    </div>
                    </form>
                    <div class="comment"> 営業日：平日（土日祝日を除く）<br>
                        営業時間：12:00～18:00<br>
                        登録メールが届かない場合<br>
                        セキュリティ設定のためユーザー受信拒否と認識されているか、お客様が迷惑メール対策等で、ドメイン指定受信を設定されている場合に、メールが正しく届かないことがございます。<br>
                        以下のドメインを受信できるように設定してください。<br>
                        @joyspe.jp</div>
                    <!-- // .container --> 
                </section>
            </div>
        </div>
    </section>