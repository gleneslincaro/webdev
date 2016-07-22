<table class="tl_fixed width_100p">
    <caption><i class="fa fa-lightbulb-o"></i>新着急募情報<i class="fa fa-lightbulb-o"></i></caption>
    <?php foreach ($articles as $data) :?>
    <tr>
        <td class="break_words">
            <a href="<?php echo base_url().'user/joyspe_user/company/'.$data['ors_id'].'/'; ?>">
                <p><?php echo $data['post_date']; ?>
                <?php echo ' '.$data['town_name']; ?><br>
                <span><?php echo ($data['storename'] != '')?$data['storename']:'&nbsp;'; ?></span></p>
                <p class="hide_words"><?php echo $data['message']; ?></p>
            </a>
        </td>
    </tr>
    <?php endforeach; ?> 
</table>