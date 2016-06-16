<?php

require_once 'app/init.php';

if (isset($_GET['as'], $_GET['item']))
{
	// $_GET['as'] is where as=done is in index.php
	$as = $_GET['as'];
	$item = $_GET['item'];

	// if $as equals to done then prepare the query and execute it
	// switch is the same as if statement
	switch ($as) {
		case 'done':
            $doneQuery = $db->prepare("
					UPDATE phptodolist_items
					SET done = 1
					WHERE id = :item
				");

			//use array() instead of [] if error happens in servers
			$doneQuery->execute(array(
					'item' => $item,
				));
			break;
	}
}

