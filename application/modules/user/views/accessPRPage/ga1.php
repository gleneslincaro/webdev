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
        ジョイスペとは、全国の高収入アルバイトを紹介している求人サイトになります。ジョイスペにアクセスしてお仕事問合せでもれなく３００円のボーナスをプレゼントしております。（マシェモバ報酬追加）
        また、お仕事紹介メールを受信してクリックするとボーナスをプレゼントしております。是非、この機会にジョイスペへご参加ください。
        <br />
        <input class="get get1" type="submit" value="今すぐボーナスゲット" id="acceptAgreement" />
        <div class="get2"> ※上記ボタンをクリックするとボーナス申請完了となります。ジョイスペへ移動する場合があります。
      また、ボーナス申請と同時に「お仕事紹介メール」をマシェモバ内で受信できるようになります。</div>
      </div>
      <hr />
      <div class="main_se">
        <h2>注意事項</h2>
      ・ボーナス追加は、申請後問合せを確認し2営業日内に追加されます。（マシェモバ報酬を確認）※土・日・祝日を除く<br>
      ・ジョイスペでは、マシェモバで登録した個人情報は一切公開されませんのでご安心ください。<br>
      </div>
    <?php if ( isset($referrer) && $referrer  ) { ?>
      <a class="modoru modoru1" style="display: block; text-decoration: none" href="<?php echo base_url().'user/accessPRPage/noAccept?pPage='.$referrer.'&lid='.$loginId; ?>">仕事サイトへ戻る</a>
    <?php }else{ ?>
      <div class="modoru modoru1" onClick="location.href='javascript:history.go(-1)'"><span>お仕事サイトへ戻る</span></div>
    <?php } ?>
    </div>
    <input type="hidden" name="pr_li" value="<?php echo $loginId; ?>" />
    <input type="hidden" name="pr_lk" value="<?php echo $password; ?>" />
    <input type="hidden" name="referrer" value="<?php echo $referrer;?>" />
    <input type="hidden" name="remoteFlag" value="1" />
  </form>
<?php endif ?>
