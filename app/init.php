<?php
$_SESSION['user_id'] = 1;

$db = new PDO('mysql:dbname=xxxxx;host=xxxxx', 'xxxxx', 'xxxxx!'); 

// Handle this in some other way
if (!isset($_SESSION['user_id']))
{
	die('Check your id and password');
	// header('Location: login-form.php');
}
