<?php 


define('TITLE','Home');
require 'required/header.php';

$progress = $points*100/30;
$favStoresQuery = "SELECT * FROM `favourite-locations` WHERE `user_id`=$userId AND `liked_store`=1;";
$resultFav = send_query($favStoresQuery);
$favStoresArray = get_info($resultFav,'multiple');


?>

<main class="account">
    <h2>Welcome <?php echo $usernameDisplay; ?>!</h2>
    <div>
        <img alt="<?php echo $usernameDisplay; ?> picture"  class="profile" src="images/users/<?php echo $profile;?>">
        <img alt="Edith profile" src="images/icon-edit.svg">
    </div>
        <section>
        <h3>Instructions</h3>
        <p>You'll be able to select a location and answer the questions it has, when you answer it correctly you will receive 10 points, and whenever you collect a total of 30 points, you will get a coupon to use for your next hunt!</p>
    </section>
    <section>
        <h3>My Points</h3>
        <div class="points-container"> 
            <!-- This is the outside and fixed bar -->
            <div class="progress-bar">
                <!-- This is the progress  blue responsive bar-->
                <div class="progress" style="width: <?php echo $progress?>%;">
                    <!-- I included the image and the tag in INSIDE the blue bar-->
                    <img class="donut" src="images/donut.svg">
                    <span id="marker" class="tag"><?php echo $points;?></span>
                </div>
            </div>
            <span class="label tag"><img alt="star" src="images/icon-star.svg"></i>30</span>
        </div> 
    </section>
    <section>
        <h3>My Rewards</h3>

        <?php
        for ($i=0; $i < $rewards; $i++) { 
            echo '<img alt="ticket" src="images/reward.svg">';
        }
        ?>
        
    </section>
    <section>
        <h3>My Favourite Places</h3>
    <?php
        foreach($favStoresArray as $fav){
            $storeID = $fav['store_id'];
            $storeArray = get_array_where("stores","store_id",$storeID);
            $storeImg = $storeArray['image'];
            $storeName = $storeArray['store_name'];

            echo "<a class='fav-store' href='store-profile.php?id=$storeID'>";
            echo "<span>$storeName</span>";
            echo "<img class='thumb' src='images/stores/$storeImg'>";
            echo '</a>';

        }
    ?>
    </section>
</main>
<style>
             main.account .progress{
                animation: progress 2s;
            }
            @keyframes progress {
            from{
                /* opacity: 0; */
                width: 0;
            }
            to{
                /* opacity: 1; */
                width: <?php echo $progress; ?>%;
            }
            }
        </style>



<?php require 'required/footer.php';?>