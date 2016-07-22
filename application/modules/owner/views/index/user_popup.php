<style type="text/css">
.modalbg{
width: 100%;
height: 100%;
top:0;
left: 0;
position: fixed;
z-index: 900;
opacity: 0.25;
background-color: #000;    
}

.modalBody #photo_container #thumbnail{
    overflow: hidden;
    width: 100%;
    padding: 0;
    margin-top: 10px;
    margin-bottom: 10px;
}
.modalBody #photo_container #thumbnail li{
    float: left;
    list-style: none;
    background-color: #fff;
}
.modalBody #photo_container #thumbnail li img{
/*    width: 100%;*/
    height: 90px;
    opacity: 0.5;
    filter: alpha(opacity=50);
    border: 1px solid #ccc;
}
.modalBody #photo_container #thumbnail li.current img{
    opacity: 1;
    filter: alpha(opacity=100);
}
#main_photo{
    position: relative;
    height: 300px;
}
#main_photo img{
    position: absolute;
    top:0;
/*    width: 100%;*/
    height: 300px;
    border: 1px solid #ccc;
}

.modalBody div#photo_container{
float: left;
color: #333;
margin-left: 20px;    
}

.modalBody div#photo_container div#photo_container_inner{

}

.modalBody div#user_info{
font-size: 18px;    
float:right;
color: #333;    
border: 1px solid #CCCCCC;
padding: 20px;
margin-left: 58px;
}

.modalBody div#user_stat{
font-size: 14px;    
float:right;
color: #333;    
border: 1px solid #CCCCCC;
padding: 10px;
margin-top: 20px;
}

.modalBody div#user_pr_msg{
font-size: 14px;    
float:right;
color: #333;    
border: 1px solid #CCCCCC;
padding: 10px;
width: 97%;
}

.img-prof li p.btns{
width: 250px;
text-align: center;
background-color: #F67286;
color: #fff;
cursor: pointer;
padding-top: 8px;
padding-bottom: 8px;
}

.modalBody div#photo_container ul#thumbnail li{
margin:0;
width: auto;
}

