<?php

    session_start();
    $pageTitle = 'Login';
    if(isset($_SESSION['sid'])){
        header('Location: index.php');
    }
    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['login'])){

            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashedPass = sha1($pass);

            $stmt = $con->prepare("SELECT
                                        UserID, FullName, Email, `Password`, GroupID, avatar
                                    FROM
                                        users
                                    WHERE
                                        FullName = ?
                                    AND
                                        `Password` = ?");
            $stmt->execute(array($user, $hashedPass));

            $get = $stmt->fetch();

            $check = $stmt->rowCount();

            if($check > 0){
                
                $_SESSION['user'] = $user; // Register Session Name
                $_SESSION['email'] = $get['Email']; // Register Session Name
                $_SESSION['userid'] = $get['UserID']; // Register Session ID
                $_SESSION['image'] = $get['avatar']; // Register Session image

                 // Register User ID In Session
                 if($get['GroupID'] == 1){
                     $_SESSION['sid'] = $get['UserID'];
                 }else{
                     $_SESSION['uid'] = $get['UserID'];
                 } 
                header('Location: index.php'); // Redirect To Dashboard Page
                exit();

            }
        }else{
            $formErrors = array();
            $avatarName = $_FILES['avatar']['name'];
                    $avatarType = $_FILES['avatar']['type'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTmp  = $_FILES['avatar']['tmp_name'];

                    // List Of Allowed File Typed To Upload

                    $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                    // Get Avatar Extension

                    @$avatarExtension = strtolower(end(explode('.', $avatarName)));

            

            $fullname   = $_POST['fullname'];
            $email      = $_POST['email'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];
            $group      = $_POST['group'];
            $gender      = $_POST['gender'];

            if(isset($fullname)){

                $filterUser = filter_var($fullname, FILTER_SANITIZE_STRING);

                if(strlen($filterUser) < 5){

                    $formErrors [] = 'Username Must Be Lager Than 5 Characters';

                }

            }

            if(isset($password) && isset($password2)){

                if(empty($password)){

                    $formErrors[] = 'Sorry Password Cant Be Empty ';

                }

                if(sha1($password) !== sha1($password2)){

                    $formErrors[] = 'Sorry Password Is Not Match';

                }

            }

            if(isset($email)){

                $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

                if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true){

                    $formErrors[] = 'Sorry This Email Is Not Valid';

                }

            }
            if(empty($group)){
                $formErrors[] = 'Sorry Type User Empty, Choose The Type Users';
            }
            if(empty($gender)){
                $formErrors[] = 'Sorry Your Gender Empty, Choose The Gender';
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

                $check = chickItem("FullName", "users", $fullname);

                if($check == 1){

                    $formErrors[] = 'This Username Is Exsit';

                }else{
                    $avatar = rand(0, 100000) . '_' . $avatarName;
                    move_uploaded_file($avatarTmp, "admin\upload\avatar\\" . $avatar);

                    // Insert Userinfo Into Database

                    $stmt = $con->prepare("INSERT INTO 
                                                users(FullName, Email, `Password`, gender, avatar, GroupID)
                                            VALUES(:zuser, :zmail, :zpass, :zgender, :zavatar, :zgroup)");
                    $stmt->execute(array(
                        'zuser'  => $fullname,
                        'zmail'  => $email,
                        'zpass'  => sha1($password),
                        'zgender'  => $gender,
                        'zavatar'  => $avatar,
                        'zgroup'  => $group
                        
                    ));

                    //Echo Success Message

                    $successMas = 'Congerat You Are Now Regestiret User';                    

                } 

            }

        }
    }
?>

    <div class="container login-page">
        <h1 class="text-center">
            <span class="selected" data-class="login">Login</span> | 
            <span data-class="signup">Signup</span>
        </h1>
        <!-- Start Login Form -->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-login-page">
                <input
                    title="Username Must Be 4 Characters"
                    class="form-control"
                    type="text" 
                    name="username"
                    autocomplete="off"
                    required
                    placeholder="Type Your Name" />
            </div>
            <div class="form-login-page">
                <input 
                    class="form-control" 
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    required
                    placeholder="Type Your Password" />
            </div>
            <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
        </form>
        <!-- End Login Form -->
        <!-- Start Signup Form -->
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
          
            <div class="form-login-page">
                <input
                    class="form-control"
                    type="text" 
                    name="fullname"
                    autocomplete="off"
                    required
                    placeholder="Enter Your Full Name" />
            </div>
            <div class="form-login-page">
                <input
                    class="form-control" 
                    type="text"
                    name="email"
                    required
                    placeholder="Enter Your Email" />
            </div>
            <div class="form-login-page">
                <input 
                    class="form-control" 
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    required
                    placeholder="Enter Complex Password" />
            </div>
            <div class="form-login-page">
                <input 
                    class="form-control" 
                    type="password"
                    name="password2"
                    autocomplete="new-password"
                    required
                    placeholder="Enter a Password Again" />
            </div>
            <div class="form-login-page">
                <select name="gender" class="form-control">
                    <option >Choose Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-login-page">
                <select name="group" class="form-control">
                    <option>....</option>
                    <option value="0">User</option>
                    <option value="1">Seller</option>
                </select>
            </div>
            <div class="form-login-page">
                <input 
                    class="form-control" 
                    type="file"
                    name="avatar"
                    required
                    placeholder="Enter a Avater" />
            </div>
            <input class="btn btn-success btn-block" type="submit" name="signup" value="Signup">
        </form>
        <!-- End Signup Form -->
        <div class="the-errors text-center">
            <?php  
            
                if(!empty($formErrors)){

                    foreach($formErrors as $error){

                        echo "<div class='masg error'>" . $error . "</div>";

                    }

                }

                if(isset($successMas)){

                    echo "<div class='masg success'>" . $successMas . "</div>";

                }

            ?>
        </div>
    </div>

<?php  
    include $tepl . 'footer.php';
?>