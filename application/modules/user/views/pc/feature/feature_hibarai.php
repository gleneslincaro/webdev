<?php $this->load->view('user/pc/header/header'); ?>
<section class="section--main_content_area">
    <div class="container cf">
        <div class="f_left p_b_50">
            <div class="feature_title">
                <h2>
                    <img alt="やっぱりその場でお金を貰いたい！日払いで貰えるお店" src="<?php echo base_url('public/user/pc/image/feature/hibarai/hibarai_logo.png')?>">
                </h2>
            </div>
            <section class="section--area_search_link">
                <h3>エリアから探す</h3>
                <div class="area_search">
                    <ul>
                        <li class="area_hokkaido"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[0]['alph_name']; ?>/">北海道・東北</a></li>
                        <li class="area_kitakanto"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[2]['alph_name']; ?>/">北関東</a></li>
                        <li class="area_kanto"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[1]['alph_name']; ?>/">関東</a></li>
                        <li class="area_tokai"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[3]['alph_name']; ?>/">東海</a></li>
                    </ul>
                    <ul>
                        <li class="area_hokuriku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[4]['alph_name']; ?>/">北陸・甲信越</a></li>
                        <li class="area_kansai"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[5]['alph_name']; ?>/">関西</a></li>
                        <li class="area_shikoku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[6]['alph_name']; ?>/">中国・四国</a></li>
                        <li class="area_kyushu"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[7]['alph_name']; ?>/">沖縄・九州</a></li>
                    </ul>
                </div>
            </section>
            <section class="section--advantage m_t_50">
                <h2><img alt="日払いの３つのメリット" src="<?php echo base_url('public/user/pc/image/feature/hibarai/advantage_ttl.png')?>"></h2>
                <div class="advantage_box">
                    <div class="col_wrap">
                        <div class="col_left"><span>1</span></div>
                        <div class="col_right">仕事帰りにショッピング</div>
                    </div>
                    <p>仕事帰りに、欲しいものを眺めるだけでなく買える機会が増えるので我慢する必要がありません。<br>
                    帰りにオシャレなカフェやレストランに寄るもよしですね。</p>
                </div>
                <div class="advantage_box">
                    <div class="col_wrap">
                        <div class="col_left"><span>2</span></div>
                        <div class="col_right">急にお金が必要でも大丈夫</div>
                    </div>
                    <p>急な支出などで現金が必要な時でも日払いであればその日にお金がもらえるので無理に節約をして月末まで待つという生活とはオサラバです。</p>
                </div>
                <div class="advantage_box">
                    <div class="col_wrap">
                        <div class="col_left"><span>3</span></div>
                        <div class="col_right">いつもお財布に余裕がある</div>
                    </div>
                    <p>日払いともなると出勤すれば給料日なのでいつでも財布にお金がある状態。<br>
                    好きな時に好きなことが出来るので余裕のある生活を送ることができるでしょう。</p>
                </div>
            </section>
            <section class="section--voice m_t_50">
                <h2><img alt="日払いバイト利用者の声" src="<?php echo base_url('public/user/pc/image/feature/hibarai/voice_ttl.png')?>" class="voice_title_image"></h2>
                <div class="col_wrap">
                    <div class="col_left"> <img alt="日払いバイト利用者の声１" src="<?php echo base_url('public/user/pc/image/feature/woman_1.png')?>"> </div>
                    <div class="col_right">
                        <dl>
                            <dt>Eさん&#12288;19才</dt>
                            <dd>カードローンの支払日に、お金がたりないって時がありました。<br>
                            毎月、支払日を忘れてピンチの時がくるので私にとって日払は必要です。</dd>
                        </dl>
                    </div>
                </div>
                <div class="col_wrap">
                    <div class="col_left"> <img alt="日払いバイト利用者の声２" src="<?php echo base_url('public/user/pc/image/feature/woman_4.png')?>"> </div>
                    <div class="col_right">
                        <dl>
                            <dt>Hさん&#12288;29才</dt>
                            <dd>子供が2人いるのですが、育ち盛りで予想できないような急な出費があります。<br>
                            こういう時に、その日にお給料を貰えると、解決できるのですごく助かってます。</dd>
                        </dl>
                    </div>
                </div>
                <div class="col_wrap">
                    <div class="col_left"> <img alt="日払いバイト利用者の声３" src="<?php echo base_url('public/user/pc/image/feature/woman_3.png')?>"> </div>
                    <div class="col_right">
                        <dl>
                            <dt>Oさん&#12288;24才</dt>
                            <dd>段はOLをしていますが、OLのお給料で一人暮らしと、友達付き合いがあるととてもじゃないけれど、生活に余裕がなくなります。<br>
                            合コンにいく洋服さえも買えない状況でしたが、副業として働いているお店では、日払い制度があるのでいまでは充実した独身生活をしています。</dd>
                        </dl>
                    </div>
                </div>
            </section>
            <section class="section--feature_job_description m_t_30">
                <h2><img alt="日払いとは？" src="<?php echo base_url('public/user/pc/image/feature/hibarai/job_description_ttl.png')?>" class="job_image"></h2>
                <div class="job_description">
                    <div class="job_description_inner">
                        <p>デリヘルをはじめとする風俗店の多くは日払いでお給料をもらえます。<br>
                        銀行へ振り込みされるわけではなく、その場で手渡しで現金をもらえます。<br>
                        そのため急にお金が必要になった場合などはすぐに現金を手に入れることができるので、給料日まであと何日？なんてか数えることから無縁となります。</p>
                    </div>
                </div>
            </section>
            <section class="section--feature_success m_t_50">
                <div class="feature_success">
                    <h2><img alt="風俗嬢の税金事情" src="<?php echo base_url('public/user/pc/image/feature/hibarai/success_ttl.png')?>"></h2>
                    <p>日払いかつ現金でお金をもらえるので銀行口座にはお金が入りません。<br>
                    また１日だけなどの超短期間でのお仕事の人も多いため税務署も一人一人調べることが困難な状況です。<br>
                    それが関係するのか風俗嬢の多くは所得の申告をしていない方が多いようです。<br>
                    但し毎月一定の収入がある方は調査の対象となる可能性は十分にあるので個人事業主の届出をして申告をする方がいいでしょう。<br>
                    携帯代や衣装代などの接客に使う費用は経費として申請することが出来るので返って税金が少なくなることもあります。<br>
                    扶養に入っている方や普段はOLなどをやっている方は収入が入ることで家族や会社にバレてしまうこともあります。<br>
                    店舗ではアリバイ対策をしてくれるお店が多くありますので、働く前に相談をしてみるといいでしょう。<br>
                    また、今後はマイナンバー制度というものが導入されますので以前のようにいかないこともあります。<br>
                    このあたりも不安であれば事前に相談をしてみましょう。</p>
                </div>
            </section>
            <section class="section--area_search_link m_t_50">
                <h3>エリアから探す</h3>
                <div class="area_search">
                    <ul>
                        <li class="area_hokkaido"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[0]['alph_name']; ?>/">北海道・東北</a></li>
                        <li class="area_kitakanto"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[2]['alph_name']; ?>/">北関東</a></li>
                        <li class="area_kanto"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[1]['alph_name']; ?>/">関東</a></li>
                        <li class="area_tokai"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[3]['alph_name']; ?>/">東海</a></li>
                    </ul>
                    <ul>
                        <li class="area_hokuriku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[4]['alph_name']; ?>/">北陸・甲信越</a></li>
                        <li class="area_kansai"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[5]['alph_name']; ?>/">関西</a></li>
                        <li class="area_shikoku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[6]['alph_name']; ?>/">中国・四国</a></li>
                        <li class="area_kyushu"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[7]['alph_name']; ?>/">沖縄・九州</a></li>
                    </ul>
                </div>
            </section>

        </div>
        <!-- end of f_left -->
        <div class="f_right">
            <?php $this->load->view('user/pc/share/aside'); ?>
        </div>
    </div>
</section>
