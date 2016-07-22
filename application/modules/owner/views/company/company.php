<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/component.css?v=20150609" type="text/css" media="screen" />
<script type="text/javascript">
    $(document).ready(function() {
        $("#th5").addClass("visited");
    });
</script>
<div class="crumb">TOP ＞ 基本情報</div>
<div style="float:right;"><a style="color:#2595F8; font-size: 18px; font-weight: bold" href="<?php echo base_url() . 'owner/userview/'; ?>">ユーザービュー</a></div>
<!--
<div class="owner-box"><?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a></div><br >
-->
<div class="list-box"><!-- list-box ここから -->
  <div class="list-title">基本情報</div>
<div class="contents-box-wrapper">
  <!-- Show owner information -->
  <?php
  if (count($owner_recruit_info1) > 0) { ?>
    <form action="<?php echo base_url() . 'owner/company/company_store'; ?>" method="POST">
      <div class="information_box">
      <div class="list-t-center">
        <input type="submit" style="width:150px; height:40px;" value="変更">
      </div>
      <br>
      <table class="information">
          <tr>
              <th colspan="2">基本情報</th>
          </tr>

          <tr>
              <td>ログインＩＤ（メールアドレス）</td>
              <td><?php echo $owner_recruit_info1['email_address']; ?></td>
          </tr>

          <tr>
              <td>パスワード</td>
              <td><?php
                  for ($i = 0; $i < strlen($owner_recruit_info1['password']); $i++) {
                      echo '*';
                  }
                  ?></td>
          </tr>
          <tr>
            <td>エリア地域</td>
            <td><?php echo $owner_recruit_info2['city_group_name']; ?></td>
          </tr>
          <tr>
            <td>エリア都道府県</td>
            <td><?php echo $owner_recruit_info2['city_name']; ?></td>
          </tr>
          <tr>
            <td>エリア都市</td>
            <td><?php echo $owner_recruit_info2['town_name']; ?></td>
          </tr>
          <tr>
            <td>タイトル</td>
            <td><?php echo $owner_recruit_info2['title']; ?></td>
          </tr>
          <tr>
            <td>店舗名</td>
            <td><?php echo $owner_recruit_info1['storename']; ?></td>
          </tr>
          <tr>
            <td>住所</td>
            <td><?php echo $owner_recruit_info1['address']; ?></td>
          </tr>
          <tr>
            <td>転送設定</td>
            <td><?php echo ($owner_recruit_info1['set_send_mail'] == 1 ? 'ON' : 'OFF'); ?></td>
          </tr>
          <tr>
              <td>店舗情報公開</td>
              <td>
                  <?php
                  if ($owner_recruit_info1['public_info_flag'] == 1) {
                      echo '公開';
                  } else {
                      echo '非公開';
                  }
                  ?>
              </td>
          </tr>
          <tr>
            <td>業種</td>
            <td>
              <?php echo $ownerJobType; ?>
            </td>
          </tr>
          <tr>
            <td>勤務地</td>
            <td><?php echo $owner_recruit_info2['work_place']; ?></td>
          </tr>
          <tr>
            <td>勤務日</td>
            <td><?php echo $owner_recruit_info2['working_day']; ?></td>
          </tr>
          <tr>
            <td>勤務時間</td>
            <td><?php echo $owner_recruit_info2['working_time']; ?></td>
          </tr>
          <tr>
            <td>交通</td>
            <td><?php echo nl2br($owner_recruit_info2['how_to_access']); ?></td>
          </tr>
          <tr>
            <td>給与</td>
            <td><?php echo nl2br($owner_recruit_info2['salary']); ?></td>
          </tr>
          <tr>
            <td>応募資格</td>
            <td><?php echo nl2br($owner_recruit_info2['con_to_apply']); ?></td>
          </tr>
          <tr>
            <td>入店特典</td>
            <td class="visiting_benifits t_center">
              <table>
                <?php for ($i=1;$i<=3;$i++) : ?>
                <tr>
                  <td>タイトル</td>
                  <td><?php echo $owner_recruit_info2['visiting_benefits_title_'.$i]; ?></td>
                </tr>
                <tr>
                  <td>テキスト</td>
                  <td><?php echo nl2br($owner_recruit_info2['visiting_benefits_content_'.$i]); ?></td>
                </tr>
                <?php endfor; ?>
              </table>
            </td>
          </tr>
          <tr>
            <td>待遇</td>
            <td>
              <center>
                <div class="check_box">
                    <?php
                    $cou = 0;
                    foreach ($allTreatments as $c) {
                        $cou++;
                        ?>
                        <input type="checkbox" disabled name="" <?php
                        if (in_array($c['id'], $ckownerTreatment)) {
                            echo "checked";
                        }
                        ?> value="<?php echo $c['name']; ?>"> <?php
                               echo $c['name'];
                               if ($cou == 4) {
                                   echo "<br/>";
                                   $cou = 0;
                               }
                               ?>
                               <?php
                           }
                           ?>
                </div>
              </center>
            </td>
          </tr>
          <tr>
            <td>その他待遇</td>
            <td><?php echo nl2br($owner_recruit_info2['other_service']); ?></td>
          </tr>
          <tr>
            <td>お店からのメッセージ</td>
            <td><?php echo nl2br($owner_recruit_info2['company_info']); ?></td>
          </tr>
          <tr>
            <td>応募時間</td>
            <td><?php echo $owner_recruit_info2['apply_time']; ?></td>
          </tr>
          <tr>
            <td>応募用電話番号</td>
            <td><?php echo $owner_recruit_info2['apply_tel']; ?></td>
          </tr>
          <tr>
            <td>応募用メールアドレス</td>
            <td><?php echo $owner_recruit_info2['apply_emailaddress']; ?></td>
          </tr>
          <tr>
            <td>オフィシャルHP</td>
            <td><?php echo $owner_recruit_info2['home_page_url']; ?></td>
          </tr>
          <tr>
            <td>LINEID</td>
            <td><?php echo $owner_recruit_info2['line_id']; ?></td>
          </tr>
          <tr>
            <td>LINE URL登録</td>
            <td><?php echo $owner_recruit_info2['line_url']; ?></td>
          </tr>
          <tr>
            <td>
              お問い合わせ通知用のメールアドレス
              <?php if($owner_data['email_error_flag'] == 1): ?>
                <p style="padding: 0;margin: 0;color: red;">docomoは迷惑メールとなる可能性が高いです. Joyspeからの受信許可設定をしてください</p>
              <?php endif; ?>
            </td>
            <td><?php echo $owner_recruit_info2['new_msg_notify_email']; ?></td>
          </tr>
          <tr>
              <td>区別</td>
              <td><?php echo $owner_recruit_info1['happy_money_type']?$owner_recruit_info1['happy_money_type']:''; ?></td>
          </tr>
          <tr>
              <td>お祝い金額</td>
              <td><?php echo $owner_recruit_info1['happy_money']; ?>円</td>
          </tr>
          <tr>
            <td>イメージ写真</td>
            <td>
              <center>
                <div class="photo_box">
                    <div class="photo" style="margin-right:25px;">
                        <img width="100" src="<?php
                        $url = '';
                        empty($owner_recruit_info2['image1']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $owner_recruit_info2['image1'];
                        echo $url;
                        ?>
                             "
                             />
                    </div>
                    <div class="photo" style="margin-right:25px;">
                        <img width="100" src="<?php
                        empty($owner_recruit_info2['image2']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $owner_recruit_info2['image2'];
                        echo $url;
                        ?>"
                             />
                    </div>
                    <div class="photo">
                        <img width="100" src="<?php
                        empty($owner_recruit_info2['image3']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $owner_recruit_info2['image3'];
                        echo $url;
                        ?>" />
                    </div>
                    <br style="clear:both;">
                </div>
                <div class="photo_box">
                    <div class="photo" style="margin-right:25px;">
                        <img width="100" src="<?php
                        empty($owner_recruit_info2['image4']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $owner_recruit_info2['image4'];
                        echo $url;
                        ?>"/>
                    </div>
                    <div class="photo" style="margin-right:25px;">
                        <img width="100" src="<?php
                        empty($owner_recruit_info2['image5']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $owner_recruit_info2['image5'];
                        echo $url;
                        ?>"/>
                    </div>
                    <div class="photo">
                        <img width="100" src="<?php
                        empty($owner_recruit_info2['image6']) == 1 ?
                                        $url = $imagePath . 'images/no_image.jpg' :
                                        $url = $imagePath . 'uploads/images/' . $owner_recruit_info2['image6'];
                        echo $url;
                        ?>"/>
                    </div>
                    <br style="clear:both;">
                </div>
              <br >
              </center>
            </td>
          </tr>
      </table>
      </div><br />
			<!--
      <div class="information_box">
        <table class="information">
            <tr>
                <th colspan="2">スカウトメール自己PR文修正 (<span style="color:blue;"><a href="<?php
                echo base_url()."owner/history/history_app_message_temp/1";
                ?>">表示確認</a></span>)</th>
            </tr>
            <tr>
                <td>自己PR文修正</td>
                <td style="text-align:left"><?php// echo nl2br($owner_recruit_info2['scout_pr_text']); ?></td>
            </tr>
        </table>
      </div>
      <br>
			-->
<!--
      <div class="information_box">
        <table class="information">
          <tr>
            <th colspan="2">採用金額設定</th>
          </tr>
          <tr>
            <td>採用金額</td>
            <td><?php echo number_format($owner_recruit_info2['joyspe_happy_money']); ?>円</td>
          </tr>
          <tr>
            <td>お祝い金</td>
            <td><?php echo number_format($owner_recruit_info2['user_happy_money']); ?>円</td>
          </tr>
          <tr>
            <td>お祝い金・達成条件</td>
            <td>初日　<?php echo number_format($owner_recruit_info2['cond_happy_money']); ?>時間以上　勤務（研修）</td>
          </tr>
        </table>
      </div>
      <br >
      <center>
        ※採用金は5,000円～200,000円まで設定が可能です。<br >
        ※お祝い金は採用金の「20％」が自動的に設定されます。
      </center><br >
      <div class="list-t-center">
          <input type="submit" name="" value="変更" style="width:150px; height:40px;"></button>
      </div>

<br >
      <center>
        一度お祝い金を設定するとそれを見たユーザーへ永続的にその金額が表示されます。金額変更を行った場合は変更前の金額を<br >
  閲覧したユーザーには変更前の金額が適用され変更前の金額を見ていないユーザーには変更後の金額が表示されます。<br >
  <br >

<img src="<?php echo base_url(); ?>public/owner/images/oiwaisample.jpg">

      </center><br >

    </form>
-->
  <?php } ?>
</div><!-- / .contents-box-wrapper -->

</div><!-- list-box ここまで -->
