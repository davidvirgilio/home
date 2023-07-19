<?php 

    session_name("dessert-hunters");
    session_start();

    date_default_timezone_set("America/Edmonton");

    if(!isset($functionsCalled)){
    require 'required/functions.php';
    }





    if(isset($_SESSION["sign-in"])){
        // If yes, access is given without verifying anything else.
        $username = $_SESSION['sign-in'];
        $login=TRUE;
    }

    else if(isset($_COOKIE["access"])){
        // If there is a cookie, it searches for the user with the cookie information in mysqli
        $password= $_COOKIE["access"];
        $username = get_user($password);   //See functions.php
    
        //If there is a user with the credentials, access is given. If not, it only goes directly to the form.
        if($username){
        $_SESSION["sign-in"]=$username;     //Storing the session
        $login=TRUE;
        }
    }else{
        $login = false;
    }

    if($login){
        $usernameDisplay = ucfirst($username);
        $userArray = get_array_where('users','username',$username);

        $points = $userArray['points'];
        $rewards = $userArray['rewards'];
        $profile = $userArray['profile_picture'];
        $userId = $userArray['user_id'];
    }


    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="querys.css">
    <script src="general.js" defer></script>
    <title>
        <?php
            if(TITLE){
                echo TITLE;
            }else{
                echo "Dessert Hunters";
            }
        ?>

    </title>
</head>
<body>
    <header>
        <a class="logo-container" href="index.php"><img alt="Dessert Hunters" src="images/logo.svg"></a>
        <a href="index.php"><h1>Dessert Hunters</h1></a>
        <button id="buttonMenu" type="menu"><img alt="menu" src="images/menu.svg"></button>
        <nav id="menu" class="menu hidden">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About us</a></li>
                <?php
                    if($login){
                        echo '<li><a href="logout.php">Sing out</a></li>';
                    }
                ?>
                <li>
                <?php
                    if($login){
                        echo '<a href="account.php">Account</a>';
                        echo "<img class='profile hidden' src='images/users/$profile'";
                    }else{
                        echo '<button class="sign-in">Sign in</button>';
                    }
                ?></li>
                
                
            </ul>
        </nav>
    </header>