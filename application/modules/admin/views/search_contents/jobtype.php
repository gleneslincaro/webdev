<center>
<p>業種文言編集</p>

<div>
<a href="<?php echo base_url().'admin/search_contents/jobtype';?>">業種</a>
</div>

<div class="jobtype_edit_list">
<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
<?php foreach($jobtype_ar as $value): ?>
<tr>
<td>
<?php echo $value['name'];?>
</td>
<td>
<button class="jobtype_edit" type="button" name="<?php echo $value['name'];?>" value="<?php echo $value['id'];?>">編集</button>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>

<div id="contents_input_area" style="display:none;">
<div id="edit_name"></div>
<form id="jobtype_form">
<textarea id="editor" name="jobtype_text" rows="4" cols="80"></textarea>
<p>平均月収</p>
<input  id="editor1" type="text" name="jobtype_income" size="90" maxlength="20">
<!-- <textarea id="editor1" name="jobtype_income" rows="4" cols="80"></textarea>  -->
<p>平均月収テキスト</p>
<textarea id="editor2" name="jobtype_text2" rows="4" cols="80"></textarea>
<p>こんな人におすすめ</p>
<textarea id="editor3" name="jobtype_text3" rows="4" cols="80"></textarea>
<p>探す時のポイント</p>
<textarea id="editor4" name="jobtype_text4" rows="4" cols="80"></textarea>
<input type="hidden" name="jobtype_id" value="">
</form>>
<p><BUTTON id="submit">　更新　</BUTTON><BUTTON id="nosubmit">　閉じる　</BUTTON></p>
</div>
</center>
<script>
$(function(){
    $('.jobtype_edit').on('click',function(){
	$("#contents_input_area").show();
	$(".jobtype_edit_list").hide();
	var jobtype_id = $(this).val();
        var name = $(this).attr("name");
        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>admin/search_contents/jobtypeContents",
            data: {'jobtype_id':jobtype_id},
            dataType:'json'
        })
        .done(function(data){
            $('#editor').val(data.contents);
            $('#editor1').val(data.income);
            $('#editor2').val(data.contents2);
            $('#editor3').val(data.contents3);
            $('#editor4').val(data.contents4);
        });
        $("input[name=jobtype_id]").val(jobtype_id);
        $("#edit_name").text('['+name+']');
    });

    $('#submit').on('click',function(){
   	    if(!confirm("更新しますか？")){
            return;
        }
    	var id = $("input[name=jobtype_id]").val();
        var income = $("input[name=jobtype_income]").val();
    	var text = $("textarea[name=jobtype_text]").val();
        var text2 = $("textarea[name=jobtype_text2]").val();
        var text3 = $("textarea[name=jobtype_text3]").val();
        var text4 = $("textarea[name=jobtype_text4]").val();
//        var data = $("#jobtype_form").serialize();
        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>admin/search_contents/updateJobtypeContents",
            data: {'id':id,'income':income, 'text':text,'text2':text2,'text3':text3,'text4':text4},
            dataType:'json'
        })
        .done(function(data){
            $("#contents_input_area").hide();
            alert("更新されました。");
            $(".jobtype_edit_list").show();
        });

    });

    $('#nosubmit').on('click',function(){
        $("#contents_input_area").hide();
        $(".jobtype_edit_list").show();
    });

});
</script>