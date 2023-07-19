<?php


// Setting the correct timezone
date_default_timezone_set("America/Edmonton");

// Declaring variables
$login=FALSE;       // to determine if the session has started
$error = FALSE;
$username = FALSE;

require 'required/functions.php';
session_name("dessert-hunters");
session_start();

// First, the script checks if there is an active session. 
if(isset($_SESSION["sign-in"])){
    // If yes, access is given without verifying anything else.
    $login=TRUE;
}

// If not, it looks for a cookie with the access. This only happens if the browser closed before. This avoids sending information back and forth.


else if(isset($_COOKIE["access"])){
    // If there is a cookie, it searches for the user with the cookie information in mysqli
    $password= $_COOKIE["access"];
    $username = get_user($password);   //See functions.php

    //If there is a user with the credentials, access is given. If not, it only goes directly to the form.
    if($username){
    $_SESSION["sign-in"]=$username;     //Storing the session
    $login=TRUE;
    }else{
    $error= TRUE;
    }
}

else if($_SERVER["REQUEST_METHOD"]=="POST"){
    
        // Checking if the form field are not empty. I preferred this to send manual messages instead of using required values in the form.
        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            $username = strtolower($_POST['username']);
            $password = $_POST['password'];
            
            //Verifying if the password matches with the one in the database
            $passwordCheck = verify_password($username,$password);          // See functions.php

            // If the password matches, it gives access.
            if(isset($passwordCheck['verification']) && $passwordCheck['verification']){
                $_SESSION["sign-in"]=$username;                                  //Starting the session
                setcookie("access",$passwordCheck['password'],time()+60*60*24*7); //Storing the cookie
                $login=TRUE;
            } else{
                $error = TRUE;
            }

        // if the one of the fields in the form has no data, it sends an error message
        }else{
            $error = TRUE;
        }
}

define('TITLE','Sign in');
require 'required/simple-header.html';

?>
<body>
<main id="dialogContainer">
    <div id="locationInfo">
    <div class="sign-container">
        <div class="title-container">
            <h2>Sign In</h2>
            <button id="closeInfo2" class="close"><img alt="close" src="images/icon-close.svg"></button>
        </div>
        <?php
            if($error){
                echo '<p class="error">We were unable to find you. Please, review your credentials.</p>';
            } 

            if($login){
                echo '<p>You have successfully log in</p>';
                echo '<a type="button" target="_parent"  class="button" id="accountButton" href="account.php">See my Account</a>';
            }else{

        ?>

        <form method="POST">
            <div>
            <label for="username">Username</label>
            <input id="username" name="username" type="text" <?php
                if($username){
                    echo "value=\"$username\"";
                }
            ?>>
            </div>
            <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password">
            </div>
            <input class="button" type="submit" value="Sign In">
        </form>
        <p>Don't you have an account?</p>
        <a title="Join Dessert Hunters" href="sign-up.php">Create an account</a>
        <?php      
            }
        ?>
        
        </div>
    </div>
</main>
</body>