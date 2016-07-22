
<div id="header_text">【重要なお知らせ】</div>

<div id="center_text">
	お祝い金のお支払には銀行口座登録が必要となります。銀行口座登録をまだ行っていない方は下記より銀行口座の登録を行ってください。<br >
	<br >

        <a class="new" href="<?php echo base_url()."user/profile_change/load_profile_change"?>/">>> 銀行口座登録（プロフィール）<<</a><br >

</div>

<hr size="2px" color="#FF1493">
<div id="container">   
<div class="title">応募一覧・お祝い金リスト</div>
<div class="select_box">
	<select class="sign_up" id="sltgethpm"  name="sltgethpm" >
    <option value="1">お祝い金・未申請</option>
    <option value="2">お祝い金・申請済</option>
    <option value="3">全て表示</option>
	</select> 
</div>

<br >
 <div id="list_owners_hpm" >
   <?php echo $this->load->view("happy_money/list_happy_money")?>
 </div>
<div class="more" id="more_hpm_id_result">
             <a href="#" id="more_hpm_id" name="more_hpm_id">▼次の10件を表示</a>
</div>
</div>
