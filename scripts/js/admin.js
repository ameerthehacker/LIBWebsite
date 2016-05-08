$(function(){
    
    var ajaxError={title:"Internal Error!",message:'Unable to perform a ajax request',style:'error',location:'tc'};
    
    var formUsersAdd=$("#form-users-add");
    var formBooksAdd=$("#form-books-add");
    var formUsersUpdate=$("#form-users-update");
    var formBooksUpdate=$("#form-books-update");
    var formUsersCSV=$("#form-users-csv");
    var formBooksCSV=$("#form-books-csv");    
    var formBooksIssue=$("#form-books-issue");
    var formBooksReturn=$("#form-books-return");
    
    var fileUsersCSV=$("#file-users-csv");
    var fileBooksCSV=$("#file-books-csv");    
    
    var labelUsersCSV=$("#label-users-csv");
    var labelBooksCSV=$("#label-books-csv");    
    
    var textBooksIssueDate=$("#text-books-issue-date");
    var textBooksIssueID=$("#text-books-issue-id");
    var textUsersIssueID=$("#text-users-issue-id");
    var textBooksReturnID=$("#text-books-return-id");
    
    
    var btnBooksAdd=$("#btn-books-add");
    var btnBooksDelete=$("#btn-books-delete");
    var btnBooksSelectAll=$("#btn-books-selectall");
    var btnBooksInvert=$("#btn-books-invert");
    var btnBooksUpdate=$("#btn-books-update");
    var btnBooksIssue=$("#btn-books-issue");
    var btnBooksReturn=$("#btn-books-return");
    var btnBooksRenew=$("#btn-books-renew");    
    
    var btnUsersAdd=$("#btn-users-add");
    var btnUsersBrowseCSV=$("#btn-users-browse-csv"); 
    var btnBooksBrowseCSV=$("#btn-books-browse-csv");     
    var btnUsersCSV=$("#btn-users-csv"); 
    var btnBooksCSV=$("#btn-books-csv");         
    var btnUsersDelete=$("#btn-users-delete");
    var btnUsersSelectAll=$("#btn-users-selectall");
    var btnUsersInvert=$("#btn-users-invert");
    var btnUsersUpdate=$("#btn-users-update");
    
    var modalUsersUpdate=$("#modal-users-update");
    var modalBooksUpdate=$("#modal-books-update");
    
    
    
    var adminTabs=$("#admin-tabs");
    var libBooks=$("#libbooks");
    var libUsers=$("#libusers");    
    var libBooksCheckBox=$(".libbooks-checkbox");
    var libUsersCheckBox=$(".libusers-checkbox");
    var libUsersCheckBox=$(".libusers-checkbox");
    var libBooksRow=$(".libbooks-row");    
    var libUsersRow=$(".libusers-row");
    
    var selectedUser={};
    var selectedBook={};
    var availableBooks=[];
    
    adminTabs.tabs();
    libBooks.dataTable();
    libUsers.dataTable();
    
    
    formUsersAdd.ajaxForm();
    formBooksAdd.ajaxForm();
    formUsersUpdate.ajaxForm();
    formUsersCSV.ajaxForm();
    
    formBooksCSV.ajaxForm();    
    formBooksIssue.ajaxForm();
    formBooksReturn.ajaxForm();
    
    textBooksIssueDate.datepicker({
        dateFormat:'yy-mm-dd'
    });
    
    textBooksIssueDate.on('keypress',function(evt){
       evt.preventDefault(); 
    });
    
    btnBooksRenew.on('click',function(evt){
       formBooksReturn.ajaxSubmit({
           url:'scripts/php/books/renew.php',           
           success:function(response){
           response=jQuery.parseJSON(response);
           $.growl(response);
       },error:function(){
           $.growl(ajaxError);
       }});
    });
    
    textBooksIssueID.on('keyup',function(evt){
       $.ajax({
          url:'scripts/php/books/detail.php',
          method:'get',
          data:{id:textBooksIssueID.val()},
          success:function(response){
              response=jQuery.parseJSON(response);
              if(response.found){
                  $("#d-bookname").text(response.book.bookname);
                  $("#d-author").text(response.book.author);
                  $("#d-publication").text(response.book.publication);
                  $("#d-price").text(response.book.price);     
                  $("#d-status").text(response.book.status);   
                  if(response.book.status=="Available"){
                      $("#row-books-details").addClass("success")
                  }
                  else{
                      $("#row-books-details").addClass("danger")                      
                  }
                  $("#div-books-details").css({'display':'block','visibility':'visible'});          
              }
              else{
                  $("#div-books-details").css({'display':'none','visibility':'hidden'});        
                  $("#row-books-details").removeClass();                                       
              }
          },error:function(){
              $.growl(ajaxError);
          } 
       });
    });
    
    
    textUsersIssueID.on('keyup',function(evt){
       $.ajax({
          url:'scripts/php/users/detail.php',
          method:'get',
          data:{id:textUsersIssueID.val()},
          success:function(response){
              response=jQuery.parseJSON(response);
              if(response.found){
                  $("#d-username").text(response.user.username);
                  $("#d-userid").text(response.user.id);
                  $("#d-department").text(response.user.dept);
                  $("#d-category").text(response.user.category);        
                  $("#div-users-details").css({'display':'block','visibility':'visible'});          
              }
              else{
                  $("#div-users-details").css({'display':'none','visibility':'hidden'});                             
              }
          },error:function(){
              $.growl(ajaxError);
          } 
       });
    });
    
    textBooksReturnID.on('keyup',function(evt){
       $.ajax({
          url:'scripts/php/books/detail.php',
          method:'get',
          data:{id:textBooksReturnID.val()},
          success:function(response){
              response=jQuery.parseJSON(response);
              if(response.found && response.book.status!="Available"){
                  $("#r-bookname").text(response.book.bookname);
                  $("#r-author").text(response.book.author);
                  $("#r-publication").text(response.book.publication);
                  $("#r-price").text(response.book.price);     
           
                  $("#r-username").text(response.book.username);
                  $("#r-userid").text(response.book.status);
                  $("#r-department").text(response.book.dept);
                  $("#r-category").text(response.book.category);
                          
                  $("#div-return-details").css({'display':'block','visibility':'visible'});          
              }
              else{
                  $("#div-return-details").css({'display':'none','visibility':'hidden'});        
              }
          },error:function(){
              $.growl(ajaxError);
          } 
       });
    });
    
    btnBooksReturn.on('click',function(evt){
       formBooksReturn.ajaxSubmit({
           url:'scripts/php/books/return.php',           
           success:function(response){               
           response=jQuery.parseJSON(response);
           $.growl(response);
       },error:function(){
           $.growl(ajaxError);
       }});
    });
    
    btnUsersBrowseCSV.on('click',function(evt){
       fileUsersCSV.trigger('click'); 
    });  
    
    btnBooksBrowseCSV.on('click',function(evt){
       fileBooksCSV.trigger('click'); 
    }); 
    
    fileUsersCSV.on('change',function(evt){
       labelUsersCSV.text(fileUsersCSV[0].files[0].name);
    });
    
    fileBooksCSV.on('change',function(evt){
       labelBooksCSV.text(fileBooksCSV[0].files[0].name);
    });
    
    btnBooksIssue.on('click',function(evt){
       formBooksIssue.ajaxSubmit({
           success:function(response){
               response=jQuery.parseJSON(response);
               $.growl(response);
           },error:function(){
               $.growl(ajaxError);       
        }});
    });
    
    btnUsersCSV.on('click',function(evt){
       formUsersCSV.ajaxSubmit({success:function(response){
           response=jQuery.parseJSON(response);
           $.growl(response);                       
       },error:function(){
           $.growl(ajaxError);                       
       }}); 
    });
    
    btnBooksCSV.on('click',function(evt){
       formBooksCSV.ajaxSubmit({success:function(response){
           response=jQuery.parseJSON(response);
           $.growl(response);                       
       },error:function(){
           $.growl(ajaxError);                       
       }}); 
    });
    
    libUsersRow.on('dblclick',function(evt){
        var fields=[];
       $(this).children('.field').each(function(){
           fields.push($(this).text());
       });
       selectedUser=fields[1];
       $("#username").val(fields[0]);
       $("#userid").val(fields[1]);
       $("#dept").children('option').each(function(){
          if($(this).text()==fields[2]){
              $(this).attr('selected','selected');
          } 
       });
       $("#category").children('option').each(function(){
          if($(this).text()==fields[3]){
              $(this).attr('selected','selected');
          } 
       });
       modalUsersUpdate.modal('show');
    });
    
    libBooksRow.on('dblclick',function(evt){
        var fields=[];
       $(this).children('.field').each(function(){
           fields.push($(this).text());
       });
       selectedBook=fields[1];
       $("#bookname").val(fields[0]);
       $("#bookid").val(fields[1]);
       $("#author").val(fields[2]);
       if(fields[3]!="N/A"){
           $("#publication").val(fields[3]);
       }
       $("#price").val(fields[4]);
       modalBooksUpdate.modal('show');
    });
    
    btnUsersInvert.on('click',function(evt){
        libUsersCheckBox.each(function(){
          if($(this).is(" :checked")){
              $(this).prop('checked',false);
          }
          else{
              $(this).prop('checked',true);
          }
       });  
    });
    
    btnUsersUpdate.on('click',function(evt){
        formUsersUpdate.ajaxSubmit({data:{id:selectedUser},success:function(response){
            response=jQuery.parseJSON(response);
            $.growl(response);
        }});
    });
    btnBooksUpdate.on('click',function(evt){
        formBooksUpdate.ajaxSubmit({data:{id:selectedBook},success:function(response){
            response=jQuery.parseJSON(response);
            $.growl(response);
        }});
    });
    btnUsersSelectAll.on('click',function(evt){
       libUsersCheckBox.each(function(){
          $(this).prop('checked',true);
       });  
    });
    
    btnBooksInvert.on('click',function(evt){
        libBooksCheckBox.each(function(){
          if($(this).is(" :checked")){
              $(this).prop('checked',false);
          }
          else{
              $(this).prop('checked',true);
          }
       });  
    });
    
     btnUsersDelete.on('click',function(){
       var checked=[];
       libUsersCheckBox.each(function(){
          if($(this).is(" :checked")){
              checked.push($(this).attr('field-id'));
          } 
       }); 
       $.ajax({url:'scripts/php/users/delete.php',method:'POST',data:{'checked':checked},success:function(response){
            response=jQuery.parseJSON(response);
            $.growl(response);   
            if(!response.error){
                setTimeout(function(){
                    window.location.reload(true);
                },2000);
            }
       },error:function(){
           $.growl({title:"Internal Error!",message:'Unable to perform a ajax request',style:'error',location:'tc'});            
       }});
    });
    
    btnBooksSelectAll.on('click',function(evt){
       libBooksCheckBox.each(function(){
          $(this).prop('checked',true);
       });  
    });
    btnBooksDelete.on('click',function(){
       var checked=[];
       libBooksCheckBox.each(function(){
          if($(this).is(" :checked")){
              checked.push($(this).attr('field-id'));
          } 
       }); 
       $.ajax({url:'scripts/php/books/delete.php',method:'POST',data:{'checked':checked},success:function(response){
            response=jQuery.parseJSON(response);
            $.growl(response);   
            if(!response.error){
                setTimeout(function(){
                    window.location.reload(true);
                },2000);
            }
       },error:function(){
           $.growl(ajaxError);            
       }});
    });
    
    btnUsersAdd.on('click',function(evt){
        formUsersAdd.ajaxSubmit({success:function(response){
            response=jQuery.parseJSON(response);
            $.growl(response);
        }});
    });
    
    btnBooksAdd.on('click',function(evt){
  
        formBooksAdd.ajaxSubmit({success:function(response){
            
            response=jQuery.parseJSON(response);
            $.growl(response);
        }});
    });
});