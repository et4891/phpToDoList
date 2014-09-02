<?php

require_once 'app/init.php';

if (isset($_GET['as'], $_GET['item']))
{
	$as = $_GET['as'];
	$item = $_GET['item'];

	switch ($as) {
		case 'done':
			$doneQuery = $db->prepare("
					UPDATE phpToDoList_items
					SET done = 1
					WHERE id = :item
					AND user = :user
				");

			//use array() instead of [] if error happens in servers
			$doneQuery->execute([
					'item' => $item,
					'user' => $_SESSION['user_id']
				]);
			break;
	}
}

header('Location: index.php');