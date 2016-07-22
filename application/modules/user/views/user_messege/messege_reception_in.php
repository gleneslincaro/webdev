<section class="section section--message_detail cf">
    <h3 class="ttl_1">オファーメール</h3>
    <div class="box_inner pt_15 pb_15 cf">
        <div class="message_detail_wrap cf">
            <div class="message_detail_head">
                <p class="title"><?php echo ($send_type == 1)?$title:$data['title']; ?></p>
                <p class="datetime"><?php echo ($send_type == 1)?strftime("%Y/%m/%d %H:%M", strtotime($data['send_date'])):strftime("%Y/%m/%d %H:%M", strtotime($data['created_date'])); ?></p>
                <p class="from">From： <?php echo ($send_type == 1)?(($data['user_message_status']==1)? $data['store_name']:"Joyspe"):$data['storename']; ?></p>
                <?php if($send_type != 1): ?>
                    <p><?php echo $data['unique_id'].' 様';?><br />
                        いつもご利用ありがとうございます。 <br /><br />
                        お問い合わせ頂いた店舗様から返信がありました。
                    </p>
                <?php endif; ?>
            </div><!-- // .message_detail_head -->
            <div class="message_detail_body">
                <p class='links'><?php if($send_type == 1) { echo $body; } else { echo nl2br($data['content']); } ;?></p>
            </div><!-- // .message_detail_body -->
        </div><!-- // .message_detail_wrap -->
    </div><!-- // .box_inner -->
    <div class="ui_btn_wrap ui_btn_wrap--half cf">
        <ul>
            <li>
                <a class="ui_btn" href="<?php if ($message_list == 1) { echo base_url() . 'user/message_list/0/'; } else { echo base_url() . 'user/message_list_garbage/0/'; } ?>">一覧へ戻る</a>
            </li>
            <li>
                <a class="ui_btn" href="<?php if ($message_list == 1) { echo base_url() . 'user/delete_message/' . $data['id'].'/'.$send_type.'/'; } else { echo base_url() . 'user/return_message/' . $data['id'].'/'; } ?>">メールを削除</a>
            </li>
        </ul>
    </div>
    <div class="ui_btn_wrap ui_btn_wrap--center mt_30 mb_30 cf">
        <ul>
            <li>
                <a class="ui_btn ui_btn--magenta ui_btn--arrow_right ui_btn--large_liquid" href="<?php echo base_url() . 'user/joyspe_user/company/' . $data['ors_id'].'/'; ?>">店舗情報を見る</a>
            </li>
        </ul>
    </div>
</section>
