<?php if(isset($message)) : ?>
  <div class="center">    
    <br /><br /><br />
    <?php echo Helper::print_error($message); ?>
    <br /><br />
  </div>
<?php else : ?>
  <form method="post" action="<?php echo base_url().'user/accessPRPage'; ?>" enctype="multipart/form-data">    
    <div align="center">
      <img src="<?php echo base_url(); ?>public/user/image/remoteLoginGa/ga1/01.png" style="width:100%"/><!-- ロゴ画像 -->
    </div> 
    <div class="main" style="width:90%;">
      <div class="main_fi">
        <h1>ジョイスペとは</h1>
        <hr />
        サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章

        サイトのメイン文章<br />
        サイトのメイン文章<br />
        <input class="get get1" type="submit" value="今すぐボーナスゲット" id="acceptAgreement" />
        <div class="get2">※応募する前に必ず注意事項をご確認ください</div>        
      </div>
      <hr />
      <div class="main_se">
        <h2>注意事項</h2>

        サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章サイトの概要文章
      </div>
    <?php if ( isset($referrer) && $referrer  ) { ?>
      <a class="modoru modoru1" style="display: block; text-decoration: none" href="<?php echo base_url().'user/accessPRPage/noAccept?pPage='.$referrer.'&lid='.$loginId; ?>">仕事サイトへ戻る</a>
    <?php }else{ ?>
      <div class="modoru modoru1" onClick="location.href='javascript:history.go(-1)'"><span>お仕事サイトへ戻る</span></div>
    <?php } ?>
    </div>      
    <input type="hidden" name="pr_li" value="<?php echo $loginId;?>" />
    <input type="hidden" name="pr_lk" value="<?php echo $password;?>" />
    <input type="hidden" name="referrer" value="<?php echo $referrer;?>" />
    <input type="hidden" name="remoteFlag" value="1" />
  </form>  
<?php endif ?> 






