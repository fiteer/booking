<?php

session_start();

$pageTitle = 'Create New Item';

include 'init.php';

if(isset($_SESSION['user'])){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Upload Variable
                    
        $avatarName = $_FILES['avatar']['name'];
        $avatarType = $_FILES['avatar']['type'];
        $avatarSize = $_FILES['avatar']['size'];
        $avatarTmp  = $_FILES['avatar']['tmp_name'];

        // List Of Allowed File Typed To Upload

        $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

        // Get Avatar Extension

        @$avatarExtension = strtolower(end(explode('.', $avatarName)));

        $formErrors = array();

        $name      = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $type      = filter_var($_POST['type'], FILTER_SANITIZE_STRING);

        if(strlen($name) < 4){
            $formErrors[] = 'Item Name Must Be At Least 4 Characters';
        }
        if(strlen($desc) < 10){
            $formErrors[] = 'Item Description Must Be At Least 4 Characters';
        }
        if(empty($price)){
            $formErrors[] = 'Item Price Must Be Not Empty';
        }
        if(empty($price)){
            $formErrors[] = 'Type Item  Must Be Not Empty';
        }
        if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
            $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
        }
        if(empty($avatarName)){
            $formErrors[] = 'Avatar Is <strong>Required</strong>';
        }
        if($avatarSize > 4194304){
            $formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
        }

        if(empty($formErrors)){
            $avatar = rand(0, 100000) . '_' . $avatarName;
            move_uploaded_file($avatarTmp, "admin\upload\avatar\\" . $avatar);

            $stmt = $con->prepare("INSERT INTO 
                                        items(`Name`, `Description`, Price, type_item, Add_Date, Member_ID, avatar)
                                        VALUES(:zname, :zdesc, :zprice, :ztype, now(), :zmember, :zavatar)");
            $stmt->execute(array(

                'zname'         => $name,
                'zdesc'         => $desc,
                'zprice'        => $price,
                'ztype'        => $type,
                'zmember'       => $_SESSION['sid'],
                'zavatar'       => $avatar

            ));

            if($stmt){
                $successMas = "Item Added";
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
                            <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                                <!-- Start Name Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            pattern=".{4,}"
                                            title="This Field Require At Least 4 Characters"
                                            class="form-control live"
                                            type="text" 
                                            name="name"  
                                            placeholder="Name Of The Item"
                                            data-class=".live-title"
                                            required>
                                    </div>
                                </div>
                                <!-- End Name Field -->
                                <!-- Start Description Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            pattern=".{10,}"
                                            title="This Field Require At Least 10 Characters"
                                            class="form-control live" 
                                            type="text" 
                                            name="description" 
                                            placeholder="Description of The Item"
                                            data-class=".live-desc"
                                            required>
                                    </div>
                                </div>
                                <!-- End Description Field -->
                                <!-- Start Price Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Price</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="text" 
                                            name="price" 
                                            placeholder="Price of The Item"
                                            data-class=".live-price"
                                            value="$"
                                            required>
                                    </div>
                                </div>
                                <!-- End Price Field -->
                                <!-- Start Type Item Field -->
                                <div class="mb-2 row">
                                        <label class="col-sm-2 col-form-label">Type Item</label>
                                        <div class="col-sm-10 col-md-10">
                                            <select name="type" class="form-control">
                                                <option>.....</option>
                                                <option value="rooms">Room</option>
                                                <option value="hotels">Hotel</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End Type Item Field -->
                                    <!-- Start Image Field -->
                                    <div class="mb-2 row">
                                        <label class="col-sm-2 col-form-label">Image Item</label>
                                        <div class="col-sm-10 col-md-10">
                                            <input
                                                class="form-control live" 
                                                type="file"
                                                name="avatar"
                                                placeholder="Separate Tags With Comma (,)"
                                                data-class=".live-img">
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
                            <div class="col-md-4">
                                <div class='view-items'>
                                    <div class='card live-preview'>
                                        <span class='price-tag'>
                                            $<span class="live-price">0</span>
                                        </span>
                                        <div class='card-header'>
                                            <!-- <img src='img.png' class='card-img-top live-img' alt='' /> -->
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

    header('Location: login.php');

    exit();

}

include $tepl . 'footer.php';

ob_end_flush();
?>