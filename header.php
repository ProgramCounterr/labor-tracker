<!-- Author: Peter Chen -->
        <header>
            <nav>
                <a href="#"id="logo"><img src="images/logo.png" alt="Twin Oaks Leaves"></a>
                <a href="profile.php" id="site-name">Twin Oaks</a>
                <ul class="nav">
                    <li><a href="input.php"><i class="fas fa-clock"></i>Enter Hours</a></li>
                    <li><a href="profile.php"><i class="fas fa-user"></i>Profile</a></li>
                    <li>
                        <a href=<?= "http://localhost:4200?page=account&user=" . $_SESSION['user'] ?> >
                        <i class="fas fa-address-card"></i>Account</a>
                    </li>
                    <li><a href="logout.php"><i class="fas fa-sign-in-alt"></i>Logout</a></li>
                </ul>
            </nav>
        </header>