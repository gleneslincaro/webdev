<script type="text/javascript">
  $(document).ready(function() {
    var count = parseInt($("#count_owner_search_id").val());
    var count_all = parseInt($("#countall_owner_search_id").val());
    var limit = parseInt($("#limit_owner_search_id").val());
    if (count == 0 || count_all <= limit) {
      $("#get_more_owner_search").hide();
    }
    else {
      $("#get_more_owner_search").show();
    }
  })
</script>
<input type="hidden" value="<?php echo $count?>" id="count_owner_search_id">
<input type="hidden" value="<?php echo $limit?>" id="limit_owner_search_id">
<input type="hidden" value="<?php echo $count_all?>" id="countall_owner_search_id">
<input type="hidden" value="<?php echo $limit?>" id ="limit_owner_id"/>
<?php if ($count < 1): ?>
  <div> 現在、対象のデータがありません。 </div>
<?php endif; ?>
<?php if ( isset($owners) && is_array($owners) ) :
    foreach($owners as $data) {
    if ($data['user_paymentstt'] != -1 && is_array($data['user_paymentstt'])) {
        $va = $data['user_paymentstt'];
        switch ($va['paymentstt']) {
          case 0:
          case 1:
          case 3: // haven't recive happy money but can not take happy money
              $owner_url = base_url() . "user/scout/company_scout/" . $data["ors_id"];
              $owner_html = '<a href="' . $owner_url. '">詳細を見る</a>';
              break;
          case 4:
          case 5:
          case 6:
          case 7: //can take happy money or received happy money
              $owner_url = base_url() . "user/celebration/company_celebration/" . $data["ors_id"];
              $owner_html = '<a href="' . $owner_url. '">詳細を見る</a>';
              break;
          default:
              $owner_url = base_url() . "user/keep_list/company_keep/" . $data["ors_id"];

              $owner_html = '<a href="' . $owner_url . '">詳細を見る</a>　｜　';
              if ($data['keepstt'] == 0) {
                  $owner_html .= '<a href="' . base_url() . "user/keep/index/" . $data["ors_id"] . '">キープ</a>';
              } else if ($data['keepstt'] == 1) {
                  $owner_html .= '<a href="' . base_url() . "user/keep/keep_clear/" . $data["ors_id"] . '">キープ解除</a>';
              }
              break;
        }
    } //if user and owner_recruit notExit in user_payments
    else{
        $owner_url = base_url() . "user/joyspe_user/company/" . $data["ors_id"];

        $owner_html = '<div class="job_menu">';
        $owner_html .= '<a href="' . $owner_url . '">詳細を見る</a>　｜　';
        if ($data['keepstt'] == 0) {
            $owner_html .= '<a href="' . base_url() . "user/keep/index/" . $data["ors_id"] . '">キープ</a>';
        } else if ($data['keepstt'] == 1) {
            $owner_html .= '<a href="' . base_url() . "user/keep/keep_clear/" . $data["ors_id"] . '">キープ解除</a>';
        }
        $owner_html .= '</div>';
    }
  ?>


<li class="cf">
    <p class="shop_name"><?php echo $data['storename']; ?></p>

        <figure class="banner"> 
            <a href="<?php echo $owner_url; ?>"> 
             <?php if($data['main_image']!=0 && $data['image' . $data['main_image']] ){
                  echo '<img src="' . $imagePath . $data['image' . $data['main_image']] . '" width="100%" alt="" />';
              }else{
                  echo '<img src="' . base_url() . 'public/owner/images/no_image_top.jpg" width="100%" alt="" />';
              } ?>
            </a> 
        </figure>
        <p class="area_cat"> <span class="area"><?php echo $data['town_name']; ?></span> <span class="cat"><?php if( isset($data['jobtypename'][0]['name']) ) { echo INDUSYTRY_PREFIX.$data['jobtypename'][0]['name']; }?></span> </p>
        <p class="payment">
           <?php if($data['salary']) : ?><?php
            $data['salary'] = Helper::displayLines($data['salary'],2);
            echo nl2br($data['salary']); ?></a><?php endif ?>
        </p>









        <?php if($data['group_name']) : ?>
          <div><?php echo $data['group_name'].' / '.$data['city_name'].' / '.$data['town_name']; ?></div>
        <?php endif ?>
        <div class="box_bold"><?php echo $data['storename']; ?></div>
        <div><?php if( isset($data['jobtypename'][0]['name']) ) { echo INDUSYTRY_PREFIX.$data['jobtypename'][0]['name']; }?></div>
        <div class="job_box">
          <div class="job_box_inner">
            <a href="<?php echo $owner_url; ?>">
              <?php if($data['main_image']!=0 && $data['image' . $data['main_image']] ){
                  echo '<img src="' . $imagePath . $data['image' . $data['main_image']] . '" width="100%" />';
              }else{
                  echo '<img src="' . base_url() . 'public/owner/images/no_image_top.jpg" width="100%" />';
              } ?>
            </a>
          </div>
          <div  class="job_box_inner">
            <p><b>給料目安</b><br>
            <?php if($data['salary']) : ?><?php
            $data['salary'] = Helper::displayLines($data['salary'],2);
            echo nl2br($data['salary']); ?></a><?php endif ?>
            </p>
          </div>
        </div>
        <div class="job_box">
          <div class="job_treatment_box">
            <?php
              $tam = count($data['treatment']);
              $br = 0;
              foreach($data['treatment'] as $t) {
            ?>
              <div class="job_treatment">
                <?php
                  $br++;
                  echo $t['name'];
                  if($br<3)
                    echo "<br>";
                ?>
              </div>
            <?php }
              if($tam==5)
                echo '<div class="job_treatment_next">………</div>'; ?>
          </div>
          <br style="clear:both">
        </div>
        <div class="job_menu">
            <?php echo $owner_html; ?>
        </div>

</li>
  <?php } ?>
<?php endif ?>
<br>
