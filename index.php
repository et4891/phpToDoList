<?php 
require_once 'app/init.php';

$itemsQuery = $db->prepare("
		SELECT id, name, done
		FROM phpToDoList_Items
		WHERE user = :user
	");

//use array() instead of [] if error happens in servers
$itemsQuery->execute([
		'user' => $_SESSION['user_id']
	]);

//use array() instead of [] if error happens in servers
$items = $itemsQuery->rowCount() ? $itemsQuery : [];

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
						<span class="item<?php echo $item['done'] ? ' done' : '' ?>"><?php echo $item['name']; ?></span>
						<?php if(!$item['done']): ?>
							<a href="done.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
						<?php endif ?>
					</li>
				<?php endforeach ?>
			</ul>
		<?php else: ?>
			<p>You haven't added any items yet.</p>
		<?php endif ?>

		<form class="item-add" action="add.php" method="post">
			<input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
			<input type="submit" value="Add" class="submit">
		</form>
	</div>
</body>
</html>