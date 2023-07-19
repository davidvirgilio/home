<?php 


define('TITLE','Home');
require 'required/header.php';

?>
<div>
<main class="home">
        <?php
            if($login){
                echo "<a class='profile-container' href='account.php'><img class='profile' src='images/users/$profile'></a>";
            }
        ?>
        <div id="viewport">
            <div id="map">
            <div class="map-container">
                <img alt="Map" src="images/map.svg">
            </div>
            <div class="indicator-container">
                <button id="indicator1" class="indicator bakery drinks" type="button" value="1"><img src="images/indicator.svg"></button>
                <button id="indicator2" class="indicator bakery drinks" type="button" value="2"><img src="images/indicator.svg"></button>
                <button id="indicator3" class="indicator ice-cream drinks" type="button" value="3"><img src="images/indicator.svg"></button>
                <button id="indicator4" class="indicator ice-cream" type="button" value="4"><img src="images/indicator.svg"></button>
                <button id="indicator5" class="indicator drinks" type="button" value="5"><img src="images/indicator.svg"></button>
                <button id="indicator6" class="indicator ice-cream drinks" type="button" value="6"><img src="images/indicator.svg"></button>
                <button id="indicator7" class="indicator drinks bakery" type="button" value="7"><img src="images/indicator.svg"></button>
                <button id="indicator8" class="indicator drinks" type="button" value="8"><img src="images/indicator.svg"></button>
            </div>
            <div>

        <div>

        </div>
    </div>
    </main>
    <aside>
        <button id="filtering">
            <h3 class="label">Filters</h3>
            <img src="images/arrow-right.svg">
        </button>
        <nav class="hidden">
            <ul>
                <li><button id="sortAll" type="button" ><img src="images/indicator.svg"></li>
                <li><button id="sortIceCream" type="button" ><img src="images/icon-icecream.svg"></li>
                <li><button id="sortDrinks" type="button" ><img src="images/icon-drink.svg"></li>
                <li><button id="sortBakeries" type="button" ><img src="images/icon-cake.svg"></li>
            </ul>
        </nav>
    </aside>


    <aside class="dialog-box">
        <button id="mascot" type="button">
            <img src="images/mascot-info.svg">
        </button>
        <div id="dialog" class="hidden">
            <h3>Welcome!</h3>
            <div>
                <button id="previousDialog" class="non-visible">
                    <img src="images/arrow-left.svg">
                </button>
                <p>Explore delish~ places in the Calgary Downtown. Select the ice cream cones on the map to discover the yummy desserts in the area.</p>
                <button id="nextDialog">
                    <img src="images/arrow-right.svg">
                </button>
            </div>
            <?php
                if(!$login){
                    echo '<button class="sign-in button hidden">Sign In</button>';
                }
            ?>
        </div>
    </aside>

<iframe id="dialogContainer" name="result" class="hidden" src="">
</iframe> 
<div>
