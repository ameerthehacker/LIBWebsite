<?php
session_start();

require_once('../../../include/connect.inc.php');
if(isset($_SESSION['user'])){
    if(isset($_FILES['bookscsv'])){
        if($_FILES['bookscsv']['type']=="application/vnd.ms-excel"){
            $sql='LOAD DATA LOCAL INFILE "upload.csv"
                  INTO TABLE libbooks
                  FIELDS TERMINATED BY ","
                  OPTIONALLY ENCLOSED BY """"
                  LINES TERMINATED BY "\r\n"
                 (id,bookname,author,publication,price)';
                 
            move_uploaded_file($_FILES['bookscsv']['tmp_name'],'upload.csv');
            
            if(mysql_query($sql)){
                $response=['title'=>'Done!','style'=>'notice','message'=>'Inserted '.mysql_affected_rows().' users','location'=>'tc'];                                                   
            }
            else{
                $response=['title'=>'Internal Error!','message'=>mysql_error(),'location'=>'tc'];                                   
            }
        }
        else{
            $response=['title'=>'Sorry!','message'=>'Invalid File Format','style'=>'error','location'=>'tc'];            
        }
    }
    else{
        $response=['title'=>'Error!','message'=>'Select a file first','style'=>'error','location'=>'tc'];                    
    }   
}
else{
    $response=['title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}
echo(json_encode($response));
?>