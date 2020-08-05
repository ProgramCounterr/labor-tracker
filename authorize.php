<?php
// author: Peter Chen

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
$data[0]['length'] = $content_length;
foreach ($request as $k => $v) {
    $data[0][$k] = $v;
}
$user = $data[0]['username'];
// check for username in database

// if the values do not contain only alphanumeric data respond false
if(!ctype_alnum($user)) {
    die(json_encode(array(
        'message' => "Forbidden username",
        'code' => 403
    )));
}

require('model/connect-db.php');
$query = "SELECT * FROM `users` WHERE BINARY `username`=:user";

$statement = $db->prepare($query);
$statement->bindValue(':user', $user);
$statement->execute();
$result = $statement->fetch();
$statement->closeCursor();
// This is the case where the username is not in the database
if (!$result) {
    echo json_encode(array(
        'message' => "Username not found",
        'code' => 401
    ));
}
// if the statement is correctly fetched
else {
    echo json_encode(array(
        'message' => "Username found",
        'code' => 200
    ));
}
    
?>
