<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_GET['id'])){
        $sql="SELECT * FROM libbooks WHERE id='$_GET[id]'";
        if($result=mysql_query($sql)){
            if($record=mysql_fetch_assoc($result)){
                $response=['found'=>true,'book'=>$record];                
            }
            else{
                $response=['found'=>false];
            }
        }
        else{
            $response=['found'=>false];
        }
    }   
    else{
        $sql="SELECT id FROM libbooks";
        $books=[];
        if($result=mysql_query($sql)){
            while($record=mysql_fetch_assoc($result)){
                array_push($books,$record['id']);
            }
            $response=$books;
        }
        else{
            $response=['title'=>'Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];               
        }
    } 
}
else{
    $response=['found'=>false];
}
echo(json_encode($response));
?>