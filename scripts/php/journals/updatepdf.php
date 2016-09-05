<?php

session_start();

require_once('../../../include/connect.inc.php');
require_once('../../../include/core.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_POST['id'])){
        if(!isset($_FILES['pdf'])){
            $response=['title'=>'Error','message'=>'Select a file first','style'=>'error','location'=>'tc'];
            echo(json_encode($response));     
            exit();                               
        }
        $_POST=sqlEscape($_POST);
        $sql="SELECT * FROM libjournals WHERE id='$_POST[id]'";
        if($result=mysql_query($sql)){
            if(mysql_num_rows($result)>0){
                move_uploaded_file($_FILES['pdf']['tmp_name'],"pdf/$_POST[id].pdf");
                $response=['title'=>'Done!','message'=>'The journal pdf was updated','style'=>'notice','location'=>'tc'];                                        
            }
            else{
                $response=['title'=>'Error','message'=>'Invalid ID','style'=>'error','location'=>'tc'];                        
            }
        }
        else{
            $response=['title'=>'Internal Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];
        }
    }
    else{
        $response=['title'=>'Error','message'=>'Invalid ID','style'=>'error','location'=>'tc'];        
    }
}
else{
    $response=['title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}
echo(json_encode($response));
?>