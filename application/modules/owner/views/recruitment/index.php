<script type="text/javascript">
    $(function() {
        if ($('.historical-btn-box span span:first-child a').text() == '') {
            $('.historical-btn-box span span:first-child a').text('<<');
        }
        if ($('.historical-btn-box span span:last-child a').text() == '') {
            $('.historical-btn-box span span:last-child a').text('>>');
        }

        $("#th9").addClass("visited");
    });
    function deleteUrgentRecruitment(id, recruitment_type) {
        var result = confirm("この記事を削除します。よろしいでしょうか。?");
        if (result) {
            $.post('<?php echo base_url(); ?>owner/recruitment/delete', { id: id, recruitment_type: recruitment_type}, function(result) {
                if (result == 'true' || result == true) {
                    alert('記事を削除しました。');
                    if (recruitment_type == 1) {
                        $('#o'+id).fadeOut();
                    } else {
                        $('#w'+id).fadeOut();
                    }
                }
                else {
                    alert('記事は削除されません。');
                }
            });
        }
    }
</script>
<style>
    .article_message {
        float: left;
        margin-top: 9px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: left;
        padding-left: 10px
    }
</style>
<div class="crumb">TOP ＞ 投稿記事作成</div>
<div style="float:right;"><a style="color:#2595F8;" target = "_blank" href="http://joyspe1.blog.fc2.com/blog-entry-20.html">登録方法</a></div>

<div style="clear: both; margin: 40px 0px -20px">
    <a class="create_article" href="<?php echo base_url(); ?>owner/recruitment/create">記事作成</a>    
</div>
<div class="list-box"><!-- list-box ここから -->
    <div class="list-title">投稿記事作成</div>
    <div class="contents-box-wrapper">
        <div id="list_container">
            <div class="table-list-wrapper">
                <div class="sub-list-title list-title">投稿予約</div>
                <table class="occasional">
                    <tbody>
                        <tr>
                            <th class="w_155">投稿日</th>
                            <th class="w_500">メッセージ</th>
                            <th class="w_100"></th>
                        </tr>
                      <?php if (count($occasional_data) > 0)  : ?>
                          <?php foreach($occasional_data as $data) : ?>
                          <tr id="o<?php echo $data['id']; ?>">
                              <td><?php echo $data['post_date']; ?></td>
                              <td class="article_message w_500">
                                  <?php echo $data['message']; ?>
                              </td>
                              <td>
                                  <a href="<?php echo base_url().'owner/recruitment/edit/'.$data['id']; ?>">編集</a>
                                  <a href="javascript:void(0)" onclick="deleteUrgentRecruitment(<?php echo $data['id']; ?>, 1)">削除</a>
                              </td>
                          </tr>
                          <?php endforeach; ?>
                      <?php else : ?>
                          <tr>
                            <td colspan="3" class="t_left pl_15">記事がありません。</td>
                          </tr>
                      <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-list-wrapper">
                <div class="sub-list-title list-title">投稿履歴</div>
                <table>
                    <tbody>
                        <tr>
                            <th class="w_155">投稿日</th>
                            <th class="w_500">メッセージ</th>
                            <th class="100"></th>
                        </tr>
                      <?php if (count($post_history) > 0)  : ?>
                          <?php foreach($post_history as $data) : ?>
                          <tr>
                              <td><?php echo $data['posted_date']; ?></td>
                              <td class="article_message w_500"><?php echo $data['message']; ?></td>
                              <td><a href="<?php echo base_url().'owner/recruitment/view/'.$data['id']; ?>">見る</a></td>
                          </tr>
                          <?php endforeach; ?>
                      <?php else : ?>
                          <tr>
                            <td colspan="3" class="t_left pl_15">記事がありません。</td>
                          </tr>
                      <?php endif; ?>
                    </tbody>
                </table>
                <div class="btn_box historical-btn-box t_center">
                    <?php if ($totalpage > 1) : ?>
                        <?php echo $ph_paging; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="table-list-wrapper">
                <div class="sub-list-title list-title">曜日設定</div>
                <table>
                    <tbody>
                        <tr>
                            <th class="w_78">日時</th>
                            <th class="w_78">日時</th>
                            <th class="w_500">メッセージ</th>
                            <th class="w_100"></th>
                        </tr>
                      <?php if (count($weekly_data) > 0)  : ?>
                          <?php foreach($weekly_data as $data) : ?>
                          <tr id="w<?php echo $data['id']; ?>">
                              <td><?php echo $days[$data['post_day']]; ?></td>
                              <td><?php echo ($data['post_hour'] < 10)?'0'.(string)$data['post_hour']:$data['post_hour']; ?> 時</td>
                              <td class="article_message w_500"><?php echo $data['message']; ?></td>
                              <td>
                                  <a href="<?php echo base_url().'owner/recruitment/edit/'.$data['id']; ?>">編集</a>
                                  <a href="javascript:void(0)" onclick="deleteUrgentRecruitment(<?php echo $data['id']; ?>, 2)">削除</a>
                              </td>
                          </tr>
                          <?php endforeach; ?>
                      <?php else : ?>
                          <tr>
                            <td colspan="4" class="t_left pl_15">記事がありません。</td>
                          </tr>
                      <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
