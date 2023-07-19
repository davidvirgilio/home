<?php

require 'required/functions.php';

$error = false;
$sent = false;
if($_SERVER["REQUEST_METHOD"]=="GET"){

    $storeId = $_GET['store_id'];
    $storeName = $_GET['store_name'];
    $userId = $_GET['user_id'];


}else if($_SERVER["REQUEST_METHOD"]=="POST"){

    // Basic info
    $caption = $_POST['caption'];
    $storeId = $_POST['store_id'];
    $storeName = $_POST['store_name'];
    $userId = $_POST['user_id'];
    $getNumber = get_assoc_array_where("gallery","store_id",$storeId);
    $number = count($getNumber);

    $imageOriginalName = $_FILES["image"]["name"];
    $fileExt = pathinfo($imageOriginalName,PATHINFO_EXTENSION);

    // Image
    $image = $_FILES["image"]["tmp_name"];
    $name = str_replace(' ','-',$storeName);
    $nameStr = strtolower($name);
    $imageName = "$nameStr-$number.$fileExt";

    if($fileExt=='jpg' || $fileExt=='jpeg'){
        $imagetmp =  imagecreatefromjpeg($image);
    }else if($fileExt=='png'){
        $imagetmp =  imagecreatefrompng($image);
    }else{
        $error = true;
    }
    if(!$error){
        // $thumbnail = imagescale($imagetmp,1000);
        $imgthumb = imagejpeg($imagetmp,"images/gallery/$imageName");
    
        $query = "INSERT INTO `gallery`(`user_id`,`caption`,`image`,`store_id`) VALUES ('$userId','$caption','$imageName','$storeId');";
        $result = send_query($query);
    
        $sent = true;
    }

}

define('TITLE','Send gallery picture');
require 'required/simple-header.html';


?>


<body>
<main id="dialogContainer">
    <div id="locationInfo">
    <div class="sign-container">
        <?php
if($error){
    echo '<div class="title-container">
        <h2>Error uploading your file</h2>
        <button id="closeInfo2" class="close"><img alt="close" src="images/icon-close.svg"></button>
    </div>
    <p>Please choose a jpg or png file.</p>
    <a href="add-to-gallery.php?store_id=<?php echo $storeId;?>&user_id=<?php echo $userId; ?>&store_name=<?php echo $storeName; ?>" class="button">Try again</a>';
    
}else if($sent){
    echo '<div class="title-container">
        <h2>File added</h2>
        <button id="closeInfo2" class="close"><img alt="close" src="images/icon-close.svg"></button>
    </div>
    <p>Thank you for sharing your valuable hunting memories with us.</p>
    <a href="add-to-gallery.php?store_id=<?php echo $storeId;?>&user_id=<?php echo $userId; ?>&store_name=<?php echo $storeName; ?>" class="button">Add another picture</a>';

}else{
?>

        <div class="title-container">
            <h2>Add a picture to the gallery</h2>
            <button id="closeInfo2" class="close"><img alt="close" src="images/icon-close.svg"></button>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <input name="store_name" type="hidden" value="<?php echo $storeName;?>">
            <input name="store_id" type="hidden" value="<?php echo $storeId;?>">
            <input name="user_id" type="hidden" value="<?php echo $userId; ?>">
            <label for="image">Submit your image</label>
            <input type="file" id="image" name="image" required><br>
            <label for="caption">Caption:</label>
            <textarea id="caption" maxlength="100" name="caption" rows="5" cols="33" required></textarea>
            <input class="button" type="submit" value="Add">
        </form>
<?php } ?>
        </div>
        </div>
</main>
</body>
