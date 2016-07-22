<div id="main">
  <div class="contents">
    <img src="<?php echo base_url(); ?>public/user/image/remoteLoginGa/fga1/001.png" alt="">
    <div class="top_wrap">
      <p>この度は「ジョイスペ」への登録が完了しました。ジョイスペでは高収入アルバイト求人を掲載している求人サイトになります。</p>
      <p>気になる店舗様に問合せをして頂ければボーナスクリアとなりマシェモバの報酬が300円もらえます。ボーナス処理後に改めてご連絡させて頂きます。</p>
      <p>ご連絡は、ボーナスクリア後翌営業日中にさせて頂きます。（月～金・11：00～18：00・祝日は除く）翌営業日になっても連絡がない場合は、下記までご連絡くださいませ。</p>
      <p>info@joyspe.com </p>
      <p>今後は『高収入求人サイト・ジョイスペ』をご利用いただけるようになります。さらにボーナスも獲得出来る稼げる求人サイトですので是非ご利用ください！</p>
      <a class="btn red txt_yellow strong modoru modoru1" href="<?php
      if ( isset($authOkButWaiting) && $authOkButWaiting ){
        echo "javascript:history.go(-2);";
      }else{
        echo "javascript:history.go(-1);";
      }
       ?>">お仕事ページへ戻る</a>
    </div>
  </div><!--//contents-->
	<a id="scroll_top" href="#header"><img src="image/icon/btn_pagetop.png" /></a>
</div><!--//main-->
