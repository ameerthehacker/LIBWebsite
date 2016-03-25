<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    foreach ($_POST as $key=>$val) {
      if($val=="" && $key!='publication'){
          $response=['title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
          echo(json_encode($response));
          exit();
      }
    }
    $sql="INSERT INTO libbooks VALUES('$_POST[bookname]','$_POST[bookid]','$_POST[author]','$_POST[publication]','$_POST[price]')";
    if(mysql_query($sql)){
         $response=['title'=>'Done!','message'=>'The book was added','style'=>'notice','location'=>'tc'];        
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