<?php
/**
 * Created by PhpStorm.
 * User: ET
 * Date: 6/18/2015
 * Time: 2:20 PM
 */
require_once 'app/init.php';

if (isset($_POST['description']))
{
    $name       = htmlentities(trim($_POST['name']), ENT_QUOTES);
    $issue      = htmlentities(trim($_POST['issue']), ENT_QUOTES);
    $description   = htmlentities(trim($_POST['description']), ENT_QUOTES);
    $assignTo   = htmlentities(trim($_POST['assignTo']), ENT_QUOTES);
    $date = date('m/d');

    if (!empty($description))
    {
        $addedQuery = $db->prepare("
				INSERT INTO issues (date, name, issue, description, assignTo, done, created)
				VALUES (:date, :name, :issue, :description, :assignTo, 0, NOW())
			");

        //use array() instead of [] if error happens in servers
        $addedQuery->execute(array(
            'date'     => $date,
            'name'     => $name,
            'issue'    => $issue,
            'description' => $description,
            'assignTo' => $assignTo,
        ));
    }

    // Using PDO's PDO::lastInsertID() to get the last id inserted and then json encode
    // so through ajax json value is sent back to the index.php with the proper id
    $id = $db->lastInsertId();
    $returnValue = array("id"=>$id);
    exit(json_encode($returnValue));
}