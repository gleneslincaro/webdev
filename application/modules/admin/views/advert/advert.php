<style>
/* モーダル コンテンツエリア */
#modal-main-banner,#modal-main-text,#modal-main-url {
display: none;
width: 500px;
height: auto;
margin: 0;
padding: 0;
background-color: #ffffff;
color: #666666;
position:fixed;
z-index: 2;
}
/* モーダル 背景エリア */
#modal-bg {
display:none;
width:100%;
height:100%;
background-color: rgba(0,0,0,0.5);
position:fixed;
top:0;
left:0;
z-index: 1;
}

.file_upload_form{
margin: 20px;
}

#modal-main-banner #ad_images{
max-height: 700px;
overflow-y: scroll;
}

.advert_edit_list table tbody tr td{
}

.advert_edit_list .interval {
width: 50px;
}

.ad_url_btn{
float: right;
}

#modal-main-text {
padding:10px;
}
#modal-main-text textarea {
width: 100%;
}
.advert_edit_list table tbody tr td.ad_contents{
vertical-align: top;
}

.advert_edit_list .ad_contents img{
width: 250px;
}

#modal-main-url input{
width: 90%;
}
</style>
<center>
<p>広告設定</p>
<!--    <p><a id="modal-open">【クリックでモーダルウィンドウを開きます。】</a></p>  -->
<div>
<!-- <a href="<?php echo base_url().'admin/search_contents/treatment';?>">待遇</a>  -->
</div>

<div class="advert_edit_list">
<table border="1" width="1100" cellspacing="0" cellpadding="5" bordercolor="#333333">
<tr>
<th bgcolor="#CCC" width="150"><font color="#FFFFFF">カテゴリー</font></th>
<th class="interval" bgcolor="#CCC" width="50"><font color="#FFFFFF">表示間隔</font></th>
<th bgcolor="#CCC" width="280"><font color="#FFFFFF">URL</font></th>
<th bgcolor="#CCC" width="80"><font color="#FFFFFF">表示タイプ</font></th>
<th bgcolor="#CCC" width="280"><font color="#FFFFFF">内容</font></th>
<th bgcolor="#CCC" width="60"><font color="#FFFFFF">編集</font></th>
<th bgcolor="#AAA" width="60"><font color="#FFFFFF">有効/無効</font></th>
</tr>

<tr>
<td>トップページ</td>
<td class="interval">
</td>

<td class="edit_url">
<p id="ad_url0" class="ad_url"><?php echo $is_top_info['ad_url']; ?></p>
<button class="ad_url_btn" type="button" data-bigcatenum="0" >編集</button>
</td>
<td class="advert_type">
<select name="advert_type" data-bigcatenum="0">
<option value="0" <?php echo ($is_top_info['ad_type'] == 0)? 'selected':''; ?> >画像</option>
<option value="1" <?php echo ($is_top_info['ad_type'] == 1)? 'selected':''; ?> >テキスト</option>
</select>
</td>
<td class="ad_contents" id="ad_contents0"><?php
	if ($is_top_info['ad_type'] == 0) {
		if($is_top_info['ad_image'] != ''){
			echo '<img src='.$is_top_info['ad_image'].'>';
		}
	} else {
		echo $is_top_info['ad_text'];
	}
?>
</td>
<td>
<button id="ad_edit0" class="ad_edit" type="button" data-ar-type="<?php echo $is_top_info['ad_type']; ?>" data-bigcatenum="0" >編集</button>
</td>
<td>
<select name="advert_flag" data-bigcatenum="0">
<option value="0" <?php echo ($is_top_info['ad_flag'] == 0)? 'selected':''; ?> >無効</option>
<option value="1" <?php echo ($is_top_info['ad_flag'] == 1)? 'selected':''; ?> >有効</option>
</select>
</td>
</tr>

<?php foreach($big_category_ar as $val): ?>
<tr>
<td>
<?php echo $val['jp_name']; ?>
</td>

