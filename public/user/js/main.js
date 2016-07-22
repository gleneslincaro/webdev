
/*
 * main javascript
 *
 */
$(window).load(function() {
    $('#slider').nivoSlider({
        manualAdvance:true,
    });
});

$(function() {
    function isAndDefaultBrowser(){
        var ua=window.navigator.userAgent.toLowerCase();
        if(ua.indexOf('linux; u;')>0){
            return true;
        }else{
            return false;
        }
    }

    // side drawer navigation
    $('#simple-menu').sidr({
        name: 'sidr',
        side: 'right',
        onOpen: function(){
            $("#menu_close_area").show();
            if(isAndDefaultBrowser()){
                $('#logo').css({ 'top': '-500px' }).hide();
            }
        },
        onClose: function(){
            $("#menu_close_area").fadeOut(200);
            if(isAndDefaultBrowser()){
                setTimeout(function(){
                    $('#logo').css({ 'top': '0' }).fadeIn(200);
                }, 400);
            }
        }
    });
    
    // mutiple select
    $('.ui_multiple_select').change(function(){
      console.log($(this).val());
    }).multipleSelect({
      placeholder: '選択してください',
      selectAllText: 'すべて選択',
      selectAllDelimiter: ['',''],
      allSelected : 'すべて選択',
      minimumCountSelected: 99,
      countSelected: '% 件中 # 件 選択済',
      noMatchesFound: '一致する条件が見つかりません',
      width: '100%'
    });    
});