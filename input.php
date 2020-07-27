<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Peter Chen">

        <title>Twin Oaks Labor tracker</title>
        <link rel="icon" href="images/logo.png"/>

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="styles/reset.css"/>
        <!-- CSS Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="styles/style.css"/>
        <link rel="stylesheet" type="text/css" href="styles/inputStyle.css"/>
        
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
        <header>
            <nav>
				<a href="#"id="logo"><img src="images/logo.png" alt="Twin Oaks Leaves"></a>
                <a href="profile.html" id="site-name">Twin Oaks</a>
                <ul class="nav">
                    <li><a href="input.html"><i class="fas fa-clock"></i>Input labor</a></li>
                    <li><a href="profile.html"><i class="fas fa-user"></i>Profile</a></li>
                    <li><a href="login.html"><i class="fas fa-sign-in-alt"></i>Logout</a></li>
                </ul>
            </nav>
        </header>

        <div class="buffer"></div>

        <div class="container">
            <form action="#">
                <div class="row">
                    <div class="col-md-4">
                        <label for="hours">Hours worked:</label>
                        <input id="hours" type="text" name="hours" autofocus/>
                        <span class="alert-danger"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="searchbar">Search for work area:</label>
                        <input type="text" list="work-areas" name="work-area" id="work-area">
                        <datalist id="work-areas">
                            <option value="Curds"></option>
                            <option value="Garden"></option>
                            <option value="Hammocks"></option>
                            <option value="Kettle"></option>
                            <option value="Pack Help"></option>
                            <option value="Pack Honcho"></option>
                            <option value="Seed Racks"></option>
                            <option value="Seeds"></option>
                            <option value="Tofu Hut"></option>
                            <option value="Trays"></option>
                        </datalist> 
                        <span class="alert-danger"></span>
                    </div>

                    <div class="col-md-4">
                        <input type="submit" class="btn btn-primary btn-lg" id="submit" value="Submit"/>
                    </div>

                </div>
            </form>
        </div>
        <script src="js/inputScript.js"></script>
		
		<?php
		//Make a table of all the work areas and populate it (if they don't exist already)
		$work_areas = array(["Curds", 1000],
						["curds", 1000],
						["Garden", 1000],
						["Hammocks", 1000],
						["Kettle", 1000],
						["Pack Help", 1000],
						["Pack Honcho", 1000],
						["Seed Racks", 1000],
						["Seeds", 1000],
						["Tofu Hut", 1000],
						["Trays", 1000]
					);

		require('model/connect-db.php');
		$query = "SELECT * FROM `work_areas`";
		$statement = $db->prepare($query);
		$statement->execute();	
		$result = $statement->fetchAll();
		//The table doesn't exit
		if (!$result){
				echo "It doesn't exist!";
				
				$query = "CREATE TABLE work_areas(
				area_name VARCHAR(255) PRIMARY KEY,
				labor_balance INT NOT NULL )";
				$statement = $db->prepare($query);
				$statement->execute();
				$statement->closeCursor();
			}
		foreach ($work_areas as $work_area){
			$query = "SELECT * FROM `work_areas` WHERE area_name=:area";
			$statement = $db->prepare($query);
			$statement->bindValue(':area', $work_area[0]);
			$statement->execute();
			$result = $statement->fetch();
			//The work area doesn't exist
			if (!$result){
				$que = "INSERT INTO `work_areas` (area_name, labor_balance) VALUES(:area, :labor)";
				$state = $db->prepare($que);
				$state->bindValue(':area', (String)$work_area[0]);
				$state->bindValue(':labor', (int)$work_area[1]);
	
				$r = $state->execute();
			}
			else{
				echo "Yay! The work area exists! </br>";
			}
		}
	}

/*
function createTable(){
 
	//connect to the database
	require('connect-db.php');
	
	//write query
	$query = "CREATE TABLE course(
				course_ID VARCHAR(8) PRIMARY KEY,
				course_desc VARCHAR(255) NOT NULL )";
				
	//prepare the query, get statement instance
	$statement = $db->prepare($query);
	
	//run the query
	$statement->execute();
	
	//release this cursor. Make it so db variable can be used by others
	$statement->closeCursor();


//close bracket from the "if" from before
}
else{   // not logged in yet
	header('Location: login.php');  // redirect to the login page
}*/
?>
		
    </body>
</html>