<center>
<div id="area_center">
<?php
    $this->load->view('search_contents/area_table_list.php');
?>
</div>
<div id="contents_input_area" style="display:none;">
<div id="edit_name"></div>
<textarea id="editor" name="area_text" rows="10" cols="80"></textarea>
<input type="hidden" name="area_id" value="">
<input id="current_area_name" type="hidden" name="current_area_name" value="">
<p><BUTTON id="submit">　更新　</BUTTON><BUTTON id="nosubmit">　閉じる　</BUTTON></p>
</div>
</center>
<script>
$(function(){
    var area_center = $('#area_center');
    var current_area_name = $('#current_area_name');
    var contents_input_area = $("#contents_input_area");

    $(document).on('click', '#breadcrumb a', function(){
        contents_input_area.hide();
        var area = $(this).attr("id");
        current_area_name.val(area);
        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>admin/search_contents/area_ajax",
            data: {area:area}
        })
        .done(function(data){
            area_center.html(data);
        });
    });

    $(document).on('click', '.areatext_edit_list table tr td a', function(){
        var area = $(this).attr("id");
        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>admin/search_contents/area_ajax",
            data: {area:area}
        })
        .done(function(data){
            area_center.html(data);
            current_area_name.val(area);
        });
    });

    $(document).on('click','.areatext_edit', function(){
        contents_input_area.show();
        $(".areatext_edit_list").hide();
        var step = $('#step').val();
        var id = $(this).val();
        var name = $(this).attr("name");
        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>admin/search_contents/getAreaContents",
            data: {'step':step,'id':id},
            dataType:'json'
        })
        .done(function(data){
            $('#editor').val(data);
        });
	    $("input[name=area_id]").val(id);
	    $("#edit_name").text('['+name+']');
    });
        
    $('#submit').on('click',function(){
        if(!confirm("更新しますか？")){
            return;
        }
        var step = $('#step').val();
        var id = $("input[name=area_id]").val();
        var text = $("textarea[name=area_text]").val();
        $.ajax({
            type:'post',
            url:"<?php echo base_url();?>admin/search_contents/updateAreaContents",
            data: {'step':step,'id':id,'text':text},
            dataType:'json'
        })
        .done(function(data){
            contents_input_area.hide();
            alert("更新されました。");
            var area = $('#current_area_name').val();
            $.ajax({
                type:'post',
                url:"<?php echo base_url();?>admin/search_contents/area_ajax",
                data: {area:area}
            })
            .done(function(data){
                area_center.html(data);
                $(".areatext_edit_list").show();
            });
        });
    });

    $('#nosubmit').on('click',function(){
        contents_input_area.hide();
        $(".areatext_edit_list").show();
    });
        
});
</script>