<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    foreach ($_POST as $key=>$val) {
      if($val==""){
          if($key=='dateofissue'&&$_POST['issuedate']=="today"){
              continue;
          }
          $response=['title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
          echo(json_encode($response));
          exit();
      }
    }
    if($_POST['issuedate']=="today"){
        $date=date("Y-m-d");
    }
    else{
        try{
            $date=new DateTime($_POST['dateofissue']);
            $date=$date->format('Y-m-d');            
        }
        catch(Exception $e){
            $response=['title'=>'Error','message'=>'Invalid Date format the correct format is YY-MM-DD','style'=>'error','location'=>'tc'];
            echo(json_encode($response));
            exit();               
        }
    }
    $sql="SELECT category FROM libusers WHERE id='$_POST[userid]'";
    if($result=mysql_query($sql)){
        if($user=mysql_fetch_assoc($result)){
            
            if($user['category']=="STUDENT"){
                $duedate = date('Y-m-d', strtotime($date . " +30 days"));
            }
            else{
                $duedate = date('Y-m-d', strtotime($date . " +1 days"));                
            }
            
            if(date('N', strtotime($duedate)) == 6){
                $duedate = date('Y-m-d', strtotime($duedate . " +2 days"));
            }
            else if(date('N', strtotime($duedate)) == 7){
                $duedate = date('Y-m-d', strtotime($duedate . " +1 days"));                    
            }
            
            $sql="INSERT INTO issues VALUES('$_POST[userid]','$_POST[bookid]','$date','$duedate')";
            if(mysql_query($sql)){
                $response=['title'=>'Done!','message'=>'The book was issued','style'=>'notice','location'=>'tc'];        
            }
            else{
                $response=['title'=>'Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];   
            }
        }
        else{
            $response=['title'=>'Error!','message'=>'No such user is found','style'=>'error','location'=>'tc'];               
        }
    }
}
else{
    $response=['title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}
echo(json_encode($response));
?>