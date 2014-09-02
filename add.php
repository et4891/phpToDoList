<?php

require_once 'app/init.php';

if (isset($_POST['todoText']))
{
	$todoText = trim($_POST['todoText']);

	if (!empty($todoText))
	{
		$addedQuery = $db->prepare("
				INSERT INTO phpToDoList_items (todoText, user, done, created)
				VALUES (:todoText, :user, 0, NOW())
			");

		//use array() instead of [] if error happens in servers
		$addedQuery->execute([
				'todoText' => $todoText,
				'user' => $_SESSION['user_id']
			]);
	}
}

header('Location: index.php');