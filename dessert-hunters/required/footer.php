<footer>
        <img src="images/mascot.svg">
        <div>
            <nav class="footerNav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About us</a></li>
                    <li>
                        <?php
                            if($login){
                                echo '<a href="account.php">Account</a>';
                            }else{
                                echo '<button class="sign-in">Sign in</button>';
                            }
                         ?>
                    </li>
                </ul>
            </nav>
            <a class="logo-container" href="index.php"><img alt="Dessert Hunters" src="images/logo.svg"></a>
        </div>
        <small>Dessert Hunters &copy; 2023</small>
    </footer>
</body>
</html>
