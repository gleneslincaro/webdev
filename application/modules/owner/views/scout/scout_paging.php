<?php if ($totalpage > 1): ?>
    <?php if(count($paging) > 1): ?>
        <span class="prev_btn"><a href="<?php echo '#'.$paging[1]?>" >前へ</a></span>
        <span class="next_btn"><a href="<?php echo '#'.$paging[0]?>" >次へ</a></span>
    <?php endif; ?>
    <?php if(count($paging) == 1): ?>
        <span class="<?php echo ($curpage != $totalpage)?'next_btn':'prev_btn'; ?>" >
        <a href="<?php echo '#'.$paging[0]?>" ><?php echo ($curpage != $totalpage)?'次へ':'前へ' ?></a>
        </span>
    <?php endif; ?>
<?php endif; ?>
<input type='hidden' id="hdPage" name='hdPage' value='<?php echo $curpage; ?>'>
<input type='hidden' id="totalpage" name='totalpage' value='<?php echo $totalpage; ?>'>
<input type="hidden" id="totalUsers" name="totalUsers" value="<?php echo $total; ?>">