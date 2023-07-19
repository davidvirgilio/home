<?php 

require 'required/functions.php';
$functionsCalled = true;


if($_SERVER["REQUEST_METHOD"]=="GET"){
    $storeId = $_GET['id'];

    $queryStore = "SELECT * FROM `stores` WHERE `store_id`=$storeId;";
    
    $resultStore = send_query($queryStore);
    $storeArray = get_info($resultStore);
    
    $storeName = $storeArray['store_name'];
    $types = $storeArray['types']; // Array
    $video = $storeArray['video'];
    $image = $storeArray['image'];
    $shortDescription = $storeArray['short_description'];
    $description = $storeArray['description'];
    $address = $storeArray['address'];
    $hours = $storeArray['hours'];
    $reviews = $storeArray['reviews'];
    $rank = $storeArray['total_rank'];
    $link = $storeArray['link'];

}else{
    header("index.php");
}

?>