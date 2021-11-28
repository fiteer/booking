<?php

session_start();

$pageTitle = 'Booking Item';

include 'init.php';

if(isset($_SESSION['user'])){
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    $stmt = $con->prepare("SELECT 
                            items.*,
                            users.FullName
                        FROM 
                            items
                        INNER JOIN
                            users
                        ON
                            users.UserID = items.Member_ID 
                        WHERE Item_ID = ?");

    // Execute Query

    $stmt->execute(array($itemid));

    // Fetch The Data

    $item = $stmt->fetch();

    // The Row Count

    $count = $stmt->rowCount();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $formErrors = array();

        $name      = $_POST['name'];
        $member      = $_POST['member'];
        $email       = $_POST['email'];
        $card       = $_POST['card'];
        $startdate       = $_POST['startdate'];
        $startdate       = $_POST['startdate'];
        $enddate       = $_POST['enddate'];

        if(empty($email)){
            $formErrors[] = 'Email Is Empty';
        }
        if(empty($card)){
            $formErrors[] = 'Card ID Must Be Not Empty';
        }
        if($startdate < date('Y-m-d')){
            $formErrors[] = 'Choose Date of Booking Larger or Equal ' . date('Y-m-d');
        }
        if(empty($startdate)){
            $formErrors[] = 'Date of Booking Must Be Not Empty';
        }
        if($enddate < date('Y-m-d')){
            $formErrors[] = 'Choose Date End Booking Larger or Equal ' . date('Y-m-d');
        }
        if(empty($enddate)){
            $formErrors[] = 'End Booking Must Be Not Empty';
        }

        if(empty($formErrors)){

            $stmt = $con->prepare("INSERT INTO 
                                        bookies(Item_id, Member_id, UserName, Email, Card_ID, stat_date, `Date`, end_date)
                                        VALUES(:zitem, :zmember, :zuser, :zemail, :zcard, :zstartdate, now(), :zenddate)");
            $stmt->execute(array(

                'zitem'         => $name,
                'zmember'       => $member,
                'zuser'         => $sessionUser,
                'zemail'        => $email,
                'zcard'         => $card,
                'zstartdate'    => $startdate,
                'zenddate'      => $enddate
            ));

            if($stmt){
                $chick = chickItem("Item_ID", "items", $itemid);

                // If There's Such ID Show The Form
            

                if($chick > 0 ){ 

                    $stmt = $con->prepare("UPDATE items SET `status` = 1 WHERE Item_ID = ?");
                    $stmt->execute(array($itemid));

                    $theMessage =  "<div class='alert alert-success'>The Item Was Booked</div>";
                    redirectHome($theMessage);
                }
            }

        }

    }

?>
    <h1 class="text-center"><?php echo $pageTitle?></h1>
    <div class="information block">
        <div class="container ">
            <div class="card">
                <div class="card-header bg-primary text-white"><?php echo $pageTitle?></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal main-form" action="" method="POST">
                                <!-- Start Name Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10 col-md-10">
                                        <input
                                            type="hidden" 
                                            name="name"
                                            value="<?php echo $item['Item_ID']?>">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10 col-md-10">
                                        <input
                                            type="hidden" 
                                            name="member"
                                            value="<?php echo $item['Member_ID']?>">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Name Item</label>
                                    <div class="col-sm-10 col-md-10">
                                        <p class="form-control"><?php echo $item['Name'] ?> </p>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Your Name</label>
                                    <div class="col-sm-10 col-md-10">
                                        <p class="form-control"><?php echo $sessionUser?></p>
                                    </div>
                                </div>
                                <!-- End Name Field -->
                                <?php 
                                     $user = getProfileUser($sessionUser);
                                 ?>
                                <!-- Start Email Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            pattern=".{10,}"
                                            title="This Field Require At Least 10 Characters"
                                            class="form-control live" 
                                            type="email" 
                                            name="email" 
                                            placeholder="Your Email"
                                            value="<?php echo $user['Email']?>"
                                            data-class=".live-desc"
                                            required>
                                    </div>
                                </div>
                                <!-- End Email Field -->
                                <!-- Start Card ID Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Card</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="text" 
                                            name="card" 
                                            placeholder="Enter Your Card ID"
                                            data-class=".live-price"
                                            required>
                                    </div>
                                </div>
                                <!-- End Card Field -->
                                <!-- Start Date of Booking Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Date of Booking</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="date" 
                                            name="startdate" 
                                            placeholder="Enter The Number of Days"
                                            data-class=".live-price"
                                            required>
                                    </div>
                                </div>
                                <!-- End Date of Booking Field -->
                                <!-- Start End of Booking Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">End of Booking</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="date" 
                                            name="enddate" 
                                            placeholder="Enter The Number of Days"
                                            data-class=".live-price"
                                            required>
                                    </div>
                                </div>
                                <!-- End End of Booking Field -->
                                
                                <!-- Start Submit Field -->
                                <div class="mb-2 row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <input type="submit" value="Book Now" class="btn btn-primary">
                                    </div>
                                </div>
                                <!-- End Submit Field -->
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class='view-items'>
                                <div class='card live-preview'>
                                    <span class='price-tag'>
                                        <span class="live-price"><?php echo $item['Price']?></span>
                                    </span>
                                    <div class='card-header'>
                                        <img src='admin/upload/avatar/<?php echo $item['avatar']?>' class='card-img-top' alt='' />
                                    </div>
                                    <div class='card-body'>
                                        <h3 class='card-title live-title'>Title</h3>
                                        <p class='card-text live-desc'>Description</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Looping Through Errors -->
                    <?php 
                        if(! empty($formErrors)){
                            foreach($formErrors as $error){

                                echo "<div class='alert alert-danger'>" . $error . "</div>";

                            }
                        }

                        if(isset($successMas)){

                            echo "<div class='alert alert-success'>" . $successMas . "</div>";
        
                        }
                    ?>
                    <!-- End Looping Through Errors -->
                </div>
            </div>
        </div>
    </div>

<?php
}else{

    $theMessage =  "<div class='alert alert-danger'>Sorry, You Cant booking Before Your Register and than Return The Booking</div>";
    redirectHome($theMessage, 'login.php', 10);

}

include $tepl . 'footer.php';

ob_end_flush();
?>