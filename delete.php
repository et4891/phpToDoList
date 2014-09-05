<?php

require_once 'app/init.php';

if (isset($_GET['as'], $_GET['item']))
{
	// $_GET['as'] is where as=delete is in index.php
	$as = $_GET['as'];
	$item = $_GET['item'];

	// if $as equals to delete then prepare the query and execute it
	// switch is the same as if statement
	switch ($as) {
		case 'delete':
			$doneQuery = $db->prepare("
					DELETE FROM phptodolist_items
					WHERE id = :item
					AND user = :user
				");

			//use array() instead of [] if error happens in servers
			$doneQuery->execute(array(
					'item' => $item,
					'user' => $_SESSION['user_id']
				));
			break;
	}
}

header('Location: index.php');