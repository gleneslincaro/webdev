<?php
    echo '<p>

【joyspe管理画面】<br>

<br>
検索<br>
　└　<a href="'.base_url().'index.php/admin/search/company/">会社・店舗</a><br>
　└　<a href="'.base_url().'admin/search/user/">ユーザー</a><br>
　└　<a href="'.base_url().'admin/search/application/">応募一覧（会社・ユーザー）</a><br>
　└　<a href="'.base_url().'index.php/admin/search/work/">勤務申請・祝金（会社・ユーザー）</a><br>
　└　<a href="'.base_url().'admin/search/penalty/">ペナルティ一覧（会社）</a><br>
<br>
ログ<br>
　└　<a href="'.base_url().'index.php/admin/log/settlement/">日別売上統計、決済数</a><br>
　└　<a href="'.base_url().'index.php/admin/log/settlementlog/">決済ログ</a><br>
　└　<a href="'.base_url().'index.php/admin/log/pointlog/">ポイントログ</a><br>
　└　<a href="'.base_url().'index.php/admin/log/sends/">スカウト送信（会社・ユーザー）</a><br>
　└　<a href="'.base_url().'index.php/admin/log/app/">応募者閲覧（会社・ユーザー）</a><br>
　└　<a href="'.base_url().'index.php/admin/log/celebration/">お祝い金申請（お祝い金支払）</a><br>
　└　<a href="'.base_url().'admin/log/owner/">店舗統計情報</a><br>
　└　<a href="'.base_url().'admin/log/userstatistic/">ユーザークリック数集計</a><br>
<br>
店舗側のキャンペーン一覧表示<br>
　└　<a href="'.base_url().'admin/campaign/ownercampaingnall/" target="_blank">オーナーキャンペーン一覧</a><br>
　└　<a href="'.base_url().'admin/campaign/ownercampaingncreate/" target="_blank">オーナーキャンペーン作成</a><br>
<br>
面接交通費キャンペーン<br>
　└　<a href="'.base_url().'admin/campaign/all/">キャンペーン一覧</a><br>
　└　<a href="'.base_url().'admin/campaign/create/">キャンペーン作成</a><br>
　└　<a href="'.base_url().'admin/campaign/index/">面接交通費申請一覧</a><br>
　└　<a href="'.base_url().'admin/campaign/interviewreports">面接報告</a><br>
　└　<a href="'.base_url().'admin/campaign/interviewreportlist">面接報告一覧</a><br>
<br>
問い合わせキャンペーン<br>
　└　<a href="'.base_url().'admin/campaign/messagecampaignownerlist/">問い合わせキャンペーン店舗一覧</a><br>
<br>
体験入店お祝いキャンペーン<br>
　└　<a href="'.base_url().'admin/campaign/bonusrequestall/">キャンペーン一覧</a><br>
　└　<a href="'.base_url().'admin/campaign/bonusrequestcreate/">キャンペーン作成</a><br>
　└　<a href="'.base_url().'admin/campaign/bonusRequestStatus/">体験入店お祝い金申請一覧</a><br>
<br>
ステップアップキャンペーン<br>
　└　<a href="'.base_url().'admin/campaign/makiacampaigncreate/">作成</a><br>
　└　<a href="'.base_url().'admin/campaign/makiacampaignall/">一覧</a><br>
　└　<a href="'.base_url().'admin/campaign/makiacampaignlist/">キャンペーン管理ページ </a><br>
　└　<a href="'.base_url().'admin/campaign/makiarequest/">倍率ボーナス申請一覧</a><br>
<br>
1円ボーナス関連<br>
　└　<a href="'.base_url().'admin/oneyenbonus/setpoint/">１ボーナス関連</a><br>
　└　<a href="'.base_url().'admin/oneyenbonus/search/">ボーナス情報検索</a><br>
<br>
申請・ボーナス関係<br>
　└　<a href="'.base_url().'admin/request/authentication/">スカウト認証</a><br>
　└　<a href="'.base_url().'admin/setting/newsPoints/">メールマガポイント設定</a><br>
　└　<a href="'.base_url().'admin/setting/scoutPoints/">ボーナス金額設定</a><br>
　└　<a href="'.base_url().'admin/request/bonus/">ボーナス申請リスト</a><br>
　└　<a href="'.base_url().'admin/request/firstMessageBonusList/">初回問い合わせ一覧</a><br>
　└　<a href="'.base_url().'admin/request/makia_user/">マキアユーザー</a><br>
<br>
入金（オーナー → joyspe）<br>
　└　<a href="'.base_url().'index.php/admin/payment/bank/">振込完了メール</a><br>
<br>
支払（joyspe → ユーザー）<br>
　└　<a href="'.base_url().'index.php/admin/payment/reward/">お祝い金支払</a><br>
　└　<a href="'.base_url().'index.php/admin/payment/reward_return/">お祝い金削除</a><br>
　└　<a href="'.base_url().'index.php/admin/payment/paid/">支払履歴</a><br>
<br>
メルマガ配信<br>
　└　<a href="'.base_url().'index.php/admin/mail/company_after/">オーナー側</a><br>
　└　<a href="'.base_url().'index.php/admin/mail/searchUser/">ユーザー側</a><br>
　└　<a href="'.base_url().'index.php/admin/mail/searchUserNew/">ユーザー側 （ポイント付け）</a><br>
　└　<a href="'.base_url().'index.php/admin/mail/searchUserNewMailQueue/">ユーザー側 （ポイント付け一覧）</a><br>
　└　<a href="'.base_url().'index.php/admin/mail/goToSendLog/">配信ログ</a><br>
　└　<a href="'.base_url().'index.php/admin/mail/monthlySend/">月次配信</a><br>
　└　<a href="'.base_url().'index.php/admin/mail/create_auto_send_magazine/">毎日自動送信メルマガ予約</a><br>
　└　<a href="'.base_url().'index.php/admin/mail/bookMailMagazine/">自動送信メルマガ予約一覧</a><br>
<br>
メール文言設定<br>
オーナー側<br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow01">ow01_仮登録</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow02">ow02_本登録</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow03">ow03_店舗情報非承認</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow04">ow04_スカウト送信</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow05">ow05_スカウトポイント決済</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow06">ow06_スカウトポイント不足決済</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow07">ow07_応募通知</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow08">ow08_応募ポイント決済</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow09">ow09_応募ポイント不足決済</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow10">ow10_応募者見送り</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow11">ow11_応募検討</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow12">ow12_店舗情報公開</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow13">ow13_勤務申請通知</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow14">ow14_勤務申請7日間経過</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow15">ow15_勤務非承認</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow17">ow17_振込完了お知らせ通知</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow18">ow18_採用金ポイント決済</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow19">ow19_採用金ポイント不足決済</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow20">ow20_お祝い金支払通知</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow21">ow21_決済ポイント追加完了</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow22">ow22_店舗情報承認</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow23">ow23_スカウト送信(お祝い金なし)</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=ow24">ow24_応募通知(お祝い金なし)</a><br>
<br>
ユーザー側<br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us01">us01_仮登録</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us02">us02_本登録</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us03">us03_スカウト受信</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us04">us04_応募完了</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us05">us05_採用見送り</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us06">us06_採用検討</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us07">us07_店舗情報通知</a><br>

　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us08">us08_祝い金申請通知</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us09">us09_勤務非承認通知</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us11">us11_祝い金振込予告</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us12">us12_祝い金振込通知</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us13">us13_パスワード再送</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us14">us14_スカウト受信(お祝い金なし)</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showUserMailForm?type=us15">us15_応募完了(お祝い金なし)</a><br>
<br>
管理側<br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss01">ss01_店舗情報</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss02">ss02_身分証明書</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss03">ss03_スカウト入金</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss04">ss04_ポイント入金</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss05">ss05_応募入金</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss06">ss06_採用入金</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss07">ss07_求人情報変更</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss08">ss08_承認中求人情報変更</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss10">ss10_【ジョイスペ】お知らせ</a><br>
　└　<a href="'.base_url().'index.php/admin/maillan/showAdminMailForm?type=ss11">ss11_店舗情報の登録が行われました。</a><br>
<br>
オーナー　→　joyspe<br>
　└　<a href="'.base_url().'index.php/admin/maillan/showJoyspeMailForm?type=sp01">sp01_振込完了お知らせ</a><br>
<br>

