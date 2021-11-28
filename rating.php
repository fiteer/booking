<?php
ob_start();
session_start();

include 'admin/connect.php';


if(isset($_POST['rating_data'])){
    $user_review = $_POST['user_review'];
    $user_rating = $_POST['rating_data'];
    $itemid = $_POST['item_id'];
    $userid = $_SESSION['userid'];
    
    
    $stmt = $con->prepare("INSERT INTO comments(user_review, rating_data, Comment_Date, item_id, `user_id`)
                            VALUES(:zuser_review, :zuser_rating, now(), :zitem, :zuser)");
    $stmt->execute(array(
			'zuser_review' => $user_review,
			'zuser_rating' => $user_rating,
            'zitem'        => $itemid,
            'zuser'        => $userid
	));
    echo "Your Review & Rating Successfully Submited";
}?>

