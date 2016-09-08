<?php
$archive='pdf/archive.zip';
if(isset($_GET['filename'])&&$_GET['filename']!=""){
    $filename=$_GET['filename'].'.zip';
}
else{
    $filename="archive.zip";
}
if(file_exists($archive)){
    header("Content-type: application/zip"); 
    header("Content-Disposition: attachment;filename=$filename");
    header("Content-length: " . filesize($archive));
    header("Pragma: no-cache"); 
    header("Expires: 0"); 
    readfile($archive);
}

?>