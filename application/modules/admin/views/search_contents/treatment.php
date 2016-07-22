<center>
<p>待遇文言編集</p>

<div>
<a href="<?php echo base_url().'admin/search_contents/treatment';?>">待遇</a>
</div>

<div class="treatment_edit_list">
<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
<?php foreach($treatments_ar as $value): ?>
<tr>
<td>
<?php echo $value['name'];?>    
</td>
<td>
<button class="treatment_edit" type="button" name="<?php echo $value['name'];?>" value="<?php echo $value['id'];?>">編集</button>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>

<div id="contents_input_area" style="display:none;">
<div id="edit_name"></div>
<textarea id="editor" name="treatment_text" rows="4" cols="80"></textarea>
<p>こんな人におすすめ</p>
<textarea id="editor2" name="treatment_text2" rows="4" cols="80"></textarea>
<p>おすすめ業種</p>
<textarea id="editor3" name="treatment_text3" rows="4" cols="80"></textarea>
<input type="hidden" name="treatment_id" value="">
<p><BUTTON id="submit">　更新　</BUTTON><BUTTON id="nosubmit">　閉じる　</BUTTON></p>
</div>
</center>
<script>
$(function(){
    $('.treatment_edit').on('click',function(){
        $("#contents_input_area").show();
        $(".treatment_edit_list").hide();
        var treatment_id = $(this).val();
        var name = $(this).attr("name");
        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>admin/search_contents/treatmentContents",
            data: {'treatment_id':treatment_id},
            dataType:'json'
        })
        .done(function(data){
            $('#editor').val(data.contents);
            $('#editor2').val(data.contents2);
            $('#editor3').val(data.contents3);
        });
	    $("input[name=treatment_id]").val(treatment_id);
        $("#edit_name").text('['+name+']');
    });

	$('#submit').on('click',function(){
		if(!confirm("更新しますか？")){
			return;
	    }
		var id = $("input[name=treatment_id]").val();
		var text = $("textarea[name=treatment_text]").val();
        var text2 = $("textarea[name=treatment_text2]").val();
        var text3 = $("textarea[name=treatment_text3]").val();
        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>admin/search_contents/updateTreatmentContents",
            data: {'id':id,'text':text,'text2':text2,'text3':text3},
            dataType:'json'
        })
        .done(function(data){
            $("#contents_input_area").hide();
            alert("更新されました。");
            $(".treatment_edit_list").show();
        });
	});

    $('#nosubmit').on('click',function(){
        $("#contents_input_area").hide();
        $(".treatment_edit_list").show();
    });

});
</script>