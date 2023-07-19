<?php
//Setting the time zone
date_default_timezone_set("America/Edmonton");

//Starting the session to work with it
session_name("dessert-hunters");
session_start();

//If there is not previous information, the user is redirected to the main page. The session and the cookie are set always together, then the logical operator can be || or &&.
if(!isset($_COOKIE["access"]) || !isset($_SESSION["access"])){
} 

//Deleting the specific cookie we created in the login. I used the same time as I did when setting the cookie to follow the book's directions. (Just in case)
setcookie("access",FALSE,time()-60*60*24*7);

//Destroying the session
session_destroy();
header("Location:index.php");

?>