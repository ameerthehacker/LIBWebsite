<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_POST['id'])){
        $sql="SELECT userid FROM journal_authors WHERE journalid='$_POST[id]'";
        if($result=mysql_query($sql)){
            $response=['found'=>true,'authors'=>[]];
            while($record=mysql_fetch_assoc($result)){
                array_push($response['authors'],$record['userid']);
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