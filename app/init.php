<?php

session_start();

$_SESSION['user_id'] = 1;

$db = new PDO('mysql:dbname=et4891_SharingDatabase;host=localhost', 'et4891_admin', '4513308');

// Handle this in some other way
if (!isset($_SESSION['user_id']))
{
	die('You are not signed in.');
}