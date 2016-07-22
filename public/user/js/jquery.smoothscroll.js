/*--------------------------------------------------------------------------*
 *  SmoothScroll 
 *--------------------------------------------------------------------------*/
 
$(function(){
	$(document).on('click', 'a[rel="smoothscroll"]', function() {
		var speed = 600;
		var href = $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		$('body, html').animate({scrollTop:position}, speed, 'swing');
		return false;
	});
});