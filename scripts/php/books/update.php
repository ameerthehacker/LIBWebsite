<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    foreach ($_POST as $key=>$val) {
      if($val==""&&$key!='publication'){
          $response=['title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
          echo(json_encode($response));
          exit();
      }
    }
    if($_POST['publication']==""){
        $sql="update libbooks SET bookname='$_POST[bookname]',id='$_POST[bookid]',author='$_POST[author]',publication=null,price='$_POST[price]' WHERE id='$_POST[id]'";                   
    }
    else{
        $sql="update libbooks SET bookname='$_POST[bookname]',id='$_POST[bookid]',author='$_POST[author]',publication='$_POST[publication]',price='$_POST[price]' WHERE id='$_POST[id]'";        
    }
    if(mysql_query($sql)){
         $response=['title'=>'Done!','message'=>'The book was updated','style'=>'notice','location'=>'tc'];        
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