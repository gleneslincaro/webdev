<div class="modal entry_modal" style="display:none;">
	<div class="modal_inner">
		<ul class="modal_slider">

			<?php for($i=1;$i<=5;$i++):?>
				<?php if(isset($priority['image_'.$i])):?>
					<li class="modal_entry_<?php echo $i?> modals">
						<p><img src="<?php echo base_url().$priority['image_'.$i]; ?>"></p>
					</li>
				<?php endif;?>	
			<?php endfor;?>
			
		</ul>
		<p class="modal_any_more"><input type="checkbox" name="dialog_oneday_flag" class="dialog_oneday_flag">今日はこれ以上表示しない</p>
		<p class="prev_modal remove_btn"><a href="#" id="slider-prev"></a></p>
		<p class="next_modal"><a href="#" id="slider-next"></a></p>
		<a href="javascript:void(0)" class="close_modal_btn close_modal">×</a>
	</div>
</div>
<script>
$(function(){
	
	//ページの読み込みが終わったら、0.8秒かけてモーダルを表示
	$(".entry_modal").fadeIn(800);
	$("body").css("position","fixed");
	// ここでsliderさせる要素の定義
	$('.modal_slider').bxSlider({
		nextSelector: '#slider-next',
		prevSelector: '#slider-prev',
		nextText: '次へ',
		prevText: '前へ',
		controls: false,
		infiniteLoop:false,
		pager:true,
		onSlideNext:function(){
			$(".prev_modal,.next_modal").removeClass("remove_btn");
		},
		onSlidePrev:function(){
			$(".prev_modal,.next_modal").removeClass("remove_btn");
		}
	});
	$(".close_modal").on("click", function(){
		var base_url = "<?php echo base_url()?>";
		$.post(base_url+'user/joyspe_user/add_session_modal_box',function(data){
			$(".entry_modal").fadeOut();
			$("body").css("position","static");
		});
	});

	$('.dialog_oneday_flag').click(function(){
		if($('.dialog_oneday_flag').is(':checked')) {
			$.cookie("dialog_oneday_flag",1,{ path:"/", expires: 1});
			$(".entry_modal").fadeOut();
			$("body").css("position","static");
		}
	});
	return false;
});

$(window).load(function() {
	var link = "<?php echo $priority['link']?>";
	var text = "<?php echo $priority['text_button']?>";
	$('.modals').last().append('<ul class="btn_wrap"><li><a href="'+link+'" class="btn_style close_modal">'+text+'</a></li></ul>');
});
</script>