<style type="text/css">
span.menu-triangle {
    border-radius: 0.5em;
    background-color: gray;
    color: white;
    font-size: 12px;
    margin: 0 10px;
    padding: 0 15px;
    cursor: pointer;
}
span.menu-triangle:hover {
    background-color: red;
}
ul.jquery-menu {
}
ul.jquery-menu li {
    list-style-type: square;
    border-left: 1px solid #333;
    border-bottom: 1px solid #333;
    border-right: 1px solid #333;
}
ul.jquery-menu li:first-child {
    border-top: 1px solid #333;
}
ul.jquery-menu-sub {
    display: none;
}
ul.jquery-menu-sub li {
    border-left: 1px solid #333;
    border-bottom: 1px solid #333;
    border-right: 1px solid #333;
    list-style-type: square;
}
ul.jquery-menu-sub li:first-child {
    border-top: 1px solid #333;
}

.category_select li.selected {
    background-color: #def1ff;
}
.category_select li {
    cursor: pointer;
}

.main_content_list {
    display: block;
    float: right;
    font-size: 1.3rem;
    line-height: 2;
    padding: 0 0 50px;
    width: 800px;
}

.category_box {
    display: inline-block;
    margin: 0 50px 30px 0;
}
.category_select {
    height: 250px;
    overflow: scroll;
}
#category_box_all {
    display: inline-block;
    vertical-align: top;
}
</style>
<div class="main_content_list">
        <div>

          <h2>カテゴリ編集</h2>
          <h3 class="category_box_h">登録済：大カテゴリ</h3>
          <div class="category_box">
            <ul class="category_select">
              <?php foreach ($big_category_ar as $key => $value): ?>
              <li class="category_parent" id="category_<?php echo $value['id'] ?>">
              <span><?php echo $value['name'] ?></span>
<!--                  <input type="button" class="category_change_btn" value="編集">  -->
                  <input type="button" class="category_name_change_btn" value="変更">
              </li>
              <?php endforeach; ?>
            </ul>
            <ul class="">
              <li class="category_parent" >
              <input type="text" class="" name="new_p_cate" value="" placeholder="大カテゴリ">
              <input type="button" id="add_p_cate_btn" class="" value="追加">
              </li>
            </ul>
          </div>
          <div id="category_box_all">
            <?php foreach ($category_ar as $i => $entry): ?>
            <div id="category_box_child_<?php echo $i; ?>">
              <ul class="category_select_child">
                <?php foreach ($entry as $i2 => $entry2): ?>
                <li class="category_child" id="child_<?php echo $i2; ?>"><?php echo $entry2; ?>
                  <input type="button" class="category_change_btn" value="編集">
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endforeach; ?>
            <ul class="">
              <li class="category_child" id="">
                <input type="text" class="" name="new_cate" value="" placeholder="小カテゴリ">
                <input type="button" id="add_cate_btn" class="" value="追加">
              </li>
            </ul>
          </div>

          <div class="category_contents_area" style="display:none;">
            <div><span class="category_detail">お店でのトラブル</span></div>
            <textarea class="extraction memo"></textarea>
          </div>
          <div class="button_center category_contents_btn"  style="display:none;">
            <input type="button" class="btn_large" value="更新" onClick="disp()">
          </div>

        </div>
        <input type="hidden" id="cate_contents_id" value="">
        <input type="hidden" id="edit_type" value="">
        <input type="hidden" id="cate_p_contents_id" value="">

</div>

