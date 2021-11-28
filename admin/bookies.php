<?php

    /**
     * ====================================================================
     * = Items Page
     * ====================================================================
     */

     ob_start();

     session_start();

     if($_SESSION['UserName']){

        $pageTitle = 'bookies';

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage'){

            $stmt = $con->prepare("SELECT
                                        bookies.*,
                                        items.Name AS Item_Name,
                                        users.FullName
                                    FROM
                                        bookies
                                    INNER JOIN
                                        items
                                    ON
                                        items.Item_ID = bookies.Item_id
                                    INNER JOIN
                                        users
                                    ON
                                        users.UserID = bookies.Member_id
                                    ORDER BY
                                        ID DESC");
            $stmt->execute();

            $rows = $stmt->fetchAll();

            ?>

            <h1 class="text-center">Manage bookies</h1>
            <div class="container">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>                        
                        <td>Item Name</td>
                        <td>Member</td>
                        <td>Email Member</td>
                        <td>Adding Date</td>
                        <td>Card ID</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($rows as $row){
                            echo "<tr>". 
                                "<td>" . $row['ID'] .                                  
                                "<td>" . $row['Item_Name'] . 
                                "<td>" . $row['FullName'] .
                                "<td>" . $row['Email'] .
                                "<td>" . $row['Date'] . 
                                "<td>" . $row['Card_ID'] . 
                                "<td>" . 
                                    "<a href='bookies.php?do=Edit&bookid=" . $row['ID'] . "'
                                        class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>" . 
                                    "<a href='bookies.php?do=Delete&bookid=" . $row['ID'] . "'
                                        class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                    
                            echo "<tr>";
                        }
                    ?>
                </table>
            </div>

            <?php

        }elseif($do == 'Edit'){

            $bookid = isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? intval($_GET['bookid']) : 0;

            $stmt = $con->prepare("SELECT * FROM bookies WHERE ID = ?");

            $stmt->execute(array($bookid));

            $booking = $stmt->fetch();

            $count = $stmt->rowCount();

            if($count > 0){ ?>

                <h1 class="text-center">Edit Booking</h1>
                <div class="container">
                    <form class="form-horizontal " action="?do=Update" method="POST">
                        <input type="hidden" name="bookid" value="<?php echo $bookid; ?>" />
                        <!-- Start Items Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Item Name</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="item">
                                    <?php
                                        $items = getAllTable("*", "items", "", "", "Item_ID", "ASC", "");
                                        foreach($items as $item){
                                            echo '<option value="' . $item['Item_ID'] . '"';
                                            if($booking['Item_id'] == $item['Item_ID']){echo 'selected';}
                                            echo '>' . $item['Name'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Items Field -->
                        <!-- Start Members Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Member</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="member">
                                    <?php
                                        $users = getAllTable("*", "users", "", "", "UserID", "ASC", "");
                                        foreach($users as $user){
                                            echo '<option value="' . $user['UserID'] . '"';
                                            if($booking['Member_id'] == $user['UserID']){echo 'selected';}
                                            echo '>' . $user['FullName'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Members Field -->
                        <!-- Start Email -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="email" class="form-control" value="<?php echo $booking['Email']; ?>" required="required" placeholder="Email Must Be Valid">
                            </div>
                        </div>
                        <!-- End Email -->
                        <!-- Start Email -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Card ID</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="card" class="form-control" value="<?php echo $booking['Card_ID']; ?>" required="required" placeholder="Email Must Be Valid">
                            </div>
                        </div>
                        <!-- End Email -->
                        <!-- Start Submit Field -->
                        <div class="mb-2 row">
                            <div class="offset-sm-2 col-sm-10">
                                <input type="submit" value="Update Booking" class="btn btn-primary">
                            </div>
                        </div>
                        <!-- End Submit Field -->
                    </form>
                </div>

            <?php

            }else{

                $TheMsg = '<div class="alert alert-danger">Thete\'s No Such ID</div>';
                redirectHome($TheMsg);

            }

        }elseif($do == 'Update'){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo "<h1 class='text-center'>Update Comment</h1>";

                $bookid     = $_POST['bookid'];
                $item       = $_POST['item'];
                $member     = $_POST['member'];
                $email      = $_POST['email'];
                $card       = $_POST['card'];

                $stmt = $con->prepare("UPDATE bookies SET 
                                                        Item_id = ?,
                                                        Member_id = ?,
                                                        Email = ?,
                                                        Card_ID = ?
                                                        WHERE ID = ?");

                $stmt->execute(array($item, $member, $email, $card, $bookid));

                    //Echo Success Message

                $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                redirectHome($TheMsg, 'back', 5);

            }else{

                $TheMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
                redirectHome($TheMsg);

            }

        }elseif($do == 'Delete'){

            echo '<h1 class="text-center"> Delete Booking</h1>';

            // Check If Get Request userid Is Numeric & Get The Integer Value Of It 

            $bookid = isset($_GET['bookid']) && is_numeric($_GET['bookid']) ? intval($_GET['bookid']) : 0;

            // Select All Data Depend On This ID

            $chick = chickItem('ID', 'bookies', $bookid);

            if($chick > 0){

                deleteRecord('bookies', 'ID', $bookid);

                $TheMsg = "<div class='alert alert-success'>" . $chick . ' Record Deleted</div>';
                redirectHome($TheMsg);

            }else{

                $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
                redirectHome($TheMsg);

            } 

        }else{

            $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
            redirectHome($TheMsg);
       }

        include $tepl . 'footer.php';

     }else{

        header('Location: index.php');
        exit();

     }

     ob_end_flush();

?>