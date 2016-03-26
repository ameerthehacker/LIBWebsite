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
    $sql="update libusers SET username='$_POST[username]',id='$_POST[userid]',dept='$_POST[dept]',category='$_POST[category]' WHERE id='$_POST[id]'";
    if(mysql_query($sql)){
         $response=['title'=>'Done!','message'=>'The user was updated','style'=>'notice','location'=>'tc'];        
    }
    else{
        $response=['title'=>'Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];   
    }
}
else{
    $response=['title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}
echo(json_encode($response));
?>