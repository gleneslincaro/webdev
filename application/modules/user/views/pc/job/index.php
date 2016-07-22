<?php if (UserControl::LoggedIn()) {
    $this->load->view('user/pc/header/header');
}?>
<section class="section--main_content_area">
  <div class="container cf">
      <div class="f_left">
		  <?php $this->load->view('user/pc/share/notification'); ?>



      <?php $this->load->view('user/pc/job/area_map'); ?>


      </div>

      <div class="f_right">
        <?php $this->load->view('user/pc/share/aside'); ?>
      </div>
  </div>



</section>
<section class="section--joyspe_desc">
  <div class="container cf">
    <ul>
      <li>
        <h3>風俗求人をお探し方へ</h3>
        <p>ジョイスペでは初心者の方でも安心かつ安全な風俗求人を探すことができます。<br>
全国の優良なデリヘル・ホテヘル・ファッションヘルスなど高収入アルバイト情報をご案内。公開しない求人選びはジョイスペで決まり！</p>
      </li>
      <li>
        <h3>お祝い金がもらえる</h3>
        <p>入店お祝い金や面接交通費をジョイスペからお支払い！だから初日から確実にお金がもらえちゃいます！<br>
        しかも業界最高峰の保証なので風俗転職者に大人気！</p>
      </li>
    </ul>
    <ul>
      <li>
        <h3>匿名で求職活動ができる</h3>
        <p>求人情報には匿名でお問合せができるので直接連絡するのが怖い。。という方はご安心してお仕事を探すことができます。
もちろん登録情報が誰かに知られてしまうということもありません。</p>
      </li>
      <li>
        <h3>風俗で働くための情報満載</h3>
        <p>そのエリアってどんなところ？お客さんの層は？出稼ぎ希望だけど家賃どれぐらい？
などの風俗求人を選ぶ前に知っておきたい情報を掲載しています。</p>
      </li>
      <li>
        <h3>自分から探さなくても大丈夫！</h3>
        <p>ジョイスペでは会員登録をするとスカウトメールを受け取ることができます。<br>
忙しい人でもプロフィールを登録しているだけで一番良い条件の風俗求人が見つかりますよ！</p>
      </li>
    </ul>
  </div>
</section>
<?php $this->load->view('user/pc/share/pickup_store'); ?>
<?php $this->load->view('user/pc/share/pickup_column'); ?>
<?php $this->load->view('user/pc/share/footer_msg'); ?>
