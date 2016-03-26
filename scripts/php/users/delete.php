<?php
session_start();

require_once('../../../include/table.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_POST['checked'])){
        $books=new CTable('libusers');
        if($books->delete($_POST['checked'])){
            $response=array('error'=>false,'title'=>'Done!','message'=>'The books were removed','style'=>'notice','location'=>'tc');                        
        }
        else{
            $response=array('error'=>true,'title'=>'Internal Error!','message'=>'There was an internal error','style'=>'error','location'=>'tc');                    
        }   
    }
    else{
        $response=array('error'=>true,'title'=>'Error!','message'=>'Choose a user first','style'=>'error','location'=>'tc');                                
    }
}
else{
    $response=array('error'=>true,'title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc');        
}

echo(json_encode($response));

?>