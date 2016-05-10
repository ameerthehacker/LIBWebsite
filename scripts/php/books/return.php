<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    if($_POST['bookid']!=""){
        $sql="SELECT * FROM issues WHERE bookid='$_POST[bookid]'";
        if($result=mysql_query($sql)){
            if(mysql_fetch_assoc($result)){
                $sql="DELETE FROM issues WHERE bookid='$_POST[bookid]'";
                if(mysql_query($sql)){
                    $response=['title'=>'Done!','message'=>'The book was returned','style'=>'notice','location'=>'tc'];        
                }   
                else{
                    $response=['title'=>'Error!','message'=>mysql_error(),'style'=>'error','location'=>'tc'];   
                }
            }
            else{
                $response=['title'=>'Sorry!','message'=>'The book was not taken','style'=>'error','location'=>'tc'];                   
            }
        } 
        else{
            $response=['title'=>'Internal Error!','message'=>mysql_error(),'style'=>'error','location'=>'tc'];               
        }
    }
    else{
        $response=['title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
    }
}
else{
    $response=['title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}
echo(json_encode($response));
?>