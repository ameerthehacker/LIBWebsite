$(function(){
    var formUsersAdd=$("#form-users-add");
    var formBooksAdd=$("#form-books-add");
    
    var btnUsersAdd=$("#btn-users-add");
    var btnBooksAdd=$("#btn-books-add");
    
    formUsersAdd.ajaxForm();
    formBooksAdd.ajaxForm();
    
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