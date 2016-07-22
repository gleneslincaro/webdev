<div class="box_qanda">
<?php foreach ($all_question_answer as $key => $field) : ?>
<table>
    <tr>
        <td width="30%">質問(Q)</td>
        <td width="55%"><b><?php echo nl2br($field['question']); ?></b><hr></td>
        <td><button class="insert_faq" data-msg-id="<?php echo nl2br($field['question_id']); ?>">FAQに追加します。</button></td>
    </tr>
    <tr>
        <td>回答(A)</td>
        <td><?php echo nl2br($field['answer']); ?></td>
        <td></td>
    </tr>
</table>
<?php endforeach; ?>
<ul>
<?php if ($page >= 5) : ?>
    <li><a href="#" data-page-id="0"> &#60;&#60; </a></li>
<?php endif; ?>
<?php $count = 1; for ($i=0; $i < $totalpages; $i++) :?>
    <?php if ($count <= 5 && $i >= ($page - 4)) : ?>
        <li><a href="#" data-page-id="<?php echo $i * TOTAL_DISPLAY_FAQ; ?>"><?php echo $i+1; ?></a></li>
    <?php $count++; endif;  ?>
<?php endfor; ?>
<?php if ($page <= 5 && $totalpages != ($page + 1)) : ?>
    <li><a href="#" data-page-id="<?php echo ($totalpages - 1) * TOTAL_DISPLAY_FAQ; ?>"> &#62;&#62; </a></li>
<?php endif; ?>
</ul>
</div>