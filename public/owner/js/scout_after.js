$(function(){
    var istr = "checkrs[]";
    var ichk = document.getElementsByName(istr);
    var ichk_cnt = 0;
    for (i = 0; i < ichk.length; i++) {
        if (ichk[i].checked == true) {
            $.get(baseUrl + "owner/scout/checkIfUserIsChecked", {user_id: ichk[i].value}, function(data) {
                if ( data != 'true') {
                    count_user_checked++;
                }
            });
        }
    }
    
    // add multiple select / deselect functionality
    $("#selectall").click(function(){
        $('.case').attr('checked', this.checked);
        resultsearch();
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){
        if ($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }
    });

    $("#th2").addClass("visited");
    displayPopupError();

    $('.user-image').bind('contextmenu', function(e){
        return false;
    });

    $( "#dialog-confirm" ).hide();
    $( "#dialog-list_of_hide_users" ).hide();

    $('#show_list_of_hide_users').click(function (){
        $.get(baseUrl + "owner/index/count_owner_hidden_users",function(data){
            if(data > 0){
                $.get(baseUrl + "owner/scout/list_of_hide_users",{str_city:str_city})
                .done(function( data ){
                    $( "#dialog-list_of_hide_users" ).html( data );
                    //var height = $( "#dialog-list_of_hide_users" ).height() + 80;
                    $( "#dialog-list_of_hide_users" ).dialog({
                        resizable: false,
                        height: 421,
                        width: 930,
                        modal: true,
                        buttons: {
                          "Ok": function() {
                            if($('#sortUsers').val() != ''){
                                var sort_type = $('#sortUsers').val();
                            }
                            var page = location.hash.replace(/#/g,"");
                            var unique_id = $('#u').val();
                            $('#sort_in_progress').show();
                            var deferredObjects = [];
                            deferredObjects.push($.ajax(
                                {type:'post',url:baseUrl+"owner/scout/list_of_users",data:{sort_type:sort_type, page:page, ppp:ppp, function_name:'return resultsearch(this);', str_city:str_city, u:unique_id}}
                            ));
                            deferredObjects.push($.ajax(
                                {type:'post',url:baseUrl+'owner/scout/scout_pagination',data:{sort_type:sort_type, page:page, cur_page:$('#hdPage').val(), str_city:str_city, u:unique_id}}
                            ));
                            $.when.apply($, deferredObjects).done(function () {
                                var data = [];
                                for (var i = 0; i < arguments.length; i++) {
                                    var result = arguments[i];
                                    data.push(result[0]);
                                }
                                $('.img-prof').html(data[0]);
                                $('.btn_box').html(data[1]);
                                $('.list-title span').text($('#totalUsers').val()+'件');
                                $( "#dialog-list_of_hide_users" ).dialog("close");
                                $('#sort_in_progress').hide();
                            });
                          }
                        }
                    });
                });
            }else{
                alert('非表示されているユーザーがありません。');
            }
        });
    });

    $(document).on('click', '.prev_btn a', function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        location.hash = href;
    });

    $(document).on('click', '.next_btn a', function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        location.hash = href;
    });

    // ページリロード確認(タイマーがリセットされていなければページリロードが起きていないということ)
    var timer = 0;
    setInterval(function(){
        ++timer;
    }, 1000);
    
    // ハッシュ変更時に実行する関数を登録
    HashObserve.addFunc(function(now_hash, prev_hash){
        var page = now_hash.replace(/#/g,"");
        var unique_id = $('#u').val();
        var sort_type = $('#sortUsers').val();
        $('#sort_in_progress').show();
        var deferredObjects = [];
        deferredObjects.push($.ajax(
            {type:'post',url:baseUrl+"owner/scout/list_of_users",data:{sort_type:sort_type, page:page, function_name:'return resultsearch(this);',ppp:ppp, str_city:str_city, u:unique_id}}
        ));
        deferredObjects.push($.ajax(
            {type:'post',url:baseUrl+'owner/scout/scout_pagination',data:{sort_type:sort_type, page:page, cur_page:$('#hdPage').val(), str_city:str_city, u:unique_id}}
        ));
        $.when.apply($, deferredObjects).done(function () {
            var data = [];
            for (var i = 0; i < arguments.length; i++) {
                var result = arguments[i];
                data.push(result[0]);
            }
            $('.img-prof').html(data[0]);
            $('.btn_box').html(data[1]);
            $('#sort_in_progress').hide();
        });
    });
    
    // 監視を開始
    setInterval(HashObserve.observe, 1000/30);    

});
/** ハッシュ監視クラス(static class) */
var HashObserve = {
    funcList: [],   // ハッシュ変更時に実行する関数リスト
    prevHash: "",   // 前回のハッシュ
    
    /** 監視 */
    observe: function()
    {
        // 前回のハッシュと比較
        if (HashObserve.prevHash!==window.location.hash) {
            // 登録されている関数を実行
            for (var i=0; i<HashObserve.funcList.length; ++i) {
                HashObserve.funcList[i](window.location.hash, HashObserve.prevHash);
            }
            // 前回のハッシュを更新
            HashObserve.prevHash=window.location.hash;
        }
    },
    
    /**
     * ハッシュ変更時に実行する関数を登録
     * @param {Object} fn
     */
    addFunc: function(fn)
    {
        HashObserve.funcList.push(fn);
    }
};

