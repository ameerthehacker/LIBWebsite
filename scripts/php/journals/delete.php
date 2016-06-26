<?php
session_start();

require_once('../../../include/table.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_POST['checked'])){
        $books=new CTable('libjournals');
        if($books->delete($_POST['checked'])){
            foreach ($_POST['checked'] as $value) {
                unlink("pdf/$value.pdf");
            }
            $response=array('error'=>false,'title'=>'Done!','message'=>'The journals were removed','style'=>'notice','location'=>'tc');                        
        }
        else{
            $response=array('error'=>true,'title'=>'Internal Error!','message'=>'There was an internal error','style'=>'error','location'=>'tc');                    
        }   
    }
    else{
        $response=array('error'=>true,'title'=>'Error!','message'=>'Choose a book first','style'=>'error','location'=>'tc');                                
    }
}
else{
    $response=array('error'=>true,'title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc');        
}

echo(json_encode($response));

?>