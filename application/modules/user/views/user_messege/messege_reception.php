<?php if (count($data) > 0) : ?>
    <ul id="message_wrapper">
    <?php foreach ($data as $key => $val) : ?>
        <li class="arrow_right">
            <div class="col_wrap">
                <div class="col_left func_area">
                    <label><input class="clCheck" id="id-<?php echo $val['id']; ?>" name="cbkdel[]" type="checkbox" value="<?php echo $val['id'].':'.$val['send_type']; ?>"></label>
                </div>
                <div class="col_right <?php echo (($val['is_read'] == "0" && $val['send_type'] == 1) || ($val['is_read'] == "1" && $val['send_type'] == 2))?'fro t_truncatem':'from t_truncate'; ?>">
                    <a href="<?php echo base_url() . 'user/message_detail/' . $val['id'].'/'.$val['send_type'].'/'.$message_list; ?>/">
                        <p class="title"><?php echo $chuoi[$key]; ?></p>
                        <p class="datetime"><?php echo strftime("%Y/%m/%d %H:%M", strtotime($val['send_date'])); ?></p>
                        <p class="from">
                            <?php
                                if ($val['user_message_status']==1) {
                                    echo $val['store_name'];
                                }
                                else {
                                    echo "Joyspe";
                                }
                            ?>
                        </p>
                    </a>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else : ?>
    <div class="pt_20 pl_15 pb_20">メールが見つかりませんでした。</div>
<?php endif; ?>
