<section class="section section--search cf">
    <h2 class="h_ttl_2 pos_parent"><?php echo $count_title;?><span class="result_number"><?php echo $count_all; ?></span>件</h2>
    <div class="box_inner pt_15 pb_7 cf" id="store_list">
        <?php $this->load->view('user/share/company_list'); ?>
    </div>    
</section>
<div class="more mt_20 mb_20 t_center" id="more_company_id_result">
    <a href="#" id="more_company_id" name="more_hpm_id">▼次の10件を表示</a>
</div>

