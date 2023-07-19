<?php


define("TITLE", "About Us");
require 'required/header.php';

?>

<main class="about">

<div class="img-container">
<h2>About Us</h2>
</div>
<div>
<p>Once upon a time, a group of talented individuals randomly formed a company. They chose downtown as their hub and came up with the idea of creating a map focused on desserts. With their various skills, they worked together amazingly well. During their journey, they enjoyed delicious food too. It was a wonderful experience of collaboration and enjoyment</p>

<h3>Dessert Hunters Trivia</h3>
<p>You'll be able to select a location and answer the questions it has, when you answer it correctly you will receive 10 points, and whenever you collect a total of 30 points, you will get a coupon to use for your next hunt!
</p>

<?php 
    if($login){
        echo '<a class="button" href="index.php">Start Hunting</a>';
    }else{
        echo '<a class="sign-in button" href="sign-in.php">Start Hunting</a>';

    }
?>
</div>

</main>
<iframe id="dialogContainer" class="hidden" src="">
</iframe>

<?php

require 'required/footer.php';

?>