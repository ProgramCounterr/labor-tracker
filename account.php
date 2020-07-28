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
		<?php include('header.html'); ?>
		
		<div class="container">
		
			<h2>Change Username and Password</h2>
			<div class="container">
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
				New Username: <input type="text" name="username" class="form-control" placeholder="New Username" autofocus required /> <br/>
				New Password: <input type="password" name="password" class="form-control" placeholder="New Password" required /> <br/>
				<input type="submit" value="Update" class="btn btn-light"  />   
				</form>
			</div>

		</div>
		
		<?php
		include('formHandlers/accountFormHandler.php');
		//close bracket from the "if" from before
		}
		else{   // not logged in yet
			header('Location: login.php');  // redirect to the login page
		}
		
		?>
		
	</body>
</html>