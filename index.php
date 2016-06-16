<?php 
require_once 'app/init.php';

$itemsQuery = $db->prepare("
		SELECT id, todoText, done
		FROM phptodolist_items
	");

$itemsQuery->execute();
//use array() instead of [] if error happens in servers
$items = $itemsQuery->rowCount() ? $itemsQuery : array();
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>To Do</title>

	<!-- Loads google fonts "Open Sans" and "Shadows Into Light Two" -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">

	<!-- Loads main css created -->
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<div class="list">
		<h1 class="header">To do lists.</h1>

		<?php if(!empty($items)): ?>
			<ul class="items">
				<?php foreach($items as $item): ?>
					<li>
						<span class="item<?php echo $item['done'] ? ' done' : '' ?>">
							<?php echo $item['todoText']; ?>
						</span>
						<?php if($item['done']): ?>
							<a href="delete-ajax.php?as=delete&item=<?php echo $item['id']; ?>" class="delete-button">Delete Task</a>
						<?php endif; ?>	
						<?php if(!$item['done']): ?>
							<!-- the as=done here means as is an action which is used in done.php  -->
							<!-- if as is done then a query will happen in done.php -->
							<!-- &item equals the item id in order to change the class -->
							<a href="done-ajax.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p class="empty">You haven't added any items yet.</p>
                <ul class="items"></ul>
		<?php endif ?>

		<form class="item-add" action="add-ajax.php" method="post">
			<input type="text" name="todoText" placeholder="       Type a new item here." class="input" autocomplete="off" required>
			<input type="submit" value="Add" class="submit">
		</form>
	</div>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="js/ajax.js"></script>
</body>
</html>