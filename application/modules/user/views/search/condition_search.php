<div class="title">▼勤務スタイル・待遇</div>

お祝い金<br >

<div class="select_box01">
<nobr>
	<select class="sign_up" name="happy_money1" id="happy_money1">
	<?php foreach ($happymoney as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['user_happy_money']?>円</option>     
        <?php endforeach; ?>
	</select>
	～
	<select class="sign_up" name="happy_money2" id="happy_money2">
	<option value="0">-----</option>
	<?php foreach ($happymoney as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['user_happy_money']?>円</option>     
        <?php endforeach; ?>
	</select>
</nobr>

</div>

時給目安<br >

<div class="select_box01">
<nobr>
	
        <select class="sign_up" name="hourly1" id="hourly1">
	<?php foreach ($hourly as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['amount']?>円</option>     
        <?php endforeach; ?>
	</select>
	～
	<select class="sign_up" name="hourly2" id="hourly2">
	<option value="0">-----</option>
	<?php foreach ($hourly as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['amount']?>円</option>     
        <?php endforeach; ?>
	</select>
</nobr>

</div>
月給目安<br >

<div class="select_box01">
<nobr>
	<select class="sign_up" name="monthly1" id="monthly1">
	<?php foreach ($monthly as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['amount']?>万円</option>     
        <?php endforeach; ?>

	</select>
	～
	<select class="sign_up" name="monthly2" id="monthly2">
	<option value="0">-----</option>
	<?php foreach ($monthly as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['amount']?>万円</option>     
        <?php endforeach; ?>
	</select>
</nobr>

</div>


<br >

<div class="select_box">
	<select class="sign_up" name="treatment1" id="treatment1">
	<option value="0">待遇・第1候補</option>
	<?php foreach ($treatment as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>     
        <?php endforeach; ?>
	</select>
<br ><br>
	<select class="sign_up" name="treatment2" id="treatment2">
	<option value="0">待遇・第2候補</option>
	<?php foreach ($treatment as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>     
        <?php endforeach; ?>
	</select>
<br ><br>
	<select class="sign_up" name="treatment3" id="treatment3">
	<option value="0">待遇・第3候補</option>
	<?php foreach ($treatment as $t=>$v ): ?>   
        <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>     
        <?php endforeach; ?>
	</select>

<br ><br >  
</div>

