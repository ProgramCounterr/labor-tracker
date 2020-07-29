<!-- Authors: Rowan Dakota -->
<?php
require('model/connect-db.php');
		
		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			
			$newUser = trim($_POST['username']);
			$newPwd = trim($_POST['password']);
			
			//check if username is unique
			$query = "SELECT * FROM `users` WHERE BINARY `username`=:user";
			$statement = $db->prepare($query);
			$statement->bindValue(':user', $newUser);
			
			$statement->execute();	
			$result = $statement->fetch();
			if ($result){
				echo "<div style='text-align: center;' class='bg-danger text-white'>The username is already in use. Please choose another</div>";
				$statement->closeCursor();
				exit;
			}			
			
			$oldUser = $_SESSION['user'];
			$oldPwd = $_SESSION['pwd'];
			
			$query = "UPDATE `users` SET `username`=:nUser, `password`=:nPwd WHERE `username`=:oUser AND `password`=:oPwd";
	
			$statement = $db->prepare($query);
	
			$statement->bindValue(':nUser', $newUser);
			$statement->bindValue(':nPwd', $newPwd);
			
			$statement->bindValue(':oUser', $oldUser);
			$statement->bindValue(':oPwd', $oldPwd);
	
			$result = $statement->execute();
			if (!$result){
				//just for production. Don't let user know what table names are
				//print_r($statement->errorInfo());
				echo "Something for sure whent wrong so . . . that's bad.";
				exit;
			}
			else{
				echo "<div style='text-align: center;' class='bg-success text-white'>Success! $newUser, your username and password have been updated! </div>";
				//update session variable
				$_SESSION['user'] = $newUser;
				$_SESSION['pwd'] = $newPwd;

				//update cookies, if any
				if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
					setcookie('username', $newUser, time() + 86400);
					setcookie('password', $newPwd, time() + 86400);
				}
			}
		
			$statement->closeCursor();
		}

?>