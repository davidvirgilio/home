<?php


// if($_SERVER["REQUEST_METHOD"]=='GET'){


        $title = "Join Us";
        $message = "You have to sign in to your account to have access to the special hunting features.";
        $button = "Sing In";
        $href = "sign-in.php";

    // }





define('TITLE','Sign in');
require 'required/simple-header.html';

?>
<body>
<main id="dialogContainer">
    <div id="locationInfo">
    <div class="sign-container">
        <div class="title-container">
            <h2><?php echo $title; ?></h2>
            <button id="closeInfo" class="close"><img alt="close" src="images/icon-close.svg"></button>
        </div>
        <p><?php echo $message;?></p>
        <a  href="<?php echo $href; ?>" class="button"><?php echo $button; ?></a>
        <p>Don't you have and account?</p>
        <a href="sign-up.php">Create an account</a>
    </div>
    </div>
</main>
</body>