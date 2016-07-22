
/*
 * message javascript
 *
 */
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

$(function() {
    var offset = $('ul#message_wrapper').children('li').length;
    var count_all = parseInt($("#countall_message_id").val());
    if (offset < 1) {
        $('#more_message_result').hide();
        $('#btnphuong').hide();
    }
    if (offset == count_all) {
        $('#more_message_result').hide();
    }

    $('#more_message_id').click(function() {
       checkHasMoreMessage();
    });


    function checkHasMoreMessage() {
        offset = $('ul#message_wrapper').children('li').length;
        if (offset < count_all) {
            $('#loader_wrapper').html('<img src="'+ base_url + 'public/owner/images/loading.gif" id="loader">');
            var gettype= parseInt($("#gettype_meessage_id").val());
            $.ajax({
                url:base_url + "user/user_messege/ajax_messege_reception",
                type:"post",
                data:{count_all:count_all,gettype:gettype,getmore:1, message_list: $("#is_message_list").val(), offset: offset },
                async:true,
                success: function(show_message){
                    $.get(base_url + 'user/user_messege/countMessages', { gettype: gettype }, function(result) {
                        $('#countall_message_id').val(result);
                    });
                    $("#list_user_message_id").append(show_message);
                    $('#loader').remove();
                    offset = $('ul#message_wrapper').children('li').length;
                    if (offset == count_all) {
                        $('#more_message_result').hide();
                    }
                    if (offset < 1) {
                        $('#btnphuong').hide();
                    }
                }
            })
            return false;
        }
    }
});

