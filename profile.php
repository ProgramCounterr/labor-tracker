<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Rowan Dakota">

        <title>Twin Oaks Labor tracker</title>
		<link rel="icon" href="images/logo.png"/>
		
		<!-- CSS -->
        <link rel="stylesheet" type="text/css" href="styles/reset.css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="styles/style.css"/>
		<link rel="stylesheet" type="text/css" href="styles/profileStyle.css"/>
        <!-- Font awesome is used for the icons (<i> elements) and requires this line-->
        <script src="https://kit.fontawesome.com/245f30a0ca.js" crossorigin="anonymous"></script>
    </head>

<!--checks to see if the user is logged in-->
<?php
session_start();
if (isset($_SESSION['user']))
{
?>
 
    <body>
        <?php include('header.html'); ?>
		
		
		<div id="chart"></div>

		<div class="form-group">
			<div class="checkbox">
				<label><input type="checkbox" id="change-view"> Show Hours Worked per Day</label>
			</div>
		</div>

		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script src="js/profileScript.js"></script>

<?php
//close bracket from the "if" from before
}
else{   // not logged in yet
	header('Location: login.php');  // redirect to the login page
}
?>

		
	</body>
</html>