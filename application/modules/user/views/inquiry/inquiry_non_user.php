<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/inquiry.js?v=20150513" ></script>
<section class="section section--before_contact cf">
    <h2 class="h_ttl_1 mb_15">お問い合わせ</h2>
    <a class="body">
    <?php
    if(isset($message)){
        echo Helper::print_error($message);
    }
    ?>
    </a>
    <form id="form_inquiry" method="post">
        <div class="box_inner">
            <dl>
                <dt>お名前(ニックネーム)</dt>
                <dd><input type="<?php echo (isset($confirm)? "hidden":"text"); ?>" name="uname" value="<?php echo set_value("uname"); ?>" placeholder="例）Joyspe 花子" required=""></dd>
                <?php if (isset($confirm)) : ?>
                    <dd class="sup_contact"><?php echo set_value("uname"); ?></dd>
                <?php else : ?>
                    <dd class="sup_contact">(全角15文字/半角30文字以内)</dd>
                <?php endif; ?>
            </dl>
            <dl>
                <dt>年齢</dt>
                <?php if (isset($confirm)) : ?>
                    <dd class="sup_contact"><?php echo set_value("age"); ?><input type="hidden" name="age" value="<?php echo set_value("age"); ?>"></dd>
                <?php else : ?>
                    <dd><select name="age">
                        <?php for ($i=18; $i <= 100; $i++) : ?>
                        <option><?php echo $i;?></option>
                        <?php endfor; ?>
                    </select></dd>
                    <dd class="sup_contact">(18最未満・高校生の応募はできません)</dd>
                <?php endif; ?>
            </dl>
            <dl>
                <dt>メールアドレス</dt>
                <dd><input type="<?php echo (isset($confirm)? "hidden":"text"); ?>" name="contact"  value="<?php echo set_value("contact"); ?>" placeholder="例）Joyspe@co.jp" required=""></dd>
                <?php if (isset($confirm)) : ?>
                    <dd class="sup_contact"><?php echo set_value("contact"); ?></dd>
                <?php else : ?>
                    <dd class="sup_contact">(連絡先を知られずにやり取りができます)</dd>
                <?php endif; ?>

            </dl>
            <dl>
                <dt>店舗名:</dt>
                <dd><input type="<?php echo (isset($confirm)? "hidden":"text"); ?>" name="storname" value="<?php echo $ownerRecruitInfo['storename']; ?>" readonly></dd>
                <?php if (isset($confirm)) : ?>
                    <dd class="sup_contact"><?php echo set_value("storname"); ?></dd>
                <?php endif; ?>
            </dl>
            <dl>
                <dt>件名：</dt>
                <?php if (isset($confirm)) : ?>
                    <dd class="sup_contact"><?php echo set_value("user_title"); ?><input type="hidden" name="user_title" value="<?php echo set_value("user_title"); ?>"></dd>
                <?php else : ?>
                    <dd><select id="user_title" name="user_title" class="messege_width100 messege_width100_a">
                        <option selected="" value="質問">質問</option>
                        <option value="応募">応募</option>
                        <option value="面接依頼">面接依頼</option>
                        <option value="その他">その他</option>
                    </select></dd>
                <?php endif; ?>
            </dl>
            <dl>
                <dt>聞きたいこと</dt>
                <dd <?php echo (isset($confirm)? 'class="sup_contact"' : ""); ?>><?php echo nl2br(set_value("mess")); ?><textarea <?php echo (isset($confirm)? 'class="display_none;"' : ""); ?> name="mess" placeholder="例）未経験なんですが、1日のお給料はどのくらい稼げますか？"><?php echo set_value("mess"); ?></textarea></dd>
                <?php if (!isset($confirm)) : ?>
                    <dd class="sup_contact">(全角500文字/半角1000文字以内)</dd>
                <?php endif; ?>
            </dl>

        </div>
        <div class="ui_btn_wrap ui_btn_wrap--center cf">
            <ul>
                <li>
                    <?php if (isset($confirm)) : ?>
                        <button onclick="window.history.back()" class="ui_btn ui_btn--gray ui_btn--medium_liquid">戻る</button>
                        <button id="btn_send" class="ui_btn ui_btn--green ui_btn--medium_liquid">送信する</button>
                        <input type="hidden" name="send_mail" value="asdfjlasldf">
                    <?php else : ?>
                        <a id="btn_send" class="ui_btn ui_btn--blue ui_btn--large_liquid" href="#">確認する</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>


        <div class="contact_notice box_inner cf">
            <h3>登録メールが届かない場合</h3>
            <p>docomo、au、softbankなど各キャリアのセキュリティ設定のためユーザー受信拒否と認識されているか、お客様が迷惑メール対策等で、ドメイン指定受信を設定されている場合に、メー ルが正しく届かないことがございます。以下のドメインを受信できるように設定してください。</p>
            <p class="t_center m_10 fsize1_5">@joyspe.jp</p>
        </div>        
    </form>
</section>

