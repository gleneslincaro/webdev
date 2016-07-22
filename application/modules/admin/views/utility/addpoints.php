<style>
  #users_content{
    margin-top:10%;
  }
  #search-container{
    margin-top:5%;
  }
</style>
<div id="content">
    <center>
        <div id="search-container">
            <form method="post" action="<?php echo base_url()?>admin/utility/search">
                <table>
                    <tr>
                        <td><label>ユニークＩＤ</label></td>
                        <td><input type="text" name="unique_id" id="unique_id" placeholder="ユニークＩＤ" value="<?php echo $unique_id?>"/></td>
                    </tr>
                    <tr>
                        <td><label>メール</label></td>
                        <td><input type="text" name="email" id="email" placeholder="メール" value="<?php echo $email?>"/></td>
                    </tr>
                    <tr>
                        <td><button id="search" type="submit">検索</button></td>
                        <td><a href="<?php echo base_url()?>admin/utility/history_page">追加履歴確認</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </center>
    <center>
    <div id="users_content">
        <?php if (isset($users)):?>
            <table width="100%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
                <tbody>
                    <tr>
                        <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center">メール</th>
                        <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center">ユニークＩＤ</th>
                    </tr>
                    <?php foreach($users as $result_users):?>
                        <tr>
                            <td style="border:1px solid #000000;"><?php echo $result_users['email_address']?>   <input type="hidden"  name="user_id[]" value="<?php echo $result_users['id']?>"> </td>
                            <td style="border:1px solid #000000;"><?php echo $result_users['unique_id']?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <br/>
            <?php if (count($users)>0):?>
                <label>ポイント</label><input type="text" id="points" name="points"/>
                <label>追加理由</label><input type="text" id="reason" name="reason"/>
                <br/><br/>
                <button type="button" id="add_points">ポイントを追加</button>                
            <?php endif;?>
        <?php endif;?>    
    </div>
    <div id="json_data"></div>
    </center>
</div>
<script>
    $('#add_points').click(function(){
        if(confirm('このユーザー様にポイントを追加します。よろしいですか？')){
            var url_addpoints = "<?php echo base_url()?>" + 'admin/utility/addpoints';
            var user_id = [];
            var points = $('#points').val();
            var reason = $('#reason').val();
            $('input[name="user_id[]"]').each(function(){
                user_id.push($(this).val());
            });
            $.post(url_addpoints,{"user_id":user_id,"points":points,"reason":reason},
                function(data){
                    if(data!='true'){
                        $('#json_data').append().html(data);
                        var errors = $('.hide-error').html();
                        var clean_errors = errors.replace(/<br\s*[\/]?>/gi,'');
                        alert(clean_errors);
                    }else{
                        alert('ポイントを追加しました。');
                        $('#points').val('');
                        $('#reason').val('');
                    }
            });  
        }
        

    });
</script>
