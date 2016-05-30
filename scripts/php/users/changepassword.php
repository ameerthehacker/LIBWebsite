<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['libuser'])){
    $username=$_SESSION['libuser']['userid'];
    $password=$_SESSION['libuser']['password'];
    foreach ($_POST as $val) {
      if($val==""){
          $response=['error'=>true,'title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
          echo(json_encode($response));
          exit();
      }
    }
    if($_POST['oldpassword']==$password){
        if($_POST['newpassword']==$_POST['retypepassword']){
            $sql="UPDATE user_password SET password='$_POST[newpassword]' WHERE userid='$username'";
            if(mysql_query($sql)){
                $_SESSION['libuser']['password']=$_POST['newpassword'];
                $response=['error'=>false,'title'=>'Done!','message'=>'The password was changed','style'=>'notice','location'=>'tc'];                                    
            }
            else{
                $response=array('error'=>true,'title'=>'Internal Error!','message'=>mysql_error(),'style'=>'error','location'=>'tc');                    
            }
        }
        else{
            $response=['error'=>true,'title'=>'Sorry!','message'=>'There is a mismatch in new passwords','style'=>'error','location'=>'tc'];                    
        }
    }
    else{
        $response=['error'=>true,'title'=>'Sorry!','message'=>'Your password is incorrect','style'=>'error','location'=>'tc'];                        
    }
}
else{
    $response=['error'=>true,'title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}

echo(json_encode($response));
 
?>