<script type="text/javascript">
function disp(){
  // 「OK」時の処理開始 ＋ 確認ダイアログの表示
  if(window.confirm('登録しますか？')){
//    location.href = "houritsu_tv_05_1.html";
    var id = $('#cate_contents_id').val();
    var type = $('#edit_type').val();
    var text = $('.memo').val();

//console.log(id);
//console.log(type);
//console.log(text);

    $.ajax({
      url: "{{ base_url }}admin/category_contents_update_ajax",
      type:"post",
      data:{edit_type:type,cate_id:id,contents:text}
    }).done(function(data){

      $('.category_contents_area').hide();
      $('.category_contents_btn').hide();
        alert('更新されました。');

    }).fail(function(data){
        alert('error!!!');
    });


  }
  // 「OK」時の処理終了

  // 「キャンセル」時の処理開始
  else{
    window.alert('キャンセルされました'); // 警告ダイアログを表示
  }
  // 「キャンセル」時の処理終了
}
</script> 
<script type="text/javascript">
  $(function(){
    $(".category_select").on("click", "li",function() {
      $("li.selected").removeClass("selected");
      $(this).addClass("selected");
      myID = this.id.split("_")[1];
      $("#category_box_all>div").hide();
      $("#category_box_child_" + myID).show();
      $("#cate_p_contents_id").val(myID);
    })
    $("#category_1").trigger("click");
  })

  $(function(){

    $("#add_p_cate_btn").on("click",function() {

      if(confirm('追加しますか？')){
        var new_cate = $("[name='new_p_cate']").val();
//        var p_cate_id = $("#cate_p_contents_id").val();

        $.ajax({
          url: "<?php echo base_url(); ?>admin/bbs/add_big_category_ajax",
          type:"post",
          data:{new_cate:new_cate}
        }).done(function(data){
          alert('追加されました。');
            location.href = "<?php echo base_url(); ?>/admin/bbs/category_setting";

        }).fail(function(data){
              alert('error!!!');
        });

      } else {
        console.log('中止');
      }

    });


    $("#add_cate_btn").on("click",function() {

      if(confirm('追加しますか？')){
        var new_cate = $("[name='new_cate']").val();
        var p_cate_id = $("#cate_p_contents_id").val();

        $.ajax({
          url: "<?php echo base_url(); ?>admin/bbs/add_category_ajax",
          type:"post",
          data:{add_type:'cate',p_cate_id:p_cate_id,new_cate:new_cate}
        }).done(function(data){
          alert('追加されました。');
          location.href = "<?php echo base_url(); ?>/admin/bbs/category_setting";

          }).fail(function(data){
              alert('error!!!');
          });

      } else {
        console.log('中止');
      }
    });


    $(".category_name_change_btn").on("click",function() {
      var cl = $(this).parents("li").attr("class");
      var text = $(this).parents("li").children('span').text();
      idx = cl.indexOf("category_parent");
      var result = prompt("大カテゴリ変更",text);
      if(result){
        $.ajax({
          url: "<?php echo base_url(); ?>admin/bbs/update_big_category_ajax",
          type:"post",
          data:{name:result}
        }).done(function(data){
          alert('変更されました。');
          location.href = "<?php echo base_url(); ?>/admin/bbs/category_setting";
        }).fail(function(data){
              alert('error!!!');
        });

      }else{
        console.log(" CANCEL が押された");
      }
    });

    $(".category_change_btn").on("click",function() {
      var cl = $(this).parents("li").attr("class");
      idx = cl.indexOf("category_parent");

        $('.memo').empty();
//        $('.category_contents_area').hide();
//        $('.category_contents_btn').hide();

      if(idx != -1) {
        console.log(cl);
        var id = $(this).parents("li").attr("id");
        var myID = id.split("_")[1];
        console.log(myID);

        $.ajax({
          url: "{{ base_url }}admin/category_contents_edit_ajax",
          type:"post",
          data:{edit_type:'p_cate',cate_id:myID}
        }).done(function(data){
//          alert('更新されました。');
          $('.memo').val(data.contents);
          $('#cate_contents_id').val(data.id);
          $('#edit_type').val(data.edit_type);
          $('.category_detail').html(data.p_cate_name);


//          console.dir(data);
            $('.category_contents_area').show();
            $('.category_contents_btn').show();

          }).fail(function(data){
              alert('error!!!');
          });

      }else{
        var id = $(this).parents("li").attr("id");
        var myID = id.split("_")[1];
        console.log(myID);

        console.log(cl);

        var p_cate_id = $("#cate_p_contents_id").val();


        $.ajax({
          url: "{{ base_url }}admin/category_contents_edit_ajax",
          type:"post",
          data:{edit_type:'cate',p_cate_id:p_cate_id,cate_id:myID}
        }).done(function(data){
//          alert('更新されました。');
          $('.memo').val(data.contents);
          $('#cate_contents_id').val(data.id);
          $('#edit_type').val(data.edit_type);
          $('.category_detail').html(data.p_cate_name+'>'+data.cate_name);

//          console.dir(data);
            $('.category_contents_area').show();
            $('.category_contents_btn').show();

          }).fail(function(data){
              alert('error!!!');
          });

      }
//      $("#category_box_all>div").hide();
//      $("#category_box_child_" + myID).show();
    });
//    $("#category_1").trigger("click");


  })
</script>

<script type="text/javascript">
$(function(){

});

function disp(){
  // 「OK」時の処理開始 ＋ 確認ダイアログの表示
  if(window.confirm('更新しますか？')){
    location.href = "houritsu_tv_05_1.html";
  }
  // 「OK」時の処理終了

  // 「キャンセル」時の処理開始
  else{
    window.alert('キャンセルされました'); // 警告ダイアログを表示
  }
  // 「キャンセル」時の処理終了
}
</script> 
<script type="text/javascript">
      $(function(){
        
        $(".category_select").on("click", "li",function() {
          $("li.selected").removeClass("selected");
          $(this).addClass("selected");
          myID = this.id.split("_")[1];
          $("#category_box_all>div").hide();
          $("#category_box_child_" + myID).show();
        })

        $("#category_1").trigger("click");
      })      
</script>
