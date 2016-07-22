<?php echo $this->load->view('user/share/has_scout_mail'); ?>
<section class="section section--top cf">
  <div class="box_inner cf">
    <div id="header_text">
      <p class="desc"> 掲載店舗数<em><?php echo HelperGlobal::gettotalHeader() ?>件</em> 現在<em><?php echo HelperGlobal::getUserTotalNumber() ?>人</em>が利用してます！
        <?php  if (UserControl::LoggedIn() == true) : ?>
        <br>
        <label>joyspe内でのIDは <?php echo UserControl::getUnique_id() ?> です。</label>
        <?php endif; ?>
      </p>
    </div>
    <div class="keyword_search_area">
      <form name="search_keyword_form" method="get" action="<?php echo base_url()."user/search/search_list"?>/">
        <div class="col_wrap">
          <div class="col_left">
            <input type="text" value="" class="input_keyword" name="search_keyword" id="search_keyword" placeholder="店舗名、日払い、デリヘル等...">
          </div>
          <div class="col_right">
            <input class="ui_btn ui_btn--symphonyblue ui_btn--bg_symphonyblue btn_search" type="submit" id="submit_searh_keyword" value="検索する">
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<section class="section section--area_cat cf">
  <h2 class="h_ttl_1 ic ic--area_search">エリアから検索</h2>
  <div class="box_inner pt_15 pb_7 cf">
    <div class="area_list cf">
      <ul>
        <li class="area_hokkaido-tohoku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[0]['alph_name']; ?>/"><img src="<?php echo base_url(); ?>public/user/image/area_hokkaido-tohoku_btn.png" alt="北海道、東北"></a></li>
        <li class="area_kanto"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[1]['alph_name']; ?>/"><img src="<?php echo base_url(); ?>public/user/image/area_kanto_btn.png" alt="関東"></a></li>
        <li class="area_northkanto"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[2]['alph_name']; ?>/"><img src="<?php echo base_url(); ?>public/user/image/area_northkanto_btn.png" alt="北関東"></a></li>
        <li class="area_hokuriku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[3]['alph_name']; ?>/"><span><img src="<?php echo base_url(); ?>public/user/image/area_hokuriku_btn.png" alt="北陸、甲信越"></span></a></li>
        <li class="area_eastsea"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[4]['alph_name']; ?>/"><img src="<?php echo base_url(); ?>public/user/image/area_eastsea_btn.png" alt="東海"></a></li>
        <li class="area_kansai"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[5]['alph_name']; ?>/"><img src="<?php echo base_url(); ?>public/user/image/area_kansai_btn.png" alt="関西"></a></li>
        <li class="area_chugoku-shikoku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[6]['alph_name']; ?>/"><span><img src="<?php echo base_url(); ?>public/user/image/area_chugoku-shikoku_btn.png" alt="四国"></span></a></li>
        <li class="area_kyushu-okinawa"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[7]['alph_name']; ?>/"><span><img src="<?php echo base_url(); ?>public/user/image/area_kyushu-okinawa_btn.png" alt="九州、沖縄"></span></a></li>
      </ul>
    </div>
  </div>
</section>

<?php echo $this->load->view("user/template/campaign_banner.php"); ?>
<?php if (count($articles) > 0) : ?>
<section class="section section--area_cons cf">
  <div class="box_inner pt_15 pb_7 cf">
    <div class="pickup_store_list cf" id="articles"> <?php echo $this->load->view("user/job/articles.php"); ?> </div>
  </div>
</section>
<?php endif; ?>
<section class="section section--joyspe_contents cf">
	<h3 class="h_ttl_1 ic ic--contents">コンテンツ</h3>
	<div class="box_inner pt_15 pb_15 cf">
		<div class="contents_list cf">
			<ul>
				<li> <a href="/column/"><img src="<?php echo base_url(); ?>public/user/image/contents/column_banner.jpg" class="width_100p" /> </li>
				<li> <a href="http://aruaru.joyspe.com/"><img src="<?php echo base_url(); ?>public/user/image/contents/banner_aruaru-620_100.png" alt="女性のあるある掲示板" /></a> </li>
			</ul>
		</div>
	</div>
</section>
<?php  if (UserControl::LoggedIn() != true) : ?>
<div class="ui_btn_wrap ui_btn_wrap--half pt_5 pb_5 cf">
  <ul>
    <li> <a class="ui_btn ui_btn--magenta ui_btn--bg_magenta ui_btn--arrow_right" href="<?php echo base_url().'user/signup/'; ?>">新規会員登録</a> </li>
    <li> <a class="ui_btn ui_btn--green ui_btn--bg_green ui_btn--arrow_right" href="<?php echo base_url().'user/login/'; ?>">ログイン</a> </li>
  </ul>
</div>
<?php endif; ?>
<section class="section section--joyspe_desc cf">
  <div class="section_inner">
    <div class="joyspe_desc">
      <h3>風俗求人をお探し方へ</h3>
      <p class="more_wrap">ジョイスペでは初心者の方でも安心かつ安全な風俗求人を探すことができます。<br>
全国の優良なデリヘル・ホテヘル・ファッションヘルスなど高収入アルバイト情報をご案内。公開しない求人選びはジョイスペで決まり！</p>
    </div>
    <div class="joyspe_desc">
      <h3>匿名で求職活動ができる</h3>
      <p class="more_wrap">求人情報には匿名でお問合せができるので直接連絡するのが怖い。。という方はご安心してお仕事を探すことができます。
もちろん登録情報が誰かに知られてしまうということもありません。</p>
    </div>
    <div class="joyspe_desc">
      <h3>お祝い金がもらえる</h3>
      <p class="more_wrap">入店お祝い金や面接交通費をジョイスペからお支払い！だから初日から確実にお金がもらえちゃいます！
        しかも業界最高峰の保証なので風俗転職者に大人気！</p>
    </div>
    <div class="joyspe_desc">
      <h3>風俗で働くための情報満載</h3>
      <p class="more_wrap">そのエリアってどんなところ？お客さんの層は？出稼ぎ希望だけど家賃どれぐらい？
などの風俗求人を選ぶ前に知っておきたい情報を掲載しています。</p>
    </div>
    <div class="joyspe_desc">
      <h3>自分から探さなくても大丈夫！</h3>
      <p class="more_wrap">ジョイスペでは会員登録をするとスカウトメールを受け取ることができます。<br>
忙しい人でもプロフィールを登録しているだけで一番良い条件の風俗求人が見つかりますよ！</p>
    </div>
  </div>
</section>
<section class="section section--joyspe_info mb_20">
  <div class="section_inner">
    <h3>ジョイスペをご覧の皆様へ</h3>
    <p>
      ジョイスペは全国の風俗求人、高収入アルバイト情報を凝縮したポータルサイトです。<br>
      短時間で普通のOLの数倍を稼ぐことができるデリヘル、ホテヘル、エステ、ピンサロ、チャットレディーなどの求人情報が盛りだくさん！大人気の主婦（人妻）向けの高収入求人情報も満載！
      日払い、体験入店、託児所などの条件からお店を検索することができます。<br>
      関東（首都圏）、関西、東海、北海道、東北、甲信越、北陸、中国、四国、九州、沖縄にある求人情報から最新の募集内容をご紹介いたします。<br>
      風俗未経験者が抱く不安や業界用語、風俗業界についてのコラムも連載中。<br>
      ジョイスペを使ってワンランク上のライフスタイルを手に入れちゃおう！
    </p>
  </div>
</section>
<?php echo $this->load->view("user/inc/type_index.php"); ?>