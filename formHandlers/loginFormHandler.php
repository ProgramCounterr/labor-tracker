<!-- Authors: Rowan Dakota and Peter Chen -->
<?php
    /** Authenticates the login form by checking for the given username and password in the database */
    function authenticate($user, $pwd) {
        // if the values contain only alphanumeric data, display error and exit
        if(!ctype_alnum($user) || !ctype_alnum($pwd))
            return false;

        require('model/connect-db.php');
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
        if (!$result){
            echo "<div style='text-align: center;' class='bg-danger text-white'>The username or password is incorrect</div>";
            return false;
        }
        // if the statement is correctly fetched, then it goes to the profile page
        else{
            return true;
        }
        
    }
?>

<?php
    // The isset makes sure that there is something in the text fields
    if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
        $username = trim($_COOKIE['username']);
        $password = trim($_COOKIE['password']);
        $authorized = authenticate($username, $password);
        if($authorized) {
            session_start();
            $_SESSION['user'] = $username;
        }
    }

    else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {	
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $authorized = authenticate($username, $password);
        if($authorized) {
            session_start();
            $_SESSION['user'] = $username;
            // puts cookie in user's browser if 'Remember me' option is checked
            if(isset($_POST['remember']) && $_POST['remember'] == "1")
            {
                setcookie('username', $username, time() + 86400); // set for one day
                setcookie('password', md5($password), time() + 86400);
            }
            // redirects to other page
            header('Location: profile.php');
        }
    }
?>