お知らせ<br>
　└　<a href="'.base_url().'index.php/admin/news/ownerNews">オーナー側・お知らせ</a><br>
　└　<a href="'.base_url().'index.php/admin/news/userNews">ユーザー側・お知らせ</a><br>
<br>
統計<br>
　└　<a href="'.base_url().'admin/statistics/showOwnerJob">オーナー職種</a><br>
　└　<a href="'.base_url().'admin/statistics/showOwnerArea">オーナー地域・47都道府県</a><br>
　└　<a href="'.base_url().'admin/statistics/showOwnerArea01">オーナー地域・地域検索</a><br>
　└　<a href="'.base_url().'admin/statistics/showOwnerTreatment">オーナー待遇</a><br>
　└　<a href="'.base_url().'admin/statistics/showUserJob">ユーザー職種</a><br>
　└　<a href="'.base_url().'admin/statistics/showUserAge">ユーザー年齢</a><br>
　└　<a href="'.base_url().'admin/statistics/showUserArea">ユーザー地域・47都道府県</a><br>
　└　<a href="'.base_url().'admin/statistics/showUserArea01">ユーザー地域・地域検索</a><br>
<br>
設定<br>
　└　<a href="'.base_url().'admin/setting/monthly_campaign_result_ads">月度キャンペーンの結果広告</a><br>
　└　<a href="'.base_url().'admin/setting/makia_login_bonus">累計ログインポイント設定</a><br>
　└　<a href="'.base_url().'admin/setting/editOwnerCode">オーナー・コード登録</a><br>
　└　<a href="'.base_url().'admin/setting/editUserCode">ユーザー・コード登録</a><br>
　└　<a href="'.base_url().'admin/setting/editTreatment">待遇</a><br>
　└　<a href="'.base_url().'admin/setting/category">業種</a><br>
　└　<a href="'.base_url().'admin/setting/point">金額・ポイント</a><br>
　└　<a href="'.base_url().'admin/setting/changeOiwaiPay">採用金・お祝い金</a><br>
　└　<a href="'.base_url().'admin/setting/registerOwnerInfoFromCSV">オーナー情報をCSVインポート</a><br>
　└　<a href="'.base_url().'admin/setting/scoutMailQtySendPerDay">スカウト送信数</a><br>
　└　<a href="'.base_url().'admin/setting/registerUserFromCSV">ユーザー情報をCSVインポート</a><br>
　└　<a href="'.base_url().'admin/utility">ボーナス追加</a><br>

