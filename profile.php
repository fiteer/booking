<?php

session_start();

$pageTitle = 'Profile';

include 'init.php';

if(isset($_SESSION['user'])){
    $getUser = $con->prepare("SELECT * FROM users WHERE FullName = ?");

    $getUser->execute(array($sessionUser));

    $infoUser = $getUser->fetch();
    $userid = $infoUser['UserID'];
?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">My Information</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Name</span> :               <?php echo $infoUser['FullName']; ?>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o fa-fw"></i>
                            <span>Email</span> :              <?php echo $infoUser['Email']; ?>
                        </li>
                        <li>
                            <?php 
                                if($infoUser['gender'] == 'Male'){
                                    echo '<i class="fa fa-male fa-fw"></i>';
                                    echo "<span>Gender</span> :"        .$infoUser['gender']; 
                                }
                                if($infoUser['gender'] == 'Female'){
                                    echo '<i class="fa fa-female fa-fw"></i>';
                                    echo "<span>Gender</span> :"        .$infoUser['gender']; 
                                }
                            ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Favouret Category</span> : 
                        </li>
                    </ul>
                    <a href="#" class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>

    <div id="view-items" class="view-items block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">My Items</div>
                <div class="card-body">
                    <div class="row row-cols-md-4">
                        <?php 

                            // $items = getAllTable("*", "bookies", "where Member_id = $userid", "", "ID");
                            $stmt = $con->prepare("SELECT
                                                        bookies.*,
                                                        users.FullName,
                                                        items.*
                                                    FROM
                                                        bookies
                                                    INNER JOIN
                                                        users
                                                    ON
                                                        users.UserID = bookies.Member_id
                                                    INNER JOIN
                                                        items
                                                    ON
                                                        items.Item_ID = bookies.Item_id
                                                    WHERE UserName = ?");
                            $stmt->execute(array($sessionUser));
                            $books = $stmt->fetchAll();

                            if(empty($books)){

                                echo "<div class='naice-message'>
                                        Not Exist Booking,
                                      </div>";

                            }else{
                                foreach($books as $book){
                                    echo "<div class='ads-user'>";
                                        echo "<div class='ads-items'>";
                                            if($book['status'] == 1){ 
                                                echo "<span class='approve-status'>Booked Up For " . $book['Number_Days'] . " Days</span>"; 
                                            }
                                            echo "<div class='img-items'>";
                                                echo "<img src='admin/upload/avatar/" . $book['avatar']. "' class='img-top' alt='' />";
                                            echo "</div>";
                                            echo "<div class='items-body'>";
                                                echo "<h3 class='title-items'>";
                                                    echo "<a href='items.php?itemid=" . $book['ID'] . "'>";
                                                        echo $book['Name'];
                                                    echo "</a>";
                                                echo "</h3>"; 
                                                if($book['type_item'] == 'rooms'){
                                                    echo "<p class='text-items'>Room</p>";
                                                }else{
                                                    echo "<p class='text-items'>Hotel</p>";
                                                }
                                                echo "<p class='date-items'>". $book['Date'] ."</p>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-comment block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">Latests Comments</div>
                <div class="card-body">
                    <?php 
                        $myComments = getAllTable("user_review", "comments", "where `user_id` = $userid", "", "C_ID");

                        if(!empty($myComments)){

                            foreach($myComments as $comment){

                                echo "<p>" . $comment['user_review'] . "</p>";

                            }

                        }else{

                            echo "There\'s No Comments To Show";

                        }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
}else{

    header('Location: login.php');

    exit();

}

include $tepl . 'footer.php';

ob_end_flush();
?>