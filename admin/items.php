<?php

    /**
     * ====================================================================
     * = Items Page
     * ====================================================================
     */

    ob_start(); // Output Buffring Start

    session_start();

    

    if(isset($_SESSION['UserName'])){

        $pageTitle = 'Items';

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage'){
            //if(!empty($stmt)){
            $stmt = $con->prepare("SELECT 
                                        items.*, 
                                        users.FullName 
                                    FROM 
                                        items 
                                    INNER JOIN 
                                        users 
                                    ON 
                                        users.UserID = items.Member_ID
                                    ORDER BY
                                        Item_ID DESC");

            $stmt->execute();

            $items = $stmt->fetchAll();
            
            ?>

            <h1 class='text-center'>Manage Items</h1>
            <div class='container'>
                <div class="table-responsive">
                    <table class="main-table text-center manage-members  table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Adding Date</td>
                            <td>Member</td>
                            <td>Type Of Item</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($items as $item){
                                echo "<tr>". 
                                           "<td>" . $item['Item_ID']. 
                                           "</td><td class='avatar-img'>";
                                        if(empty($item['avatar'])){
                                            echo "<img src='layout/image/img.jpg' alt=''>";
                                        }else{
                                            echo "<img src='upload/avatar/" . $item['avatar'] ."' alt=''>";
                                        } 
                                        echo "</td><td>" . $item['Name'] . 
                                           "<td class='td-decription'>" . $item['Description'] . 
                                           "<td>" . $item['Price'] . 
                                           "<td>" . $item['Add_Date'] .
                                           "<td>" . $item['FullName'] .
                                           "<td>" . $item['type_item'] .
                                           "<td>" . 
                                                  "<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' 
                                                      class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>". 
                                                  "<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' 
                                                      class='btn btn-danger confirm'>
                                                      <i class='fa fa-close'></i> Delete</a>";
                                                    if($item['status'] == 1){
                                                    echo "<a href='items.php?do=Status&itemid=" . $item['Item_ID'] . "' 
                                                            class='btn btn-info activate'>
                                                            <i class='fa fa-check'></i> Booked Up</a>"; 
                                                    }
                                                    
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
                <a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
            </div>

            <?php
           // }
        }elseif($do == 'Add'){ // Add Page ?>

            <h1 class="text-center">Add New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <!-- Start Name Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                 class="form-control"
                                 type="text" 
                                 name="name"  
                                 placeholder="Name Of The Item">
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start Description Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                 class="form-control" 
                                 type="text" 
                                 name="description"                                 
                                 placeholder="Description of The Item">
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Start Price Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                 class="form-control" 
                                 type="text" 
                                 name="price" 
                                 value="$"
                                 placeholder="Price of The Item">
                        </div>
                    </div>
                    <!-- End Price Field -->
                    <!-- Start Type Item Field -->
                    <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Type Item</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="type" class="form-control">
                                    <option>.....</option>
                                    <option value="rooms">Room</option>
                                    <option value="hotels">Hotel</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Type Item Field -->
                    
                        <!-- Start Members Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Member</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="member">
                                    <option value="0">...</option>
                                    <?php
                                        $allMembers = getAllTable('*', 'users', '', '', 'UserID', 'ASC', '');
                                        foreach($allMembers as $user){
                                            echo '<option value="' . $user['UserID'] . '">' . $user['FullName'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Members Field -->
                        <!-- Start Image Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Avatar</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="file" name="avatar" class="form-control" required="required">
                            </div>
                        </div>
                        <!-- End Image Field -->
                        <!-- Start Submit Field -->
                        <div class="mb-2 row">
                            <div class="offset-sm-2 col-sm-10">
                                <input type="submit" value="Add Item" class="btn btn-primary">
                            </div>
                        </div>
                        <!-- End Submit Field -->
                    </form>
                </div>

        <?php

        }elseif($do == 'Insert'){ // Insert Page

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class="text-center">Insert Page</h1>';
                echo '<div class="container">';

                // Upload Variable
                
                    // Upload Variable
                    
                    $avatarName = $_FILES['avatar']['name'];
                    $avatarType = $_FILES['avatar']['type'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTmp  = $_FILES['avatar']['tmp_name'];

                    // List Of Allowed File Typed To Upload

                    $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                    // Get Avatar Extension

                    @$avatarExtension = strtolower(end(explode('.', $avatarName)));

                // Get Variables From The Form

                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $type      = $_POST['type'];
                $member     = $_POST['member'];

                // Validate The Form

                $formError = array();

                if(empty($name)){
                    $formError[] = 'Name Can\'t be <strong>Empty</strong>';
                }
                if(empty($desc)){
                    $formError[] = 'Description Can\'t be <strong>Empty</strong>';
                }
                if(empty($price)){
                    $formError[] = 'Price Can\'t be <strong>Empty</strong>';
                }
                if(empty($type)){
                    $formError[] = 'Type Item Can\'t be <strong>Empty</strong>';
                }
                if($member == 0){
                    $formError[] = 'You Must Choose The <strong>Member</strong>';
                }
                if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
                    $formError[] = 'This Extension Is Not <strong>Allowed</strong>';
                }
                if(empty($avatarName)){
                    $formError[] = 'Avatar Is <strong>Required</strong>';
                }
                if($avatarSize > 4194304){
                    $formError[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
                }


                // Loop Into Errors Array And Echo It

                foreach($formError as $error){

                    echo '<div class="alert alert-danger">' . $error . '</div>';
                    
                }

                if(empty($formError)){

                    $avatar = rand(0, 100000) . '_' . $avatarName;
                    move_uploaded_file($avatarTmp, "upload\avatar\\" . $avatar);

                    $stmt = $con->prepare("INSERT INTO
                                    items(`Name`, `Description`, Price, type_item, Add_Date, Member_ID, avatar)
                                VALUES(:zname, :zdesc, :zprice, :ztype, now(), :zmember, :zavatar)");
                    $stmt->execute(array(

                        'zname'     => $name,
                        'zdesc'     => $desc,
                        'zprice'    => $price,
                        'ztype'    => $type,
                        'zmember'   => $member,
                        'zavatar'    => $avatar
                    ));

                    $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                    redirectHome($TheMsg, 'back');


                }

            }else{

                $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                redirectHome($TheMsg);


            }
            echo '</div>';

        }elseif($do == 'Edit'){// Edit Page

            // Check If Get Request itemid Is Numeric & Get The Integer Value Of It

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

            // Execute Query

            $stmt->execute(array($itemid));

            // Fetch The Data

            $item = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

            if($count > 0){ ?>

                <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
                        <!-- Start Name Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 col-md-9">
                                <input 
                                    class="form-control"
                                    type="text" 
                                    name="name"  
                                    placeholder="Name Of The Item"
                                    value="<?php echo $item['Name']; ?>">
                            </div>
                        </div>
                        <!-- End Name Field -->
                        <!-- Start Description Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10 col-md-9">
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    name="description"                                 
                                    placeholder="Description of The Item"
                                    value="<?php echo $item['Description']; ?>">
                            </div>
                        </div>
                        <!-- End Description Field -->
                        <!-- Start Price Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10 col-md-9">
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    name="price" 
                                    
                                    placeholder="Price of The Item"
                                    value="<?php echo $item['Price']; ?>">
                            </div>
                        </div>
                        <!-- End Price Field -->
                        <!-- Start Type Item Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Type Item</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="type" class="form-control">
                                    <option value="<?php echo $item['type_item'] ?>"><?php echo $item['type_item'] ?></option>
                                    <option value="rooms">Room</option>
                                    <option value="hotels">Hotel</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Type Item Field -->
                        <!-- Start Members Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Member</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="member">
                                    <?php
                                        $users = getAllTable("*", "users", "", "", "UserID", "ASC", "");
                                        foreach($users as $user){
                                            echo '<option value="' . $user['UserID'] . '"';
                                            if($item['Member_ID'] == $user['UserID']){echo 'selected';}
                                            echo '>' . $user['FullName'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Members Field -->
                        <!-- Start Image Field -->
                        <div class="mb-2 row">
                                <label class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10 col-md-9">
                                    <input 
                                        type="file" 
                                        name="avatar" 
                                        value="<?php echo $item['avatar'] ?>"
                                        class="form-control" 
                                        required="required">
                                </div>
                            </div>
                        <!-- End Image Field -->
                        <!-- Start Submit Field -->
                        <div class="mb-2 row">
                            <div class="offset-sm-2 col-sm-10">
                                <input type="submit" value="Update Item" class="btn btn-primary">
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

        }elseif($do == 'Update'){ // Update Page

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class="text-center">Update Item</h1>';

                    // Upload Variable
                    
                    $avatarName = $_FILES['avatar']['name'];
                    $avatarType = $_FILES['avatar']['type'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTmp  = $_FILES['avatar']['tmp_name'];

                    // List Of Allowed File Typed To Upload

                    $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                    // Get Avatar Extension

                    @$avatarExtension = strtolower(end(explode('.', $avatarName)));

                // Get Vairables From The Form

                $id         = $_POST['itemid'];
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $type      = $_POST['type'];
                $member     = $_POST['member'];

                // Validate The Form

                $formError = array();

                if(empty($name)){
                    $formError[] = 'Name Can\'t be <strong>Empty</strong>';
                }
                if(empty($desc)){
                    $formError[] = 'Description Can\'t be <strong>Empty</strong>';
                }
                if(empty($price)){
                    $formError[] = 'Price Can\'t be <strong>Empty</strong>';
                }
                if(empty($type)){
                    $formError[] = 'Type Item Can\'t be <strong>Empty</strong>';
                }
                if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
                    $formError[] = 'This Extension Is Not <strong>Allowed</strong>';
                }
                if(empty($avatarName)){
                    $formError[] = 'Avatar Is <strong>Required</strong>';
                }
                if($avatarSize > 4194304){
                    $formError[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
                }

                // Loop Into Errors Array And Echo It

                foreach($formError as $error){

                    echo '<div class="alert alert-danger">' . $error . '</div>';
                    
                }

                // Check If There's No Erorr Proceed The Update Operations

                if(empty($formError)){

                    $avatar = rand(0, 100000) . '_' . $avatarName;
                    move_uploaded_file($avatarTmp, "upload\avatar\\" . $avatar);

                    // Update The Database With This Info

                    $stmt = $con->prepare("UPDATE 
                                                items 
                                            SET 
                                                `Name` = ?,
                                                `Description` = ?, 
                                                Price = ?,
                                                type_item = ?,
                                                Member_ID = ?,
                                                avatar = ?
                                            WHERE 
                                                Item_ID = ?");
                    $stmt->execute(array($name, $desc, $price, $type, $member, $avatar, $id ));

                    //Echo Success Message

                    $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                    redirectHome($TheMsg, 'back', 5);

                }

            }else{

                $TheMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
                redirectHome($TheMsg);

            }

        }elseif($do == 'Delete'){

            echo '<h1 class="text-center"> Delete Item</h1>';

            // Check If Get Request userid Is Numeric & Get The Integer Value Of It 

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            // Select All Data Depend On This ID

            $chick = chickItem('Item_ID', 'items', $itemid);

            if($chick > 0){

                deleteRecord('items', 'Item_ID', $itemid);

                $TheMsg = "<div class='alert alert-success'>" . $chick . ' Record Deleted</div>';
                redirectHome($TheMsg, 'back', 5);

            }else{

                $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
                redirectHome($TheMsg);

            } 

        }elseif($do == 'Status'){

            echo "<h1 class='text-center'>Status Item</h1>";

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            // Select All Data Depend On This ID

            $chick = chickItem("Item_ID", "items", $itemid);

            // If There's Such ID Show The Form
            

            if($chick > 0 ){ 

                $stmt = $con->prepare("UPDATE items SET `status` = 0 WHERE Item_ID = ?");
                $stmt->execute(array($itemid));

                $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                redirectHome($TheMsg, 'back');
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