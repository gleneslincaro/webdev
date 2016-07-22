<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/jquery-ui_new.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url() ?>public/owner/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/public/owner/js/scout_after.js"></script>
<script type="text/javascript">
var count_user_checked = <?php echo isset($sRetainCheckrs)?count($sRetainCheckrs):0; ?>;
var str_city = "<?php echo (isset($str_city))?$str_city:''; ?>";
var ppp = "<?php echo (isset($ppp))?$ppp:''; ?>";
$(function(){
    var sort_active = "<?php echo (isset($sSortActive))?$sSortActive:''; ?>";
    if(sort_active != '') {
        $('.sort span').removeClass('active_blue');
        $('#'+sort_active).addClass('active_blue');
    }

    // add multiple select / deselect functionality
    <?php foreach ($groupcity as $key => $group) { ?>
    $("#<?php echo $group['id']; ?>").click(function() {
        $(".checkcity<?php echo $group['id']; ?>").attr('checked', this.checked);
    });
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".checkcity<?php echo $group['id']; ?>").click(function() {

        if ($(".checkcity<?php echo $group['id']; ?>").length == $(".checkcity<?php echo $group['id']; ?>:checked").length) {
            $("#<?php echo $group['id']; ?>").attr("checked", "checked");
        } else {
            $("#<?php echo $group['id']; ?>").removeAttr("checked");
        }

    });
    <?php } ?>
});
</script>
<div class="crumb">TOP ＞ スカウト機能</div>
<div style="float:right;"><a style="color:#2595F8; font-size: 18px; font-weight: bold" href="<?php echo base_url() . 'owner/history/history_app_message_temp'; ?>">テンプレート</a></div>
<?php
if (empty($owner_data)) {
    redirect(base_url() . 'owner/login');
} else {
    $o = $owner_data;
}
?>
<?php echo Helper::print_error($message); ?>
<!--
<div class="owner-box"><?php echo $o['storename']; ?>　様　ポイント：<?php echo number_format($o['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a></div><br >
-->
<div class="list-box">

    <!--search -->
    <form class="historical-data-form" name="myForm" action="<?php echo base_url().'owner/scout/doSearch'; ?>" method ="post">
        <div class="scout-search">
            <div>
                ID: <input id ="u" type="text"  name="u" placeholder="ID" autocomplete="off" style="width:200px" value="<?php echo $unique_id;?>" />
                <input type="submit" id="search" value="検索" >
            </div>
        </div>
    </form>
    <!--end search -->

<div class="list-title">スカウト機能・検索</div>
    <div class="contents-box-wrapper">
        <div class="regional-list-wrapper">
        <form method="POST" action="<?php echo base_url() . 'owner/scout/doSearch'; ?>">
            <!--<div class="list-title-box-top"><div class="list-t-right"><a href="<?php echo base_url() . 'owner/history/history_app_message_temp' ?>" target="_blank">▼テンプレート確認</a></div></div>-->
            <br>
            <!--    City Group -->
            <?php foreach ($groupcity as $key => $group) { ?>
            <div class="regional-table-wrapper">
                <table cellpadding="0" cellspacing="0">
                <tr>
                    <th>
                        <input <?php
                        if (!empty($sCheckall)){
                            foreach ($sCheckall as $id){
                                if ($group['id'] == $id){echo 'checked="checked"';}
                            }
                        }
                        ?> type="checkbox" id="<?php echo $group['id']; ?>" class="checkall" name="checkall[]" value="<?php echo $group['id']; ?>"/><?php echo $group['name']; ?>
                    </th>
                </tr>
            <!--    City-->
            <?php foreach ($city as $key => $value){
                if ($value['city_group_id'] == $group['id']){ ?>
                <tr>
                    <td><input <?php
                    if (!empty($sCity)){
                        foreach ($sCity as $id){
                            if ($value['id'] == $id){echo 'checked="checked"';}
                        }
                    }
                    ?> class="checkcity<?php echo $value['city_group_id']; ?>" id="checkcity<?php echo $value['city_group_id']; ?>" type="checkbox" name="checkcity[]" value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?>
                    </td>
                </tr>
                <?php
                }
            }
                ?>
                </table>
            </div>
            <?php } ?>
            <br style="clear:both;">
        	<br >
            <div class="list-t-center input-bottom">
            	<input type="hidden" value='1' name="doSearch">
            	<input type="submit" id ="btn_search_duc" name="btnSubmit" value="検索" style="width:150px; height:40px;">
            </div>
        </form>
        </div>
<!--RESULT PAGE-->
<?php if($flag != 0 ) { ?>
        <form id="resultsearch" <?php if(!isset($_SESSION['sCheckrs'])){echo "onsubmit='return check();'";} ?> method="post" action="<?php echo base_url().'owner/history/history_app_scout'; ?>">
        <div class="list-title list-title-result">検索結果 <span class="ml10"><?php echo ($total > 0)?$total."件":''; ?></span></div><br >
        <div class="regional-list-wrapper">
            <div id="dialog-confirm">
                <p>一覧から非表示にしますか？</p>
    		</div>
    		<div id="dialog-list_of_hide_users">
                <p></p>
    		</div>
            <?php if (count($newUser) > 1): ?>
            <div class="sort_area">
                <?php $this->load->view('owner/index/user_sort'); ?>
                <a class="hide-text" href="javascript:void(0)" id="show_list_of_hide_users">非表示を戻す</a>
            </div>
            <?php endif; ?>
            <div class="img-prof in_new result-list">
            <?php if(isset($newUser) && is_array($newUser)): ?>
            <?php
                $this->load->view('index/list_of_users.php');
            ?>
            <?php else: ?>
                ユーザーが見つかりませんでした。
            <?php endif; ?>
            </div>
            <?php
                $this->load->view('index/user_popup.php'); 
            ?>        
        </div><!-- / .regional-list-wrapper -->
        <!--      END CONTENT-->
        <div class="btn_box">
        <?php
            $this->load->view('scout/scout_paging.php');
        ?>        
        </div>
        <!-- LINK -->
        <div class="list-title-box-bottom">
            <!--<div class="list-t-right"><a href="<?php echo base_url() . 'owner/history/history_app_message_temp' ?>" target="_blank">▼テンプレート確認</a></div>-->
        </div>
        <!-- BUTTON -->
        <?php if ($total > 0): ?>
            <?php if ( $o['remaining_scout_mail'] > 0 ){ ?>
        <div class="list-t-center input-bottom"><input type="submit" value="スカウトメッセージを送る" style="width:180px; height:40px;"></div>
            <?php }else{ ?>
        <div class="list-t-center input-bottom"><input type="submit" disabled value="スカウトメッセージを送る" style="width:180px; height:40px;">
        <center>本日送信可能スカウトメールは0通です</center></div>
            <?php } ?>
        <?php endif; ?>
        <input type="hidden" id="sortUsers" name="sortUsers" value="login_user0">
<!--        <input type="hidden" id="totalUsers" name="totalUsers" value="<?php echo $total; ?>">  -->
        <input type="hidden" id="sendlimit" name="sendlimit" value="<?php echo $o['remaining_scout_mail']; ?>">
        </form>
<?php } ?>
    </div>
</div>
<?php
    $this->load->view('index/wait_for_sort');
?>