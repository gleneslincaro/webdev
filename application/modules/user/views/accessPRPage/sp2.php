<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/sp_access_pr_page.js?v=20150506"></script>
<?php if(isset($message)) : ?>
  <div class="center">    
    <br /><br /><br />
    <?php echo Helper::print_error($message); ?>
    <br /><br />
  </div>
<?php else : ?>
  <form method="post" action="<?php echo base_url().'user/accessPRPage'; ?>" enctype="multipart/form-data">
    <div class="contents">
      <img src="../public/user/image/remoteLoginSp/sp1/01.png" alt="">  
      <div class="btn red txt_yellow strong syonin syonin1" id="acceptbutton">今すぐボーナスGET!</div>
      <div class="top_wrap">
        <p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
        <p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
        <img src="<?php echo base_url(); ?>public/user/image/remoteLoginSp/sp1/02.png" alt="">
        <img src="<?php echo base_url(); ?>public/user/image/remoteLoginSp/sp1/03.png" alt="">
        <img src="<?php echo base_url(); ?>public/user/image/remoteLoginSp/sp1/04.png" alt="">
      </div>
    </div><!--//contents-->
    <a id="scroll_top" href="#header"><img src="<?php echo base_url(); ?>public/user/image/remoteLoginSp/sp1/icon/btn_pagetop.png" /></a>
    <div class="btn red txt_yellow strong syonin syonin1" id="acceptbutton1">今すぐボーナスGET!</div>
    <div class="top_wrap">
      <p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
      <p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
    <?php if ( isset($referrer) && $referrer  ) { ?>
      <a class="modoru modoru1" style="display: block; text-decoration: none" href="<?php echo base_url().'user/accessPRPage/noAccept?pPage='.$referrer.'&lid='.$loginId; ?>/">仕事サイトへ戻る</a>
    <?php }else{ ?>
      <div class="modoru modoru1" onClick="location.href='javascript:history.go(-1)'"><span>お仕事サイトへ戻る</span></div>
    <?php } ?>
    </div>
    <input type="hidden" name="pr_li" value="<?php echo $loginId;?>" />
    <input type="hidden" name="pr_lk" value="<?php echo $password;?>" />   
    <input type="hidden" name="referrer" value="<?php echo $referrer;?>" />   
    <input type="hidden" name="remoteFlag" value="1" />    
    <input type="submit" value="今すぐボーナスGET!" id="acceptAgreement" style="display: none; " />        
  </form>  
<?php endif ?> 





