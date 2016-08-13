<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    if(!isset($_FILES['pdf'])){
        $response=['title'=>'Sorry!','message'=>'Select a pdf of the journal','style'=>'error','location'=>'tc'];
        echo(json_encode($response));
        exit();
    }
    foreach ($_POST as $value) {
        if($value==""){
            $response=['title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
            echo(json_encode($response));
            exit();
        }
    }

    //Check the authors exist

    $authors=explode(",",$_POST['authors']);

    foreach ($authors as $value) {
        $sql="SELECT id FROM libusers WHERE id='$value'";
        if($result=mysql_query($sql)){
            if(!mysql_fetch_assoc($result)){
                $response=['title'=>'Sorry!','message'=>'One or more authors could not be found','style'=>'error','location'=>'tc'];
                echo(json_encode($response));
                exit();   
            }
        }
        else{
            $response=['title'=>'Internal Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];
            echo(json_encode($response));
            exit();   
        }
    }

    //Insert the jounrnal

    $sql="INSERT INTO libjournals VALUES('','$_POST[journalname]','$_POST[journaltitle]','$_POST[year_from]','$_POST[year_to]','$_POST[issue]','$_POST[volume]','$_POST[impactfactor]')";

    if(!mysql_query($sql)){
        $response=['title'=>'Internal Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];
        echo(json_encode($response));
        exit();   
    }  
    else{
        $journalID=mysql_insert_id();
    }

    //Insert the authors
    
    foreach ($authors as $value) {
        $sql="INSERT INTO journal_authors VALUES('$journalID','$value')";
        if(!mysql_query($sql)){
            $response=['title'=>'Internal Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];
            echo(json_encode($response));
            exit();  
        }
    }

    //Upload the pdf file

    if(!move_uploaded_file($_FILES['pdf']['tmp_name'],"pdf/".$journalID.".pdf")){
        $response=['title'=>'Internal Error','message'=>'Could not upload the pdf file','style'=>'error','location'=>'tc'];
        echo(json_encode($response));
        exit();  
    }
    $response=['title'=>'Done!','message'=>'The journal was added','style'=>'notice','location'=>'tc'];            
}
else{
    $response=['title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}

echo(json_encode($response));

?>