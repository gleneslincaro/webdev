<!-- pagebody--gray -->
<h2 class="h_ttl_2 pos_parent">キープ件数<span class="result_number"><?php echo ($storeOwner == null ? '0': count($storeOwner))?></span>件<span class="sort"><a href="./keep2.html">並び替え</a></span></h2>
<?php $this->load->view('user/share/company_list'); ?>