

$(document).ready(function(){

    setTimeout(function(){
    $("#status").html("<i class='bi bi-check2-circle'></i> Page is Ready");
    },1000); 
    setTimeout(function(){
    $("#status").html("What do you want today?");
    },3000); 
    setTimeout(function(){
    $("#status").html("Try clicking on the side bar on your left...");
    },10000); 
     setTimeout(function(){
    $("#status").html("");
    },25000); 
    $("div.progress").hide();
    
    
    
  $("button.acadyearbtn").click(function(){
      var str= $(this).text();
      var i_d = $(this).attr('identifier');
      $("#acadyeardisplay").html(str);
      $("div.collapse.popups").collapse('hide');
      
  }); 
    
    
//    setInterval(function(){
//       
//    if( $("input#session").val() == "" ){
//        $("div#mainContainer").addClass("hidden").hide();
//        $("div#loginContainer").removeClass("hidden").show();
//    }
//    else{
//        $("div#mainContainer").removeClass("hidden").show();
//        $("div#loginContainer").addClass("hidden").hide();
//        
//    }
//       
//   },100);    
//  

  $("a#syslogoff").on("click",function(){
      if(confirm("Do you really want to logoff?") == true){
       $.ajax({ 
        type:"POST",
        url:"inc/syslogoff.php",
        cache:false,
        data: { syslogoff : "logoff" },
        success: function(data){
            
           //$("input#session").val("") ;
           //$("div#mainContainer").hide();
           //$("div#loginContainer").show();
           location.reload();
           
        }
      });
      }
  });
    
  $("form.sys-login").on("click","button.sys-login",function(e){
      e.preventDefault();
      var dta = $("form.sys-login").serializeArray();
      $.ajax({
        beforeSend: function(){
            $("button.sys-login").html("<span class='spinner-border spinner-border-sm' role='status'></span>");
        },  
        type:"POST",
        url:"inc/syslogin.php",
        cache:false,
        data: $.param(dta),
        success: function(data){
            if(data == "1"){
                $("div.progress").show();
                var prog = $("#sysloginprogressbar").attr("aria-valuenow");
                var timer = 0;
                
                
                 setTimeout(function(){
                     $("button.sys-login").removeClass("btn-outline-primary").removeClass("btn-outline-danger").addClass("btn-outline-success").html("<i class='bi bi-check-circle'></i> Successful Login");
                 },500);     
                
                timer = timer + 100;
                setInterval(function(){
                    $("#sysloginprogressbar").css("width",prog+"%");  
                    if(prog < 100){
                       prog = prog + 1
                    }
                },100);
                
                //$("input#session").val(1) ;
                //$("div#loginContainer").fadeOut();
                //$("div#mainContainer").fadeIn();
//                timer = timer + 2000;
//                
               setTimeout(function(){
                    location.reload();
               },700);
                
                 
            }
            else{
                setTimeout(function(){
                     $("button.sys-login").removeClass("btn-outline-primary").removeClass("btn-outline-success").addClass("btn-outline-danger").html("<i class='bi bi-exclamation-octagon'></i>" + data);
                 },500);    
            }
           
             
        }
      });
  });
  

  $("a.list-group-item").click(function(){
      $("div.collapse.popups").collapse('hide');
  }); 
 
    
   //newCourse
  $("form#addNewCourse").on("click","#newCoursebtn",function(e){
     //e.preventDefault();
      var x = $("form#addNewCourse").serializeArray();
      
      $.ajax({
        beforeSend: function(){
            $("p.lead#newCourseStatus").html("<span class='spinner-border spinner-border-sm' role='status'></span>");
        },  
        type:"POST",
        url:"inc/newcourse.inc.php",
        cache:false,
        data: $.param(x),
         success: function(data){
              setTimeout(function(){
                 $("p.lead#newCourseStatus").html(data);
             },1000); 
             
          },
       error: function(XMLHttpRequest, textStatus, errorThrown){
             setTimeout(function(){
                 $("p.lead#newCourseStatus").html(errorThrown+" <i class='bi bi-x-octagon'></i> ");
             },1000);  
        }
      });
      
  }); 
    

   //newClass
  $("form#addNewClass").on("click","#newClassbtn",function(e){
     //e.preventDefault();
      var x = $("form#addNewClass").serializeArray();
      
      $.ajax({
        beforeSend: function(){
            $("p.lead#newClassStatus").html("<span class='spinner-border spinner-border-sm' role='status'></span>");
        },  
        type:"POST",
        url:"inc/newclass.inc.php",
        cache:false,
        data: $.param(x),
         success: function(data){
              setTimeout(function(){
                 $("p.lead#newClassStatus").html(data);
             },1000); 
             
          },
       error: function(XMLHttpRequest, textStatus, errorThrown){
             setTimeout(function(){
                 $("p.lead#newClassStatus").html(errorThrown+" <i class='bi bi-x-octagon'></i> ");
             },1000);  
        }
      });
      
  }); 
  //newstudent
  $("form#addNewStudent").on("click","#newstudentbtn",function(e){
     //e.preventDefault();
      var x = $("form#addNewStudent").serializeArray();
      
      $.ajax({
        beforeSend: function(){
            $("#addnewstudentstat").html("<span class='spinner-border spinner-border-sm' role='status'></span>");
        },  
        type:"POST",
        url:"inc/newstudent.inc.php",
        cache:false,
        data: $.param(x),
         success: function(data){
              setTimeout(function(){
                 $("#addnewstudentstat").html(data);
             },1000); 
             
          },
       error: function(XMLHttpRequest, textStatus, errorThrown){
             setTimeout(function(){
                 $("#addnewstudentstat").html(errorThrown+" <i class='bi bi-x-octagon'></i> ");
             },1000);  
        }
      });
      
  });
  //update grade
  $("button.updateGradeSubmit").click(function(){
      var the_id = $(this).attr('id');
      var x = $("form#"+$(this).attr('id')).serializeArray();
     $.ajax(
      {
        type:"POST",
        url:"inc/updategrade.inc.php",
        data: $.param(x),
         success: function(data){
            $("#result"+the_id).html("<span class='spinner-border' role='status'></span>"); 
              setTimeout(function(){
                 $("#newresult"+the_id).html(data);
             },1000); 
             
             setTimeout(function(){
                 $("#result"+the_id).html("<span class='badge bg-success'><i class='bi bi-check'></i> Updated</span>"); 
             },1000); 
          }
      });
  });   
    
  $("#idSearchBar").on('keyup',function(){
      var str = $(this).val();
      if (str == ""){
          $("#searchresults").html("");
      }else{
           $.ajax({
          type: "GET",
          url: "inc/search.php?s="+str,
          data: str,
          success: function(data){
              $("#searchresults").html(data);
          } 
      });
      }
     
  });
     
    //grades
    $("#searchresults").on("click","button.updateGradeSubmitSearch", function(){
       var the_id = $(this).attr('id');
      var x = $("form.searchupdateform#"+$(this).attr('id')).serializeArray();
      
     $.ajax(
      {
        beforeSend: function(){
                setTimeout(function(){
                  $("span.updresfeedback#upd"+the_id).html("<span class='spinner-grow spinner-grow-sm' role='status'></span>");     
                },100);
                    setTimeout(function(){
                  $("span.updresfeedback#upd"+the_id).append("<span class='spinner-grow spinner-grow-sm' role='status'></span>");     
                },250);
                    setTimeout(function(){
                  $("span.updresfeedback#upd"+the_id).append("<span class='spinner-grow spinner-grow-sm' role='status'></span>");     
                },450);
                  },
        type:"POST",
        url:"inc/updategradebysearch.inc.php",
        data: $.param(x),
         success: function(data){
             setTimeout(function(){
                 $("span.updresfeedback#upd"+the_id).html("<span class='badge bg-success'><i class='bi bi-check'></i> Updated</span>"); 
             },1000);    
          }
      });
    }); 
    
    //student name
    $("#searchresults").on("click","button.updateGradeFullName", function(e){
      e.preventDefault();
      
      var the_id = $(this).attr('id');
      console.log(the_id);
      var x = $("form.updateGradeFullName#Upd"+the_id).serializeArray();
      
     $.ajax(
      {
        beforeSend: function(){
            $("button.updateGradeFullName#"+the_id).html("<span class='spinner-border spinner-border-sm' role='status'></span>");    
        },
        type:"POST",
        url:"inc/updatestudnamebysearch.inc.php",
        data: $.param(x),
         success: function(data){
             if(data !== false){
                setTimeout(function(){
                $("button.updateGradeFullName#"+the_id).html("Saved <i class='bi bi-check'>").removeClass("btn-outline-primary").addClass("btn-outline-success").blur();    
                },500);        
             }else{
                 $("button.updateGradeFullName#"+the_id).html("Saved <i class='bi bi-x-circle'>").removeClass("btn-outline-primary").addClass("btn-outline-danger").blur();    
             }
            
          }
      });
    });   
  
    
    $("form#updategradebyfile").submit(function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);
      $.ajax(
      {
        beforeSend: function(){
               $("button#updateGradeByForm").html("<span class='spinner-border spinner-border-sm' role='status'></span>");
         }, 
        contentType: false,
        processData: false,
        enctype: 'multipart/form-data',
        type:"POST",
        timeout: 20000,
        url:"inc/updategradebyfile.inc.php",
        data: formData,
        cache:false,
        success: function(data){
                setTimeout(function(){
                // $("button#updateGradeByForm").html("Grade Updated <i class='bi bi-check'></i>");
                    $("button#updateGradeByForm").html(data); 
                },800);    
                setTimeout(function(){
                    $("button#updateGradeByForm").html("Save <i class='bi bi-save'></i>" ); 
                },1000);    
             
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
             setTimeout(function(){
                 //$("#uploadstatus").html("<span class='badge bg-danger'><i class='bi bi-x-octagon'></i> Failed</span>"); 
                 $("button#updateGradeByForm").html("Error <i class='bi bi-x-octagon'></i>");
             },1000);  
        }
      });
    });
    
});
