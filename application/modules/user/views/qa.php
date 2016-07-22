<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/faq.js?v=20150511" ></script>
<section class="section section--faq cf">
    <div class="settings_data_wrap cf">
        <h3 class="ttl_1">FAQ</h3>
        <div class="faq_list box_inner cf">
            <dl>
                <dt id="travel_expense"><span>Q</span>. 面接の時に交通費の承認をお願いしてもよいのですか？</dt>
                <dd><span>A</span>. 面接の時に『ジョイスペを見て来ました。承認よろしくお願いします。』と笑顔でお願いしてきてください。<br>店舗様も毎日に沢山の女の子を面接したりしていますので対応が遅れてしまうこともあります。<br>
									一言お願いするだけで対応がより早くなると思いますよ！</dd>
                <dt><span>Q</span>. 面接交通費はどのようにしてもらうことができますか？</dt>
                <dd><span>A</span>. 面接に行かれましたら各店舗に設置された申請ボタンより申請を行ってください。<br>申請されますと店舗へ通知が行きますので承認を受けることで受け取ることができます。</dd>
                <dt><span>Q</span>. 面接交通費の申請ボタンが無くなりました。</dt>
                <dd><span>A</span>. こちらはキャンペーンですので告知無く終了する場合がございます。</dd>

    <dt><span>Q</span>. お友達と面接に行ってもいいですか？</dt>
    <dd><span>A</span>. 体験入店を前提とした場合に限り可能とします。</dd>
    <dt><span>Q</span>. 面接交通費が支給されません</dt>
    <dd><span>A</span>. 店舗から承認が取れていない場合や身分証明書が登録されていない場合はお支払いできません。<br />その他には
      <ul>
        <li>1.店舗から「ひやかし」と判断されてしまった場合</li>
        <li>2.プロフィール画像が無いために店舗側で会員を把握できず承認されない場合</li>
        <li>3.店舗がログインをしていないために承認されない場合</li>
        <li>4.サイトご登録から3日以内の申請は無効とさせて頂きます。</li>
        <li>5.サイト内での求職活動履歴の無いアカウントの場合</li>
        <li>6.当社調査により不正アカウントの疑いがある場合</li>
        <li>7.LINEでの面接の場合</li>

      </ul>
      ※これらの理由の場合、運営からお支払いをすることが一切出来ませんのでご注意ください。
    </dd>

                <dt id="trial_work"><span>Q</span>. 体験入店お祝い金申請はいつもらえますか？</dt>
                <dd><span>A</span>. お店で体験入店が終わりましたらジョイスペから申請ボタンを押してください。<br />お店から承認をもらうことでお祝い金をお支払いいたします。<br>
									体験入店を終えた後にお店を出る際は『本日はありがとうございました！ジョイスペの承認よろしくお願いします。』と一言添えて帰って来てくださいね。</dd>
                <dt><span>Q</span>. 体験入店のお祝い金は本入店した場合はもらえないのですか？</dt>
                <dd><span>A</span>. いいえ。本入店の場合でも問題ありません。是非ご申請ください。</dd>
                <dt><span>Q</span>. 体験入店の回数に制限はありますか？</dt>
                <dd><span>A</span>. いいえ。何店舗でも可能です。</dd>
                <dt><span>Q</span>. 体験入店の申請と交通費の申請を同時にできますか？</dt>
                <dd><span>A</span>. はい。同時に申請を頂いても問題ありません。合計の金額をお支払いいたします。</dd>
            </dl>
        </div>
    </div>
</section>

<section class="section section--contact cf" id="form_contact">
    <form method="post" action="#form_contact" name="form_contact_us" id="form_contact_us">
        <div class="cf">
            <h3 class="ttl_1 mb_15">お問い合わせ</h3>
            <?php if(isset($message)) : ?>
                <div><?php echo Helper::print_error($message); ?></div>
            <?php endif; ?>
            <dl class="dl_1 cf">
                <dt class="ttl_3 ttl_3--salmon"><span>メールアドレス</span></dt>
                <dd><input type="email" name="email" class="size_max" value="<?php echo set_value('email',$email)?>" maxlength="100" class="messege_width100" /></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>件名</span></dt>
                <dd><input type="text" name="subject" class="size_max" value="" maxlength="100" class="messege_width100" /></dd>
                <dt class="ttl_3 ttl_3--salmon"><span>本文</span></dt>
                <dd><textarea name="body" class="size_max"></textarea></dd>
            </dl>
        </div>
        <div class="ui_btn_wrap ui_btn_wrap--center cf">
            <ul>
                <li>
                    <a class="ui_btn ui_btn--blue ui_btn--large_liquid" href="#" name="btnqa" id="contact_us">送信する</a>
                </li>
            </ul>
        </div>
    </form>
    <div class="contact_notice box_inner cf">
        <h4>営業日：平日（土日祝日を除く）</h4>
        <h4>営業時間12:00～18:00</h4>
        <h4>登録メールが届かない場合</h4>
        <p>docomo、au、softbankなど各キャリアのセキュリティ設定のためユーザー受信拒否と認識されているか、お客様が迷惑メール対策等で、ドメイン指定受信を設定されている場合に、メー ルが正しく届かないことがございます。以下のドメインを受信できるように設定してください。</p>
        <p>@joyspe.jp</p>
    </div>
</section>
