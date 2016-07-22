<div class="title">▼検索エリア</div>

<!--矢印つきリスト-->
<div class="list1"> 
    <ul>
        <?php foreach ($city_group as $v): ?>
             
        <li><a href="<?php echo base_url() . "user/search/detail_search/" . $v['id']; ?>/"><?php echo $v['name']?></a></li>            
           <?php endforeach; ?>
           
    </ul>
</div>
