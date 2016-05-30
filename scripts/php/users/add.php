<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    foreach ($_POST as $val) {
      if($val==""){
          $response=['title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
          echo(json_encode($response));
          exit();
      }
    }
    $sql="INSERT INTO libusers VALUES('$_POST[username]','$_POST[userid]','$_POST[dept]','$_POST[category]')";
    if(mysql_query($sql)){
         $response=['title'=>'Done!','message'=>'The user was added','style'=>'notice','location'=>'tc'];        
    }
    else{
        $response=['title'=>'Internal Error!','message'=>mysql_error(),'style'=>'error','location'=>'tc'];   
    }
}
else{
    $response=['title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}
echo(json_encode($response));
?>