<section class="section section--signup cf">
<h3 class="ttl_1">新規会員登録</h3>
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
      <div class="ui_btn_wrap ui_btn_wrap--half mt_15 mb_25 cf">
          <ul>
              <li>
                  <a class="ui_btn" href="<?php echo $to_url; ?>">あとで</a>
              </li>
              <li>
                  <a class="ui_btn ui_btn--magenta" href="<?php echo base_url()."user/settings/"; ?>">プロフィール登録をする</a>
              </li>
          </ul>
      </div>
    </div><!-- // .box_inner -->
</section>
