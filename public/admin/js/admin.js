
             /*
                * @author  [IVS] Nguyen Minh Ngoc
                * @name
                * @todo 	common js
                * @param
                * @return
               */
          $(document).ready(function(){
               $( "#txtLastLoginFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtLastLoginTo" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtDatePickerCommonFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtDatePickerCommonTo" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtDatePickerCommonFrom2" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtDatePickerCommonTo2" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtf_dktam" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtt_dktam" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtf_dk" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtt_dk" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtbirthday" ).datepicker({ dateFormat: "yy/mm/dd" });

              $("#txtbirthday").change(function(){
            var lastloginto = $("#txtbirthday").val();
            if(lastloginto!="" && !lastloginto.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#txtbirthday").val("");
            }
              });

                /*
                * @author  [IVS] Nguyen Minh Ngoc
                * @name
                * @todo 	upload image1
                * @param
                * @return
               */
                $('#iupload').change(function() {
                 var base = $("#base").attr("value");
                 var noImage = "no_image.jpg";
                 var id=$("#txtuid").val();
                 var upload_action = base + "admin/search/fileUploadAjx";
                $('#form_mn').ajaxSubmit({
                         url: upload_action,
                         type:"post",
                         async:true,
                         data: { id: id },
                         dataType:'json',
                         success: function(responseText, statusText, xhr, $form){
                              $("#idp_img").attr("src", responseText.url);
                               $("#img1").attr("value", responseText.fileName);
                              if(responseText.error !=null){
                                  alert(responseText.error);
                              }
                         }
                });
                return false;
              })
             /*
                * @author  [IVS] Nguyen Minh Ngoc
                * @name
                * @todo 	upload image2
                * @param
                * @return
               */
              $('#iupload1').change(function() {
                 var base = $("#base").attr("value");
                 var noImage = "no_image.jpg";
                 var id=$("#txtuid").val();
                 var upload_action = base + "admin/search/fileUploadAjx";
                $('#form_mn').ajaxSubmit({
                         url: upload_action,
                         type:"post",
                         async:true,
                         data: { id: id },
                         dataType:'json',
                         success: function(responseText, statusText, xhr, $form){
                              $("#idp_img1").attr("src", responseText.url);
                               $("#img2").attr("value", responseText.fileName);
                               $("#iupload1").clearInputs();
                              if(responseText.error !=null){
                                  alert(responseText.error);
                              }
                         }
                });
                return false;
              });
              /*
                * @author  [IVS] Nguyen Minh Ngoc
                * @name
                * @todo 	 delete image1
                * @param
                * @return
               */
              $("#btndel1").click(function(){
                var base = $("#base").attr("value");
                var path = base + "/public/admin/image/no_image.jpg";
                var iupload = $("#iupload");
                var bol=window.confirm('登録しますか？');
                if(bol==true){
                    $("#idp_img").attr("src",path);
                    $("#img1").attr("value","");
                     iupload.clearInputs();
                }
              });
              /*
                * @author  [IVS] Nguyen Minh Ngoc
                * @name
                * @todo 	  delete image2
                * @param
                * @return
               */
              $("#btndel2").click(function(){
                var base = $("#base").attr("value");
                var path = base + "/public/admin/image/no_image.jpg";
                 var iupload = $("#iupload1");
                  var bol=window.confirm('登録しますか？');
                if(bol==true){
                $("#idp_img1").attr("src",path);
                $("#img2").attr("value","");
                iupload.clearInputs();
                }
              });

               /*
                * @author  [IVS] Nguyen Minh Ngoc
                * @name
                * @todo
                * @param
                * @return
               */
                $('#iuploadow').change(function() {
                 var base = $("#base").attr("value");
                 var noImage = "no_image.jpg";
                 var id=$("#txtowrid").val();
                 var upload_action = base + "admin/authentication/fileUploadAjx";
                    $('#form_ow').ajaxSubmit({
                            url: upload_action,
                            type:"post",
                            async:true,
                            data: { id: id },
                            dataType:'json',
                            success: function(responseText, statusText, xhr, $form){
                                if(responseText.error !=null)
                                {
                                    alert(responseText.error);
                                }
                                else
                                {
                                    if($("#image1").attr("src").substr($("#image1").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image1").attr("src", responseText.url);
                                         $("#hdImage1").val(responseText.fileName);
                                    }
                                    else if($("#image2").attr("src").substr($("#image2").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image2").attr("src", responseText.url);
                                         $("#hdImage2").val(responseText.fileName);
                                    }
                                    else if($("#image3").attr("src").substr($("#image3").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image3").attr("src", responseText.url);
                                         $("#hdImage3").val(responseText.fileName);
                                    }
                                    else if($("#image4").attr("src").substr($("#image4").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image4").attr("src", responseText.url);
                                         $("#hdImage4").val(responseText.fileName);
                                    }
                                    else if($("#image5").attr("src").substr($("#image5").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image5").attr("src", responseText.url);
                                         $("#hdImage5").val(responseText.fileName);
                                    }
                                    else if($("#image6").attr("src").substr($("#image6").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image6").attr("src", responseText.url);
                                         $("#hdImage6").val(responseText.fileName);
                                    }
                                }
                            }
                    });
                return false;
              });
                /*
                * @author  [IVS] Nguyen Minh Ngoc
                * @name
                * @todo
                * @param
                * @return
               */
                $('#iuploadow2').change(function() {
                 var base = $("#base").attr("value");
                 var noImage = "no_image.jpg";
                 var id=$("#txtorid").val();
                 var upload_action = base + "admin/authentication/fileUploadAjx2";
                 $('#form_ow2').ajaxSubmit({
                    url: upload_action,
                    type:"post",
                    async:true,
                    data: { id: id },
                    dataType:'json',
                    success: function(responseText){
                        if(responseText.error !=null)
                                {
                                    alert(responseText.error);
                                }
                                else
                                {
                                    if($("#image1").attr("src").substr($("#image1").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image1").attr("src", responseText.url);
                                         $("#hdImage1").val(responseText.fileName);
                                    }
                                    else if($("#image2").attr("src").substr($("#image2").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image2").attr("src", responseText.url);
                                         $("#hdImage2").val(responseText.fileName);
                                    }
                                    else if($("#image3").attr("src").substr($("#image3").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image3").attr("src", responseText.url);
                                         $("#hdImage3").val(responseText.fileName);
                                    }
                                    else if($("#image4").attr("src").substr($("#image4").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image4").attr("src", responseText.url);
                                         $("#hdImage4").val(responseText.fileName);
                                    }
                                    else if($("#image5").attr("src").substr($("#image5").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image5").attr("src", responseText.url);
                                         $("#hdImage5").val(responseText.fileName);
                                    }
                                    else if($("#image6").attr("src").substr($("#image6").attr("src").lastIndexOf("/") +1) == noImage)
                                    {
                                         $("#image6").attr("src", responseText.url);
                                         $("#hdImage6").val(responseText.fileName);
                                    }
                                }
                 }

                });
                return false;
              });

              $('#uploadCsv').change(function() {
                var base = $("#base").attr("value");
                var upload_action = base + "admin/authentication/fileUploadAjx3";
                $('#form_csv').ajaxSubmit({
                  url: upload_action,
                  type:"post",
                  async:true,
                  dataType:'json',
                  success: function(responseText){
                    if(responseText.error !=null) {
                      alert(responseText.error);
                      $('#uploadCsv').val('');
                      $('#btnCsv').attr('disabled', true);
                    }
                    else {
                      $('#fixName').val(responseText.fixName);
                      $('#btnCsv').removeAttr('disabled');
                    }
                  }
                });
                return false;
              });
            });




            /*
            * @author  [IVS] Nguyen Hoai Nam
            * @name 	pagingByAjaxSearch
            * @todo 	Paging by ajax
            * @param
            * @return
            */
            function pagingByAjaxSearch(){
                $("#txtDateFrom").change(function(){
                    var lastloginto = $("#txtDateTo").val();
                    var lastloginfrom = $("#txtDateFrom").val();
                    if(lastloginfrom!="" && !lastloginfrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                        alert("日付が正しくありません。再入力してください。");
                        $('#txtDateFrom').val("");
                    }
                    if(lastloginto!=null){
                       // $.datepicker.parseDate("yy/mm/dd", lastloginto)
                       // $.datepicker.parseDate("yy/mm/dd", lastloginfrom)
                        if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
                        alert("日付範囲は無効です。終了日は開始日より後になります。")
                        document.getElementById("txtDateFrom").value = "";
                        return false;
                        }
                    }
                })
                $("#txtDateTo").change(function(){
                    var lastloginto = $("#txtDateTo").val();
                    var lastloginfrom = $("#txtDateFrom").val();
                     if(lastloginto!="" && !lastloginto.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                        alert("日付が正しくありません。再入力してください。");
                        $('#txtDateTo').val("");
                    }
                    if(lastloginfrom!=null){
                       // $.datepicker.parseDate("yy/mm/dd", lastloginto)
                       // $.datepicker.parseDate("yy/mm/dd", lastloginfrom)
                        if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
                        alert("日付範囲は無効です。終了日は開始日より後になります。")
                        document.getElementById("txtDateTo").value = "";
                        return false;
                        }
                    }
                })
                $("#jquery_link_seachApp a").click(function(){
                        var url = $(this).attr("href");
                        var dateFrom = $("#txtDateFrom").val();
                        var dateTo = $("#txtDateTo").val();
                        $.ajax({
                                type:"post",
                                url: url,
                                data: "ajax=0"+"&txtDateFrom="+dateFrom+"&txtDateTo="+dateTo,
                                async: true,
                                success: function(kq){
                                        $("#content").html(kq);

                                }
                        })
                        return false;
                })
                 $("#jquery_link_seachSends a").click(function(){
                        var url = $(this).attr("href");
                        var dateFrom = $("#txtDateFrom").val();
                        var dateTo = $("#txtDateTo").val();
                        $.ajax({
                                type:"post",
                                url: url,
                                data: "ajax=0"+"&txtDateFrom="+dateFrom+"&txtDateTo="+dateTo,
                                async: true,
                                success: function(kq){
                                        $("#content").html(kq);

                                }
                        })
                        return false;
                })
                $("#jquery_link_seachCelebration a").click(function(){
                        var url = $(this).attr("href");
                        var dateFrom = $("#txtDateFrom").val();
                        var dateTo = $("#txtDateTo").val();
                        var sl = $("#selectList").val();
                        $.ajax({
                                type:"post",
                                url: url,
                                data: "ajax=0"+"&txtDateFrom="+dateFrom+"&txtDateTo="+dateTo+"&selectList="+sl,
                                async: true,
                                success: function(kq){
                                        $("#content").html(kq);

                                }
                        })
                        return false;
                })

            }
            /*
             * @author  [IVS] Ho Quoc Huy
             * @name 	AddText
             * @todo 	Add Text after current cursor in textarea
             * @param
             * @return
            */
            function addText(){
            $('#btnReplace').click(function() {
                if($('#sltOptions').val()==null) {
                    alert("対象を選択して下さい。");
                    return;
            }
                var text = "/--"+$('#sltOptions').val()+"--/";
                var element = document.getElementById("context");
                if (document.selection) {
                    element.focus();
                    var sel = document.selection.createRange();
                    sel.text = text;
                    element.focus();
                } else if (element.selectionStart || element.selectionStart === 0) {
                    var startPos = element.selectionStart;
                    var endPos = element.selectionEnd;
                    var scrollTop = element.scrollTop;
                    element.value = element.value.substring(0, startPos) + text + element.value.substring(endPos, element.value.length);
                    element.focus();
                    element.selectionStart = startPos + text.length;
                    element.selectionEnd = startPos + text.length;
                    element.scrollTop = scrollTop;
                } else {
                    element.value += text;
                    element.focus();
                }
            })
          }

//            var scrollPos = txtarea.scrollTop;
//            var strPos = 0;
//            var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
//                "ff" : (document.selection ? "ie" : false ) );
//            if (br == "ie") {
//                txtarea.focus();
//                var range = document.selection.createRange();
//                range.moveStart ('character', -txtarea.value.length);
//                strPos = range.text.length;
//            }
//            else if (br == "ff") strPos = txtarea.selectionStart;
//
//            var front = (txtarea.value).substring(0,strPos);
//            var back = (txtarea.value).substring(strPos,txtarea.value.length);
//            txtarea.value=front+text+back;
//            strPos = strPos + text.length;
//
//            if (br == "ie") {
//                txtarea.focus();
//                var range = document.selection.createRange();
//                range.moveStart ('character', -txtarea.value.length);
//                range.moveStart ('character', strPos);
//                range.moveEnd ('character', 0);
//                range.select();
//
//            }
//            else if (br == "ff") {
//                txtarea.selectionStart = strPos;
//                txtarea.selectionEnd = strPos;
//                txtarea.focus();
//
//            }
//            txtarea.scrollTop = scrollPos;
//
//                })
//                return;
//
//        }

    /*
     * @author  [IVS] Nguyen Minh Ngoc
     * @name    updatePoint
     * @todo 	 update record in mst_point_masters
     * @param
     * @return
    */
   function updatePoint(){
       var base = $("#base").attr("value");
       $("a.update").click(function(){
                  var id=$(this).attr("id");
                  var amount = $("#a"+id).val();
                  var point = $("#p"+id).val();
                  var method = $("#slt"+id).val();
                  $.ajax({
                      url:base+"index.php/admin/setting/updatePoint",
                      type:"post",
                      data:"id="+id+"&amount="+amount+"&point="+point+"&method="+method,
                      async:true,
                      success:function(kq){
                          if(kq != "false"){
                              alert("update success");
                          }else{
                              alert("The amount and money is exist");
                              window.location=base+"index.php/admin/setting/point";
                          }

                      }
                  });
       });
   }
   /*
     * @author  [IVS] Nguyen Minh Ngoc
     * @name     deletePoint
     * @todo 	  delete record in mst_point_masters
     * @param
     * @return
    */
    function deletePoint(){
        var base = $("#base").attr("value");
         $("a.delete").click(function(){
            var id=$(this).attr("id");
            var bol=window.confirm('登録しますか？');
            if(bol==true){
            $.ajax({
              url:base+"index.php/admin/setting/deletePoint",
              type:"post",
              data:"id="+id,
              async:true,
              success:function(kq){
                     window.location=base+"index.php/admin/setting/comp";
              }

          });
            }
         });
    }
/*
    * @author  [IVS] Nguyen Minh Ngoc
    * @name 	Paging
    * @todo 	Paging by ajax
    * @param
    * @return
    */

        function pagingByAjax_nm(){
            $("#pagi a").click(function(){
            var url = $(this).attr("href");
             var email = $("#mn_txtEmailAddress").val();
             var unique = $("#mn_txtunique_id").val();
             var name = $("#mn_txtname").val();
             var web = $("#mn_sltwebs").val();
             var acname = $("#mn_txtaccountname").val();
             var f_dktam = $("#mn_txtf_dktam").val();
             var t_dktam = $("#mn_txtt_dktam").val();
             var f_dk = $("#mn_txtf_dk").val();
             var t_dk = $("#mn_txtt_dk").val();
             var mail = $("#mn_sltmail").val();
             var status = $("#mn_sltstatus").val();
             var memo = $("#mn_txtmemo").val();
             var tel_num = $("#txttelephone").val();
             var tel_record = $("#txttelrecord").val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtEmailAddress="+email+"&txtunique_id="+unique+"&txtname="+name+"&sltwebs="+web+
                            "&txtaccountname="+acname+"&txtf_dktam="+f_dktam+"&txtt_dktam="+t_dktam+"&txtf_dk="+f_dk+
                            "&txtt_dk="+t_dk+"&sltmail="+mail+"&sltstatus="+status+"&txtmemo="+memo+"&txttelephone="+tel_num+"&txttelrecord="+tel_record,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                    }
            })
            return false;
        })
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     displayPopupError
     * @todo
     * @param
     * @return
    */
    function displayPopupError(){
        var div_error = $(".hide-error");
        if(div_error.length > 0){
            var error = div_error.text();
            if(error!=""){
                alert(error);
            }
        }
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     moveTreatmentUp
     * @todo 	  move record up
     * @param
     * @return
    */
    function moveTreatmentUp(){
        var base = $("#base").attr("value");
        $("a.treat_up").click(function(){
             var id=$(this).attr("id");
             $.ajax({
                  url:base+"index.php/admin/setting/moveUpTreatment",
                  type:"post",
                  data:"id="+id,
                  async:true,
                  success:function(kq){
                      window.location=base+"index.php/admin/setting/editTreatment";
                  }
             });
             return false;
          });
    }
     /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     moveTreatmentDown
     * @todo 	  move record down
     * @param
     * @return
    */
    function moveTreatmentDown(){
        var base = $("#base").attr("value");
        $("a.treat_down").click(function(){
             var id=$(this).attr("id");
            $.ajax({
                  url:base+"index.php/admin/setting/moveDownTreatment",
                  type:"post",
                  data:"id="+id,
                  async:true,
                  success:function(kq){
                      window.location=base+"index.php/admin/setting/editTreatment";
                  }
             });
             return false;
          });
    }
   /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name 	 insertAccount
     * @todo    add record to admin table
     * @param
     * @return
    */
    function insertAccount(){
        var base = $("#base").attr("value");
        var flagInsertAcc = $("#txtFlagInsertAcc").val();
        var username = $("#txtUsername").val();
        var password = $("#txtPassword").val();
        if(flagInsertAcc == 1){
            if(window.confirm('登録しますか？')){
                $('#txtFlagInsertAcc').val("0");
                 $.ajax({
                   url:base+"index.php/admin/setting/doInsertAccount",
                   type:"post",
                   data:"txtUsername="+username+"&txtPassword="+password,
                   async:true,
                   success:function(kq){
                       window.location=base+"index.php/admin/setting/manager";
                   }
                 });
            }
        }
    }

   /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name    deleteAccount
     * @todo 	 delete record in admin table
     * @param
     * @return
    */
    function deleteAccount(){
       var base = $("#base").attr("value");
       $("a.deleteAcc").click(function(){
            if(window.confirm("削除しますか？")){
                var id = $(this).attr("id");
                  $.ajax({
                      url:base+"index.php/admin/setting/doDeleteAccount",
                      type:"post",
                      data:"id="+id,
                      async:true,
                      success:function(kq){
                          if(kq !== "false"){
                              alert("完了しました。");
                              window.location=base+"index.php/admin/setting/manager";
                          }else{
                              alert("アカウントがログイン中ですので、削除できません。!");
                              window.location=base+"index.php/admin/setting/manager";
                          }
                      }
                  });
            }
        });
    }
    /*
     * @author  [IVS] Nguyen Minh Ngoc
     * @name     upRecord
     * @todo 	  change priority of job type
     * @param
     * @return
    */
    function upRecord(){
        var base = $("#base").attr("value");
        $("a.aup").click(function(){
             var id=$(this).attr("id");
             $.ajax({
                  url:base+"index.php/admin/setting/updatePriority",
                  type:"post",
                  data:"id="+id,
                  async:true,
                  success:function(kq){
                      window.location=base+"index.php/admin/setting/category";
                  }
             });
             return false;
          });
    }
     /*
     * @author  [IVS] Nguyen Minh Ngoc
     * @name     downRecord
     * @todo 	 change priority of job type
     * @param
     * @return
    */
    function downRecord(){
        var base = $("#base").attr("value");
        $("a.adown").click(function(){
             var id=$(this).attr("id");
            $.ajax({
                  url:base+"index.php/admin/setting/updatePriority_Down",
                  type:"post",
                  data:"id="+id,
                  async:true,
                  success:function(kq){
                      window.location=base+"index.php/admin/setting/category";
                  }
             });
             return false;
          });
    }
    /*
     * @author  [IVS] Nguyen Minh Ngoc
     * @name     checked
     * @todo 	  check checkbox is checked
     * @param
     * @return
    */
    function checked(){
      var id;
      var str;
      $(".chk").click(function(){
           if ($(this).is(':checked')) {
               str=$("#spid").val();
               id=$(this).attr("id");
                str =str.replace(id,"");
               $("#spid").val(str);

           } else {
               id=$(this).attr("id");
               $("#spid").val($("#spid").val()+" "+id);
           }
      });
    }
    /*
     * @author  [IVS] Nguyen Minh Ngoc
     * @name     deletejob
     * @todo 	  delete record in mst_job_types
     * @param
     * @return
    */
    function deletejob(){
        var base = $("#base").attr("value");
        $("#deljob").click(function(){
             var strup=$("#spid").val();
             strup=strup.split(" ");
             var bol =window.confirm("編集しますか？");
             if(bol==true){
                $.ajax({
                     url:base+"index.php/admin/setting/deleteJobType",
                     type:"post",
                     data:"array="+strup,
                     async:true,
                     success:function(kq){
                         alert(kq);
                         //window.location=base+"index.php/admin/setting/comp";
                     }
                });
             }
             return false;

         });

    }

/*
* @author  [IVS] Ho Quoc Huy
* @name 	setCurrentDate
* @todo 	set current date to send_date
* @param
* @return
*/
    function setCurrentDate(){
    var base = $("#base").attr("value");
        $("#btnSetDate").click(function(){
        $.ajax({
                  url:base+"index.php/admin/mail/getDateTime",
                  type:"post",
                  data:"id",
                  async:true,
                  success:function(kq){
                        var array = kq.split("-");
                        $('#sltYear option[value="'+array[0]+'"]').prop('selected', true);
                        $('#sltMonth option[value="'+array[1]+'"]').prop('selected', true);
                        $('#sltDay option[value="'+array[2]+'"]').prop('selected', true);
                        $('#sltHour option[value="'+array[3]+'"]').prop('selected', true);
                        $('#sltMinute option[value="'+array[4]+'"]').prop('selected', true);
                  }
        })
    })
}
/*
* @author  [IVS] Ho Quoc Huy
* @name 	checkValidateDate
* @todo 	check validate of send_date
* @param
* @return 	result
*/
function checkValidateDate(){
    $("#btnSendMail").click(function(){
    var title = $("#txtTitle").val();
    var listEmail = $("#arrayEmail").val();
    var fromEmail = $("#txtFromEmail").val();
    var context = $("#context").val();
    var base = $("#base").attr("value");
    var year = $("#sltYear").val();
    var month = $("#sltMonth").val();
    var day = $("#sltDay").val();
    var hour = $("#sltHour").val();
    var minute = $("#sltMinute").val();
    // alert(year+" "+month+" "+day);
    if(year%4!=0 && month==2 && day>28){
        alert("Invalidate DateTime1");
    }else if(year%4==0 && month==2 && day>29){
        alert("Invalidate DateTime2");

    }else if((month==4 ||month==6 ||month==9 ||month==11)&&day>30){
        alert("Invalidate DateTime3");

    }
        $.ajax({
                  url:base+"index.php/admin/mail/checkDateTime",
                  type:"post",
                  data:"dataDate="+year+"-"+month+"-"+day+" "+hour+":"+minute+"&listEmail="+listEmail+"&fromEmail="+fromEmail+"&context="+context+"&title="+title,
                  async:true,
                  success:function(kq){

                   alert(kq);
                  }
            });

    });
}


/*
* @author  [IVS] Ho Quoc Huy
* @name 	checkFromDateAndToDate
* @todo 	check Date Range
* @param
* @return
*/
function checkFromDateAndToDate(){

    $("#txtLastLoginFrom").change(function(){
        var lastloginto = $("#txtLastLoginTo").val();
        var lastloginfrom = $("#txtLastLoginFrom").val();
        if(lastloginfrom!="" && !lastloginfrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtLastLoginFrom').val("");
        }
        else if(lastloginto!=null){
            if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtLastLoginFrom").value = "";
            return false;
            }
        }
    })
    $("#txtLastLoginTo").change(function(){
        var lastloginto = $("#txtLastLoginTo").val();
        var lastloginfrom = $("#txtLastLoginFrom").val();
        if(lastloginto!="" && !lastloginto.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtLastLoginTo').val("");
        }
        else if(lastloginfrom!=null){
            if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtLastLoginTo").value = "";
            return false;
            }
        }
    })
        /*
        * @author  [IVS] Nguyen Minh Ngoc
        * @name
        * @todo 	check Date valid and Date Range
        * @param
        * @return
        */
       $("#mn_txtf_dktam").change(function(){
        var lastloginto = $("#mn_txtt_dktam").val();
        var lastloginfrom = $("#mn_txtf_dktam").val();
        if(lastloginfrom!="" && !lastloginfrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
             alert("日付が正しくありません。再入力してください。");
             $("#mn_txtf_dktam").val("");
         }
        else if(lastloginto!=null){
            if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("mn_txtf_dktam").value = "";
            return false;
            }
        }
    })
    $("#mn_txtt_dktam").change(function(){
        var lastloginto = $("#mn_txtt_dktam").val();
        var lastloginfrom = $("#mn_txtf_dktam").val();
            if(lastloginto!="" && !lastloginto.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#mn_txtt_dktam").val("");
            }
        else if(lastloginfrom!=null){
            if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("mn_txtf_dktam").value = "";
            return false;
            }
        }
    })
     $("#mn_txtf_dk").change(function(){
        var lastloginto = $("#mn_txtt_dk").val();
        var lastloginfrom = $("#mn_txtf_dk").val();
        if(lastloginfrom!="" && !lastloginfrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
             alert("日付が正しくありません。再入力してください。");
             $("#mn_txtf_dk").val("");
         }
        else if(lastloginto!=null){
            if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("mn_txtf_dk").value = "";
            return false;
            }
        }
    })
    $("#mn_txtt_dk").change(function(){
        var lastloginto = $("#mn_txtt_dk").val();
        var lastloginfrom = $("#mn_txtf_dk").val();
            if(lastloginto!="" && !lastloginto.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#mn_txtt_dk").val("");
            }
        else if(lastloginfrom!=null){
            if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("mn_txtf_dk").value = "";
            return false;
            }
        }
    })

}
/*
* @author  [IVS] Ho Quoc Huy
* @name 	Paging
* @todo 	Paging by ajax
* @param
* @return
*/
function pagingByAjax(){
    $("#jquery_link_user a").click(function() {
        var url = $(this).attr("href");
        var form_data = $("form" ).serialize();
        var sltStatus = $("#sltStatusOfRegistration").val();
        $.ajax({
            type: "post",
            url: url,
            data: 'ajax=0&' + form_data,
            async: true,
            success: function(kq){
                $('#sltStatusOfRegistration option[value="'+sltStatus+'"]').prop('selected', true);
                $("#content").html(kq);
            }
        })
        return false;
    })
    $("#jquery_link_log a").click(function(){
        var url = $(this).attr("href");
        var lastloginto = $("#txtLastLoginTo").val();
        var lastloginfrom = $("#txtLastLoginFrom").val();
        $.ajax({
            type: "post",
            url: url,
            data: "ajax=0"+"&txtLastLoginTo="+lastloginto+"&txtLastLoginFrom="+lastloginfrom,
            async: true,
            success: function(kq){
                $("#content").html(kq);
            }
        })
        return false;
    })
//     $("#jquery_link_news a").click(function(){
//    var url = $(this).attr("href");
//    var txtDate = $("#txtDate").val();
//    var txtTitle = $("#txtTitle").val();
//    var txtContent = $("#txtContent").val();
//    var txtFlag = $("#txtFlag").val();
//    //alert("aaaaa");
//        $.ajax({
//            type: "post",
//            url: url,
//            data: "ajax=0"+"&txtDate="+txtDate+"&txtTitle="+txtTitle+"&txtContent="+txtContent+"&txtFlag="+txtFlag,
//            async: true,
//            success: function(kq){
//                    $("#content").html(kq);
//            }
//        })
//    return false;
//    })
     $("#jquery_link a").click(function(){
		var url = $(this).attr("href");
                 var email = $("#txtEmailAddress").val();
                 var name = $("#txtStoreName").val();
                 var lastloginto = $("#txtLastLoginTo").val();
                 var lastloginfrom = $("#txtLastLoginFrom").val();
                 var note = $("#txtNote").val();
                 var sltShopClubs = $("#sltShopClubs").val();
		$.ajax({
			type: "post",
			url: url,
			data: "ajax=0"+"&txtEmailAddress="+email+"&txtStoreName="+name+"&txtLastLoginTo="+lastloginto+"&txtLastLoginFrom="+lastloginfrom+"&txtNote="+note+"&sltShopClubs="+sltShopClubs,
			async: true,
			success: function(kq){
				$("#content").html(kq);

			}
		})
		return false;
                })

}


/*
* @author  [IVS] Ho Quoc Huy
* @name 	upDateMessageContent
* @todo 	upDate Message (sent_date , content , title) by ID
* @param
* @return 	result
*/
function upDateMessageContent(){

    $("#btnUpdate_h").click(function(){
        ans = confirm('邱ｨ髮・＠縺ｾ縺吶?');
        if(ans==true){
        var messageID = $("#txtMessageID").val();
        var templateType = $("#txtTemplateType").val();
        var templateID = $("#txtTemplateID").val();
        var title = $("#txtTitle").val();
        var content = $("#txtContent").val();
        var base = $("#base").attr("value");
        var year = $("#sltYear").val();
        var month = $("#sltMonth").val();
        var day = $("#sltDay").val();
        var hour = $("#sltHour").val();
        var minute = $("#sltMinute").val();
        if(year%4!=0 && month==2 && day>28){
            alert("Invalidate DateTime1");
            return false;
        }else if(year%4==0 && month==2 && day>29){
            alert("Invalidate DateTime2");
            return false;
        }else if((month==4 ||month==6 ||month==9 ||month==11)&&day>30){
            alert("Invalidate DateTime3");
            return false;
        }else{
              $.ajax({
                      url:base+"index.php/admin/mail/checkDateTimeOfLog",
                      type:"post",
                      data:"dataDate="+year+"-"+month+"-"+day+" "+hour+":"+minute+"&content="+content+"&title="+title+"&messageID="+messageID+"&templateType="+templateType+"&templateID="+templateID,
                      async:true,
                      success:function(kq){

                       alert(kq);
                      }
            });
        }

        }
    })
}


/*
* @author  [IVS] Ho Quoc Huy
* @name 	deactiveMessage
* @todo 	deactive Message by ID (list owner/user message ) type = 0 =>user , type = 1 =>owner
* @param
* @return 	result
*/
function deactiveMessage(){

    $("#btnDeactive_h").click(function(){
        ans = confirm('取消しますか？');
        var base = $("#base").attr("value");
        var messageID = $("#txtMessageID").val();
        var templateType = $("#txtTemplateType").val();
        if(ans==true){
            $.ajax({
                      url:base+"index.php/admin/mail/deactiveMessage",
                      type:"post",
                      data:"messageID="+messageID+"&templateType="+templateType,
                      async:true,
                      success:function(kq){
                          window.location=base+"index.php/admin/mail/deactiveMail";

                      }
            });
        }
    })
}
/*
     * @author  [IVS] Nguyen Minh Ngoc
     * @name     aprovideUS
     * @todo 	  approvide user
     * @param
     * @return
    */
    function aprovideUS(){
        var base = $("#base").attr("value");
        $(".a_apro").click(function(){
          var id =$(this).attr("id");
          var bol =window.confirm("本登録に切り替えますか?")
          if(bol==true){
                $.ajax({
                     url:base+"admin/search/approveUS",
                     type:"post",
                     data:"uid="+id,
                     async:true,
                     success:function(kq){
                         window.location=base+"index.php/admin/search/complete";
                     }
                });
                return false;
          }
       });
    }

    /*
     * @author  [IVS] Ho Quoc Huy
     * @name     checkValidation
     * @todo 	  check Validation to Update mst_templates
     * @param
     * @return
    */
    function checkValidation(){
         var messageID = $("#txtFlag").val();
               var title=$("#txtTitle").val();
               var content=$("#context").val();
               var type=$("#type").val();
                var mail=$("#txtFromEmail").val();
               var base = $("#base").attr("value");
               //alert(messageID);
               if(messageID==11){
                   if(window.confirm('登録しますか？')){

                $('#txtFlag').val("00");
                        $.ajax({
                          url:base+"index.php/admin/maillan/updateTemplatebyType",
                          type:"post",
                          data:"txtTitle="+title+"&context="+content+"&type="+type+"&txtFromEmail="+mail,
                          async:true,
                          success:function(kq){
                              window.location=base+"index.php/admin/maillan/maillanComp";
                                    }
                        });
                   }
         }
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     checkValidationHour
     * @todo 	  check Validation to insert mst_hourly_salaries
     * @param
     * @return
    */
    function checkValidationHour(){
        var base = $("#base").attr("value");
        var flagHour = $("#txtFlagHour").val();
        var amountHour = $("#txtAmountHour").val();
        if(flagHour == 1){
            if(window.confirm('登録しますか？')){
                   $('#txtFlagHour').val("0");
                 $.ajax({
                   url:base+"index.php/admin/setting/doInsertHour",
                   type:"post",
                   data:"txtAmountHour="+amountHour,
                   async:true,
                   success:function(kq){
                       window.location=base+"index.php/admin/setting/comp";
                   }
                 });
            }
        }
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     checkValidationMonth
     * @todo 	  check Validation to insert mst_monthly_salaries
     * @param
     * @return
    */
    function checkValidationMonth(){
        var base = $("#base").attr("value");
        var flagMonth = $("#txtFlagMonth").val();
        var amountMonth = $("#txtAmountMonth").val();
        if(flagMonth == 1){
            if(window.confirm('登録しますか？')){
                $('#txtFlagMonth').val("0");
                 $.ajax({
                   url:base+"index.php/admin/setting/doInsertMonth",
                   type:"post",
                   data:"txtAmountMonth="+amountMonth,
                   async:true,
                   success:function(kq){
                       window.location=base+"index.php/admin/setting/comp";
                   }
                 });
            }
        }
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     checkValidationTreatment
     * @todo 	  check Validation to insert mst_treatments
     * @param
     * @return
    */
    function checkValidationTreatment(){
        var base = $("#base").attr("value");
        var flagTreatment = $("#txtFlagTreatment").val();
        var nameTreatment = $("#txtNameTreatment").val();
        if(flagTreatment == 1){
            if(window.confirm('登録しますか？')){
                 $('#txtFlagTreatment').val("0");
                 $.ajax({
                   url:base+"index.php/admin/setting/doInsertTreatment",
                   type:"post",
                   data:"txtNameTreatment="+nameTreatment,
                   async:true,
                   success:function(kq){
                       window.location=base+"index.php/admin/setting/comp";
                   }
                 });
            }
        }
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     checkValidationBeforeInsertOwnerCode
     * @todo 	  check Validation before insert
     * @param
     * @return
    */
    function checkValidationBeforeInsertOwnerCode(){
        var base = $("#base").attr("value");
        var flagOC = $("#txtFlagOC").val();
        var nameOC = $("#txtNameOC").val();
        var codeOC = $("#txtCodeOC").val();
        if(flagOC == 1){
            if(window.confirm('登録しますか？')){
                  $('#txtFlagOC').val("0");
                 $.ajax({
                   url:base+"index.php/admin/setting/doInsertOwnerCode",
                   type:"post",
                   data:"txtNameOC="+nameOC+"&txtCodeOC="+codeOC,
                   async:true,
                   success:function(kq){
                       window.location=base+"index.php/admin/setting/comp";
                   }
                 });
            }
        }
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     checkValidationBeforeDeleteOwnerCode
     * @todo 	  check Validation before delete
     * @param
     * @return
    */
    function checkValidationBeforeDeleteOwnerCode(){
        var base = $("#base").attr("value");
        var flagCheckboxOC = $("#txtFlagCheckboxOC").val();
        var errorOC = $("#txtErrorOC").val();
        var arrayOC = $("#txtArrayOC").val();
        if(flagCheckboxOC == 2){
            if(window.confirm('削除しますか？')){
                $('#txtFlagCheckboxOC').val("0");
                 $.ajax({
                    url:base+"index.php/admin/setting/doDeleteOwnerCode",
                    type:"post",
                    data:"txtArrayOC="+arrayOC,
                    async:true,
                    success:function(){
                        window.location=base+"index.php/admin/setting/comp";
                    }
                  });
            }
        }
        if(flagCheckboxOC == 1){
            alert(errorOC);
        }
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     checkValidationBeforeInsertUserCode
     * @todo 	  check Validation before insert
     * @param
     * @return
    */
    function checkValidationBeforeInsertUserCode(){
        var base = $("#base").attr("value");
        var flagUC = $("#txtFlagUC").val();
        var nameUC = $("#txtNameUC").val();
        var codeUC = $("#txtCodeUC").val();
        if(flagUC == 1){
            if(window.confirm('登録しますか？')){
                 $('#txtFlagUC').val("0");
                 $.ajax({
                   url:base+"index.php/admin/setting/doInsertUserCode",
                   type:"post",
                   data:"txtNameUC="+nameUC+"&txtCodeUC="+codeUC,
                   async:true,
                   success:function(kq){
                       window.location=base+"index.php/admin/setting/comp";
                   }
                 });
            }
        }
    }
    /*
     * @author  [IVS] Nguyen Hoai Nam
     * @name     checkValidationBeforeDeleteUserCode
     * @todo 	  check Validation before delete
     * @param
     * @return
    */
    function checkValidationBeforeDeleteUserCode(){
        var base = $("#base").attr("value");
        var flagCheckboxUC = $("#txtFlagCheckboxUC").val();
        var errorUC = $("#txtErrorUC").val();
        var arrayUC = $("#txtArrayUC").val();
        if(flagCheckboxUC == 2){
            if(window.confirm('削除しますか？')){
                $('#txtFlagCheckboxUC').val("0");
                 $.ajax({
                    url:base+"index.php/admin/setting/doDeleteUserCode",
                    type:"post",
                    data:"txtArrayUC="+arrayUC,
                    async:true,
                    success:function(){
                        window.location=base+"index.php/admin/setting/comp";
                    }
                  });
            }
        }
        if(flagCheckboxUC == 1){
            alert(errorUC);
        }
    }



        /*
     * @author  [IVS] Ho Quoc Huy
     * @name     checkFlag
     * @todo 	  check Validation to insert mailqueue
     * @param
     * @return
    */
    function checkFlag(){
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var context =$("#context").val();
        var title =$("#txtTitle").val();
        var listEmail =$("#arrayEmail").val();
        var send_date =$("#txtDate").val();
        var fromEmail =$("#txtFromEmail").val();
        var list = listEmail.split(",");
        var count = list.length;
              var array1 =$("#txtDate").val();
              array = array1.split(" ");
              temparray1 = array[0].split("-");
              temparray2 = array[1].split(":");
                        $('#sltYear option[value="'+temparray1[0]+'"]').prop('selected', true);
                        $('#sltMonth option[value="'+temparray1[1]+'"]').prop('selected', true);
                        $('#sltDay option[value="'+temparray1[2]+'"]').prop('selected', true);
                        $('#sltHour option[value="'+temparray2[0]+'"]').prop('selected', true);
                        $('#sltMinute option[value="'+temparray2[1]+'"]').prop('selected', true);
        var type =$("#txtType").val();
              if(flag==11){
              var mess =$("#txtMessage").val();
              alert(mess);

              }else if (flag==22){
                    if(window.confirm('送信しますか？')){
                        $('#txtFlag').val("00");
                         $.ajax({
                           url:base+"index.php/admin/mail/insertToMailQueue",
                           type:"post",
                           data:"context="+context+"&txtTitle="+title+"&arrayEmail="+listEmail+"&txtDate="+send_date+"&txtFromEmail="+fromEmail+"&type="+type,
                           async:true,
                           success:function(kq){
                               window.location=base+"index.php/admin/mail/mailcomp/"+count;
                           }
                         });
                    }
              }

    }

    function userNewMailQueue() {
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var context =$("#context").val();
        var title =$("#txtTitle").val();
        var listEmail =$("#arrayEmail").val();
        //var send_date =$("#txtDate").val();
        var fromEmail =$("#txtFromEmail").val();
        var owner = $('#txtowner').val();
        var list = listEmail.split(",");
        var type =$("#txtType").val();
        var set_send_mail = 0;
        if ($('#set_send_mail').is(':checked')) {
            set_send_mail = 1;
        }
        if(flag==11){
          var mess =$("#txtMessage").val();
          alert(mess);
        }else if (flag==22){
            if(window.confirm('登録しますか？')){
                $('#txtFlag').val("00");
                $.ajax({
                    url:base+"index.php/admin/mail/userNewMailQueue",
                    type:"post",
                    data:"context="+context+"&txtTitle="+title+"&arrayEmail="+listEmail+"&txtFromEmail="+fromEmail+"&type="+type+'&owner='+owner+'&set_send_mail='+set_send_mail,
                    async:true,
                    success:function(kq){
                       window.location=base+"index.php/admin/mail/mailcomp/"+kq;
                    }
                });
            }
        }
    }

    function checkFlag1(){
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var context =$("#context").val();
        var title =$("#txtTitle").val();
        var listEmail =$("#arrayEmail").val();
        //var send_date =$("#txtDate").val();
        var fromEmail =$("#txtFromEmail").val();
        var owner = $('#txtowner').val();
        var list = listEmail.split(",");
        var count = list.length;
        var type =$("#txtType").val();
        var set_send_mail = 0;
        if ($('#set_send_mail').is(':checked')) {
            set_send_mail = 1;
        }
        if(flag==11){
          var mess =$("#txtMessage").val();
          alert(mess);
        }else if (flag==22){
            if(window.confirm('送信しますか？')){
                $('#txtFlag').val("00");
                $.ajax({
                    url:base+"index.php/admin/mail/newsLetter",
                    type:"post",
                    data:"context="+context+"&txtTitle="+title+"&arrayEmail="+listEmail+"&txtFromEmail="+fromEmail+"&type="+type+'&owner='+owner+'&set_send_mail='+set_send_mail,
                    async:true,
                    success:function(kq){
                       window.location=base+"index.php/admin/mail/mailcomp/"+count;
                    }
                });
            }
        }
    }


     function checkFlagLog(){
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var txtContent =$("#txtContent").val();
        var txtTitle =$("#txtTitle").val();
        var messageID =$("#txtMessageID").val();
        var txtDate =$("#txtDate").val();
              if(flag==11){
              var mess =$("#txtMessage").val();
              alert(mess);

              }else if (flag==22){
                    if(window.confirm('編集しますか？')){
                          $('#txtFlag').val("00");
                         $.ajax({
                           url:base+"index.php/admin/mail/insertToListMessage",
                           type:"post",
                           data:"txtContent="+txtContent+"&txtTitle="+txtTitle+"&messageID="+messageID+"&txtDate="+txtDate,
                           async:true,
                           success:function(kq){
                               window.location=base+"admin/mail/sendcomp";
                           }
                         });
                    }
              }
    }

            /*
     * @author  [IVS] Ho Quoc Huy
     * @name     checkFlag_NewsForOwner
     * @todo 	  checkFlag_ insert news for owner
     * @param
     * @return
    */
    function checkFlag_NewsForOwner(){
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var txtContent =$("#txtContent").val();
        var txtTitle =$("#txtTitle").val();
        var txtDate =$("#txtDate").val();
        var array1 =$("#txtDate").val();
              array = array1.split("-");
                        $('#sltYear option[value="'+array[0]+'"]').prop('selected', true);
                        $('#sltMonth option[value="'+array[1]+'"]').prop('selected', true);
                        $('#sltDay option[value="'+array[2]+'"]').prop('selected', true);
              if(flag==11){
              var mess =$("#txtMessage").val();
              alert(mess);

              }else if (flag==22){
                    if(window.confirm('ニュースを追加しますか？')){
                        $('#txtFlag').val("00");
                         $.ajax({
                           url:base+"index.php/admin/news/insertToMst_News",
                           type:"post",
                           data:"txtContent="+txtContent+"&txtTitle="+txtTitle+"&newType=1&txtDate="+txtDate,
                           async:true,
                           success:function(kq){

                              window.location=base+"index.php/admin/news/ownerNews";
                           }
                         });
                    }else return false;
              }


    }

    /*
    * @author  [IVS] Nguyen Minh Ngoc
    * @name 	Paging
    * @todo 	Paging by ajax
    * @param
    * @return
    */

        function pagingByAjaxPen_nm(){
            $("#pagipen a").click(function(){
            var url = $(this).attr("href");
             var email = $("#txtpemail").val();
             var store = $("#txtpstore").val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtpemail="+email+"&txtpstore="+store,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                    }
            });
            return false;
        });
    }

                    /*
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkUpdateFlag_NewsForOwnerToUpdate
    * @todo 	check Flag to Update News For Owner (update function )
    * @param
    * @return
    */
     function checkUpdateFlag_NewsForOwnerToInsert(){
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var txtContent =$("#txtContent").val();
        var txtTitle =$("#txtTitle").val();
        var txtDate =$("#txtDate").val();
        var array1 =$("#txtDate").val();
              array = array1.split("-");
                        $('#sltYear option[value="'+array[0]+'"]').prop('selected', true);
                        $('#sltMonth option[value="'+array[1]+'"]').prop('selected', true);
                        $('#sltDay option[value="'+array[2]+'"]').prop('selected', true);
              if(flag==11){
              var mess =$("#txtMessage").val();
              alert(mess);

              }else if (flag==22){
                    if(window.confirm('ニュースを追加しますか？')){
                        $('#txtFlag').val("00");
                         $.ajax({
                           url:base+"index.php/admin/news/insertToMst_News",
                           type:"post",
                           data:"txtContent="+txtContent+"&txtTitle="+txtTitle+"&newType=1&txtDate="+txtDate,
                           async:true,
                           success:function(kq){

                              window.location=base+"index.php/admin/news/ownerNews";
                           }
                         });
                    }else return false;
              }
    }

                /*
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkUpdateFlag_NewsForOwnerToUpdate
    * @todo 	check Flag to Update News For Owner (update function )
    * @param
    * @return
    */
    function checkUpdateFlag_NewsForOwnerToUpdate(){
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var txtContent =$("#txtContent").val();
        var txtTitle =$("#txtTitle").val();
        var txtDate =$("#txtDate").val();
        var txtID =$("#txtID").val();
        var array1 =$("#txtDate").val();
              array = array1.split("-");
                        $('#sltYear option[value="'+array[0]+'"]').prop('selected', true);
                        $('#sltMonth option[value="'+array[1]+'"]').prop('selected', true);
                        $('#sltDay option[value="'+array[2]+'"]').prop('selected', true);
              if(flag==11){
              var mess =$("#txtMessage").val();
              alert(mess);

              }else if (flag==22){
                    if(window.confirm('変更しますか？')){
                        $('#txtFlag').val("00");
                         $.ajax({
                           url:base+"index.php/admin/news/updateNew",
                           type:"post",
                           data:"txtContent="+txtContent+"&txtTitle="+txtTitle+"&txtDate="+txtDate+"&txtID="+txtID,
                           async:true,
                           success:function(kq){

                              window.location=base+"index.php/admin/news/newsComp";
                           }
                         });
                    }else return false;
              }
    }

            /*
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkUpdateFlag_NewsForUserToInsert
    * @todo 	check Flag to Update News For User (insert function )
    * @param
    * @return
    */
    function checkUpdateFlag_NewsForUserToInsert(){
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var txtContent =$("#txtContent").val();
        var txtTitle =$("#txtTitle").val();
        var txtDate =$("#txtDate").val();
        var array1 =$("#txtDate").val();
              array = array1.split("-");
                        $('#sltYear option[value="'+array[0]+'"]').prop('selected', true);
                        $('#sltMonth option[value="'+array[1]+'"]').prop('selected', true);
                        $('#sltDay option[value="'+array[2]+'"]').prop('selected', true);
              if(flag==11){
              var mess =$("#txtMessage").val();
              alert(mess);

              }else if (flag==22){
                    if(window.confirm('ニュースを追加しますか？')){
                        $('#txtFlag').val("00");
                         $.ajax({
                           url:base+"index.php/admin/news/insertToMst_News",
                           type:"post",
                           data:"txtContent="+txtContent+"&txtTitle="+txtTitle+"&newType=0&txtDate="+txtDate,
                           async:true,
                           success:function(kq){

                              window.location=base+"index.php/admin/news/userNews";
                           }
                         });
                    }else return false;
              }
    }

        /*
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkUpdateFlag_NewsForUserToUpdate
    * @todo 	check Flag to Update News For User  (update function )
    * @param
    * @return
    */
    function checkUpdateFlag_NewsForUserToUpdate(){
        var base = $("#base").attr("value");
        var flag =$("#txtFlag").val();
        var txtContent =$("#txtContent").val();
        var txtTitle =$("#txtTitle").val();
        var txtDate =$("#txtDate").val();
        var txtID =$("#txtID").val();
        var array1 =$("#txtDate").val();
              array = array1.split("-");
                        $('#sltYear option[value="'+array[0]+'"]').prop('selected', true);
                        $('#sltMonth option[value="'+array[1]+'"]').prop('selected', true);
                        $('#sltDay option[value="'+array[2]+'"]').prop('selected', true);
              if(flag==11){
              var mess =$("#txtMessage").val();
              alert(mess);

              }else if (flag==22){
                    if(window.confirm('変更しますか？')){
                        $('#txtFlag').val("00");
                         $.ajax({
                           url:base+"index.php/admin/news/updateNew",
                           type:"post",
                           data:"txtContent="+txtContent+"&txtTitle="+txtTitle+"&txtDate="+txtDate+"&txtID="+txtID,
                           async:true,
                           success:function(kq){

                              window.location=base+"index.php/admin/news/newsComp";
                           }
                         });
                    }else return false;
              }
    }
    /*
    * @author  [IVS] Nguyen Hoai Nam
    * @name 	pagingByAjaxSearchOwnerApproved
    * @todo 	Paging by ajax
    * @param
    * @return
    */
    function pagingByAjaxSearchOwnerApproved(){
        $("#txtDateFrom").change(function(){
            var lastloginto = $("#txtDateTo").val();
            var lastloginfrom = $("#txtDateFrom").val();
            if(lastloginfrom!="" && !lastloginfrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#txtDateFrom").val("");
            }
        else if(lastloginto!=null){
               // $.datepicker.parseDate("yy/mm/dd", lastloginto)
               // $.datepicker.parseDate("yy/mm/dd", lastloginfrom)
                if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
                alert("日付範囲は無効です。終了日は開始日より後になります。")
                document.getElementById("txtDateFrom").value = "";
                return false;
                }
            }
        })
        $("#txtDateTo").change(function(){
            var lastloginto = $("#txtDateTo").val();
            var lastloginfrom = $("#txtDateFrom").val();
            if(lastloginto!="" && !lastloginto.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#txtDateTo").val("");
            }
        else if(lastloginfrom!=null){
               // $.datepicker.parseDate("yy/mm/dd", lastloginto)
               // $.datepicker.parseDate("yy/mm/dd", lastloginfrom)
                if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
                alert("日付範囲は無効です。終了日は開始日より後になります。")
                document.getElementById("txtDateTo").value = "";
                return false;
                }
            }
        })
        $("#jquery_link_searchOwnerApproved a").click(function(){
                var url = $(this).attr("href");
                var ownerEmail = $("#txtOwnerEmail").val();
                var ownerName = $("#txtOwnerName").val();
                var dateFrom = $("#txtDateFrom").val();
                var dateTo = $("#txtDateTo").val();
                $.ajax({
                        type:"post",
                        url: url,
                        data: "ajax=0"+"&txtOwnerEmail="+ownerEmail+"&txtOwnerName="+ownerName+"&txtDateFrom="+dateFrom+"&txtDateTo="+dateTo,
                        async: true,
                        success: function(kq){
                                $("#content").html(kq);
                        }
                })
                return false;
        })
    }
    /*
    * @author  [IVS] Nguyen Hoai Nam
    * @name 	pagingByAjaxSearchOwnerUnapproved
    * @todo 	Paging by ajax
    * @param
    * @return
    */
    function pagingByAjaxSearchOwnerUnapproved(){
        $("#txtDateFrom").change(function(){
            var lastloginto = $("#txtDateTo").val();
            var lastloginfrom = $("#txtDateFrom").val();
            if(lastloginfrom!="" && !lastloginfrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#txtDateFrom").val("");
            }
        else if(lastloginto!=null){
               // $.datepicker.parseDate("yy/mm/dd", lastloginto)
               // $.datepicker.parseDate("yy/mm/dd", lastloginfrom)
                if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
                alert("日付範囲は無効です。終了日は開始日より後になります。")
                document.getElementById("txtDateFrom").value = "";
                return false;
                }
            }
        })
        $("#txtDateTo").change(function(){
            var lastloginto = $("#txtDateTo").val();
            var lastloginfrom = $("#txtDateFrom").val();
            if(lastloginto!="" && !lastloginto.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#txtDateTo").val("");
            }
        else if(lastloginfrom!=null){
               // $.datepicker.parseDate("yy/mm/dd", lastloginto)
               // $.datepicker.parseDate("yy/mm/dd", lastloginfrom)
                if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
                alert("日付範囲は無効です。終了日は開始日より後になります。")
                document.getElementById("txtDateTo").value = "";
                return false;
                }
            }
        })
        $("#jquery_link_searchOwnerUnapproved a").click(function(){
                var url = $(this).attr("href");
                var ownerEmail = $("#txtOwnerEmail").val();
                var ownerName = $("#txtOwnerName").val();
                var dateFrom = $("#txtDateFrom").val();
                var dateTo = $("#txtDateTo").val();
                $.ajax({
                        type:"post",
                        url: url,
                        data: "ajax=0"+"&txtOwnerEmail="+ownerEmail+"&txtOwnerName="+ownerName+"&txtDateFrom="+dateFrom+"&txtDateTo="+dateTo,
                        async: true,
                        success: function(kq){
                                $("#content").html(kq);
                        }
                })
                return false;
        })
    }
    /*
    * @author  [IVS] Nguyen Hoai Nam
    * @name 	pagingByAjaxSearchApplication
    * @todo 	Paging by ajax
    * @param
    * @return
    */
    function pagingByAjaxSearchApplication(){
        $("#txtDateFrom").change(function(){
                    var lastloginto = $("#txtDateTo").val();
                    var lastloginfrom = $("#txtDateFrom").val();
                    if(lastloginfrom!="" && !lastloginfrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#txtDateFrom").val("");
            }
                    if(lastloginto!=null){
                        if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
                        alert("日付範囲は無効です。終了日は開始日より後になります。")
                        document.getElementById("txtDateFrom").value = "";
                        return false;
                        }
                    }
                })
        $("#txtDateTo").change(function(){
            var lastloginto = $("#txtDateTo").val();
            var lastloginfrom = $("#txtDateFrom").val();
            if(lastloginto!="" && !lastloginto.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                alert("日付が正しくありません。再入力してください。");
                $("#txtDateTo").val("");
            }
            if(lastloginfrom!=null){
                if (Date.parse(lastloginfrom) > Date.parse(lastloginto)) {
                alert("日付範囲は無効です。終了日は開始日より後になります。")
                document.getElementById("txtDateTo").value = "";
                return false;
                }
            }
        })
        $("#jquery_link_searchApplication a").click(function(){
                var url = $(this).attr("href");
                var ownerEmail = $("#txtOwnerEmail").val();
                var ownerName = $("#txtOwnerName").val();
                var userId = $("#txtUserId").val();
                var userName = $("#txtUserName").val();
                var dateFrom = $("#txtDateFrom").val();
                var dateTo = $("#txtDateTo").val();
                var sl = $("#selectList").val();
                $.ajax({
                        type:"post",
                        url: url,
                        data: "ajax=0"+"&txtOwnerEmail="+ownerEmail+"&txtOwnerName="+ownerName+"&txtUserId="+userId+"&txtUserName="+userName+"&txtDateFrom="+dateFrom+"&txtDateTo="+dateTo+"&selectList="+sl,
                        async: true,
                        success: function(kq){
                                $("#content").html(kq);
                        }
                })
                return false;
        })
    }

           /*
    * @author  [IVS] Ho Quoc Huy
    * @name 	changeSelectOptions
    * @todo 	change Options of sltDay
    * @param
    * @return
    */
    function changeSelectOptions(){
          $("#sltMonth").change(function(){
              var valDay = $("#sltDay").val();
            $('#sltDay option').remove();
            var valMonth = $("#sltMonth").val();
            var valYear = $("#sltYear").val();

               if(valMonth==2 && valYear%4!=0){
                 for(var i = 0;i<=28;i++){
                     if(i<10)
                      $('#sltDay').append($(document.createElement("option")).
                        attr("value","0"+i).text("0"+i));
                    else $('#sltDay').append($(document.createElement("option")).
                        attr("value",i).text(i));
                 }
               }else if(valMonth==2 && valYear%4==0){
                 for(var i = 0;i<=29;i++){
                     if(i<10)
                      $('#sltDay').append($(document.createElement("option")).
                        attr("value","0"+i).text("0"+i));
                    else $('#sltDay').append($(document.createElement("option")).
                        attr("value",i).text(i));
                 }
               }else if(valMonth==4||valMonth==6||valMonth==9||valMonth==11){
                   for(var i = 0;i<=30;i++){
                     if(i<10)
                      $('#sltDay').append($(document.createElement("option")).
                        attr("value","0"+i).text("0"+i));
                    else $('#sltDay').append($(document.createElement("option")).
                        attr("value",i).text(i));
                 }
               }else{
                   for(var i = 0;i<=31;i++){
                     if(i<10)
                      $('#sltDay').append($(document.createElement("option")).
                        attr("value","0"+i).text("0"+i));
                    else $('#sltDay').append($(document.createElement("option")).
                        attr("value",i).text(i));
                }
               }
               $('#sltDay option[value="'+valDay+'"]').prop('selected', true);
        })
        $("#sltYear").change(function(){
              var valDay = $("#sltDay").val();
            $('#sltDay option').remove();
            var valMonth = $("#sltMonth").val();
            var valYear = $("#sltYear").val();

               if(valMonth==2 && valYear%4!=0){
                 for(var i = 0;i<=28;i++){
                     if(i<10)
                      $('#sltDay').append($(document.createElement("option")).
                        attr("value","0"+i).text("0"+i));
                    else $('#sltDay').append($(document.createElement("option")).
                        attr("value",i).text(i));
                 }
               }else if(valMonth==2 && valYear%4==0){
                 for(var i = 0;i<=29;i++){
                     if(i<10)
                      $('#sltDay').append($(document.createElement("option")).
                        attr("value","0"+i).text("0"+i));
                    else $('#sltDay').append($(document.createElement("option")).
                        attr("value",i).text(i));
                 }
               }else if(valMonth==4||valMonth==6||valMonth==9||valMonth==11){
                   for(var i = 0;i<=30;i++){
                     if(i<10)
                      $('#sltDay').append($(document.createElement("option")).
                        attr("value","0"+i).text("0"+i));
                    else $('#sltDay').append($(document.createElement("option")).
                        attr("value",i).text(i));
                 }
               }else{
                   for(var i = 0;i<=31;i++){
                     if(i<10)
                      $('#sltDay').append($(document.createElement("option")).
                        attr("value","0"+i).text("0"+i));
                    else $('#sltDay').append($(document.createElement("option")).
                        attr("value",i).text(i));
                }
               }
               $('#sltDay option[value="'+valDay+'"]').prop('selected', true);
        })
    }

        /*
        * @author       [IVS] Nguyen Van Vui
        * @name 	Paging
        * @todo 	Paging by ajax
        * @param
        * @return
        */

        function pagination_company_kanri(){
            $("#pagination_company_kanri a").click(function(){
                 var url = $(this).attr("href");
                 var email = $("#txtEmail").val();
                 var storeName = $("#txtStoreName").val();
                 var pic = $("#txtPic").val();
                 var ip = $("#txtIP").val();
                 var tel = $("#txtTel").val();
                 var tempRegDateFrom = $("#txtDatePickerCommonFrom").val();
                 var tempRegDateTo = $("#txtDatePickerCommonTo").val();
                 var createdDateFrom = $("#txtDatePickerCommonFrom2").val();
                 var createdDateTo = $("#txtDatePickerCommonTo2").val();
                 var address = $("#txtAddress").val();
                 var memo = $("#txtMemo").val();
                 var ownerStatus = $("#cbOwnerStatus").val();
                 var creditResult = $("#cbCreditResult").val();
                 var website = $("#cbWebsite").val();
                 var rdPublicFlag = $("#rdPublicFlag").val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtEmail="+email+"&txtStoreName="+storeName+"&txtPic="+pic+"&txtIP="+ip+
                            "&txtTel="+tel+"&txtTempRegDateFrom="+tempRegDateFrom+"&txtTempRegDateTo="+tempRegDateTo+"&txtCreatedDateFrom="+createdDateFrom+
                            "&txtCreatedDateTo="+createdDateTo+"&txtAddress="+address+"&txtMemo="+memo+"&cbOwnerStatus="+ownerStatus+"&cbCreditResult="+creditResult+"&cbWebsite="+website+"&rdPublicFlag="+rdPublicFlag,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
             return false;
            });

        };

        /*
        * @author       [IVS] Nguyen Van Vui
        * @name 	Paging
        * @todo 	Paging by ajax
        * @param
        * @return
        */

        function pagination_bank_kanri(){
            $("#pagination_bank_kanri a").click(function(){
                 var url = $(this).attr("href");
                 var email = $("#txtEmail").val();
                 var storeName = $("#txtStoreName").val();
                 var paymentName = $("#txtPaymentName").val();
                 var createDateFrom = $("#txtDatePickerCommonFrom").val();
                 var createDateTo = $("#txtDatePickerCommonTo").val();
                 var paymentStatus = $("#cbPaymentStatus").val();
                 var paymentCase = $("#cbPaymentCase").val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtEmail="+email+"&txtStoreName="+storeName+"&txtPaymentName="+paymentName+
                            "&txtCreateDateFrom="+createDateFrom+"&txtCreateDateTo="+createDateTo+
                            "&cbPaymentStatus="+paymentStatus+"&cbPaymentCase="+paymentCase,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
            return false;
            });
        };

        /*
        * @author       [IVS] Nguyen Van Vui
        * @name 	Paging
        * @todo 	Paging by ajax
        * @param
        * @return
        */

        function pagination_work_kanri(){
            $("#pagination_work_kanri a").click(function(){
                 var url = $(this).attr("href");
                 var email = $("#txtEmail").val();
                 var storeName = $("#txtStoreName").val();
                 var userId = $("#txtUserId").val();
                 var userName = $("#txtUserName").val();
                 var applicationDateFrom = $("#txtDatePickerCommonFrom").val();
                 var applicationDateTo = $("#txtDatePickerCommonTo").val();
                 var cbSelect = $("#cbSelect").val();
                 var ckCheck = $("#cbSelect").val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtEmail="+email+"&txtStoreName="+storeName+"&txtUserId="+userId+"&txtUserName="+userName+
                            "&txtApplicationDateFrom="+applicationDateFrom+"&txtApplicationDateTo="+applicationDateTo+
                            "&cbSelect="+cbSelect+"&ckCheck="+ckCheck,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
            return false;
            });
        };

        /*
        * @author       [IVS] Nguyen Van Vui
        * @name 	Paging
        * @todo 	Paging by ajax
        * @param
        * @return
        */

        function pagination_pointlog_kanri(){
            $("#pagination_pointlog_kanri a").click(function(){
                 var url = $(this).attr("href");
                 var txtEmail = $("#txtEmail").val();
                 var cbPaymentCases = $("#cbPaymentCases").val();
                 var txtCreatedDateFrom = $("#txtDatePickerCommonFrom").val();
                 var txtCreatedDateTo = $("#txtDatePickerCommonTo").val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtEmail="+txtEmail+"&cbPaymentCases="+cbPaymentCases+
                            "&txtCreatedDateFrom="+txtCreatedDateFrom+"&txtCreatedDateTo="+txtCreatedDateTo,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
            return false;
            });
        };

        /*
        * @author       [IVS] Nguyen Van Vui
        * @name 	Paging
        * @todo 	Paging by ajax
        * @param
        * @return
        */

        function pagination_settlementlog_kanri(){
            $("#pagination_settlementlog_kanri a").click(function(){
                 var url = $(this).attr("href");
                 var txtEmail = $("#txtEmail").val();
                 var cbPaymentCases = $("#cbPaymentCases").val();
                 var cbPaymentMethods = $("#cbPaymentMethods").val();
                 var cbCreditResult = $("#cbCreditResult").val();
                 var txtTranferDateFrom = $("#txtDatePickerCommonFrom").val();
                 var txtTranferDateTo = $("#txtDatePickerCommonTo").val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtEmail="+txtEmail+"&cbPaymentCases="+cbPaymentCases+"&cbPaymentMethods="+cbPaymentMethods+"&cbCreditResult="+cbCreditResult+
                            "&txtTranferDateFrom="+txtTranferDateFrom+"&txtTranferDateTo="+txtTranferDateTo,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
            return false;
            });
        };

        /*
        * @author       [IVS] Nguyen Van Vui
        * @name 	Paging
        * @todo 	Paging by ajax
        * @param
        * @return
        */

        function pagination_paid_kanri(){
            $("#pagination_paid_kanri a").click(function(){
                 var url = $(this).attr("href");
                 var txtUniqueId = $("#txtUniqueId").val();
                 var txtAccountName = $("#txtAccountName").val();
                 var txtPaymentDateFrom = $("#txtDatePickerCommonFrom").val();
                 var txtPaymentDateTo = $("#txtDatePickerCommonTo").val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtUniqueId="+txtUniqueId+"&txtAccountName="+txtAccountName+"&txtPaymentDateFrom="+txtPaymentDateFrom+"&txtPaymentDateTo="+txtPaymentDateTo,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
            return false;
            });
        };

        /*
        * @author   [VJS] チャンキムバック
        * @name     change_pay_all
        * @todo     お祝い・採用金変更ボタン処理
        * @param    なし
        * @return   なし
        */

        function change_pay_all(){
            confrm_change = confirm('編集しますか？');
            if(confrm_change == true){
                var form = document.getElementById('change_oiwaipay_all');
                form.style.display = "none";
                var input = document.getElementsByTagName('input');
                var my_inputs       = new Array(); //お祝い金、採用金データ
                var money_no_cnt    = 0; //お祝い金項目数
                var cnt             = 0;
                //console.log(input);
                for (var i=0; i<input.length; i++){
                    name = input[i].name;
                    if ( name != null ){
                        res1 = name.indexOf("joyspe_happy_money_"); //採用金
                        res2 = name.indexOf("user_happy_money_");   //お祝い金
                        res3 = name.indexOf("active_");             //アクティブフラグ
                        res4 = (name == "money_no") ? 0 : -1;
                        if ( res1 >= 0 || res2 >= 0 || res3 >= 0 || res4 >= 0 ){
                            if ( res3 >= 0 && input[i].checked == false){
                                //アクティブがuncheckedの場合、Submitデータに入れない
                                continue;
                            }
                            if ( res4 >= 0 ){　 //お祝い金項目数カウント
                                name = name.concat("_", money_no_cnt);
                                money_no_cnt++;
                            }
                            var item = new Array();
                            item[0] =  name;
                            item[1] =  input[i].value;
                            my_inputs[cnt] = item;
                            cnt++;
                        }
                    }
                }
                if ( money_no_cnt > 0){
                    var my_input = document.createElement('input');
                    my_input.setAttribute('type', 'hidden');
                    my_input.setAttribute('name', "money_no_cnt");
                    my_input.setAttribute('value', money_no_cnt);
                    form.appendChild(my_input);
                    for ( var i=0; i<my_inputs.length; i++){
                        var my_input = document.createElement('input');
                        my_input.setAttribute('type', 'hidden');
                        my_input.setAttribute('name', my_inputs[i][0]);
                        my_input.setAttribute('value', my_inputs[i][1]);
                        form.appendChild(my_input);
                    }
                }
                form.submit();
            }
        }
		function storeKeyword(){
			var base_url= $("#base").attr("value");
			var keyword = $('#searchStore').val();
			$.post(base_url+'admin/mail/storeKeyword',
				   {"keyword":keyword},
				   function(data){
					var stores = $.parseJSON(data);
					$('#owner').empty().append('<option value="">--店舗名一覧--</option>');
					$.each(stores, function(index,value) {
                   		$('#owner').append('<option value="'+value.id+'">'+value.storename+'</option>');
					});
			});

		}
        function pagingAjax(){
            $("#pagination a").click(function(){
               var url = $(this).attr("href");
               var reason = $('#reason').val();
               var email = $('#email').val();
               var unique_id = $('#unique_id').val();
               var dateFrom = $('#txtDateFrom').val();
               var dateTo = $('#txtDateTo').val();
              $.ajax({
                      type: "post",
                      url: url,
                      data: "ajax=0"+"&reason="+reason+"&email="+email+"&unique_id="+unique_id+"&txtDateFrom="+dateFrom+"&txtDateTo="+dateTo,
                      async: true,
                      success: function(kq){
                              $("#content").html(kq);
                      }
              })
              return false;
            });
        }
        function paginationOwner(){
            $("#pagination_owner a").click(function(){
                var url = $(this).attr("href");
                var txtDateFrom = $('#txtDateFrom').val();
                var txtDateTo = $('#txtDateTo').val();
                $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtDateFrom="+txtDateFrom+"&txtDateTo="+txtDateTo,
                    async: true,
                    success: function(kq){
                        $("#content").html(kq);
                    }
                });
                return false;
            });
        }
        function paginationUserStatistics(){
          $("#userStatistics a").click(function(){
              var url = $(this).attr("href");
              var txtDateFrom = $('#txtDateFrom').val();
              var txtDateTo = $('#txtDateTo').val();
              $.ajax({
                  type: "post",
                  url:  url,
                  data: "ajax=0&txtDateFrom="+txtDateFrom+"&txtDateTo="+txtDateTo,
                  async: true,
                  success: function(kq){
                      $('#content').html(kq);
                  }
              });
              return false;
          });
        }

        /*
        * @name 	Paging
        * @todo 	Paging by ajax
        * @param
        * @return
        */

        function pagination_first_messsage_bonus_list(){
            $("#pagination_first_messsage_bonus_list a").click(function(e){
                 var data_ext = '';
                 var url = $(this).attr("href");
                 var member_name = $("#txt_member_name").val();
                 var storename = $("#txt_storename").val();
                 if ($('#chkbox_first_message').is(":checked")) {
                    data_ext = "&chkbox_first_message=" + $("#chkbox_first_message").val();
                 }
                 if ($('#chkbox_public_message').is(":checked")) {
                    data_ext += "&chkbox_public_message=" + $("#chkbox_public_message").val();
                 }
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txt_member_name="+member_name+"&txt_storename="+storename+data_ext,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
             return false;
            });
        }

        /*
        * @name     Paging in request authentication and for bonus
        * @todo     Paging by ajax
        * @param
        * @return
        */
        function pagination_request(){
            $("#pagination_request a").click(function(){
                 var url = $(this).attr("href");
                 var unique_id = $('#txtUserUniqueId').val();
                 var old_id = $('#txtOldId').val();
                 var user_name = $('#txtUsersName').val();
                 var site_type = $('#siteType').val();
                 var bonus_receive_flag = $('#bunosReceivingFlag').val();
                 var agreement_date_from = $('#txtAgreementDateFrom').val();
                 var agreement_date_to = $('#txtAgreementDateTo').val();
                 var receive_bonus_date_from = $('#txtReceiveBonusDateFrom').val();
                 var receive_bonus_date_to = $('#txtReceiveBonusDateTo').val();
                 //from request/bonus
                 var bonus_app_date_from= $('#txtBonusAppDateFrom').val();
                 var bonus_app_date_to= $('#txtBonusAppDateTo').val();
                 var bonus_grant_date_from = $('#txtBonusGrantDateFrom').val();
                 var bonus_grant_date_to = $('#txtBonusGrantDateTo').val();
                 var last_visit_date_from = $('#txtLastVisitDateFrom').val();
                 var last_visit_date_to = $('#txtLastVisitDateTo').val();
                 var telephone_record = $('#phoneDealing').val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtUserUniqueId="+unique_id+"&txtOldId="+old_id+"&txtUsersName="+user_name+"&siteType="+site_type+
                            "&bunosReceivingFlag="+bonus_receive_flag+"&txtAgreementDateFrom="+agreement_date_from+"&txtAgreementDateTo="+agreement_date_to+"&txtReceiveBonusDateFrom="+receive_bonus_date_from+
                            "&txtReceiveBonusDateTo="+receive_bonus_date_to+"&txtBonusAppDateFrom="+bonus_app_date_from+"&txtBonusAppDateTo="+bonus_app_date_to+
                            "&txtBonusGrantDateFrom="+bonus_grant_date_from+"&txtBonusGrantDateTo="+bonus_grant_date_to+"&txtLastVisitDateFrom="+last_visit_date_from+"&txtLastVisitDateTo="+last_visit_date_to+"&phoneDealing="+telephone_record,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
             return false;
            });
        }
        /*
        * @name     Paging in request for makia user
        * @todo     Paging by ajax
        * @param
        * @return
        */
        function pagination_request_makia_user () {
            $("#pagination_request a").click(function(){
                 var url = $(this).attr("href");
                 var unique_id = $('#txtUserUniqueId').val();
                 var user_name = $('#txtUserName').val();
                 var website_type = $('#websiteType').val();
                 var receive_bonus_flag = $('#receivedBonusFlag').val();
                 var received_bonus_date_from = $('#txtReceiveBonusDateFrom').val();
                 var received_bonus_date_to = $('#txtReceiveBonusDateTo').val();
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0"+"&txtUserUniqueId="+unique_id+"&txtUsersName="+user_name+"&websiteType="+website_type+
                            "&receivedBonusFlag="+receive_bonus_flag+"&txtReceiveBonusDateFrom="+received_bonus_date_from+"&txtReceiveBonusDateTo="+received_bonus_date_to,
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
             return false;
            });
        }

        function pagination_user_experience_list(){
            $("#user_exp_pagination a").click(function(e){
                 var url = $(this).attr("href");
            $.ajax({
                    type: "post",
                    url: url,
                    data: "ajax=0",
                    async: true,
                    success: function(kq){
                            $("#content").html(kq);
                        }
                    });
             return false;
            });
        }

        function showExp(id,base_url) {
            $.post(base_url+'admin/experiences/update_show_status',{id:id,status:1},function(data){
                if(data == 1){
                    $('#validation').empty().append('アップデートしました');
                    $('#row_'+id).removeClass('hidden_exp');
                    $('#btn_edit_'+id).attr('disabled',false);
                    $('#btn_show_'+id).attr('disabled',true);
                    $('#btn_not_show_'+id).attr('disabled',false);
                    $('#btn_edit_'+id).wrap('<a href="'+base_url+'admin/experiences/modify/'+id+'" target="_blank"></a>');
                }
            });

        }

        function hideExp(id,base_url) {
            $.post(base_url+'admin/experiences/update_show_status',{id:id,status:0},function(data){
                if(data == 1){
                    $('#validation').empty().append('アップデートしました');
                    $('#row_'+id).addClass('hidden_exp');
                    $('#btn_edit_'+id).attr('disabled',true);
                    $('#btn_show_'+id).attr('disabled',false);
                    $('#btn_not_show_'+id).attr('disabled',true);
                    $('#btn_edit_'+id).unwrap();
                }
            });
        }

        function deleteExp(id,base_url) {
            if(confirm('このを削除してもよろしいですか？')) {
                $.post(base_url+'admin/experiences/delete_experience',{id:id},function(data){
                    if(data == 1) {
                        window.location.reload();
                    }
                });
            }
            
        }

        function editAruaruBonus () {
            var notEmptyField = 0;
            $('#bbsBonusPointSetting input[type="number"]').each(function ()
            {
                if ($.trim(this.value) != "") notEmptyField++;
            });
            if (notEmptyField > 0) {
                var t_bonus = $('#threadCreateBonusPoints').val();
                var c_bonus = $('#commentBonusPoints').val();
                var like_multiply = $('#likePointsMultiplyBy').val();
                var c_like_bonus = $('#commentLikePoints').val();
                var max_comment_bonus = $('#MaxCommentsHasBonus').val();

                if(confirm('編集しますか？')) {
                    $.ajax({
                        type:"post",
                        dataType: "json",
                        url: '/admin/bbs/bonusEdit',
                        data: {threadBonus:t_bonus, commentBonus:c_bonus, likeMultiplyBy:like_multiply, commentLikeBonus:c_like_bonus, maxCommentHasBonus:max_comment_bonus},
                        success: function(response){
                               if (response.status == 'success') {
                                    location.reload();
                               } else if (response.status == 'error') {

                               }
                        }
                    })
                }
            } else {
                return;
            }

        }

        function editOnayamiBonus () {
            var notEmptyField = 0;
            $('#bbsBonusPointSetting input[type="number"]').each(function ()
            {
                if ($.trim(this.value) != "") notEmptyField++;
            });
            if (notEmptyField > 0) {
                var questionBonus = $('#questionBonus').val();
                var ansBonus = $('#answerBonus').val();
                 var multiplyBy = $('#likePointsMultiplyBy').val();
                var evalBonus = $('#evaluateBonus').val(); likePointsMultiplyBy
                var maxAnswerHas = $('#maxAnswerHasBonus').val();

                if(confirm('編集しますか？')) {
                    $.ajax({
                        type:"post",
                        dataType: "json",
                        url: '/admin/onayami/bonusEdit',
                        data: {questionBonus:questionBonus, answerBonus:ansBonus, likePointsMultiplyBy: multiplyBy, evaluateBonus:evalBonus, maxAnswerHasBonus:maxAnswerHas },
                        success: function(response){
                               if (response.status == 'success') {
                                    location.reload();
                               } else if (response.status == 'error') {

                               }
                        }
                    })
                }
            } else {
                return;
            }

        }

        /* prevent inputing non-numeric*/
        $(document).ready(function() {
            $("#bbsBonusPointSetting").keydown(function(event) {
                var key = event.keyCode;
                // Allow only backspace and delete
                if ( key == 46 || key == 8 ) {
                    // let it happen, don't do anything
                }
                else {
                    // Ensure that it is a number and stop the keypress
                    if ((key < 48 || key > 57) && (key < 96 || key > 105 )){
                        event.preventDefault(); 
                    }   
                }
            });

           $('#bbsBonusPointSetting input').keypress(function(event) {
                 if($(this).val().length >= 4 && event.keyCode!=8) {
                    $(this).val($(this).val().slice(0, 4));
                    return false;
                }
            });
        });
