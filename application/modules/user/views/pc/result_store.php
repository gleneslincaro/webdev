<section class="section--store_list">
    <?php $common = new Common(); ?>
    <?php if($storeOwner):?>
    <?php foreach ($storeOwner as $key => $data): ?>
        <?php if($data['owner_status']!=5):?>
            <div class="store_box_1">
                <h3 class="store_name">
    <!--            <span class="tag tag-new">NEW</span>  -->
                <?php echo $data['storename']; ?></h3>
                <p class="desc_1">
                <?php if(isset($data['title'])) : ?>
                <?php
                    echo $data['title'];
                ?>
                <?php endif; ?>
                </p>
                <div class="data_1">
                    <dl>
                        <dt>給料</dt>
                        <dd>
                        <?php if($data['salary']) : ?>
                        <?php
                            $data['salary'] = Helper::displayLines($data['salary'],2);
                            echo nl2br($data['salary']);
                        ?>
                        <?php endif; ?>
                        </dd>
                    </dl>
                </div>
                <div class="box_wrap cf">
                    <div class="box_left">
                        <figure class="banner">
                        <!-- <img src="./image/store/ace.png" />  -->
                        <a href="<?php echo base_url() . 'user/joyspe_user/company/' . $data['orid']; ?>/">
                            <?php if($data['main_image'] != 0 && $data['image' . $data['main_image']] ): ?>
                                <img src="<?php echo $imagePath . $data['image' . $data['main_image']]; ?>" alt="<?php echo $data['storename']; ?>" />
                            <?php else: ?>
                                <img src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                            <?php endif; ?>
                        </a>
                        </figure>
                        <p class="desc_2"><?php echo $common->_japanese_character_limiter($data['company_info'], 150); ?></p>
                    </div><!-- // .box_left -->
                    <div class="box_right">
                        <div class="data_2">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>地域</th>
                                        <td><?php echo $data['town_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>業種</th>
                                        <td><?php if( isset($data['jtname']) ) { echo $data['jtname']; }?></td>
                                    </tr>
                                    <tr>
                                        <th>TEL</th>
                                        <td><?php echo $data['apply_tel']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($data['happy_money_type'] && $data['happy_money'] != 0) : ?>
                        <div class="trial_bonus">
    <!--                        <p>体入お祝い金<strong>10,000</strong>円</p>  -->
                        <p><?php echo $data['happy_money_type']; ?>お祝い金<strong><?php echo $data['happy_money']; ?></strong>円</p>
                        </div>
                        <?php endif;?>
                        <ul class="btn_wrap">
                            <li>
                                <a href="#" class="ui_btn ui_btn--small btn_keep"></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>user/joyspe_user/company/<?php echo $data['orid']; ?>/" class="ui_btn ui_btn--bg_magenta ui_btn--small">詳細ページ</a>
                            </li>
                        </ul>
                    </div><!-- // .box_right -->
                </div><!-- // .box_wrap -->
                <?php
                    $treatmentsID = explode(",", $data['treatmentsID']);
                    $treatmentsName = explode(",", $data['treatmentsName']);
    //              var_dump($treatments);
                ?>
                <div class="tag_area cf">
                    <ul class="store_tags cf">
                    <?php for ($x=0;$x<sizeof($treatments);$x++) : ?>
                        <li class="<?php echo in_array($treatments[$x]['id'] , $treatmentsID) ? 'on' :''; ?>" >
                        <?php echo $treatments[$x]['name']; ?>
                        </li>
                    <?php endfor; ?>
    <!--
                        <li class="on">日払い可能</li>
                        <li class="on">給与保証制度</li>
                        <li class="on">報奨金あり</li>
                        <li class="on">罰金ノルマなし</li>
                        <li class="on">面接交通費支給</li>
                        <li class="on">未経験大歓迎</li>
                        <li class="on">1日体験入店</li>
                        <li class="on">短期短時間</li>
                        <li>送迎あり</li>
                        <li>寮あり</li>
                        <li>出張面接あり</li>
                        <li>アリバイ対策</li>
                        <li>長期休暇可能</li>
                        <li>個室待機あり</li>
                        <li>託児所あり</li>
                        <li>衛生対策あり</li>
                        <li>生理休暇あり</li>
                        <li>制服備品貸与</li>
    -->
                    </ul>
                </div>
            </div><!-- // .store_box_1 -->
            <?php else:?>
                <div class="store_box_1_2">
                    <h3 class="store_name"><?php echo $data['storename']; ?></h3>
                    <div class="box_wrap cf">
                            <div class="data_2 cf">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th width="120px">地域</th>
                                            <td><?php echo $data['town_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th width="120px">業種</th>
                                            <td><?php if( isset($data['jtname']) ) { echo $data['jtname']; }?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <ul class="btn_wrap cf">
                                <li></li>
                                <li> <a class="ui_btn ui_btn--bg_magenta ui_btn--small" href="<?php echo base_url(); ?>user/joyspe_user/company/<?php echo $data['orid']; ?>/">詳細ページ</a> </li>
                            </ul>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach; ?>
    <?php endif;?>
</section>

<div class="ui_pager">
    <ul>
    <?php
    if(isset($page_links)){
        echo $page_links;
    }
    ?>
    </ul>
</div>
