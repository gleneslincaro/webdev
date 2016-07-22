
<div class="title">▼検索エリア</div>

<!--矢印つきリスト-->
<div class="list1">
	<ul>
        <?php foreach ($city_group as $v): ?>
        <li><a href="<?php echo base_url() . "user/search/detail_search/".$v['id']; ?>/"><?php echo $v['name']?></a></li>
           <?php endforeach; ?>
    </ul>
</div>
<!--矢印つきリスト-->
<br>
<div class="list1"> 
    <form method="post" action="search_list" id="formsearch">
        <b><input type="submit"  style="width:40%; height:32px;font-size:15px;color: #6EA2FF;font:bold" class="btn" value="検索" name="btnsearch" /></b>
    </form>
</div>


