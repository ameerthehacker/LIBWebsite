<?php
function popUp($title,$message,$style="error",$location="tc",$time=3000)
{
	$popMsg="<script type=\"text/javascript\">$.growl({duration:\"$time\",title: \"$title!\",message: \"$message\",style:\"$style\",location:\"$location\" });</script>";
	echo("$popMsg");
}
function sqlEscape($array){
	foreach ($array as $key => $value) {
		$array[$key]=mysql_real_escape_string($value);
	}
	return $array;
}
?>