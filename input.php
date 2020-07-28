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
        <?php include('header.html'); ?>

        <?php include('model/workAreas-db.php'); ?>

        <div class="buffer"><?php include('formHandlers/inputFormHandler.php'); ?></div>

        <div class="container">

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="hours">Hours worked:</label>
                        <input id="hours" type="number" name="hours"
                            value="<?php if (isset($_GET['hours']) && !$confirm) echo $_GET['hours']; ?>" 
                            <?php if(empty($_GET['hours'])) { ?> autofocus <?php }; ?>/>
                        <span class="alert-danger"><?= $hours_msg; ?></span>
                    </div>

                    <div class="col-md-3">
                        <label for="work-area">Work area:</label>
                        <input type="text" list="work-areas" name="work-area" id="work-area"
                            value="<?php if(isset($_GET['work-area']) && !$confirm) echo $_GET['work-area'] ?>"
                            <?php if(empty($_GET['work-area'])) { ?> autofocus <?php }; ?> />
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
                        <span class="alert-danger"><?= $workArea_msg; ?></span>
                    </div>

                    <div class="col-md-3">
                        <label for="date">Day of work:</label>
                        <input type="date" name="date" id="date"
                            value="<?php if(isset($_GET['date']) && !$confirm) echo $_GET['date'] ?>"/>
                        <span class="alert-danger"><?= $date_msg; ?></span>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" class="btn btn-primary btn-lg" id="submit" value="Submit"/>
                    </div>
                </div>
            </form>
            
            <h2 class="submissions">Recent submissions:</h2>
            <table class="submissions">
                <thead>
                    <tr>
                        <th><b>Work area</b></th>
                        <th><b>Hours</b></th>
                        <th><b>Date</b></th>
                    </tr>
                </thead>

                <div class="database"><?php include('formHandlers/inputFormDbHandler.php'); ?></div>

                <tbody>
                    <?php
                        ob_start(); // start tracking outputs (echo statements)
                        function makeInputsTable() {
                            include('model/connect-db.php');
                            $query = "SELECT `Work Area`, `Hours`, `Date` FROM `inputs` WHERE `Username`=:user ORDER BY `Id` DESC LIMIT 5";
                            $statement = $db->prepare($query);
                            $statement->bindValue(':user', $_SESSION['user']);
                            $statement->execute();
                            $results = $statement->fetchAll();
                            $statement->closeCursor();

                            if(!$results) echo "No recent inputs";
                            else {
                                foreach($results as $record) {
                                    echo "<tr>";
                                    echo "<td>" . $record['Work Area'] . "</td>";
                                    echo "<td>" . $record['Hours'] . "</td>";
                                    echo "<td>" . $record['Date'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        makeInputsTable(); // initial invocation
                        // update table every time user submits
                        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['hours'])) {
                            ob_end_clean(); // clear echo statements since ob_start()
                            makeInputsTable();
                        }
                    ?>
                </tbody>
            </table>
                
        </div>
        <script src="js/inputScript.js"></script>
        
        <?php
        //close bracket from the "if" from before
        }
        else {   // not logged in yet
            header('Location: login.php');  // redirect to the login page
        }
        ?>
    </body>
</html>