<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_POST['bookid'])){
        $date=date("Y-m-d");          
    }
    else{
        $response=['title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];        
    }
    $sql="SELECT userid FROM issues WHERE bookid='$_POST[bookid]'";
    if($result=mysql_query($sql)){
        if($userid=mysql_fetch_assoc($result)){
           $sql="SELECT category FROM libusers WHERE id='$userid[userid]'";
           $result=mysql_query($sql);
           $user=mysql_fetch_assoc($result);
           
           if($user['category']=="STUDENT"){
                $duedate = date('Y-m-d', strtotime($date . " +30 days"));
            }
            else{
                $duedate = date('Y-m-d', strtotime($date . " +180 days"));                
            }
            
            if(date('N', strtotime($duedate)) == 6){
                $duedate = date('Y-m-d', strtotime($duedate . " +2 days"));
            }
            else if(date('N', strtotime($duedate)) == 7){
                $duedate = date('Y-m-d', strtotime($duedate . " +1 days"));                    
            }
            
            $sql="UPDATE issues set idate='$date',duedate='$duedate' WHERE bookid='$_POST[bookid]'";
            if(mysql_query($sql)){
                $response=['title'=>'Done!','message'=>'The book was renewed','style'=>'notice','location'=>'tc'];        
            }
            else{
                $response=['title'=>'Error!','message'=>mysql_error(),'style'=>'error','location'=>'tc'];   
            }
           
        }
        else{
            $response=['title'=>'Sorry!','message'=>'The book is not taken','style'=>'error','location'=>'tc'];               
        }
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