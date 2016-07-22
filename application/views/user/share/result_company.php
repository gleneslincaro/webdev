<script type="text/javascript">
    var search_area = "<?php echo (isset($groupCity_info) && isset($city_info) && isset($arrTownId)? '&cityGroup=' . $groupCity_info['id'] . '&city=' .  $city_info['id'] . '&town=' . $arrTownId . '&treatment=' . $arrTreatment . '&cate=' . $arrCate : '' );?>";
    var controller_name = "<?php echo $this->router->fetch_class(); ?>";
    var base_url = "<?php echo base_url(); ?>";
    var ajax_load_more = "<?php echo isset($ajax_load_more)?$ajax_load_more:''; ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/show_more_store.js?v=20150522"></script>
<h2 class="h_ttl_2 pos_parent"><?php echo $count_title;?><span class="result_number"><?php echo number_format($count_all); ?></span>件</h2>
<section class="section section--jobs cf">
    <div class="box_inner pt_15 pb_7 cf">
        <div class="city_1 cf">
            <input type="hidden" value="<?php echo $count_all?>" id="countall_company_id">
            <ul id="store_list">
                <?php if (count($storeOwner) < 1 || $storeOwner == null): ?>
                    <li class="company_details">お店が見つかりません。</li>
                <?php else: ?>
                    <?php $this->load->view('user/share/company_list'); ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>
<div id="loader_wrapper" class="t_center"></div>
<div class="more mt t_center" id="more_company_id_result">
    <a href="javascript:void(0)" id="more_company_id" name="more_hpm_id">▼次の<?php echo STORE_LIMIT; ?>件を表示</a>
</div>
