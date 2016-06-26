<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_POST['id'])){

        $condition="";
        foreach ($_POST['id'] as $value) {
            if($condition==""){
                $condition="id='".$value."'";
            }
            else{
                $condition.=" OR id='".$value."'";
            }
        }
        $sql="SELECT * FROM libusers WHERE $condition";
        if($result=mysql_query($sql)){
            $response=['found'=>false,'authors'=>[]];                
            while($record=mysql_fetch_assoc($result)){
                $response['found']=true;
                array_push($response['authors'],$record['username']);                
            }
        }
        else{
            $response=['found'=>false];
        }
    }   
}
else{
    $response=['found'=>false];
}
echo(json_encode($response));
?>