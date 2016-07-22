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
      <center>
    　※上記ボタンをクリックするとボーナス申し込みとなります。<br>
    　ジョイスペに移動する場合があります。<br>
    　また、ボーナス申し込みと問合せでマシェモバの報酬が300円追加されます。<br>
    　ボーナス申請と同時に「お仕事紹介メール」をマシェモバ内でも受信できるようになります。<br><br>
      </center>
      <div class="top_wrap">
        <p>ジョイスペとは、全国の高収入アルバイトを紹介している求人サイトになります。ジョイスペにアクセスしてお仕事問合せで<span style="color:red">もれなく</span>３００円のボーナスをプレゼントしております。（マシェモバ報酬追加）</p>
        <p>また、お仕事紹介メールを受信してクリックするとボーナスをプレゼントしております。是非、この機会にジョイスペへご参加ください。</p>
        <img src="<?php echo base_url(); ?>public/user/image/remoteLoginSp/sp1/02.png" alt="">
        <img src="<?php echo base_url(); ?>public/user/image/remoteLoginSp/sp1/03.png" alt="">
      </div>
    </div><!--//contents-->
    <a id="scroll_top" href="#header"><img src="<?php echo base_url(); ?>public/user/image/remoteLoginSp/sp1/icon/btn_pagetop.png" /></a>
    <div class="btn red txt_yellow strong syonin syonin1" id="acceptbutton1">今すぐボーナスGET!</div>
      <center>
      ※上記ボタンをクリックするとボーナス申請完了<br>
      となります。ジョイスペへ移動する場合があります。<br>
      また、ボーナス申請と同時に「お仕事紹介メール」を<br>
      マシェモバ内で受信できるようになります。<br><br>
      </center>
    <div class="top_wrap">
      <p>【注意事項】</p>
      ・ボーナス追加は、申請後問合せを確認し2営業日内に追加されます。（マシェモバ報酬を確認）※土・日・祝日を除く<br>
      ・ジョイスペでは、マシェモバで登録した個人情報は一切公開されませんのでご安心ください。<br>
      </p>
    </div>
    <?php if ( isset($referrer) && $referrer  ) { ?>
      <a class="modoru modoru1" style="display: block; text-decoration: none" href="<?php echo base_url().'user/accessPRPage/noAccept?pPage='.$referrer.'&lid='.$loginId; ?>/">仕事サイトへ戻る</a>
    <?php }else{ ?>
      <div class="modoru modoru1" onClick="location.href='javascript:history.go(-1)'"><span>お仕事サイトへ戻る</span></div>
    <?php } ?>

    <input type="hidden" name="pr_li" value="<?php echo $loginId;?>" />
    <input type="hidden" name="pr_lk" value="<?php echo $password;?>" />
    <input type="hidden" name="referrer" value="<?php echo $referrer;?>" />
    <input type="hidden" name="remoteFlag" value="1" />
    <input type="submit" value="今すぐボーナスGET!" id="acceptAgreement" style="display: none; " />
  </form>
<?php endif ?>
