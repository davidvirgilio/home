<?php

define('TITLE','Questions');
require 'required/simple-header.php';

$showForm = true;
$message = false;


if($_SERVER["REQUEST_METHOD"]=="GET"){
    $storeId = $_GET['id'];
    $queryQ = "SELECT * FROM `questions` WHERE `store_id`= '$storeId'";
    $resultQ = send_query($queryQ);
    $arrayQ = get_info($resultQ,'multiple');
    $randomKey = array_rand($arrayQ);
    $randomQ =  $arrayQ[$randomKey];
    
    $questionId = $randomQ['question_id'];
    $question = $randomQ['question'];
    $right = $randomQ['right_answer'];
    $wrong1 = $randomQ['answer_1'];
    $wrong2 = $randomQ['answer_2']; 
    $wrong3 = $randomQ['answer_3']; 

}else if($_SERVER["REQUEST_METHOD"]=="POST"){
    $storeId = $_POST['store'];
    $answerFromUser = $_POST['answer'];
    $right = $_POST['right-answer'];
    $questionId = $_POST['question'];
    $question = $_POST['question'];
    $wrong1 = $_POST['wrong1']; 
    $wrong2 = $_POST['wrong2']; 
    $wrong3 = $_POST['wrong3']; 

    if($answerFromUser==$right){

        $totalPoints = $points + 10;

        if($totalPoints == 30){
            $rewards++;
            $rewardQuery = "UPDATE `users` SET `rewards`= '$rewards';";
            $pointsQuery = "UPDATE `users` SET `points`= '0';";

            send_query($rewardQuery);
            send_query($pointsQuery);
        }else{
            $pointsQuery = "UPDATE `users` SET `points`= '$totalPoints';";
            send_query($pointsQuery);
        }

        $message = 'You have won 10 points!';
        $showForm = false;

    }else{
        $message = 'Wrong answer! Try again';
    }


}
$arrayQs = [$right , $wrong1, $wrong2, $wrong3];
shuffle ($arrayQs );
?>


<body>
    <main id="dialogContainer" class="questions">
        <div id="locationInfo">
            <div class="sign-container">
            <div class="title-container">
                <h2>Answer to win points</h2>
                <button id="closeInfo" class="close"><img alt="close" src="images/icon-close.svg"></button>
            </div>

            <?php
                if($showForm){
                    if($message){
                        echo '<p>'. $message.'</p>';
                    }
            ?>
            <form method="POST">
            <fieldset>
                <legend><?php echo $question;?></legend>
                <?php
                    foreach($arrayQs as $answer){
                        echo "<div>
                        <label for='$answer'>$answer</label>
                        <input id='$answer' type='radio' name='answer' value='$answer' required>
                        </div>";
                    }
                ?>

            </fieldset>
            <input type="hidden" name="store" value="<?php echo $storeId;?>">
            <input type="hidden" name="question" value="<?php echo $question;?>">
            <input type="hidden" name="right-answer" value="<?php echo $right;?>">
            <input type="hidden" name="wrong1" value="<?php echo $wrong1;?>">
            <input type="hidden" name="wrong2" value="<?php echo $wrong2;?>">
            <input type="hidden" name="wrong3" value="<?php echo $wrong3;?>">
            <input class="button" type="submit" value="Submit">
            </form>
            <?php
                 }
                 else{
                    echo "<p>$message</p>";
                    echo "<a class='button' href='questions.php?id=$storeId'>Try another questions</a>";
                 }
            ?>
                </div>
        </div>
    </main> 