<script type="text/javascript">
    function doCheck(){
        var isCheck = false;
        
        $(".clCheck").each(function(){
            var id = $(this).attr("id");
            if ($('#' + id).is(":checked")) {
                isCheck = true;
            }
        });
        
        if (isCheck) {
            document.getElementById('frmMessRecep').submit();
        }else{                     
            alert('チェックボックスが選択されておりません。対象を選択して下さい。!');            
        }
    }
</script>
        <section class="section section--message_list cf">
            <h3 class="ttl_1">オファーメール</h3>
            <div class="box_inner pt_15 pb_15 cf">
                <div class="ui_tab cf">
                    <ul>
                        <li>
                            <a class="on" href="<?php echo base_url() . 'user/user_messege/messege/'.$gettype; ?>/">受信一覧<?php if ( $new_data ) { echo "(".$new_data.")"; } ?></a>
                            <!--<a class="on" href="./message_list.html">受信一覧(10)</a>-->
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'user/messege_details/messege_dustbox/'.$gettype; ?>/">ゴミ箱</a>
                            <!--<a href="./message_list_garbage.html">ゴミ箱</a>-->
                        </li>
                    </ul>
                </div>
            </div>
            <form id='frmMessRecep' action="<?php echo base_url() . 'user/messege_details/messege_delete_in/'; ?>" method="post">
                <div class="ui_list_1 message_list cf">
                    <ul id="list_user_message_id">
                        <?php echo $this->load->view("user/user_messege/messege_reception.php"); ?>                   
                    </ul>
                </div>            
                <div style="margin: 10px 0; text-align: center;">
                    <div class="more" ><a href="#" id="show_more_message_id">▼次の10件を表示</a></div>
                </div>
            </form>
            <div class="ui_btn_wrap ui_btn_wrap--center cf">
                <ul>
                    <li>
                        <a class="ui_btn ui_btn--large_liquid" href="javascript:{}" onclick="doCheck();">選択メールを削除</a>
                    </li>
                </ul>
            </div>
        </section>