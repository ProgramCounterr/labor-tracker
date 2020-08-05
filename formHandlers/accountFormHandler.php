<?php
// Authors: Rowan Dakota  and Peter Chen

// accept requests from this url
header('Access-Control-Allow-Origin: http://localhost:4200');
// allow requests from all domains (too risky)
// header ('Access-Control-Allow-Origin: *);
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

// get the size of incoming data
$content_length = (int) $_SERVER['CONTENT_LENGTH'];

// retrieve data from the request
// read whole raw data because data won't always be in $_POST
$postdata = file_get_contents("php://input");

// Process data

$request = json_decode($postdata);

$data = [];
// $data[0]['length'] = $content_length;
foreach ($request as $k => $v) {
    $data[0][$k] = $v; // get properties
}

?>

<?php
/** Authenticates the login form by checking for the given username and password in the database */
function authenticate($user, $pwd) {
	// if the values do not contain only alphanumeric data, return false
	if(!ctype_alnum($user) || !ctype_alnum($pwd))
		return false;

	require('../model/connect-db.php');
	
	$hashPwd = md5($pwd); // hash the password
	// :user and :pwd are bound to the variables down below
	$query = "SELECT * FROM `users` WHERE BINARY `username`=:user AND BINARY `password`=:pwd";

	$statement = $db->prepare($query);

	$statement->bindValue(':user', $user);
	$statement->bindValue(':pwd', $hashPwd);
	
	$statement->execute();
	
	$result = $statement->fetch();
	$statement->closeCursor();
	// This is the case where the username/password is incorrect
	if (!$result)
		return false;

	// if the statement is correctly fetched, then it goes to the profile page
	else
		return true;
	
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$oldUser = trim($data[0]['username']);
	$pwd = trim($data[0]['password']);
	$authorized = authenticate($oldUser, $pwd);
	if(!$authorized)
		die(json_encode(array(
			'message' => "Current password incorrect",
			'code' => 401
		)));
	
	$newUser = trim($data[0]['newUsername']);
	$hashNewPwd = md5(trim($data[0]['newPassword']));
	require('../model/connect-db.php');
	// check if username is unique
	$query = "SELECT * FROM `users` WHERE BINARY `username`=:user";
	$statement = $db->prepare($query);
	$statement->bindValue(':user', $newUser);
	
	$statement->execute();	
	$result = $statement->fetch();
	if ($result){
		$statement->closeCursor();
		die(json_encode(array(
			'message' => "This username is already in use. Please choose another.",
			'code' => 409
		)));
	}			

	$hashOldPwd = md5($pwd); // store hash of old password
	
	// attempt to update database
	$query = "UPDATE `users` SET `username`=:nUser, `password`=:nPwd WHERE `username`=:oUser AND `password`=:oPwd";

	$statement = $db->prepare($query);

	$statement->bindValue(':nUser', $newUser);
	$statement->bindValue(':nPwd', $hashNewPwd);
	
	$statement->bindValue(':oUser', $oldUser);
	$statement->bindValue(':oPwd', $hashOldPwd);

	$result = $statement->execute();
	$statement->closeCursor();
	if (!$result) {

		// send error response (in json format) and exit
		echo json_encode(array(
			'message' => 'Unable to update database',
			'code' => 500
		));
	}
	// FIXME: DOES NOT WORK
	else {
		session_start();
		// update session variable
		$_SESSION['user'] = $newUser . "Old User: " . $oldUser . " END";
		
		// update cookies, if any
		if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
			setcookie('username', $newUser, time() + 86400);
			setcookie('password', $hashNewPwd, time() + 86400);
		}

		// Send response (in json format) back to the frotend
		echo json_encode(array(
			'message' => "Success! $newUser, your username and password have been updated!",
			'code' => 200
		));

	}

}

?>