.modal{display:none;}
.modalBody{
position: fixed; z-index:1000; background: #fff; width:720px; left:50%;
/*top:50%;*/
top:40px;
border: 1px solid #ccc;
}
.modalBK{position: fixed; z-index:999; height:100%; width:100%;background:#000; opacity: 0.9;filter: alpha(opacity=90);-moz-opacity:0.90;}

.close_box{font-size:15px;margin-top:-3px;border: 2px solid #333;color:#333;border-radius:50%;height:15px;width:15px;float:right;line-height:1;text-align: center;}
.close{color:#333;cursor: pointer;display: inline;font-size: 15px;}
.modal{width:690px; color: #eee;}
.modal p{font-size:12px; text-align:justify;}
.modal h1{font-weight:bold; font-size: 30px;}
.modalBody{padding: 10px;}
</style>

<div class="modal wd1">
    <div class="modalBody">
        <div style="text-align:right"><div class="close">close<div class="close_box">x</div></div></div>    

        <div id="user_info">
        </div>

        <div id="photo_container">
            <div id="photo_container_inner">
            <div id="main_photo">
            </div>
            </div>
            <ul id="thumbnail">
            </ul>
        </div>

        <div id="user_stat">
        </div>

        <div id="user_pr_msg">
        </div>

    </div>
    <div class="modalBK"></div>
</div>

<script type="text/javascript">
var checked_id;
$(function(){
    $(document).on('click', '.btns', function(){
        wn = '.' + $(this).data('tgt');
        var mW = $(wn).find('.modalBody').innerWidth() / 2;
        var mH = $(wn).find('.modalBody').innerHeight() / 2;
        $(wn).find('.modalBody').css({'margin-left':-mW,'margin-top':-mH});
        $(wn).fadeIn(250);

        var id = $(this).data('id');
        checked_id = id;
        var text = $('.img-prof ul li#user_'+id+' p.profile_text').html();
        var stat = $('.img-prof ul li#user_'+id+' p.stat').text();
        var pr_msg = $('.img-prof ul li#user_'+id+' p.pr_msg').html();
        $("#thumbnail").empty();
        $("#main_photo").empty();
        $("#user_stat").empty();
        $('.img-prof ul li#user_'+id+' div.pic img').each(function(){
            var src = $(this).attr('src');
            var img_tag = '<li><a href="'+src+'"><img src="'+src+'" alt="photo" /></a></li>';
            $('#thumbnail').append(img_tag);
        });
        thumbnail_set();

        $('#user_info').html(text);
        $('#user_info span.profile_detail').show();

        <?php if(isset($doSearch_flag)): ?>
            $('#user_stat').html('<input id="popupcheck" type="checkbox" value="'+id+'" onchange="return popupsendScout2(this);">');
        <?php else: ?>
            $('#user_stat').html('<input id="popupcheck" type="checkbox" value="'+id+'" onchange="return popupsendScout(this);">');
        <?php endif; ?>

        $("body").prepend('<div class="modalbg" >');
//        $("body").append('</div>');

        $('#user_stat').append(stat);
        $('#user_pr_msg').html(pr_msg);

        if($('#checkrss'+id).prop('checked')){
            $('#popupcheck').prop('checked',true);
        }else{
            $('#popupcheck').prop('checked',false);
        }

    });
    $(document).on('click', '.close,.modalBK', function(){
        $(".modalbg").remove();
        $(wn).fadeOut(250);
    });

});

function popupsendScout(e){
    if($(e).prop('checked')){
        $('#checkrss'+checked_id).prop('checked',true);
    }else{
        $('#checkrss'+checked_id).prop('checked',false);
    }
    sendScout(e);
}
function popupsendScout2(e){
    if($(e).prop('checked')){
        $('#checkrss'+checked_id).prop('checked',true);
    }else{
        $('#checkrss'+checked_id).prop('checked',false);
    }
    resultsearch(e);
}
</script>
<script>
    // 横幅などの設定
    var options = {
        maxWidth : 400, // #photo_container の max-width を指定(px)
        thumbMaxWidth : 80, // #thumbnail li の max-width を指定(px) 
        thumbMinWidth : 60, // #thumbnail li の min-width を指定(px) 
        fade : 500 // フェードアウトするスピードを指定
    };

    function thumbnail_set(){
        // 変数を作る
    var thumbList = $('#thumbnail').find('a'),
            mainPhoto = $('#main_photo'),
            img = $('<img />'),
            imgHeight;
         
        // 親ボックスと li 要素に max-width 指定
//        $('#photo_container').css('maxWidth', options.maxWidth);
        $('#photo_container').css('width', options.maxWidth);
         
        // li 要素の横幅の計算と指定
        var liWidth = Math.floor((options.thumbMaxWidth / options.maxWidth) * 100);
/*        $('#thumbnail li').css({
            width : liWidth + '%',
            maxWidth : options.thumbMaxWidth,
            minWidth : options.thumbMinWidth
        });*/
         
        // 最初の画像の div#main_photo へ表示と current クラスを指定
        img = img.attr({
                src: $(thumbList[0]).attr('href'),
                alt: $(thumbList[0]).find('img').attr('alt')
        });
        mainPhoto.append(img);
        $('#thumbnail li:first').addClass('current');

        var mw = mainPhoto.width() / 2;
        var w = mainPhoto.find('img').width() / 2;
        mainPhoto.find('img').css({
            left:mw-w
        });
 
        // メイン画像を先に読み込んどく
        for(var i = 0; i < thumbList.length; i++){
            $('<img />').attr({
                src: $(thumbList[i]).attr('href'),
                alt: $(thumbList[i]).find('img').attr('alt')
            });
        }
        
        // サムネイルのクリックイベント
        thumbList.on('click', function(){ 
            // img 要素を作り サムネイル画像からリンク・altの情報を取得・設定する
            var photo = $('<img />').attr({
                src: $(this).attr('href'),
                alt: $(this).find('img').attr('alt')
            });
 
            // div#main_photo へ 上で作った img 要素を挿入する
            mainPhoto.find('img').before(photo);

            var mw = mainPhoto.width() / 2;
            var w = mainPhoto.find('img').width() / 2;
            mainPhoto.find('img').css({left:mw-w});

            var w = mainPhoto.find('img:not(:first)').width() / 2;
            mainPhoto.find('img:not(:first)').css({left:mw-w});

            // div#main_photo に先に表示されていた img 要素をフェードしながら非表示にし要素を消す、 
            mainPhoto.find('img:not(:first)').stop(true, true).fadeOut(options.fade, function(){
                $(this).remove();
            });
            
            // 新しく表示した img の親 li へ .current を付け、
            // 他の li 要素についていた .current を削除する
            $(this).parent().addClass('current').siblings().removeClass('current');
            // 画像の親要素を現在表示中の画像の高さへ変更する
            mainPhoto.height(photo.outerHeight());
            return false;
        });    
         
        // ウィンドウが読み込まれた時とリサイズされた時に 
        // div#main_photo の高さを img の高さへ変更する
        $(window).on('resize load', function(){
            mainPhoto.height(mainPhoto.find('img').outerHeight());
        });
    };
</script>