<td class="interval">
<select name="advert_interval" data-bigcatenum="<?php echo $val['id']; ?>">
<option value="0" <?php echo ($val['ad_interval'] == 0)? 'selected':''; ?> >表示しない</option>
<option value="1" <?php echo ($val['ad_interval'] == 1)? 'selected':''; ?> >1</option>
<option value="2" <?php echo ($val['ad_interval'] == 2)? 'selected':''; ?> >2</option>
<option value="3" <?php echo ($val['ad_interval'] == 3)? 'selected':''; ?> >3</option>
<option value="4" <?php echo ($val['ad_interval'] == 4)? 'selected':''; ?> >4</option>
<option value="5" <?php echo ($val['ad_interval'] == 5)? 'selected':''; ?> >5</option>
<option value="6" <?php echo ($val['ad_interval'] == 6)? 'selected':''; ?> >6</option>
<option value="7" <?php echo ($val['ad_interval'] == 7)? 'selected':''; ?> >7</option>
<option value="8" <?php echo ($val['ad_interval'] == 8)? 'selected':''; ?> >8</option>
<option value="9" <?php echo ($val['ad_interval'] == 9)? 'selected':''; ?> >9</option>
<option value="10" <?php echo ($val['ad_interval'] == 10)? 'selected':''; ?> >10</option>
<option value="11" <?php echo ($val['ad_interval'] == 11)? 'selected':''; ?> >11</option>
<option value="12" <?php echo ($val['ad_interval'] == 12)? 'selected':''; ?> >12</option>
<option value="13" <?php echo ($val['ad_interval'] == 13)? 'selected':''; ?> >13</option>
<option value="14" <?php echo ($val['ad_interval'] == 14)? 'selected':''; ?> >14</option>
<option value="15" <?php echo ($val['ad_interval'] == 15)? 'selected':''; ?> >15</option>
</select>
</td>

<td class="edit_url">
<p id="ad_url<?php echo $val['id']; ?>" class="ad_url"><?php echo $val['ad_url']; ?></p>
<button class="ad_url_btn" type="button" data-bigcatenum="<?php echo $val['id']; ?>" >編集</button>
</td>

<td class="advert_type">
<select name="advert_type" data-bigcatenum="<?php echo $val['id']; ?>">
<option value="0" <?php echo ($val['ad_type'] == 0)? 'selected':''; ?> >画像</option>
<option value="1" <?php echo ($val['ad_type'] == 1)? 'selected':''; ?> >テキスト</option>
</select>
</td>
<td class="ad_contents" id="ad_contents<?php echo $val['id']; ?>"><?php
	if ($val['ad_type'] == 0) {
		if($val['ad_image'] != ''){
			echo '<img src='.$val['ad_image'].'>';
		}
	} else {
		echo $val['ad_text'];
	}
?>
</td>
<td>
<button id="ad_edit<?php echo $val['id']; ?>" class="ad_edit" type="button" data-ar-type="<?php echo $val['ad_type']; ?>" data-bigcatenum="<?php echo $val['id']; ?>" >編集</button>
</td>
<td>
<select name="advert_flag" data-bigcatenum="<?php echo $val['id']; ?>">
<option value="0" <?php echo ($val['ad_flag'] == 0)? 'selected':''; ?> >無効</option>
<option value="1" <?php echo ($val['ad_flag'] == 1)? 'selected':''; ?> >有効</option>
</select>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>

<div class="file_upload_form">

<form id="my_form">
    <input type="file" name="file_1">
    <button id = "file_upload" type="button" >アップロード</button>
</form>


</div>

<div id="modal-main-url">
<p>URL編集</p>
<input type="text" name="advert_url">
<button class="ad_no_save" type="button" >戻る</button>
<button class="ad_ok_save" type="button" >保存</button>
</div>

<div id="modal-main-text">
<p>テキスト編集</p>
<textarea id="ad_text" rows="4" cols="40"></textarea>
<button class="ad_no_save" type="button" >戻る</button>
<button class="ad_ok_save" type="button" >保存</button>
</div>

<div id="modal-main-banner">
	<p>バナー選択</p>
	<div id="ad_images">
	<p><input type="radio" name="ar_image" value="/public/admin/uploads/images/advert_def/sample_2.gif" checked="checked">
	<img width="180px;" src="/public/admin/uploads/images/advert_def/sample_2.gif"></p>
	<?php foreach($advert_image_ar as $val): ?>
	<p><input type="radio" name="ar_image" value="<?php echo $val['image_path']; ?>"><img width="180px;" src="<?php echo $val['image_path']; ?>"></p>
	<?php endforeach; ?>
	</div>
	<button class="ad_no_save" type="button" >戻る</button>
	<button class="ad_ok_save" type="button" >保存</button>
