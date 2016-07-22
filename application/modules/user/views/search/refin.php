<script type="text/javascript">    
    var group_city = '<?php echo $groupCity_info["id"];?>';
    var city = '<?php echo $city_info["id"];?>';
    var town = "<?php echo $arrTown;?>";
    var group_city_info = '<?php echo $groupCity_info["alph_name"]; ?>';
    var city_info_alph_name = '<?php echo $city_info["alph_name"]; ?>';
    var base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/refin.js?v=20150525"></script>
<div class="refine_search_bg"></div>
<div class="refine_search">
    <div class="refine_search_title"><span class="refine_search_close"></span></div>
    <div class="page_wrap_inner">
        <div class="refine_search_table">
            <div class="f_left">
                <dl>
                    <dt>業種</dt>
                    <?php foreach ($allJobType as $key) :?>
                    <dd>
                        <label><span class="checkbox_area">
                            <input type="checkbox" data-jobtype="<?php echo $key['id']?>" value="<?php echo $key['alph_name']?>">
                            </span><span class="refine_search_item"><?php echo $key['name'] ?></span></label>
                    </dd>
                    <?php endforeach; ?>

                </dl>
            </div>
            <div class="f_right">
                <dl>
                    <dt>特徴</dt>
                    <?php foreach ($treatments as $key) :?>
                    <dd>
                        <label><span class="checkbox_area">
                            <input type="checkbox" value="<?php echo $key['alph_name']?>">
                            </span><span class="refine_search_item"><?php echo $key['name']; ?></span></label>
                    </dd>
                    <?php endforeach; ?>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="footer_search_area">
    <p class="ic--area_search"> <a href="#">検索する</a> </p>
</div>
