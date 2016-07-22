<input type="hidden" value="<?php echo $message_list;?>" name="is_message_list" id="is_message_list" />
<input type="hidden" value="<?php echo $gettype?>" id="gettype_meessage_id">
<input type="hidden" value="<?php echo $count_all?>" id="countall_message_id">
<input type="hidden" value="<?php echo $limit?>" id="limit_message_id">
        <section class="section section--message_list cf">
            <h3 class="ttl_1">オファーメール</h3>
            <div class="box_inner pt_15 pb_15 cf">
                <div class="ui_tab cf">
                    <ul>
                        <li>
                            <a <?php echo ($message_list == 1)?"class='on'":''; ?> href="<?php echo base_url() . 'user/message_list/'.$gettype; ?>/">受信一覧<?php if (isset($new_data) && $new_data > 0) { echo "(".$new_data.")"; } ?></a>
                            <!--<a class="on" href="./message_list.html">受信一覧(10)</a>-->
                        </li>
                        <li>
                            <a <?php echo ($message_list == 0)?"class='on'":''; ?> href="<?php echo base_url() . 'user/message_list_garbage/'.$gettype; ?>/">ゴミ箱</a>
                            <!--<a href="./message_list_garbage.html">ゴミ箱</a>-->
                        </li>
                    </ul>
                </div>
            </div>
            <form id='frmMessRecep' action="<?php if ($message_list == 1) { echo base_url() . 'user/user_messege/delete_messages/'; } else {  echo base_url() . 'user/user_messege/return_messages/'; }; ?>" method="post">
                <div class="ui_list_1 message_list cf" id="list_user_message_id">
                    <?php echo $this->load->view("user/user_messege/messege_reception.php"); ?>
                </div>
                <div class="t_center mt_10" id="more_message_result">
                    <a href="javascript:void(0)" id="more_message_id" name="more_message_id">▼次の10件を表示</a>
                </div>
                <div id="loader_wrapper" class="t_center"></div>
            </form>
            <div class="ui_btn_wrap ui_btn_wrap--center cf">
                <ul>
                    <li>
                        <a class="ui_btn ui_btn--large_liquid" href="javascript:{}" onclick="doCheck();" id="btnphuong">
                        <?php if (isset($actionButtonText) && $actionButtonText) {
                            echo $actionButtonText;
                        } else {
                            echo "選択メールを削除";
                        } ?>
                        </a>
                    </li>
                </ul>
            </div>
		</section>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/message.js?v=20150511"></script>
