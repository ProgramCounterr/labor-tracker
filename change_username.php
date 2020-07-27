<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Rowan Dakota">

		<title>Twin Oaks Labor Tracker</title>
		<link rel="icon" href="images/logo.png"/>

		<!-- CSS only -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/loginStyle.css"/>

		<!-- Font awesome is used for the icons (<i> elements) and requires this line-->
		<script src="https://kit.fontawesome.com/245f30a0ca.js" crossorigin="anonymous"></script>

		<!-- JS, Popper.js, and jQuery -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" type="text/css" href="styles/style.css"/>
		
	</head>

<?php
session_start();
if (isset($_SESSION['user']))
{
?>

	<body>
	    <header>
            <nav> 
				<a href="#"id="logo"><img src="images/logo.png" alt="Twin Oaks Leaves"></a>
                <a href="#" id="site-name"> Twin Oaks</a>
                <ul class="nav">
                    <li><a href="input.html"><i class="fas fa-clock"></i>Input labor</a></li>
                    <li><a href="profile.html"><i class="fas fa-user"></i>Profile</a></li>
                    <li><a href="login.html"><i class="fas fa-sign-in-alt"></i>Logout</a></li>
                </ul>
            </nav>
        </header>
		<div class="container">
		
			<h2>Change Username and Password</h2>
			<div class="container">
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
				Name: <input type="text" name="username" class="form-control" placeholder="New Username" autofocus required /> <br/>
				Password: <input type="password" name="password" class="form-control" placeholder="New Password" required /> <br/>
				<input type="submit" value="Update" class="btn btn-light"  />   
				</form>
			</div>

		</div>
		
				
		<?php
		
		//close bracket from the "if" from before
		}
		else{   // not logged in yet
			header('Location: login.php');  // redirect to the login page
		}
		
		require('model/connect-db.php');
		
		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			
			//We might want to do put some validation stuff here.
			
			$oldUser = $_SESSION['user'];
			$oldPwd = $_SESSION['pwd'];
			
			$newUser = trim($_POST['username']);
			$newPwd = trim($_POST['password']);
			
			$query = "SELECT * FROM `users` WHERE `username`=:user AND `password`=:pwd";
			
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
				echo "<div style='text-align: center;' class='bg-success text-white'>Success! Your new username is " . $newUser . "</div>";
			}
	
			$statement->closeCursor();
			
			
		}
		?>
		
		
	</body>
</html>