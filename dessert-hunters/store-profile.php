<?php

require 'required/data-by-id.php';

define('TITLE',$storeName);
require 'required/header.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $userIdArray = get_array_where('users','username',$username);
    $userId = $userIdArray['user_id'];
    $reviewToDB = $_POST['review'];
    $rateToDB = $_POST['rate'];

    $reviewQuery = "INSERT TO `reviews` (`store_id`,`user_id`,`review`, `rate`) VALUES ($storeId, $userId, $reviewToDB, $rateToDB)";
    send_query($reviewQuery);
}

$favArray = get_assoc_array_where("favourites", "store_id", $storeId);
$reviewsArray = get_assoc_array_where('reviews', 'store_id', $storeId);

if($login){
    $queryFav = "SELECT * FROM `favourite-locations` WHERE `store_id`=$storeId AND `user_id`=$userId";
    $resultFavourite = send_query($queryFav);
    $isItFavouriteArray = get_info($resultFavourite);
    if($isItFavouriteArray){
        $isItFavourite = $isItFavouriteArray['liked_store'];
    }
}

?>

<main class="store">
    <div class="heading-container">
        <div class="title">
            <h2><?php echo $storeName ?></h2>
    <?php
            if($login){
    ?>
            <form id="heart" method="post" action="process-form.php" target="result">
                <input type="hidden" name="type" value="like">
                <input type="hidden" name="username" value="<?php echo $username;?>">
                <input type="hidden" name="store_id" value="<?php echo $storeId;?>">
                <input type="checkbox" id="like" name="like" <?php if(isset($isItFavourite) && $isItFavourite == 1){ echo 'checked';} ?>>
                <label for="like" class="heart-label <?php if(isset($isItFavourite) && $isItFavourite == 1){ echo 'filled';}?>"></label>
            </form>
<?php 
            }else{
                echo '<div class="heart-label"></div>';
            }
?>
        </div>
        <div>
            <div class="stars" title="<?php echo $rank;?>">
                <?php
                $rankRounded = round($rank);
                $delta = $rank - $rankRounded;
                for ($i=0; $i < $rankRounded; $i++) {
                    echo '<span class="starReviewFilled"></span>';
                }
                if($delta > 0){
                    echo '<span class="starReviewHalf"></span>';
                }else if($delta == 0 && $rankRounded < 5 || $delta < 0 && $rankRounded < 5){
                    echo '<span class="starReview"></span>';
                }
                for($i=$rankRounded; $i < 4 ; $i++){
                    echo '<span class="starReview"></span>';
                }
                ?>
                <!-- <img alt="stars" src="images/five.svg"> -->
            </div>
            <p>(<?php echo $reviews;?> reviews)</p>
        </div>
        <img alt="<?php echo $storeName;?>" src="images/stores/<?php echo $image;?>">
    </div>
    <section>
        <h3>About</h3>
        <p class="description">
            <?php echo $description;?>
        </p>
        <p><span>Address: </span> <?php echo $address;?></p>
        <p><span>Hours</span> <?php echo $hours;?></p>
        <a href="<?php echo $link;?>" class="button">Order Now</a>
    </section>
    <section>
        <h3>Fan Favourites</h3>
        <div>
        
        <?php
        
        foreach($favArray as $fav){
            $favImage = $fav['image'];
            $price = $fav['price'];
            $favName = $fav['name'];

            echo '<div class="fav-container">';
            echo "<img alt='$favName' src='images/favourites/$favImage'>";
            echo "<div><p>$favName</p>";
            echo "<p>$$price</p></div>";
            echo '</div>';
        }
        
        ?>



