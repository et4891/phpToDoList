<?php session_start(); ?>
<?php
require 'app/init.php';
require 'app/password.php';
$_SESSION['password'] = $_POST['password'];
/*Inserts*/
// $password = password_hash('todo', PASSWORD_BCRYPT, array('cost' => 10));
// $username = 'ET';

// $insertQuery = $db->prepare("
// 		INSERT INTO et_todo (username, password)
// 		VALUES (:username, :password)
// 	");

// $insertQuery->execute(array(
// 		'username' => $username,
// 		'password' => $password
// 	));

/* Selects */
$selectQuery = $db->prepare("
		SELECT id, username, password
		FROM et_todo
		WHERE id = :id
	");

$selectQuery->execute(array(
		'id' => 2
	));

$rows = $selectQuery->rowCount() ? $selectQuery : array();

foreach ($rows as $row)
{
	if(password_verify($_SESSION['password'], $row['password']))
	{ 
		exit(header('Location: index.php'));
	}
	else
	{
		echo '<!doctype html>';
		echo '<html lang="en">';
		echo '<head>';
		echo '<link rel="stylesheet" href="css/main.css">';
		echo '<meta charset="UTF-8">';
		echo '<title></title>';
		echo '</head>';
		echo '<body>';
		echo 'Password invalid </br>';
		echo '<a href="' . dirname('__FILE__') . '/login-form.php' .  '">';
		echo 'Please re-enter</a>';
		echo '</body>';
		echo '</html>';

	}
}

/*Alternative way if using the fetchAll(PDO::FETCH_ASSOC)*/
// $rows = $selectQuery->rowCount() ? $selectQuery->fetchAll(PDO::FETCH_ASSOC) : array();
// echo $rows[0]['password'] . '<br>';
// $hash = strlen($rows[0]['password']);
// echo $hash;

// if (password_verify('todo', $rows[0]['password'])) {
//     /* Valid */
//     echo 'valid';
// } else {
//     /* Invalid */
//     echo 'invalid';
// }

?>