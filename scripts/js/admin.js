$(function(){
    
    var ajaxError={title:"Internal Error!",message:'Unable to perform a ajax request',style:'error',location:'tc'};
    
    var formUsersAdd=$("#form-users-add");
    var formBooksAdd=$("#form-books-add");
    var formUsersUpdate=$("#form-users-update");
    var formBooksUpdate=$("#form-books-update");
    var formUsersCSV=$("#form-users-csv");
    var formBooksIssue=$("#form-books-issue");
    var formBooksReturn=$("#form-books-return");
    
    var fileUsersCSV=$("#file-users-csv");
    
    var labelUsersCSV=$("#label-users-csv");
    
    var textBooksIssueDate=$("#text-books-issue-date");
    
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
    var btnUsersCSV=$("#btn-users-csv");   
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
    
    adminTabs.tabs();
    libBooks.dataTable();
    libUsers.dataTable();
    
    
    formUsersAdd.ajaxForm();
    formBooksAdd.ajaxForm();
    formUsersUpdate.ajaxForm();
    formUsersCSV.ajaxForm();
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
    
    fileUsersCSV.on('change',function(evt){
       labelUsersCSV.text(fileUsersCSV[0].files[0].name);
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