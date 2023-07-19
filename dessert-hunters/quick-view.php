<?php 

require 'required/data-by-id.php';
define('TITLE',$storeName);
require 'required/simple-header.php';

?>

<body>
    <div id="dialogContainer" class="">
        <div id="locationInfo">
            <div class="title-container">
                <div class="title">
                    <h3><?php echo $storeName; ?></h3>
                    <div class="dessert-types">
                    <?php 
                            if(str_contains($types, 'ice cream')){
                                echo '<img alt="Ice Cream" src="images/ice-cream-type.svg">';
                            }
                            if(str_contains($types, 'bakery')){
                                echo '<img alt="Bakery" src="images/bakery-type.svg">';
                            }
                            if(str_contains($types, 'drinks')){
                                echo '<img alt="Drinks" src="images/drink-type.svg">';
                            } 
                    ?>
                    </div>
                </div>
                <button id="closeInfo" class="close"><img alt="close" src="images/icon-close.svg"></button>
            </div>
            <div class="stars">
               
                <img src="images/five.svg" alt="stars" class="starIcon">
                <p>
                    <?php
                        echo "($reviews reviews)";
                    ?>
                </p>
            </div>
    
            <video controls="" autoplay="true" muted="false" playsinline="" loop="loop" id="videoView">
                <source src=" <?php echo "videos/$video";?>">
            </video>
    
           <div id="info">
                <p><?php echo $shortDescription; ?></p>
                <address><span>Address:</span> <?php echo $address; ?></address>
                <p><span>Hours:</span> <?php echo $hours; ?></p>
 
                <a id="questionButton" href="<?php
                    if($login){
                        echo "questions.php?id=$storeId";
                    }else{
                        echo "warning.php";
                    }
                    ?>
                ">
                    <img alt="?" src="images/question.svg">
                    <p>Get points</p>
                </a>
                <a class="button" target="_parent" href="store-profile.php?id=<?php echo $storeId; ?>" >View More</a>
         </div>
    
        </div>
    </div>
    
</body>
</html>
