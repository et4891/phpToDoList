<?php

session_start();

$_SESSION['user_id'] = 1;

$db = new PDO('mysql:dbname=phptodolist;host=localhost', 'root', '');

// Handle this in some other way
if (!isset($_SESSION['user_id']))
{
	die('You are not signed in.');
}



function dd($var) {
		return '<pre>' . print_r($var, true) . '</pre>';
	}