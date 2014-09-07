<?php

session_start();

$_SESSION['user_id'] = 1;

$db = new PDO('mysql:dbname=SharingDatabase;host=68.178.143.9', 'SharingDatabase', 'Sharing4513308!'); 

// Handle this in some other way
if (!isset($_SESSION['user_id']))
{
	die('Check your id and password');
	// header('Location: login-form.php');
}