function sortUsersFunc(e) {
    var page = location.hash.replace(/#/g,"");
    var unique_id = $('#u').val();
    $('#sort_in_progress').show();
    var deferredObjects = [];
    deferredObjects.push($.ajax(
        {type:'post',url:baseUrl+"owner/scout/list_of_users",data:{sort_type:e.id, page:page, function_name:'return resultsearch(this);',ppp:ppp, str_city:str_city, u:unique_id}}
    ));
    deferredObjects.push($.ajax(
        {type:'post',url:baseUrl+'owner/scout/scout_pagination',data:{sort_type:e.id, page:page, cur_page:$('#hdPage').val(), str_city:str_city, u:unique_id}}
    ));
    $.when.apply($, deferredObjects).done(function () {
        var data = [];
        for (var i = 0; i < arguments.length; i++) {
            var result = arguments[i];
            data.push(result[0]);
        }
        $('.img-prof').html(data[0]);
        $('.btn_box').html(data[1]);
        $('.sort span').removeClass('active_blue');
        $('#'+e.id).addClass('active_blue');
        $('#sortUsers').val(e.id);
        $('.list-title span').text($('#totalUsers').val()+'件');
        $('#sort_in_progress').hide();
    });
}

function show_users(id) {
    $.post(baseUrl+"owner/index/show_scout_user", {id: id}, function(data) {
        $('#totalUsers').val(parseInt($('#totalUsers').val())+1);
        if(data > 0 ){
          $('#hide_user_'+id).fadeOut(200);
        }
        else {
            if($('#sortUsers').val() != ''){
                sortUser = $('#sortUsers').val();
            }
            $('#sort_in_progress').show();
            var page = location.hash.replace(/#/g,"");
            $.post(baseUrl+"owner/scout/list_of_users",{sort_type:sortUser, page:page, ppp:ppp, function_name:'return resultsearch(this);', str_city:str_city})
            .done(function(data){
                $('#sort_in_progress').hide();
                $('.img-prof').html(data);
                $('.sort span').removeClass('active_blue');
                $('#'+sortUser).addClass('active_blue');
                $('#sortUsers').val(sortUser);
                $('.list-title span').text($('#totalUsers').val()+'件');
                $( "#dialog-list_of_hide_users" ).dialog("close");
            });
        }
    })
}

function hide_user(id) {
    var page = location.hash.replace(/#/g,"");
    $("#dialog-confirm").dialog({
        resizable: false,
        height:140,
        width: 300,
        modal: true,
        closeOnEscape: true,
        buttons:{
            "はい": function() {
                $('#sort_in_progress').show();
                $.post(baseUrl+'owner/scout/remove_user_scout',{id: id, remove: true, hdPage: $('#hdPage').val()},function(data){
                    if($('#checkrss' + id).is(":checked")){
                        $('#checkrss' + id).removeAttr('checked');
                    }
                    $('#user_'+id).fadeOut(300, function(){
                        var page = location.hash.replace(/#/g,"");
                        var sort_type = $('#sortUsers').val();
                        var deferredObjects = [];
                        deferredObjects.push($.ajax(
                            {type:'post',url:baseUrl+'owner/scout/list_of_users', data:{sort_type:sort_type, page:page, ppp:ppp, function_name:'return resultsearch(this);', str_city:str_city}}
                        ));
                        deferredObjects.push($.ajax(
                            {type:'post',url:baseUrl+'owner/scout/scout_pagination', data:{sort_type:sort_type, page:page, cur_page: $('#hdPage').val(), str_city:str_city}}
                        ));
                        $.when.apply($, deferredObjects).done(function() {
                            var data = [];
                            // 結果は仮引数に可変長で入る **順番は保証されている**
                            // 取り出すには arguments から取り出す さらにそれぞれには [data, textStatus, jqXHR] の配列になっている
                            for (var i = 0; i < arguments.length; i++) {
                                var result = arguments[i];
                                data.push(result[0]);
                            }
                            //data[0];// => リクエストの配列と同じ順番で結果を参照できる
                            $('.img-prof').html(data[0]);
                            $('.btn_box').html(data[1]);
                            $('.list-title span').text($('#totalUsers').val()+'件');
                            $('#sort_in_progress').hide();
                        });
                    });
                });
                $( this ).dialog( "close" );
            },
            "いいえ": function() {
                $( this ).dialog( "close" );
            }
        }
    });
}

function check() {
    var send_limit = document.getElementById('sendlimit').value;
    if (count_user_checked == 0) {
        alert("チェックボックスが選択されておりません。対象を選択して下さい。");
        return false;
    }else{
        if ( count_user_checked > send_limit) {
             alert("選択されたスカウトメール数は本日送信可能数を超えました。再選択ください。");
             return false;
        }
    }
}

function resultsearch(e){
    var send_limit = document.getElementById('sendlimit').value;
    if ( document.getElementById(e.id).checked == false ) {
        count_user_checked--;
    }
    else {
        count_user_checked++;
    }
    if ( count_user_checked <= send_limit ) {
        var data = document.getElementById(e.id);
        var checked = 0;
        if(data.checked)
            checked = 1;

        var scout_action = baseUrl + "owner/scout/saveCheck1";

        $.post(scout_action, {checked: checked, id: e.value, hdPage: $('#hdPage').val() },function(){
        });
    }
    else {
        count_user_checked--;
        document.getElementById(e.id).checked = false;
        alert("本日のスカウト送信数をオーバーしています。選択数を減らしてください。");
    }
}

function retainSaveCheck(e){
    var href  = $(e).attr('href');
    $.post(baseUrl + "owner/scout/retainSaveCheck",{}, function(data){
        window.location.href = href;
    });
    return false
}

function displayPopupError(){
    var div_error = $(".hide-error");
    if(div_error.length > 0){
        var error = div_error.text();
        var arr = error.split('● ');
        var strErr = "";
        for (i = 1; i < arr.length; i++)
        {
            strErr += '● ' + arr[i] + "\n";
        }
        alert(strErr);
    }
}