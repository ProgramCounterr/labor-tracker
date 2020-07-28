<?php
    if ($confirm) {
        include('model/connect-db.php');

        $query = "SELECT `labor_balance` FROM `work_areas` WHERE `area_name`=:workArea";
        $statement = $db->prepare($query);
        $statement->bindValue(':workArea', $workArea);
        $statement->execute();
        $laborBalance = intval($statement->fetchAll()[0]["labor_balance"]); 

        if($laborBalance - $hours < 0) {
            echo "Insufficient hours in labor balance of this work area";
            $statement->closeCursor();
            exit;
        }

        // update 'Total labor' column of 'users' table with columns 'Username', 'Password', and 'Total labor'
        $query = "UPDATE `users` SET `Total labor`=`Total labor`+:hours WHERE `Username`=:user";
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
        $query = "INSERT INTO `inputs`(`Username`, `Work Area`, `Hours`, `Date`) VALUES (:user, :workArea, :hours, :date)";
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
        else
            echo "Successfully submitted " . intval($hours) . " hours at the $workArea for $date!";

        $statement->closeCursor();
    }
?>     