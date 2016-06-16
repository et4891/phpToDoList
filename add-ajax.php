<?php
/**
 * Created by PhpStorm.
 * User: ET
 * Date: 6/18/2015
 * Time: 2:20 PM
 */
require_once 'app/init.php';

if (isset($_POST['todoText']))
{
    $todoText = htmlentities(trim($_POST['todoText']), ENT_QUOTES);

    if (!empty($todoText))
    {
        $addedQuery = $db->prepare("
				INSERT INTO phptodolist_items (todoText, done, created)
				VALUES (:todoText, 0, NOW())
			");

        //use array() instead of [] if error happens in servers
        $addedQuery->execute(array(
            'todoText' => $todoText,
        ));
    }

    // Using PDO's PDO::lastInsertID() to get the last id inserted and then json encode
    // so through ajax json value is sent back to the index.php with the proper id
    $id = $db->lastInsertId();
    $returnValue = array("id"=>$id);
    exit(json_encode($returnValue));
}