<br>
管理者アカウント<br>
　└　<a href="'.base_url().'admin/setting/manager">アカウント管理</a><br>
　└　<a href="'.base_url().'admin/setting/limitIP">ＩＰ制限設定</a><br>
<br>
承認<br>
　└　<a href="'.base_url().'admin/authentication/lists">承認一覧</a><br>
　└　<a href="'.base_url().'admin/authentication/history">承認履歴</a><br>
　└　<a href="'.base_url().'admin/authentication/unapproved">非承認一覧</a><br>
<br>
文言登録<br>
　└　<a href="'.base_url().'admin/search_contents/area">エリア</a><br>
　└　<a href="'.base_url().'admin/search_contents/treatment">待遇</a><br>
　└　<a href="'.base_url().'admin/search_contents/jobtype">業種</a><br>
<br>
お悩み相談掲示板<br>
　└　<a href="'.base_url().'admin/bbs/category_setting">カテゴリー追加・編集</a><br>
　└　<a href="'.base_url().'admin/search_contents/treatment">記事編集</a><br>
<br>
モーダルセットアップ <br>
　└　<a href="'.base_url().'admin/dialog_box/">モーダルボックスセットアップ</a><br>
<br>
みんなの体験談 <br>
　└　<a href="'.base_url().'admin/experiences/">サクラ体験談</a><br>
　└　<a href="'.base_url().'admin/experiences/all">投稿の体験談　編集・有効・無効・削除</a><br>
<br>
あるある掲示板 <br>
　└　<a href="'.base_url().'admin/bbs/bonus">ポイント設定</a><br>
　└　<a href="'.base_url().'admin/bbs/thread_point">スレッド管理</a><br>
　└　<a href="'.base_url().'admin/advert/advert_setting">広告管理</a><br>
<br>
女性のお悩み相談室 <br>
　└　<a href="'.base_url().'admin/onayami/bonus">ポイント設定</a><br>
　└　<a href="'.base_url().'admin/onayami/thread_point">スレッド管理</a><br>
<br>
<a href="'.base_url().'admin/system/logout">ログアウト</a><br>
</p>';

?>
