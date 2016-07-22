<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $titlePage ?></title>
        <meta name="language" content="ja" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/common.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/user/css/themes/default/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/user/css/themes/light/light.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/user/css/themes/dark/dark.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/user/css/themes/bar/bar.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/user/css/nivo-slider.css" type="text/css" media="screen" />

        <script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-1.9.0.min.js"></script>
        <script type="text/javascript"> var title="<?php echo (isset($title))?$title:''; ?>"; </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery.nivo.slider.js"></script>


        <script type="text/javascript">
            $(window).load(function() {
                $('#slider').nivoSlider();
            });
        </script>
       <script language="javascript">
            
            
            $(document).ready(function() {
                //show more top owner
                $("#more_top_owner_list").click(function(){
                    more_top_owner_list=this.href;
                    var countall_top_id=$("#countall_top_id").val();
                    var limit_top_id=$("#limit_top_id").val();
                    
                    var base = $("#base").attr("value");
                    $.ajax({
                        url:base+"user/joyspe_user/process",
                        type:"post",
                        data:"more_top_owner_list="+more_top_owner_list+"&count_all="+countall_top_id+"&limit="+limit_top_id,
                        async:true,
                        success: function(show_top){
                            $("#phuongdeptrai").html(show_top);
                        }
                    })
                    return false;
                });
                //show more user message dustbox
                $("#show_more_message_dustbox").click(function(){
                    show_more_message_dustbox=this.href;
                    var count_all = parseInt($("#countall_message_id").val());
                    var limit = parseInt($("#limit_message_id").val());
                    var gettype= parseInt($("#gettype_meessage_id").val());
                    
                    var base = $("#base").attr("value");
                   
                    $.ajax({
                        url:base+"user/messege_details/ajax_messege_dustbox",
                        type:"post",
                        //data:"count_all="+count_all+"&limit="+limit+"&gettype="+gettype,
                        data:{count_all:count_all,limit:+limit,gettype:gettype,getmore:show_more_message_dustbox},
                        async:true,
                        success: function(mss_dustbox){
                            
                            $("#list_message_dustbox").html(mss_dustbox);
                        }
                        
                    })
                    return false;
                });
                
                //show more user message
                $("#show_more_message_id").click(function(){
                    show_more_message_id=this.href;
                    var count_all = parseInt($("#countall_message_id").val());
                    var limit = parseInt($("#limit_message_id").val());
                    var gettype= parseInt($("#gettype_meessage_id").val());
                    var base = $("#base").attr("value");
                    $.ajax({
                        url:base+"user/user_messege/ajax_messege_reception",
                        type:"post",
                        //data:"count_all="+count_all+"&limit="+limit+"&gettype="+gettype,
                        data:{count_all:count_all,limit:+limit,gettype:gettype,getmore:show_more_message_id},
                        async:true,
                        success: function(show_message){
                            $("#list_user_message_id").html(show_message);
                        }
                        
                    })
                    return false;
                });
                //show more scout_owner
                $("#more_scout__owner_id").click(function(){
                    more_scout__owner_id=this.href;
                    var countall_scout_id=$("#countall_scout_id").val();
                    var limit_scout_id=$("#limit_scout_id").val();
                    var base = $("#base").attr("value");
                    $.ajax({
                        url:base+"user/scout/ajax_load_ScoutList",
                        type:"post",
                        data:"more_scout_id="+more_scout__owner_id+"&count_all="+countall_scout_id+"&limit_scout_id="+limit_scout_id,
                        async:true,
                        success: function(show_scout){
                            $("#div_scout_more").html(show_scout);
                        }
                    })
                    return false;
                })
                //show more keep owners
               $("#more_keep_id").click(function(){
                   more_keep_id=this.href;
                   var limit_keep_id=$("#limit_keep_id").val();
                   var count_all=$("#countall_keep_id").val();
                  
                   var base = $("#base").attr("value");
                   $.ajax({
                       url:base+"user/keep_list/load_ajax_keeplist",
                       type:"post",
                       data:"more_keep_id="+more_keep_id+"&limit_keep_id="+limit_keep_id+"&count_all="+count_all,
                       async:true,
                       success: function(kq){
                           $("#keep_list_id").html(kq);
                       }
                   })
                   return false;
               });
                //show more happy money 
                $("#more_hpm_id").click(function() {
                    more_hpm_id = this.href;
                    var sltgethpm = $("#sltgethpm").val();
                    var limit_hpn_id = $("#limit_hpn_id").val();
                    var base = $("#base").attr("value");
                    $.ajax({
                        url: base + "user/celebration/load_ajax_HappyMoney",
                        type: "post",
                        data: "get_condition=" + sltgethpm + "&limithpm=" + limit_hpn_id + "&more_hpm_id=" + more_hpm_id,
                        async: true,
                        success: function(get_again) {
                            $("#list_owners_hpm").html(get_again);
                        }
                    })
                    return false;
                });
                //change drodownlist : get happy money
                $("#sltgethpm").change(function() {
                    sltgethpm = this.value;
                    var limit_hpn_id = $("#limit_hpn_id").val();
                    var base = $("#base").attr("value");
                    $.ajax({
                        url: base + "user/celebration/load_ajax_HappyMoney",
                        type: "post",
                        data: "get_condition=" + sltgethpm + "&limithpm=" + limit_hpn_id,
                        async: true,
                        success: function(get_again) {
                            $("#list_owners_hpm").html(get_again);
                        }
                    })
                });
                //show more News
                $("#show_more_id").click(function() {
                    show_more_id = this.href;
                    var limit = $("#limit_id").val();
                    var base = $("#base").attr("value");
                    $.ajax({
                        url: base + "user/news/ajax_GetNews",
                        type: "post",
                        data: "show_more_id=" + show_more_id + "&limit=" + limit,
                        async: true,
                        success: function(show_more) {
                            $("#news_id").html(show_more);
                        }
                    })
                    return false;

                });
                //sap xep result search
                $("#sltsort").change(function() {
                    id_select = this.value;
                    var limit = $("#limit_owner_id").val();
                    var hp_mn = $("#hpmn1").val();
                    var hp_mn2 = $("#hpmn2").val();
                    var hourly = $("#hls1").val();
                    var hourly2 = $("#hls2").val();
                    var monthly = $("#mls1").val();
                    var monthly2 = $("#mls2").val();
                    var treatment1 = $("#treat1").val();
                    var treatment2 = $("#treat2").val();
                    var treatment3 = $("#treat3").val();
                    var base = $("#base").attr("value");
                    var check_city_id = $("#check_city_id");
                    //get city checked
                    var city_id = '';
                    $(".check_city").each(function() {
                        var id = $(this).attr('id');
                        if ($('#' + id).is(":checked"))
                        {
                            city_id += $('#' + id).val() + ',';
                        }
                    });
                    $.ajax({
                        url: base + "user/search/do_ajax_sort",
                        type: "post",
                        data: "happy_money1=" + hp_mn + "&happy_money2=" + hp_mn2 + "&hourly1=" + hourly + "&hourly2=" + hourly2 + "&monthly2=" + monthly2 + "&monthly1=" + monthly + "&treatment1=" + treatment1 + "&treatment2=" + treatment2 + "&treatment3=" + treatment3 + "&check_id=" + city_id + "&id_select=" + id_select + "&limit=" + limit,
                        async: true,
                        success: function(sort) {
                            $("#list_owner").html(sort);
                        }
                    })
                });
                //show more result search
                $("#more_id").click(function() {
                    more_id = this.href;
                    var id_select = $("#sltsort").val();
                    var limit = $("#limit_owner_id").val();
                    //alert(limit);
                    var hp_mn = $("#hpmn1").val();

                    var hp_mn2 = $("#hpmn2").val();
                    var hourly = $("#hls1").val();
                    var hourly2 = $("#hls2").val();
                    var monthly = $("#mls1").val();
                    var monthly2 = $("#mls2").val();
                    var treatment1 = $("#treat1").val();
                    var treatment2 = $("#treat2").val();
                    var treatment3 = $("#treat3").val();
                    var base = $("#base").attr("value");
                    var check_city_id =  $("#check_city_id");
                    var base = $("#base").attr("value");
                    var city_id = '';
                    $(".check_city").each(function() {
                        var id = $(this).attr('id');
                        if ($('#' + id).is(":checked"))
                        {
                            city_id += $('#' + id).val() + ',';
                        }
                    });
                    $.ajax({
                        url: base + "user/search/do_ajax_sort",
                        type: "post",
                        data: "happy_money1=" + hp_mn + "&happy_money2=" + hp_mn2 + "&hourly1=" + hourly + "&hourly2=" + hourly2 + "&monthly2=" + monthly2 + "&monthly1=" + monthly + "&treatment1=" + treatment1 + "&treatment2=" + treatment2 + "&treatment3=" + treatment3 + "&check_id=" + city_id + "&id_select=" + id_select + "&more=" + more_id + "&limit=" + limit,
                        async: true,
                        success: function(sort) {
                            $("#list_owner").html(sort);
                        }
                    })
                    return false;
                })
            })
        </script>
    </head>
    <body>
    <div id="wrapper"> 
    <?php $this->load->view('user/share/header'); ?>  
    <?php $this->load->view('user/share/header_index'); ?>   
    <hr size="2px" color="#FF1493">

  
                            <?php $this->load->view($load_page); ?>
                            <input type="hidden" value="<?php echo base_url() ?>" id="base" />
 
             <div id="kq"></div>    
    <hr size="2px" color="#FF1493">
    <?php $this->load->view('user/share/footer'); ?>
    </div><!-- wrapper ここまで -->    
    </body>
</html>