</div>
</section>
<section id="gallery">
    <h3>Gallery</h3>
    <div class="gallery-container">
        <?php 
            $queryPics = "SELECT * FROM `gallery` WHERE `store_id` = $storeId";
            
            $arrayGallery = get_assoc_array_where('gallery','store_id',$storeId);
            $index = 1;

            if($arrayGallery){

                
                
                foreach($arrayGallery as $post){
                    $caption = ucfirst($post['caption']);
                    $path = $post['image'];
                    $postUser = ucfirst($post['user_id']);
                    
                    $userInfo = get_array_where('users', 'user_id', $postUser);
                    $userPic = $userInfo['profile_picture'];
                    $userName = ucfirst($userInfo['username']);
                    
                    
                    
                    echo '<div id="slide'.$index.'" class="slides">';
                    echo '<div class="post-image">';
                    echo "<img src='images/gallery/$path'>";
                    echo '</div>';
                    echo '<div class="post">';
                    echo "<img class='profile' src='images/users/$userPic'>";
                    echo "<p><span class='bold'>$userName</span> at $storeName</p>";
                    echo '</div>';
                    echo "<p>\"$caption\"</p>";
                    echo '</div>';
                    
                    $index ++;
                }
                echo '<button class="previous"><img src="images/icon-previous.svg"></button>
                <button class="next"><img src="images/icon-next.svg"></button>';
            }
            ?>
            </div>


            <a id="add" target="result" href="<?php
            if($login){
                echo "add-to-gallery.php?store_id=$storeId&user_id=$userId&store_name=$storeName;";
            }else{
                echo 'warning.php';
            }
            ?>" class="add"><img src="images/icon-plus.svg"><span class="letters">Add picture<span></a>

        </section>
        <section>
        <h3>Reviews</h3>
        <?php
        foreach($reviewsArray as $review){
            $userIdReview = $review['user_id'];
            $user = get_array_where('users','user_id',$userIdReview);
            $userDisplayName = ucfirst($user['username']);
            $rateReview = $review['rate'];
            $reviewCopy = $review['review'];

            


            echo '<div class="review-container">';
            echo "<div><h4>$userDisplayName</h4>";
            echo '<div class="stars">';
            for ($i=0; $i < $rateReview; $i++) { 
                echo '<span class="starReviewFilled"></span>';
            }
            echo '</div>';
            echo '</div>';
            echo "<p>$reviewCopy</p>";
            echo '</div>';
        }
        ?>
        <a id="viewMore" href="#">View more</a>
    </section>
    <section>
        <h3>Your opinion matters</h3>
        <form method="POST" action="process-form.php" target="result">
            <label for="review">Share your thoughts:</label>
            <textarea id="review" name="review" maxlength="280" required><?php
                if(!$login){
                    echo 'Log in to leave reviews of your favourite dessert houses.';
                }
                ?></textarea>
            <fieldset>
                <div>
                <legend>Rating:</legend>
                <div class="stars">
                <div>
                    <label for="star1" class="star"></label>
                    <input id="star1" type="radio" name="rate" value="1">
                </div>
                <div>
                    <label for="star2" class="star"></label>
                    <input id="star2" type="radio" name="rate" value="2">
                </div>
                <div>
                    <label for="star3" class="star"></label>
                    <input id="star3" type="radio" name="rate" value="3">
                </div>
                <div>
                    <label for="star4" class="star"></label>
                    <input id="star4" type="radio" name="rate" value="4">
                </div>
                <div>
                    <label for="star5" class="star"></label>
                    <input id="star5" type="radio" name="rate" value="5">
                </div>
             </div>
             </div>
            </fieldset>
            <input type="hidden" name="type" value="review">
            <input type="hidden" name="username" value="<?php echo $username;?>">
            <input type="hidden" name="store_id" value="<?php echo $storeId;?>">
            <input type="hidden" name="total_reviews" value="<?php echo $reviews;?>">
            <?php
            if($login){
                echo '<button id="submitReview" type="submit" class="button">Submit</button>';
            }else{
                echo '<a class="button sign-in" href="sign-in.php" target="result">Sign In</a>';
            }
            ?>
            
        </form>
    </section>
</main>
<iframe id="dialogContainer" class="hidden" name="result" src="">
</iframe>

<?php
require 'required/footer.php';
?>