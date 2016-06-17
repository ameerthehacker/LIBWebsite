<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['libuser'])||isset($_SESSION['user'])){
    if(isset($_SESSION['libuser'])){
        $password=$_SESSION['libuser']['password'];        
    }
    else if(isset($_SESSION['user'])){
        $password=$_SESSION['user']['password'];        
    }
    foreach ($_POST as $val) {
      if($val==""){
          $response=['error'=>true,'title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
          echo(json_encode($response));
          exit();
      }
    }
    if($_POST['oldpassword']==$password){
        if($_POST['newpassword']==$_POST['retypepassword']){

            //Select user or admin

            if(isset($_SESSION['libuser'])){
                $username=$_SESSION['libuser']['userid'];                
                $sql="UPDATE user_password SET password='$_POST[newpassword]' WHERE userid='$username'";
            }
            else{
                $username=$_SESSION['user']['username'];                
                $sql="UPDATE users SET password='$_POST[newpassword]' WHERE username='$username'";                
            }

            //Execute apropriate query

            if(mysql_query($sql)){
                $response=['error'=>false,'title'=>'Done!','message'=>'The password was changed','style'=>'notice','location'=>'tc'];                                    
            }
            else{
                $response=array('error'=>true,'title'=>'Internal Error!','message'=>mysql_error(),'style'=>'error','location'=>'tc');                    
            }

            //Update session variable

            if(isset($_SESSION['libuser'])){
                $_SESSION['libuser']['password']=$_POST['newpassword'];                
            }
            else if(isset($_SESSION['user'])){
                $_SESSION['user']['password']=$_POST['newpassword'];                                
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