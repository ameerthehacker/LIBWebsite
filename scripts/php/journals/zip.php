<?php
session_start();

require_once('../../../include/connect.inc.php');

if(isset($_SESSION['user'])){
    if(isset($_POST['year_from'])&&isset($_POST['year_to'])){
        if($_POST['year_from']!=""&&$_POST['year_to']!=""){
            if(file_exists('pdf/archive.zip')){
                unlink('pdf/archive.zip');
            }
            $zip=new ZipArchive();
            if($zip->open('pdf/archive.zip',ZipArchive::CREATE)){
                $sql="SELECT * FROM libjournals WHERE year_from>='$_POST[year_from]' AND year_to<='$_POST[year_to]'";
                if($result=mysql_query($sql)){
                    while($journal=mysql_fetch_assoc($result)){
                        $zip->addFile('pdf/'.$journal['id'].'.pdf',$journal['id'].'_'.$journal['journaltitle'].'.pdf');
                    }
                    $zip->close();
                    $response=['error'=>false,'title'=>'Done!','message'=>'Zip file created','style'=>'notice','location'=>'tc','filename'=>$_POST['year_from']."-".$_POST['year_to']];            
                }
                else{
                    $response=['error'=>true,'title'=>'Internal Error','message'=>mysql_error(),'style'=>'error','location'=>'tc'];
                }
            }
            else{
                $response=['error'=>true,'title'=>'Internal Error','message'=>'Cannot create zip file','style'=>'error','location'=>'tc'];                
            }
        }
        else{
            $response=['error'=>true,'title'=>'Sorry!','message'=>'Make sure you fill all the fields','style'=>'error','location'=>'tc'];            
        }

    }
    else{
        $response=['error'=>true,'title'=>'Error!','message'=>'Insufficient Data','style'=>'error','location'=>'tc'];                    
    }
}
else{
    $response=['error'=>true,'title'=>'Access Denied','message'=>'You are not authentiated','style'=>'error','location'=>'tc'];
}

echo(json_encode($response));

?>