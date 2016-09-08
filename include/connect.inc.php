<?php
	require_once('config.inc.php');
	$server=mysql_connect($host,$username,$password);
	mysql_select_db($database,$server);
?>