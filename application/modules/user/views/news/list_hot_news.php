<?php foreach($listnews as $data => $v) : ?>
    <ul id="news_wrapper">    
        <li class="arrow_right">
            <a href="<?php echo base_url().'user/info_detail/'.$v['id']; ?>/">
                <p class="title t_truncate"><?php echo $v['title']?></p>
                <p class="datetime"><?php echo $v['created_date']?></p>
            </a>
        </li>    
    </ul>
<?php endforeach; ?>
                
