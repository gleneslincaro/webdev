 
<form method="post" action="" enctype="multipart/form-data">
    joyspeでは、お祝い金の受け渡しを行うにあたり不正登録防止 及び 
    18歳未満（高校生年齢）の雇用は法違反のため、18歳未満（高校生年齢）の登録は抑止させて頂いております。
    つきましては年齢認証にご協力をお願い致します。<br >
    <input type="hidden" name="linkid" value="<?php echo $linkid;?>"/>
    <br >
    <div id="header_text">【年齢認証のやり方】</div>
    1.免許証<br >
    2.住基カード<br >
    3.パスポート<br >
    4.学生証<br >
    5.社員証<br >
    <br >
    のいずれかをご用意下さい。※顔写真が付いていない身分証明書は受け付けておりませんのでご注意下さいませ。
    <br >
    <br >
    用意ができたら、携帯で１枚写真を撮り、
    下記からアップロードまたはメールでサポートセンターまでお送り下さい。
    <br >
    <br >
    <div id="header_text">【アップロードする場合】</div>
    <a class="body"> <?php echo $div; ?></a>
    <a class="body"> 
        <?php 
        if(isset($message)){                   
            echo Helper::print_error($message); 
        }
        ?> 
   </a>
    <p>JPEGファイル：<input type="file" name="img" accept="image/jpg/jpeg/png"></p>
    <input type="submit" class="btn" value="登録する" name="btn" /></input>
    <br >
    <div id="center_text">
    ※アップロードが完了したら下記を表示<br >

    </div>
    <br >
    <div id="header_text">【メールで送る場合】</div>
    <div id="center_text">
    ↓コチラから送信して下さい↓<br><br>
    <a href="mailto:info@joyspe.com?subject=joyspe年齢認証&body=撮っていただいたお写真を添付しそのままお送りくださいませ">
    >> 年齢認証メールを送る <<
    </a>
    </div>
    <br >
    <br >
    年齢確認がjoyspe側で確認できましたら登録アドレス宛へ次のステップメールをお送りさせて頂きます。
    年齢確認につきましては、10分程度お時間を頂いております。アップロード・送信後、少々お待ち下さいませ。
    <br >
    <br >
    <div id="center_text">
    </div>
</form>

