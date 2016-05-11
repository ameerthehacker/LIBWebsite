$(function(){
    
    var ajaxError = { title: "Internal Error!", message: 'Unable to perform a ajax request', style: 'error', location: 'tc' };
    var formUsersChangePassword=$("#form-users-change-password");
    var btnUsersChangePassword=$("#btn-users-change-password");
    
    formUsersChangePassword.ajaxForm();
    
    btnUsersChangePassword.on('click',function(evt){
        formUsersChangePassword.ajaxSubmit({
            success:function(response){
                response=jQuery.parseJSON(response);
                $.growl(response);
            },
            error:function(){
                $.growl(ajaxError);
            }
        });
    });
    
    $('[data-toggle="popover"]').popover(); 
});