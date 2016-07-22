<script language="javascript">
 $("document").ready(function(){
        var flag =$("#txtflag").val();
        var base = $("#base").attr("value");
        var name=$("#txtjobname").val();
        var pri=$("#txtpri").val();
        if(flag!=null && flag!=""){
            bol=window.confirm("登録しますか？");
            if(bol==true){
                $.ajax({
                    url:base+"admin/setting/do_insertjob",
                    type:"post",
                    data:"txtjobname="+name+"&pri="+pri,
                    async:true,
                    success:function(kq){
                        window.location=base+"admin/setting/comp";
                    }
                })
            }
        }    
 })
</script>
<?php
echo "<center>";
echo "<form action='Category_Set' method='post'>";
echo '<p>項目・追加</p>';
echo "<input type='hidden' name='txtpri' id='txtpri' value='";
    if(isset($pri)){
        echo $pri;
    }
echo "'>";
echo "<input type='hidden' name='txtflag' id='txtflag' value='";
    if(isset($flag)){
        echo $flag;
    }
echo "'>";
echo '<p>
業種内容　　：<input type="text" name="txtjobname" id="txtjobname" size="60" value="';
if(isset($name)){
    echo $name;
}else{
    echo set_value('txtjobname');
}
echo'"></p>

<p><input type="submit" value="　登録　" name="btnaddjob" /></p>';

echo "</form>";
echo '</center>'
?>
