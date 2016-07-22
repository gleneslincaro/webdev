<script type="text/javascript">
    $(document).ready(function(){

            var count = parseInt($("#count_hpn_id").val());
            var count_all = parseInt($("#countall_hpn_id").val());
            var limit_hpn_id = parseInt($("#limit_hpn_id").val());
            //alert("all:"+count_all+"count:"+count+"limit:"+limit_hpn_id);
            if (count == 0 || count_all <= limit_hpn_id)
            {
                $("#more_hpm_id_result").hide();
            }
            else
            {
                $("#more_hpm_id_result").show();
            }
        })

</script>



    <?php if ($count < 1): ?>
             <div> 現在、対象のデータがありません。 </div>          
    <?php endif; ?>
    <input type="hidden" value="<?php echo $count?>" id="count_hpn_id">    
    <input type="hidden" value="<?php echo $limithpm?>" id="limit_hpn_id">
    <input type="hidden" value="<?php echo $count_all?>" id="countall_hpn_id">
 <?php 
    //お祝い金表示用のフォントサイズ調整
    $user_hm = 0;
    $money_font_size = OIWAI_PAY_MONEY_FONTSIZE_LARGE;
    $yen_font_size = OIWAI_PAY_YEN_FONTSIZE_LARGE;
 foreach($listHappyMoney as $data) {
        $num_of_characters = strlen($data['user_happy_money']);
        if ( $num_of_characters > 6){
            $money_font_size = OIWAI_PAY_MONEY_FONTSIZE_SMALL;
            $yen_font_size = OIWAI_PAY_YEN_FONTSIZE_SMALL;
        }
        if ($data['user_happy_money'] ){
            $user_hm = number_format($data['user_happy_money']);
        }
        ?>
  
<div class="box">
	<div class="box_in">
        <?php if($user_hm > 0): ?>
        <img src="<?php echo base_url().'public/user/image/oiwai.jpg'; ?>" />
        <div class="vertical_align_wrapper">
            <div class="outer">
                <div class="middle">
                    <div class="inner" style="font-size: <?=$money_font_size;?>px;">
                        <?=$user_hm;?><span style="font-size:<?=$yen_font_size;?>px;">円</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="happy_text">
            <span style="color:black;"><?php echo OIWAI_PAY_TEXT_PRFEFIX; ?>
            <span style="color:#ff2b00"><?php echo OIWAI_PAY_TEXT_MIDDLE."</span>".OIWAI_PAY_TEXT_SUFFIX; ?></span>
        </div>
    <?php endif ?>
	<?php if($data['group_name']) : ?>  
    <div><?php echo $data['group_name'].' / '.$data['city_name'].' / '.$data['town_name']; ?></div>
  <?php endif ?>
	<div class="box_bold"><?php echo $data['storename']; ?></div>
    <div><?php if( isset($data['jobtypename'][0]['name']) ) { echo INDUSYTRY_PREFIX.$data['jobtypename'][0]['name']; }?></div>
	<div class="job_box">
		<div class="job_box_inner">
                    <?php if($data['image'.$data['main_image']]!=0 && $data['image' . $data['main_image']]){ ?>
                        <img src="<?php echo $imagePath.$data['image' . $data['main_image']]; ?>"
                                        width="100%"></div>
                        <?php
                    }else{
                        echo '<img src="'.base_url().'public/owner/images/no_image_top.jpg" width="100%" /></div>';
                    }
                        ?>
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
                <?php $tam=  count($data['treatment']); $br=0;  foreach($data['treatment'] as $t):?>
		<div class="job_treatment">
                    <?php
                        $br++;
                        echo $t['name'];
                        if($br<3)
                            echo "<br>";
                      ?>
                </div>
                <?php endforeach;
                if($tam==5)
                    echo '<div class="job_treatment_next">………</div>'?>
        </div>
     	<br style="clear:both">
	</div>
	<div class="job_menu">
            <?php if ($data['user_payment_status']==5 ||$data['user_payment_status']==6)
                    echo '<a href="'.base_url() . "user/celebration/company_celebration/".$data["ors_id"].'/">詳細を見る</a>';
                     
            else 
                echo '<a href="'.base_url() . "user/celebration/company_celebration/".$data["ors_id"].'/">詳細を見る</a>';
                   
            ?>
	</div>
	</div>
         
         
</div>
<br >
<?php }?>  
<br>

 
