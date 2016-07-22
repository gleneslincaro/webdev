<script type="text/javascript">
    $(document).ready(function() {        
        showMoreText();

        function showMoreText() {
            var slideHeight = 330;
            var defHeight = $('.show-more').height();
            if (defHeight >= slideHeight) {
              addShowMore(slideHeight, defHeight);
            }
        }

        function addShowMore(slideHeight, defHeight) {
            $('.show-more').css('height' , '330px');
            $('#read-more').append('<a href="#"><button>もっと見る</button></a>');
            $('#read-more').css('padding', '8px 0');
            $('#read-more a').css('text-decoration', 'none');
            $('#read-more a').click(function() {
                var curHeight = $('.show-more').height();
                if (curHeight == slideHeight) {
                    showMoreDisplay(defHeight);
                } else {
                    hideMoreDisplay(slideHeight);
                }
                return false;
            });
        }

        function showMoreDisplay(defHeight) {
            $('.show-more').animate({
                height: defHeight
            }, "fast");
        }

        function hideMoreDisplay(slideHeight) {
            $('.show-more').animate({
                height: slideHeight
            }, "fast");
        }

        $(window).resize(function() {
            //$('.show-more').css('height', '');
            var defHeight = $('.show-more').height();
            //$('.show-more').css('height', '330px');
            if (defHeight > 330) {
                $('.company_info').css('border-bottom', '');
                if ($("#read-more:has(a)").length == 0) {
                    addShowMore(330, defHeight);
                } else {
                    $('#read-more a').remove();
                    addShowMore(330, defHeight);
                }
                $('#read-more').show();
            } else {
                $('#read-more').hide();
                hideMoreDisplay(defHeight);
            }
        });
    })
</script>
        <section class="section section--keep_list cf">
            <h3 class="ttl_1">キープ一覧</h3>
            <div class="box_inner pt_15 pb_7 cf">
                <div class="shop_list_1 cf " id="keep_list_id">         
                    <?php echo $this->load->view("user/keep/keeplist");?>                    
                </div><!-- // .shop_list -->                
                <div style="margin: 10px 0; text-align: center;" class="more" id="more_keep_id_result">
                    <a href="#" id="more_keep_id" name="more_hpm_id">▼次の10件を表示</a>
                </div>                
            </div><!-- // .box_inner -->
        </section>
<script type="text/javascript">
    $(function(){
        // side drawer navigation
        $('#simple-menu').sidr({
            name: 'sidr',
            side: 'right'
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
</script>







