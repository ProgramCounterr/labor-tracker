<?php
    if ($confirm) {
        include('model/connect-db.php');

        $query = "SELECT `labor_balance` FROM `work_areas` WHERE `area_name`=:workArea";
        $statement = $db->prepare($query);
        $statement->bindValue(':workArea', $workArea);
        $statement->execute();
        $laborBalance = intval($statement->fetchAll()[0]["labor_balance"]); 

        if($laborBalance - $hours < 0) {
            echo "<p style='color:red;'> Insufficient hours in labor balance of this work area </p>";
            $statement->closeCursor();
            exit;
        }

        // update 'labor_balance' column of 'users' table with columns 'Username' (Primary Key), 'Password', and 'labor_balance'
        $query = "UPDATE `users` SET `labor_balance`=`labor_balance`+:hours WHERE `username`=:user";
        $statement = $db->prepare($query);
        $statement->bindValue(':hours', $hours);
        $statement->bindValue(':user', $_SESSION['user']);
        $result = $statement->execute();

        if(!$result) {
            print_r($statement->errorInfo());
            $statement->closeCursor();
            exit;
        }

        // insert record into 'inputs' table 
        // (which should have a primary key id that auto-increments and foreign keys `Username` and 'area_name'
        // that should have ON DELETE CASCADE and ON UPDATE CASCADE constraints)
        $query = "INSERT INTO `inputs`(`username`, `area_name`, `hours`, `date`) VALUES (:user, :workArea, :hours, :date)";
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $_SESSION['user']);
        $statement->bindValue(':workArea', $workArea);
        $statement->bindValue(':hours', $hours);
        $statement->bindValue(':date', $date);
        $result = $statement->execute();

        if(!$result) {
            print_r($statement->errorInfo());
            $statement->closeCursor();
            exit;
        }

        $query = "UPDATE `work_areas` SET `labor_balance`=`labor_balance`-:hours WHERE `area_name`=:workArea";
        $statement = $db->prepare($query);
        $statement->bindValue(':workArea', $workArea);
        $statement->bindValue(':hours', $hours);
        $result = $statement->execute();

        if(!$result) {
            print_r($statement->errorInfo());
            $statement->closeCursor();
            exit;
        }

        $statement->closeCursor();
    }
?>     