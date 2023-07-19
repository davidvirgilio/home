<?php

require 'required/functions.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST['username'];
    $storeId = $_POST['store_id'];
    $userIdArray = get_array_where('users','username',$username);
    $userId = $userIdArray['user_id'];
    $type = $_POST['type'];

    if($type == 'review'){
        $reviewToDB = $_POST['review'];
        $rateToDB = $_POST['rate'];
        $totalReviews = $_POST['total_reviews'];
    
        $reviewQuery = "INSERT INTO `reviews` (`store_id`, `user_id`, `review`, `rate`) VALUES ($storeId, $userId, '$reviewToDB', $rateToDB);";
        send_query($reviewQuery);
        
        $totalReviews++;
        
        $updateReviews = "UPDATE `stores` SET `reviews`= $totalReviews WHERE `store_id` = $storeId";
        send_query($updateReviews);
        
        $rateArray = get_assoc_array_where("reviews","store_id",$storeId);
        $rate = [];
        foreach($rateArray as $rateSub){
            $rate[] = $rateSub['rate'];
        }
        
        $rank = round(array_sum($rate)/count($rate),1);
        $updateRank = "UPDATE `stores` SET `total_rank`= $rank WHERE `store_id` = $storeId";
        send_query($updateRank);

        $display = true;

    }else if($type == 'like'){
        if(isset($_POST['like'])){
            $like = $_POST['like'];
            $query = "SELECT * FROM `favourite-locations` WHERE `user_id`=$userId AND `store_id`=$storeId";
            $exist = send_query($query);
            $existD = get_info($exist);
    
            if(!$existD){
                $setLike = "INSERT INTO `favourite-locations` (`user_id`,`store_id`,`liked_store`) VALUES ($userId, $storeId, 1);";
                send_query($setLike);
                echo "You have inserted sent $like";
            }else{
                $updateLikes = "UPDATE `favourite-locations` SET `liked_store`= 1";
                send_query($updateLikes);
                echo "You have UPDATE $like";
            }       
        }
        else{
            $updateLikes = "UPDATE `favourite-locations` SET `liked_store`= 0 WHERE `user_id`=$userId AND `store_id`=$storeId;";
            send_query($updateLikes);
            echo "You have sent a dislike";
        }
    }

}

if($display){
    define('TITLE','Sign in');
    require 'required/simple-header.html';


?>

<body>
<main id="dialogContainer">
    <div id="locationInfo">
    <div class="sign-container">
        <div class="title-container">
            <h2>Thanks for your feedback!</h2>
            <button id="closeInfo2" class="close"><img alt="close" src="images/icon-close.svg"></button>
        </div>
        <p>Your review has been added successfully.</p>
        <a class="button" href="index.php">Resume my hunting.</a>
    </div>
    </div>
</main>
</body>

<?php } ?>