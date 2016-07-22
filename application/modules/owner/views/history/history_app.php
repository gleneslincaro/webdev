<script type="text/javascript">
  $(document).ready(function() {
    $("#th8").addClass("visited");

    $('.user-image').bind('contextmenu', function(e){
      return false;
    });
  });

     $(document).ready(function() {
// add multiple select / deselect functionality
        $("#all").click(function() {
            $('.case').attr('checked', this.checked);
        });

        // if all checkbox are selected, check the selectall checkbox
        // and viceversa
        $(".case").click(function() {

            if ($(".case").length == $(".case:checked").length) {
                $("#all").attr("checked", "checked");
            } else {
                $("#all").removeAttr("checked");
            }

        });

 //add multiple select / deselect functionality
        $(".checkall").click(function() {
            var checkall = $(this).attr('id');
            $('.' + checkall).attr('checked', this.checked);
        });
    });

   function checkall()
    {

        if($('#all').is(':checked'))
        {

            $("input[name='ckUser[]']").each(function(){
                $(this).attr('checked', true);
             });
        }
        else
        {

            $("input[name='ckUser[]']").each(function(){
                $(this).removeAttr('checked');
           });
        }
        check();
    }


//    function checkall(el)
//    {
//        var ip = document.getElementsByTagName('input'), i = ip.length - 1;
//
//        for (i; i > -1; --i)
//        {
//            if (ip[i].type && ip[i].type.toLowerCase() === 'checkbox')
//            {
//                ip[i].checked = el.checked;
//            }
//        }
//    }
//
//    function onChangeItemCk() {
//	el = document.getElementById('all');
//	var chez = true;
//	var ip = document.getElementsByTagName('input');
//	i = ip.length - 1;
//	//alert(i);
//	for (i; i > -1; --i){
//		if(ip[i].type && ip[i].type.toLowerCase() === 'checkbox' && ip[i].name != 'all'){
//			if(!ip[i].checked) {
//				chez = false;
//			}
//		}
//	}
//	el.checked = chez;
//    }


//    function onChangeItemCk() {
//	el = document.getElementById('all');
//	var chez = true;
//	var ip = document.getElementsByTagName('input');
//	i = ip.length - 1;
//	//alert(i);
//	for (i; i > -1; --i){
//		if(ip[i].type && ip[i].type.toLowerCase() === 'checkbox' && ip[i].name != 'all'){
//			if(!ip[i].checked) {
//				chez = false;
//			}
//		}
//	}
//	el.checked = chez;
//}


    function checkInterview()
    {
        var flag = false;
        var str = "ckUser[]";
        var chk = document.getElementsByName(str);

        for (i = 0; i < chk.length; i++) {
            if (chk[i].checked == true) {
                flag = true;
            }
        }

        if (!flag)
        {
            alert('チェックボックスが選択されておりません。対象を選択して下さい。');
            return false;
        }
        else
        {
            setTimeout(function()
        {
            $('#myForm').submit();
        },2000);

        }
    }

    function check()
    {
       var scout_action = baseUrl + "owner/history/saveCheck";

       $('#myForm').ajaxSubmit({
            url: scout_action,
            dataType:'json',
            success: function(responseText, statusText, xhr, $form){
            }
        });
    }
</script>

<?php $count_ = $count[0]; ?>

    <div class="crumb">TOP ＞ 申請一覧 ＞ 面接完了報告一覧</div>
<!--
    <div class="owner-box"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a></div><br >
-->

    <div class="list-box"><!-- list-box ここから -->
        <div class="list-title">面接完了報告一覧</div>
        <div class="contents-box-wrapper">
        <div class="work-list-wrapper">
        <div class="list-menu">
            <a class="pr35" href="<?php echo base_url() . 'owner/history/history_work' ?>">勤務確認一覧</a>
            <a class="pr35" href="<?php echo base_url() . 'owner/history/history_app' ?>"style=" color: rgb(0,0,0)" ><font color="#000000">面接完了報告一覧</font></a>
            <a class="pr35" href="<?php echo base_url() . 'owner/history/history_adoption' ?>">採用者一覧</a>
        </div>

        <div class="table-list-wrapper">
        <form id="myForm" name="myForm" method="POST" action="<?php echo base_url() ?>owner/history/history_app_action_conf" <?php if(!isset($_SESSION['sCheckrs'])) { ?>  onSubmit="return checkInterview();" <?php } ?>>
        <table>

            <tr>
                <th>ID</th>
                <th>写真</th>
                <th>地域</th>
                <th>年齢</th>
                <th>採用金額（円）</th>
                <th>面接完了報告時間</th>
            </tr>
                <?php foreach ($user_data as $value): ?>
                <tr>
                        <td><?php echo $value['unique_id']; ?></td>
                        <td><?php
                        $data_from_site = $value['user_from_site'];
                        if ( $value['profile_pic'] ){
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                            if ( file_exists($pic_path) ){
                                $src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
                            }else{
                                if ( $data_from_site == 1 ){
                                    $src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
                                }else{
                                    $src = $this->config->item('aruke_pic_path').$value['profile_pic'];
                                }
                            }
                            echo "<img class='user-image' src='".$src."' alt='写真' height='90'>";
                        }else{
                            echo "<img class='user-image' src='".base_url()."/public/user/image/no_image.jpg' alt='写真'
                                        width='120px' height='90'>";
                        }
                        ?></td>
                        <td><?php echo $value['cityname']; ?></td>
                        <td><?php echo $value['name1']."~".$value['name2']; ?></td>
                        <td><?php echo number_format($value['joyspe_happy_money']); ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($value['apply_date'])); ?></td>
                    </tr>
                <?php endforeach; ?>
        </table>
		<div class="btn_box">

            <?php
            if ($totalpage > 1) {
                ?>
                <a href="<?php echo base_url() . 'owner/history/history_app' ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_back.png' ?>" alt="次へ"></a>
                <?php echo $paging; ?>
                <a href="<?php echo base_url() . 'owner/history/history_app/' . $totalpage; ?>"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_next.png' ?>" alt="次へ"></a>
                <?php
            }
            ?>
        </div>
            <input type='hidden' id="hdPage" name='hdPage' value='<?php echo $curpage; ?>'>
 </form>
 </div><!-- / .table-list-wrapper -->
 </div><!-- /. work-list-wrapper -->
</div><!-- / .contents-box-wrapper -->
    </div><!-- list-box ここまで -->
