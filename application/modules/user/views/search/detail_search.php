<div class="title">▼検索エリア<?php echo "    ".$city_name['name'] ?></div>
<form method="post" action="<?php echo base_url()."user/search/search_list"?>" >
    <input type="hidden" value="<?php echo $city_group_id?>" name="city_group_id"/>
    <?php foreach ($city as $t ): ?>   
      <div class="title_serch">
          <input class="check_city" id="check_city_id<?php echo $t['id']  ?>" type="checkbox" name="check_city[]" value="<?php echo $t['id']?>"<?php if(isset($_POST['check_city'])) echo 'checked'; ?>>
                <?php echo $t['name']?> </input>
      </div>           
    <?php endforeach; ?>
    <br /><br />         
    <input type="submit" style="width:40%; height:32px;font-size:15px;color: #6EA2FF;font: bold; cursor: pointer" class="btn" value="検索" name="btnsearch" />    
</form>