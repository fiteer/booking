<?php 
ob_start();
session_start();
$pageTitle = 'About Us';
include "init.php";

?>

        <h1 class="text-center">About Us</h1>
        <div class="container">
            <div class="row about">
                <div class="col-md-4 img-info">
                    <img src="images/hotel_astro_resort.jpg" alt="" srcset="">
                </div>
                <div class="col-md-8 items-info">
                    <p>
                        By investing in the technology that helps take the friction out of travel, 
                        Booking.com seamlessly connects millions of travellers with memorable 
                        experiences, a range of transport options and incredible places to 
                        stay - from homes to hotels and much more. As one of the world’s 
                        largest travel marketplaces for both established brands and entrepreneurs 
                        of all sizes, Booking.com enables properties all over the world to reach 
                        a global audience and grow their businesses.
                    </p>
                </div>
            </div>
            <div class="row about">
                <div class="col-md-8 items-info">
                    <p>
                        By investing in the technology that helps take the friction out of travel, 
                        Booking.com seamlessly connects millions of travellers with memorable 
                        experiences, a range of transport options and incredible places to 
                        stay - from homes to hotels and much more. As one of the world’s 
                        largest travel marketplaces for both established brands and entrepreneurs 
                        of all sizes, Booking.com enables properties all over the world to reach 
                        a global audience and grow their businesses.
                    </p>
                </div>
                <div class="col-md-4 img-info">
                    <img src="images/hot1.jpg" alt="" srcset="">
                </div>
            </div>
            <div class="row about">
                <div class="col-md-4 img-info">
                    <img src="images/room2.jpeg" alt="" srcset="">
                </div>
                <div class="col-md-8 items-info">
                    <p>
                        By investing in the technology that helps take the friction out of travel, 
                        Booking.com seamlessly connects millions of travellers with memorable 
                        experiences, a range of transport options and incredible places to 
                        stay - from homes to hotels and much more. As one of the world’s 
                        largest travel marketplaces for both established brands and entrepreneurs 
                        of all sizes, Booking.com enables properties all over the world to reach 
                        a global audience and grow their businesses.
                    </p>
                </div>
            </div>
            
            <div class="row about">
                <div class="col-md-8 items-info">
                    <p>
                        By investing in the technology that helps take the friction out of travel, 
                        Booking.com seamlessly connects millions of travellers with memorable 
                        experiences, a range of transport options and incredible places to 
                        stay - from homes to hotels and much more. As one of the world’s 
                        largest travel marketplaces for both established brands and entrepreneurs 
                        of all sizes, Booking.com enables properties all over the world to reach 
                        a global audience and grow their businesses.
                    </p>
                </div>
                <div class="col-md-4 img-info">
                    <img src="images/room_3.jpg" alt="" srcset="">
                </div>
            </div>
        </div>

<?php
include $tepl . 'footer.php';
ob_end_flush();
?>