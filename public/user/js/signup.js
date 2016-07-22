
/*
 * signup javascript
 *
 */   
$(document).ready(function(){
    var y=1930;
    $("#year_id").change(function() {
        var year = parseInt($("#year_id option:selected").text());
        y= year;            
        change(y); 
    });
    
    $("#month_id").change(function() {
        var month =parseInt($("#month_id option:selected").text());
        m= month;
        change(y); 
    });
   
    function showBtnRegist() {
        if($('#ok').is(':checked')) {
            $('#btn').attr('disabled',false);
            $("#btn").removeAttr('disabled');
        } else {
            $('#btn').attr("disabled",true);
        }
    }
   
});
     
function change(y) {
    var m =parseInt($("#month_id option:selected").text());
    var d=30;
    switch(m) {
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            d = 31;
            break;
        case 2:
            if((y % 4 ==0 && y % 100!=0) || y % 400==0){
                d=29;
            } else
                d=28;
            break;
        default:
            break;
    }
    // alert(d);
    option="<option value=''>--</option>";
    for(var i=1;i<=d;i++){
        option= option+"<option value='"+i+"'>"+i+"</option>";
    }
    $("#day_id option").remove();
    $("#day_id").append(option);
}
