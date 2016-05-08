<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_GET['id'])){
        $sql="SELECT l.bookname,l.id,l.author,IFNULL(l.publication,'N/A') AS publication,price,IFNULL(i.userid,'Available') AS status,u.username,u.dept,u.category FROM libbooks l LEFT OUTER JOIN issues i on l.id=i.bookid LEFT OUTER JOIN libusers u ON u.id=i.userid WHERE l.id='$_GET[id]'";
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