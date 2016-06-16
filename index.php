<?php 
require_once 'app/init.php';

$itemsQuery = $db->prepare("
		SELECT id, name, todoText, done
		FROM phptodolist_items
	");

$itemsQuery->execute();

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
			<table class="items">
				<thead>
					<tr>
						<th class="w100"">Date</th>
						<th class="w100"">Name</th>
						<th class="w100"">Issue #</th>
						<th class="w660">Description</th>
						<th class="w100"">Assign To</th>
						<th class="w100"">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($items as $item): ?>
						<tr>
							<td>Aug-10</td>
							<td>
								<?php echo $item['name']; ?>
							</td>
							<td>83726</td>
							<td style="overflow-x: auto; width: 660px;" class="item<?php echo $item['done'] ? ' done' : '' ?>">
								<?php echo $item['todoText']; ?>
							</td>
							<td>John</td>
							<td>
								<?php if($item['done']): ?>
									<a href="delete-ajax.php?as=delete&item=<?php echo $item['id']; ?>" class="delete-button">Delete Task</a>
								<?php endif; ?>
								<?php if(!$item['done']): ?>
									<!-- the as=done here means as is an action which is used in done.php  -->
									<!-- if as is done then a query will happen in done.php -->
									<!-- &item equals the item id in order to change the class -->
									<a href="done-ajax.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<p class="empty">You haven't added any items yet.</p>
                <table class="items">
					<thead>
						<tr>
							<td class="w100">Date</td>
							<td class="w100"">Name</td>
							<td class="w100"">Issue #</td>
							<td class="w660">Description</td>
							<td class="w100"">Assign To</td>
							<td class="w100"">Actions</td>
						</tr>
					</thead>
				</table>
		<?php endif ?>

		<form class="item-add" action="add-ajax.php" method="post">
			<input type="text" name="name" placeholder="       Type your name here" class="input" autocomplete="on" required>
            <input type="text" name="issue" placeholder="       Type your issue# here" class="input" autocomplete="on" required>
			<input type="text" name="todoText" placeholder="       Type a new item here." class="input" autocomplete="on" required>
            <input type="text" name="assignTo" placeholder="       Type name of person assigning to" class="input" autocomplete="on" required>
			<input type="submit" value="Add" class="submit">
		</form>
	</div>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="js/ajax.js"></script>
</body>
</html>