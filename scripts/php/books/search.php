<?php

require_once('../../../include/connect.inc.php');
require_once('../../../include/core.inc.php');
require_once('../../../include/table.inc.php');

$_GET=sqlEscape($_GET);   //SQL injection safe

$sql="SELECT l.bookname,l.id,l.author,IFNULL(l.publication,'N/A') AS publication,price,IFNULL(i.userid,'Available') AS status 
FROM libbooks l 
LEFT OUTER JOIN issues i on l.id=i.bookid 
LEFT OUTER JOIN libusers u ON u.id=i.userid 
WHERE l.$_GET[category] like '$_GET[keyword]%'";

$result=new CTable();
$html=$result->drawTable(['Book Name','ID','Author','Publisher','Price','Status'],false,$sql);

$response=['html'=>$html];

echo(json_encode($response));

?>