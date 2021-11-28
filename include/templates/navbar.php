<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php"><img src="images/logo22.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav  me-auto mb-2 mb-lg-0">
        
          <li><a class='nav-link' href='index.php'>Home</a></li>
          <li><a class='nav-link' href='about.php'>About Us</a></li>
          <li><a class='nav-link' href='bookies.php'>Bookings</a></li>
          <?php if(isset($_SESSION['user'])){
        ?>
          <li class="nav-item dropdown session-user">
              <a class="btn btn-default  nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="admin/upload/avatar/<?php echo $_SESSION['image']?>" class="img-thumbnail img-circle" alt="" /><?php echo $sessionUser ?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php
                        if(isset($_SESSION['sid'])){
                            echo '<li><a class="dropdown-item" href="newad.php">New Item</a></li>';
                            echo '<li><a class="dropdown-item" href="dashboard.php">My Dashboard</a></li>';
                        }
                  ?>
                  <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              </ul>
          </li>
       <?php }else{ ?>

          <a href="login.php" class='nav-link'>
              <span class="login-header pull-right">Login/Signup</span>
          </a>

          <?php }?>
      </ul>
    </div>
  </div>
</nav>
<div class="hero">
     <div class="container">
          <div class="main-heading">
          <h1 class="title">Discover Our Horizone</h1>
          <h2 class="Subtitle">Events, Hotels, Concentrations, Camps</h2>
          </div>


          <a href="#" class="btn btn-gradient">
          Find Out Now
          </a>
     </div>
</div>