<div class="pagebody pagebody--white">
    <div class="pagebody_inner cf">                
        <section class="section section--login cf">
            <h3 class="ttl_1">パスワードを忘れた場合</h3>   
            <div class="box_inner pt_15 pb_7 cf">
                <p>パスワード再送をご希望の方は、下記フォームに登録メールアドレスを入力し再送ボタンを押してください。</p>
                <p>登録メールアドレスにパスワードが記載されたメールが届きます。</p>
            </div>
            <?php if (isset($message)) : ?>                    
                <?php echo Helper::print_error($message); ?>                
            <?php endif; ?>            
            <form name="resendpassword" action=""  method="post">
                <div class="box_inner pt_15 pb_7 cf">
                  <div class="pass_form_wrap cf">
                    <dl class="dl_1 cf">
                      <dt><span>登録メールアドレス</span></dt>
                      <dd class="pass_form pb_20">
                        <input type="text" name="email" class="size_max bg_fff" value="<?php echo set_value('email'); ?>">                                    
                      </dd>                      
                    </dl>
                  </div>
                  <div class="ui_btn_wrap ui_btn_wrap--center mt_20 mb_5 cf">
                    <ul>
                      <li>
                        <input type="submit" class="ui_btn ui_btn--magenta ui_btn--large_liquid fsize_16 fw_bold" value="送信" name="btn"/></input>
                      </li>                      
                    </ul>
                  </div>
                </div>
            </form>     
            <div class="box_inner pt_15 pb_7 cf">
                <p>再送メールが届かない方は下記よりお問い合わせください。</p>                
            </div>
            <div class="box_inner pt_15 pb_7 cf t_center"><a class="ui_btn ui_btn--blue ui_btn--large_liquid fsize_16 fw_bold" href="<?php echo base_url(); ?>user/contact/">Q&amp;Aお問合せ</a></div>
        </section>                
    </div><!-- // .pagebody_inner -->
</div><!-- // .pagebody -->






