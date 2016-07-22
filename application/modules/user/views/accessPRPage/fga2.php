<div id="main">    
  <div class="contents">
    <img src="<?php echo base_url(); ?>public/user/image/remoteLoginGa/fga2/001.png" alt="">
    <div class="top_wrap">
      <p>この度は「ジョイスペ・ボーナス」申込誠に有難う御座いました。現在、ボーナス処理中となります。改めてジョイスペからご連絡させて頂きます。</p>
      <p>ご連絡は、翌営業日中にさせて頂きます。（月～金・11：00～18：00・祝日は除く）翌営業日以降になっても連絡がない場合は、下記までご連絡くださいませ。</p>
      <p>info@joyspe.com </p>
      <p>ボーナス追加と完了と同時に「高収入求人サイト・ジョイスペ」をご利用いただけるようになります。さらにボーナスも獲得できる仕組みも用意しているので是非ご利用ください。</p>
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
