<?php $this->load->view('user/pc/header/header'); ?>
<div class="page_wrap page_wrap--posting_form">
    <div class="page_wrap_inner">
        <div class="pagebody pagebody--gray">
            <section class="section section--posting_form">
                <div class="pagebody_inner">
                    <div class="box_inner">
                        <div class="form_preview experiences_list management"> <img src="/public/user/pc/image/bg1.png">
                            <p>体験談が採用されたら<br>
                                <i class="fa fa-gift"></i>100ptプレゼント<i class="fa fa-gift"></i></p>
                            <img src="/public/user/pc/image/bg2.png"> </div>
                            <div class="form_preview experiences_list">
                                <h4 class="experiences_post_h">タイトル50文字以内</h4>
                                <div class="position_center">
                                    <input type="text" class="posting_form ttl title" title="50文字以内で入力してください" maxlength="50" required="" placeholder="50文字以内で入力してください">
                                </div>
                            </div>
                            <div class="form_preview experiences_list">
                                <h4 class="experiences_post_h">本文1000文字以内</h4>
                                <div class="position_center">
                                    <textarea type="text" class="posting_form content" title="1000文字以内で入力してください" maxlength="1000" required="" placeholder="1000文字以内で入力してください"></textarea>
                                </div>
                                <div class="position_center"> <a class="posting m_b_30" rel="leanModal" href="#experiences_send_modal"> 投稿する</a> </div>
                                <div id="experiences_send_modal" class="position_center">
                                    <p>投稿しますか？</p>
                                    <a class="experiences_send_btn" rel="leanModal" href="#experiences_send_modal_2"> 投稿する</a> <a class="cancel_btn">キャンセル</a> </div>
                                <div id="experiences_send_modal_2">
                                    <p class="finish_comment">投稿が完了しました</p>
                                    <a class="cancel_btn" href="/user/experiences/">閉じる</a> 
                                </div>
                                <div id="experiences_send_modal_3">
                                    <p class="err"></p>
                                    <a class="cancel_btn">キャンセル</a>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- // .box_inner --> 
            </section>
        </div>
        <!-- // .pagebody_inner --> 
    </div>
    <!-- // .pagebody --> 
</div>