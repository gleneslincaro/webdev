<style type="text/css">
    #modal #pagination {

        padding-top: 10px;
    }
    #modal #pagination ul li {
        float: left;
        width: 20px;
        list-style-type: none;
        padding: 0 5px;
    }
</style>
<div style="text-align: center; margin: 30px 0; font-size: 25px">自動送信メルマガ予約一覧</div>
<div class="request-filter-form" style="text-align:center">
    <form method="post">
        <label>ソートメルマガ</label>
        <select name="sort_magazine">
            <option value="1" <?php echo ($sort==1) ? 'selected="selected"' : '';?>>有効</option>
            <option value="2" <?php echo ($sort==2) ? 'selected="selected"' : '';?>>無効</option>
            <option value="3" <?php echo ($sort==3) ? 'selected="selected"' : '';?>>全部</option>
        </select>
        <input type="submit" value="絞り込む" />        
    </form>
    
</div>
<form method="post">
    <table cellpadding="10" class="template1">
        <thead>
            <tr>
                <th>メール送信先</th>
                <th>メール送信元</th>
                <th>件名</th>
                <th>送信の時間</th>
                <th>メール内容</th>
                <th>履歴</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($queue_mail as $mail):?>
            <tr id="mail<?php echo $mail['id'];?>" class="<?php echo ($mail['display_flag'] == 0) ? 'disable-mail-magazine':'';?>">
                <td><?php echo $mail['to_mail'];?></td>
                <td style="word-wrap:break-word;word-break:break-all; width: 300px;">
                <p class="more_wrap" style="height:56px;overflow:hidden;"><?php echo $mail['from_mail'];?></p>
                <?php if(strlen(nl2br($mail['from_mail'])) > 100):?>
                        <span class="more_btn short" data-val="<?php echo $mail['id']?>" style="color:#fb729e;cursor:pointer;">･･･もっと見る</span>
                    <?php endif;?>
                </td>
                <td width="130"><?php echo $mail['title'];?></td>
                <td align="center"><?php echo $mail['send_time'];?></td>
                <td style="width:400px;">
                    <p class="more_wrap" style="height:56px;overflow:hidden;"><?php echo nl2br($mail['content']);?></p>
                    <?php if(strlen(nl2br($mail['content'])) > 100):?>
                        <span class="more_btn short" data-val="<?php echo $mail['id']?>" style="color:#fb729e;cursor:pointer;">･･･もっと見る</span>
                    <?php endif;?>
                </td>
                <td><button class="btn_history" data-id="<?php echo $mail['id'];?>">見る</button></td>
                <td>
                    <a href="<?php echo base_url().'admin/mail/edit_auto_send_magazine/' . $mail['id']; ?>/" target="_blank">編集</a>
                </td>
                <td style="word-wrap:break-word;word-break:break-all;">
                    <?php if($mail['display_flag'] == 1):?>
                    <button value="<?php echo $mail['id']?>" name="disable" class="btn-disable">無効にします</button>
                    <?php else:?>
                    <button value="<?php echo $mail['id']?>" name="enable" class="btn-enable">有効にする</button>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</form>
<div id="jquery_link_user" align="center" style="padding-top: 20px; padding-bottom: 50px;">
    <?php echo $this->pagination->create_links(); ?>
</div>
<div id="modal" style="display: none; z-index: 999; width: 70%; height: 50%; position: absolute; top: 10%; left:0%; background-color: #fff; padding: 20px; border: 1px solid #000;">
    <div style="overflow: auto; height: 90%;">
        <table cellpadding="5" class="template1" style="width: 100%;">
        </table>
    </div>
    <div id="pagination"></div>
    <button id="btn_close_modal" style="position: absolute;bottom: 20px;right: 20px;">閉じる</button>
</div>
<div id="modalBg" style="display: none; opacity: .50;position: absolute; top:-8px; left:-37%; height: 100%; background-color: #000;"></div>


<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-disable').click(function(){
            if (!confirm('このメールマガジンを無効にしてもよろしいですか？')) {
                return false;
            }
        });
        $('.btn-enable').click(function(){
            if (!confirm('このメールマガジンを有効にしてもよろしいですか？')) {
                return false;
            }
        });
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

        var mainHeight = $( document ).height();
        var mainWidth = $( document ).width();
        $('#modalBg').css({'height': mainHeight, 'width': mainWidth});
        $('#btn_close_modal').on('click',function(){
            $('#modal').hide();
            $('#modalBg').hide();
            $('#modal table').html('');
            $('#pagination').html('');
            return false;
        });

        $('.btn_history').click(function(){
            $('#modal').show();
            $('#modalBg').show();
            var id = $(this).data('id');
            getHistoryPagination(id);
            return false;
        });


        function getHistoryPagination(id, page){
            page = page ? page : "<?php echo base_url(); ?>admin/mail/mail_magazine_history/0";

            $.ajax({
                url: page,
                type:"post",
                data:{"id" : id},
                dataType: 'json',
                success:function(ret){
                    var isTable = "<tr><th >送信日付</th><th>送信件数</th></tr>"
                    var isTr = '';
                    if (ret.length == 1) {
                        isTr += "<tr><td>0</td><td>0</td></tr>";
                    }
                    for (var i = 0; i < ret.length - 1; i++) {
                        isTr += "<tr><td align='center'>" + ret[i].date_sent + "</td><td align='center'>" + ret[i].count_sent + "</td></tr>";
                        
                    };
                    isTable += isTr;
                    $('#modal table').html(isTable);
                    $('#modal #pagination').html(ret[ret.length -1].pagination);

                    $('#pagination a').click(function(){
                        var a_href = $(this).attr('href');
                        getHistoryPagination(id, a_href);
                        return false;
                    });
                }
            });
        }

        pagingByAjax();
    });

</script>