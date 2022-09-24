<?php
//this line of code helps in starting session
session_start();
//required the respective file at least ones in this file
require_once 'dbConnection.php';
require_once 'insertInto.php';
//logic on if statement that controls the authorization in this page.
//Allows only users with permissions to access this pages protected content.
if(!isset($_SESSION['onBoard']) && !isset($_SESSION['onBoardUser'])){
	header('location: noAccess.php');
	die();
}
//code to check if a user is logged out. If user clicks logout this code gets executed and logs the user out.
if(isset($_GET['loginStatus'])){
	$_SESSION['loggedOut'] = true;
	unset($_SESSION['onBoard']);
	unset($_SESSION['onBoardUser']);
	$_SESSION['outMessage'] = "You just Logged out!.";
	header('location: login.php');
	die();
}

?>