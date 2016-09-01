<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    foreach ($_POST as $value) {
        if($value==""){
            $response=['title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];
            echo(json_encode($response));            
            exit();
        }
    }

    //Check proper academinc year

    if($_POST['year_from']>$_POST['year_to']){
        $response=['title'=>'Sorry!','message'=>'Invalid academic year interval','style'=>'error','location'=>'tc'];
        echo(json_encode($response));        
        exit();
    }


    //Check if the authors exist     

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

    //Update the journal

    $sql="UPDATE libjournals SET journalname='$_POST[journalname]',journaltitle='$_POST[journaltitle]',month='$_POST[month]',year_from='$_POST[year_from]',year_to='$_POST[year_to]',issue='$_POST[issue]',volume='$_POST[volume]',impactfactor='$_POST[impactfactor]' WHERE id='$_POST[id]'";
    if(mysql_query($sql)){

        //Update the authors

        //First Delete the authors

        $sql="DELETE FROM journal_authors WHERE journalid='$_POST[id]'";
        if(mysql_query($sql)){

            //Insert the new authors

            foreach ($authors as $value) {
                $sql="INSERT INTO journal_authors VALUES('$_POST[id]','$value')";
                if(!mysql_query($sql)){
                    $response=['title'=>'Internal Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];
                    echo(json_encode($response));
                    exit();  
                }
            }

            $response=['title'=>'Done!','message'=>'The journal was updated','style'=>'notice','location'=>'tc'];      

        }
        else{
            $response=['title'=>'Internal Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];
            echo(json_encode($response));
            exit();
        }
    }
    else{
        $response=['title'=>'Internal Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];        
    }
}
else{ 
    $response=['title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}
echo(json_encode($response));

?>