<?php
	include("../objects/user.php");
	include("../controller/loginUserctl.php");
	
	$user = new User();
	$member = new LoginUserCtl();
	
	$user->setFirstname($_POST["firstname"]);
	$user->setLastname($_POST["lastname"]);
	$user->setUserId($_POST["username"]);
	$user->setPassword($_POST["password"]);
	
	$user = $member->registerUser($user);
	
	session_start();
	$_SESSION['user']=$user;
	session_write_close();
	
	header( 'Location: main.php' ) ;
?>