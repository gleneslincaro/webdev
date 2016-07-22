<?php $this->load->view('user/pc/header/header'); ?>
<section class="section--denial">
    <div class="container cf">
        <div class="box_white">
            <div class="denial">
                <h2 class="denial_h">キープ</h2>
                <p class="confirmation"><?php echo $storename; ?>のキープが完了しました。</p>
            </div>
            <div class="select_btn">
                <ul>
                    <?php if ($type_page==1) : ?>
                    <li> <a class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta" href="/user/search/search_list/">検索後のページへ戻る</a> </li>
                    <?php endif; ?>
                    <li> <a class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta" href="/user/">ＴＯＰへ戻る</a> </li>
                </ul>
            </div>
        </div>
    </div>
</div>