<?php

require_once 'app/init.php';

if (isset($_POST['name']))
{
	$name = trim($_POST['name']);

	if (!empty($name))
	{
		$addedQuery = $db->prepare("
				INSERT INTO phpToDoList_items (name, user, done, created)
				VALUES (:name, :user, 0, NOW())
			");

		//use array() instead of [] if error happens in servers
		$addedQuery->execute([
				'name' => $name,
				'user' => $_SESSION['user_id']
			]);
	}
}

header('Location: index.php');