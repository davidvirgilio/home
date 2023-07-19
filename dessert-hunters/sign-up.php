<?php


session_name("dessert-hunters");
session_start();

date_default_timezone_set("America/Edmonton");


$msg = FALSE;
$success = FALSE;

if($_SERVER["REQUEST_METHOD"]=="POST"){

        //Variables' short forms
        $username = strtolower($_POST["username"]);
        $password =$_POST["password"];
        $confirm =$_POST["confirm-password"];

        //Verifying if the inserted passwords match
        if($password==$confirm){
            
            //Calling our functions
            require "required/functions.php";

            //Verifying if there is not another user with the same username. In this way, we also avoid error from the database.
            $existence = get_array_where("username",$username);

            //If there is, it sends a message.
            if($existence){
                $msg="This user already exists. Please, choose another username.";
            }

            else{
                //If the username is available, it sends the new credentials to the database.
                $hashedPassword = create_new_user($username,$password);
                
                
                $_SESSION["sign-in"]= $username;
                setcookie("sign-in",$hashedPassword,time()+60*60*24);

                $success = TRUE;
                }
                
        }
        //If the passwords are different, a warning is sent an the user must insert new data.
        else{
            $msg ="The password doesn't match";
        }

    }

    define('TITLE','Sign Up');
    require ('required/simple-header.html');

?>
<body>
<main id="dialogContainer" class="">
    <div id="locationInfo">
        <div class="sign-container">
        <div class="title-container">
            <h2>Become a Dessert Hunter</h2>
            <button id="closeInfo2" class="close"><img alt="close" src="images/icon-close.svg"></button>
        </div>
        <?php
            if($msg){
                echo "<p class=\"error\">$msg</p>";
            }
            if($success){
                echo '<p>You have successfully created and account.</p>';
                echo '<a target="_parent" class="button" id="accountButton" href="account.php">See my Account</a>';
            }else{
        ?>
            <form method="POST">
                <div>
                <label for="username">Username</label>
                <input id="username" name="username" type="text">
                </div>
                <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password">
                </div>
                <div>
                <label for="confirm-password">Confirm Password</label>
                <input id="confirm-password" name="confirm-password" type="password">
                </div>
                <input class="button" type="submit" value="Sign Up">
                <input name="type" type="hidden" value="signUp">
            </form>
            <p>Don't you already have an account?</p>
            <a title="Log in" href="sign-in.php">Log in in to your account</a>
        <?php       
            }
        ?>
        </div>
    </div>
</main>
</body>
