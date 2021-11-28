<?php 
ob_start();
session_start();
$pageTitle = 'Show Item';
include "init.php";
// Check If Get Request Item Is Numeric & Get Its Integer Value
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
// Select All Data Depend On This ID

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
$count = $stmt->rowCount();
    if($count > 0){
        $item = $stmt->fetch();
?>

        <h1 class="text-center"><?php echo $item['Name'] ?></h1>
        <div class="container">
            <div class="row">
                <div class="col-md-4 img-info">
                    <?php echo "<img src='admin/upload/avatar/" . $item['avatar'] ."' alt='' class='img-responsive img-thumbnail'>";?>
                </div>
                <div class="col-md-8 items-info">
                    <h2>
                        <span><?php echo $item['Name'] ?></span>
                        <?php
                            if($item['status'] == 1){
                                echo '<span class="booking">Booked Up</span>';
                            }else{?>
                                <span class="booking"><a href="booking.php?itemid=<?php echo $item['Item_ID']?>">Booking</a></span>
                    <?php   }
                        ?>
                        
                    </h2>
                    <p><?php echo $item['Description'] ?></p>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Add Date</span> : <?php echo $item['Add_Date'] ?>
                        </li>
                        <li>
                            <i class="fa fa-money fa-fw"></i>
                            <span>Price</span> : $<?php echo $item['Price'] ?>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Added By</span> : <a href="#"><?php echo $item['FullName'] ?></a>
                        </li>
                        
                            <?php
                            if($item['status'] == 1){
                                $stmt = $con->prepare("SELECT * FROM bookies WHERE Item_id = ?");
                                $stmt->execute(array($itemid));
                                $count = $stmt->rowCount();
                                if($count > 0){
                                    $days = $stmt->fetch();
                                    echo '<li>';
                                        echo '<i class="fa fa-calendar fa-fw"></i>';
                                        echo '<span>Reserved For </span> : Booked Up From  ' . $days['stat_date'];
                                    echo '</li>';
                                    echo '<li>';
                                        echo '<i class="fa fa-calendar fa-fw"></i>';
                                        echo '<span>End Booking </span> :  Until Date  ' . $days['end_date'];
                                    echo '</li>';
                                }
                            }else{
                                echo '<li>';
                                    echo '<i class="fa fa-calendar fa-fw"></i>';
                                    echo '<span>Booking Now </span> :   <a href="booking.php"> Booking</a>';
                                echo '</li>'; 
                            }

                            ?>
                        </li>
                        <li>
                           
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="costom-hr">
            
        </div>

<?php if(isset($_SESSION['user'])){ ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css.map">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="container">
        <h1 class="mt-5 mb-5">You Can Put Your Rating Here</h1>
        <div class="card">
            <div class="card-header">Total Rating</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 text-center">
                       <h1 class="text-warning mt-4 mb-4">
                           <b><span id="avarage_rating">0.0</span> /5</b>
                       </h1>
                       <div class="mb-3">
                            <i class="fa fa-star star-light mr-1 main_star text-warning"></i>
                            <i class="fa fa-star star-light mr-1 main_star text-warning"></i>
                            <i class="fa fa-star star-light mr-1 main_star text-warning"></i>
                            <i class="fa fa-star star-light mr-1 main_star text-warning"></i>
                            <i class="fa fa-star star-light mr-1 main_star text-warning"></i>
                       </div>
                       <h3><span id="total_review">0</span> Review</h3> 
                    </div>
                    <div class="col-sm-4">
                        <p>
                            <div class="propress-label-left"><b>5</b> <i class="fa fa-star text-warning"></i></div>
                            <div class="propress-label-right">(<span id="total_five_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="propress-label-left"><b>4</b> <i class="fa fa-star text-warning"></i></div>
                            <div class="propress-label-right">(<span id="total_four_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="propress-label-left"><b>3</b> <i class="fa fa-star text-warning"></i></div>
                            <div class="propress-label-right">(<span id="total_three_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="propress-label-left"><b>2</b> <i class="fa fa-star text-warning"></i></div>
                            <div class="propress-label-right">(<span id="total_two_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="propress-label-left"><b>1</b> <i class="fa fa-star text-warning"></i></div>
                            <div class="propress-label-right">(<span id="total_one_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                            </div>
                        </p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h3 class="mt-4 mb-3">Write Review Here</h3>
                        <button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="mt-5" id="review_content"></div>
        
    </div>
    <?php
         }else{
            echo "<div class='container'>";
                echo "<a class='text-center' href='login.php'>Login</a> Or <a href='login.php'>Register</a> To Add Comment";
            echo "</div>";
        }
        ?>
</body>
</html>

<div id="review_modal" class="modal" tabindex="1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center mt-2 mb-4">
                    <i class="fa fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                    <i class="fa fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                    <i class="fa fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                    <i class="fa fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                    <i class="fa fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                </h4>
                
                <div class="form-group">
                    <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
                </div>
                <div class="form-group text-center mt-4">
                    <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                </div>
                <input type="hidden" name="item_id" id="item_id" value="<?php echo $item['Item_ID']?>">
            </div>
        </div>
    </div>
</div>
<div class="container">
    <hr class="costom-hr">
    <?php  
            
                 $stmt = $con->prepare("SELECT
                                             comments.*,
                                             users.FullName, avatar
                                         FROM
                                             comments
                                         INNER JOIN
                                             users
                                         ON
                                             users.UserID = comments.user_id
                                         WHERE
                                             item_id = ?
                                        
                                         ORDER BY
                                             C_ID DESC");
                 $stmt->execute(array($item['Item_ID']));
                $comments = $stmt->fetchAll();
                    foreach($comments as $comment){?>
                        <div class="comment-box">
                             <div class="row">
                            
                                 <div class="col-md-2 ">
                                     <img src="admin/upload/avatar/<?php echo $comment['avatar']?>" class="img-responsive img-thumbnail img-circle" alt="" />
                                     <p><?php echo $comment['FullName']?></p>
                                     <?php if($comment['rating_data'] == 0){ ?>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                    <?php }?>
                                     <?php if($comment['rating_data'] == 1){ ?>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                    <?php }?>
                                     <?php if($comment['rating_data'] == 2){ ?>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                    <?php }?>
                                     <?php if($comment['rating_data'] == 3){ ?>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x "></i>
                                        <i class="fa fa-star fa-1x "></i>
                                    <?php }?>
                                     <?php if($comment['rating_data'] == 4){ ?>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x "></i>
                                    <?php }?>
                                     <?php if($comment['rating_data'] == 5){ ?>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                        <i class="fa fa-star fa-1x text-warning"></i>
                                    <?php }?>
                                 </div>
                                 <div class="col-md-10">
                                     <p class='lead'><?php echo $comment['user_review']?><p>
                                 </div>
                        
                             </div>
                         </div>
                         <hr class="costom-hr">
             <?php   }
            ?>
            
</div>

<?php


 }else{
        $theMessage =  "<div class='alert alert-danger'>There\'s No Such ID Or This Item Is Waiting Approval</div>";
        redirectHome($theMessage, 'back', 5);
    }






    include $tepl . 'footer.php';
ob_end_flush();
?>

