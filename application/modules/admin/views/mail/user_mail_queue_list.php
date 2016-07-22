<div style="text-align: center; margin: 30px 0; font-size: 25px">ユーザー側 （ポイント付け一覧）</div>

<form method="post">
    <table cellpadding="10" class="template1">
        <thead>
            <tr>
                <th>メール送信元</th>
                <th>メール送信先</th>
                <th>件名</th>
                <th>メール内容</th>
                <th>強制送信</th>
                <th>送信数（予定）</th>
                <th>送信したメール数</th>
                <th>開封したメール数</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($queue_mail as $mail):?>
            <tr>
                <td width="50"><?php echo $mail['from_mail'];?></td>
                <td style="vertical-align: top; width: 250px;word-wrap:break-word;word-break:break-all;">
                <p class="more_wrap" style="height:56px;overflow:hidden;"><?php echo $mail['to_mail'];?></p>
                <?php if(strlen(nl2br($mail['to_mail'])) > 100):?>
                        <span class="more_btn short" data-val="<?php echo $mail['id']?>" style="color:#fb729e;cursor:pointer;">･･･もっと見る</span>
                    <?php endif;?>
                </td>
                <td width="100" align="center"><?php echo $mail['title'];?></td>
                <td style="width:200px;">
                    <p class="more_wrap" style="height:56px;overflow:hidden;"><?php echo nl2br($mail['content']);?></p>
                    <?php if(strlen(nl2br($mail['content'])) > 100):?>
                        <span class="more_btn short" data-val="<?php echo $mail['id']?>" style="color:#fb729e;cursor:pointer;">･･･もっと見る</span>
                    <?php endif;?>
                </td>
                <td align="center" width="80"><?php echo $mail['set_send_mail'] == 1 ? '強制送信ON' : '強制送信OFF'; ?></td>
                <td width="30" align="center"><?php echo $mail['count_mail']; ?></td>
                <td width="30" align="center"><?php echo $mail['count_mail_sent']; ?></td>
                <td width="30" align="center"><?php echo $mail['count_mail_open']; ?></td>
                <td width="50">
                    <?php if ($mail['count_mail_sent'] < $mail['count_mail']) : ?>
                        <button name="btn_send[]" value="<?php echo $mail['id']; ?>">送信</button>
                    <?php else: ?>
                        送信済
                    <?php endif; ?>
                </td>
                <td style="word-wrap:break-word;word-break:break-all; width: 70px;">
                    <?php if($mail['display_flag'] == 1):?>
                        <button name="btn_disable[]" value="<?php echo $mail['id']?>"  class="btn-disable">削除。</button>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</form>
<div style="width: 200px; margin: auto; padding-top: 20px; padding-bottom: 100px;">
    <?php echo $links; ?>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $(".more_btn").on("click",function(){
            var id = $(this).data('val')
            if($(this).hasClass("short")){
                $(this).removeClass("short").addClass("more").text("閉じる");
                $(this).parent('td').children('p').css("height","auto");

            } else if($(this).hasClass("more")){
                $(this).removeClass("more").addClass("short").text("･･･もっと見る");
                $(this).parent('td').children('p').css("height","56px");
            }
        });

        $('.btn-disable').click(function(){
            if(!window.confirm('このを削除してもよろしいですか？')){
                return false;
            }
            
        });

    });

</script>