</div>

</center>

<script>
	//modal
$(function(){

	$('#file_upload').on('click', function() {

	    var formdata = new FormData($('#my_form').get(0));

	    $.ajax({
	        url  : "/admin/advert/advert_upload_ajax",
	        type : "POST",
	        data : formdata,
	        cache       : false,
	        contentType : false,
	        processData : false,
	        dataType    : "html"
	    })
	    .done(function(data, textStatus, jqXHR){
	        alert(data);
			location.reload();
	    })
	    .fail(function(jqXHR, textStatus, errorThrown){
	        alert("fail");
	    });

	});

/*

	function file_upload()
	{



	    var formdata = new FormData($('#my_form').get(0));

	    $.ajax({
	        url  : "/admin/advert/advert_upload_ajax",
	        type : "POST",
	        data : formdata,
	        cache       : false,
	        contentType : false,
	        processData : false,
	        dataType    : "html"
	    })
	    .done(function(data, textStatus, jqXHR){
	        alert(data);
	    })
	    .fail(function(jqXHR, textStatus, errorThrown){
	        alert("fail");
	    });
	}

*/

	/* 有効化 */
	$('select[name=advert_flag]').on('change', function() {
		var flag = $(this).val();
		var num = $(this).data('bigcatenum');
		$.ajax({
			url: "/admin/advert/advert_setting_ajax",
			type:"post",
			dataType: "json",
			data:{q:'ad_flag', id: num, ad_flag: flag}
		}).done(function(data){
			if (flag == 1) {
				alert('有効化されました。');
			} else {
				alert('無効化されました。');
			}
		}).fail(function(data){
			alert('error!!!');
		});
	});

	//表示間隔
	$('select[name=advert_interval]').on('change', function() {
		var interval = $(this).val();
		var num = $(this).data('bigcatenum');
		//alert('変更されました'+num+'='+str);
		$.ajax({
			url: "/admin/advert/advert_setting_ajax",
			type:"post",
			dataType: "json",
			data:{q:'ad_interval', id: num, ad_interval: interval}
		}).done(function(data){
			console.log('変更されました。表示間隔');
		}).fail(function(data){
			alert('error!!!');
		});

	});


	$('.ad_url_btn').on('click', function() {
		//body内の最後に<div id="modal-bg"></div>を挿入
		$("body").append('<div id="modal-bg"></div>');
		var num = $(this).data('bigcatenum');
		var text = $(this).prev('p').text();
		$('input[name=advert_url]').val(text);

		$('#modal-main-url .ad_ok_save').off('click');
		$('#modal-main-url .ad_no_save').off('click');

		//画面中央を計算する関数を実行
		modalResize("#modal-main-url");
		//モーダルウィンドウを表示
		$("#modal-bg,#modal-main-url").fadeIn("fast");
		//クリックしたらモーダルを閉じる
		$('#modal-main-url .ad_ok_save').on('click', function() {
			var ad_url = $('input[name=advert_url]').val();
			$('#ad_url'+num).text(ad_url);

			$.ajax({
				url: "/admin/advert/advert_setting_ajax",
				type:"post",
				dataType: "json",
				data:{q:'ad_url',id: num, ad_url: ad_url}
			}).done(function(data){
				console.log('変更されました。URL');
			}).fail(function(data){
				alert('error!!!');
			});

			$("#modal-main-url,#modal-bg").fadeOut("fast",function(){
				$('#modal-bg').remove() ;
			});
		});

		$('#modal-main-url .ad_no_save').on('click', function() {
			$("#modal-main-url,#modal-bg").fadeOut("fast",function(){
				$('#modal-bg').remove() ;
			});
		});

		//画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
		$(window).resize(modalResize("#modal-main-url"));

	});

	$('select[name=advert_type]').on('change', function() {
		var type_num = $(this).val();
		var num = $(this).data('bigcatenum');
		$('#ad_edit'+num).attr('data-ar-type', type_num);
		$.ajax({
			url: "/admin/advert/advert_setting_ajax",
			type:"post",
			dataType: "json",
			data:{q:'ad_type',id: num, ad_type: type_num}
		}).done(function(data){
			console.log('変更されました。表示タイプ');
		}).fail(function(data){
		      alert('error!!!');
		});
	});

   //テキストリンクをクリックしたら
	$('.ad_edit').on('click', function() {
      //body内の最後に<div id="modal-bg"></div>を挿入
        $("body").append('<div id="modal-bg"></div>');

		var num = $(this).data('bigcatenum');
		var type = $(this).attr('data-ar-type');

		console.log(type);
		console.log(num);

		if (type == '0') {
			$('#modal-main-banner .ad_ok_save').off('click');
			$('#modal-main-banner .ad_no_save').off('click');

		    //画面中央を計算する関数を実行
    		modalResize("#modal-main-banner");
 
    		//モーダルウィンドウを表示
        	$("#modal-bg,#modal-main-banner").fadeIn("fast");

 
    		//クリックしたらモーダルを閉じる
			$('#modal-main-banner .ad_ok_save').on('click', function() {



			    var radioVal = $("input[name='ar_image']:checked").val();
			    if(radioVal == 'undefined'){
				    console.log('選択されていません');
			    } else {
					$.ajax({
					  url: "/admin/advert/advert_setting_ajax",
					  type:"post",
					  dataType: "json",
					  data:{q:'ad_image',id: num, ad_image: radioVal}
					}).done(function(data){
					    console.log('変更されました。画像');
					}).fail(function(data){
					      alert('error!!!');
					});
			    }

	            $("#modal-main-banner,#modal-bg").fadeOut("fast",function(){
	                $('#modal-bg').remove() ;
					var html_code = '<img src="'+radioVal+'" >';
	            	$('#ad_contents'+num).html(html_code);
	            });
	 
	        });

			$('#modal-main-banner .ad_no_save').on('click', function() {
	            $("#modal-main-banner,#modal-bg").fadeOut("fast",function(){
	                $('#modal-bg').remove() ;
	            });
	 
	        });
 
		    //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
        	$(window).resize(modalResize("#modal-main-banner"));

		} else {
			$('#modal-main-text button.ad_ok_save').off('click');
			$('#modal-main-text button.ad_no_save').off('click');

           	$('#ad_text').val('');
//			var text = $('#ad_contents'+num).text();
			var text = $('#ad_contents'+num).html();
           	$('#ad_text').val(text);

		    //画面中央を計算する関数を実行
    		modalResize("#modal-main-text");
 
    		//モーダルウィンドウを表示
        	$("#modal-bg,#modal-main-text").fadeIn("fast");

    		//クリックしたらモーダルを閉じる
			$('#modal-main-text button.ad_ok_save').on('click', function() {
            	var text = $('#ad_text').val();
				$.ajax({
					url: "/admin/advert/advert_setting_ajax",
					type:"post",
					dataType: "json",
					data:{q:'ad_text',id: num, ad_text: text}
				}).done(function(data){
					console.log('変更されました。テキスト');
				}).fail(function(data){
					alert('error!!!');
				});

	            $("#modal-main-text,#modal-bg").fadeOut("fast",function(){
	                $('#modal-bg').remove() ;
//	            	$('#ad_contents'+num).text(text);
	            	$('#ad_contents'+num).html(text);
	            });

	        });

			$('#modal-main-text button.ad_no_save').on('click', function() {
	            $("#modal-main-text,#modal-bg").fadeOut("fast",function(){
	                $('#modal-bg').remove() ;
	            });
	        });

		    //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
        	$(window).resize(modalResize("#modal-main-text"));
		}

    });
    function modalResize(sel){

        var w = $(window).width();
        var h = $(window).height();

        var cw = $(sel).outerWidth();
        var ch = $(sel).outerHeight();

	    //取得した値をcssに追加する
        $(sel).css({
            "left": ((w - cw)/2) + "px",
            "top": ((h - ch)/2) + "px"
        });
    }

});
</script>