<?php
 
	require_once('connect.inc.php');
	
	class CLogin{
		private $username;
		private $password;
		
		function __construct($username,$password){
			$this->username=$username;
			$this->password=$password;
		}
		function getUser(){
			$sql="SELECT * FROM users WHERE username='$this->username'";
			$res=mysql_query($sql);
			$user=mysql_fetch_assoc($res);
			
			return $user;
		}
		function getLibUser(){
			$sql="SELECT * FROM user_password WHERE userid='$this->username'";
			$res=mysql_query($sql);
			$user=mysql_fetch_assoc($res);
			
			return $user;
		}
		function isLibUser(){
			$user=$this->getLibUser();
			if($user){
				if($user['password']==$this->password){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function isAuthentiated(){
			$user=$this->getUser();
			if($user){
				if($user['password']==$this->password){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
	}
?>