<?php
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60))
{
    // last request was more than 1 minute ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
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
<?php
require_once 'app/init.php';
?>

<?php if(!isset($_SESSION['password'])): ?>

	<p>Please enter your password first at <a href="<?php echo 'login-form.php'; ?>">Login Form</a></p>
	<?php die(); ?>

<?php endif ?>

<?php
$itemsQuery = $db->prepare("
		SELECT id, todoText, done
		FROM ET_TodoList
		WHERE user = :user
	");

//use array() instead of [] if error happens in servers
$itemsQuery->execute(array(
		'user' => $_SESSION['user_id']
	));

//use array() instead of [] if error happens in servers
$items = $itemsQuery->rowCount() ? $itemsQuery : array();
?>
	<div class="list">
		<h1 class="header">ET's To do lists.</h1>

		<?php if(!empty($items)): ?>
			<ul class="items">
				<?php foreach($items as $item): ?>
					<li>
						<span class="item<?php echo $item['done'] ? ' done' : '' ?>">
							<?php echo $item['todoText']; ?>
						</span>
						<?php if($item['done']): ?>
							<a href="delete.php?as=delete&item=<?php echo $item['id']; ?>" class="delete-button">Delete Task</a>
						<?php endif; ?>	
						<?php if(!$item['done']): ?>
							<!-- the as=done here means as is an action which is used in done.php  -->
							<!-- if as is done then a query will happen in done.php -->
							<!-- &item equals the item id in order to change the class -->
							<a href="done.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p>You haven't added any items yet.</p>
		<?php endif ?>

		<form class="item-add" action="add.php" method="post">
			<input type="text" name="todoText" placeholder="Type a new item here." class="input" autocomplete="off" required>
			<input type="submit" value="Add" class="submit">
		</form>
	</div>
</body>
</html>