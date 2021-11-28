<?php
ob_start();
session_start();

$pageTitle = 'HomePage';

include 'init.php';



?>

<div class="container view-item">
    <div class="row col-items">
        <?php 

            if(isset($_SESSION['user'])){?>

                <form class="form-horizontal search" method="POST">
                    <input 
                            class="form-control"
                            type="search" 
                            name="search"  
                            placeholder="Search Of The Item">
            
                    <input type="submit" value="Search" name="submit" class="btn btn-primary">
                </form>

                <?php
                if(isset($_POST['submit'])){
                    $str = $_POST['search'];
                    $search = getItems("", "WHERE Name LIKE '%$str%'", "", 'Item_ID');
                    if($search > 0){
                        foreach($search as $sth){
                        
                            ?>
                            
                            <div class="card-items">
                                <ul class='list-items'>
                                        <li><span><i class='fa fa-user'></i> <?php echo $sth['FullName']?></span></li>
                                        <li><span><i class='fa fa-book'></i> <?php echo $sth['Add_Date']?></span></li>
                                        <li>comments: <span>
                                            <i class='fa fa-comment'></i>  
                                            <?php echo countComment("item_id", "comments", $sth['Item_ID'])?></span>
                                        </li>
                                </ul>
                                <div class="front">
                                    <span class='price-items'><?php echo  $sth['Price']?></span>
                                    <div class='img-items'>
                                        <?php echo "<img src='admin/upload/avatar/" . $sth['avatar'] ."' alt='' class='img-top'>";?>
                                    </div>
                                    
                                </div>
                                <div class="back">
                                    <h3><a href='items.php?itemid=<?php echo $sth['Item_ID']?>'> <?php echo $sth['Name']?></a></h3>
                                    <?php echo "<p class='text-items'>" . $sth['type_item'] . "</p>";?>
                                </div>
                            </div>
                    <?php } 
                    }else{
                        echo "There Are No Matching Items";
                    }
                }
                ?>



            <?php
                $itemsAll = getItems("", "", 'Item_ID', 'LIMIT 9');
                if(empty($itemsAll)){

                    echo "<div class='naice-message'>Sorry This Category Is Empty</div>";
    
                }else{
                   
                    foreach($itemsAll as $item){
                        
                        ?>
                        
                        <div class="card-items">
                            <ul class='list-items'>
                                    <li><span><i class='fa fa-user'></i> <?php echo $item['FullName']?></span></li>
                                    <li><span><i class='fa fa-book'></i> <?php echo $item['Add_Date']?></span></li>
                                    <li>comments: <span>
                                        <i class='fa fa-comment'></i>  
                                        <?php echo countComment("item_id", "comments", $item['Item_ID'])?></span>
                                    </li>
                            </ul>
                            <div class="front">
                                <?php
                                if($item['status'] == 1){
                                    echo "<span class='approve-status'>Booked Up</span>"; 
                                }else{
                                    echo "<span class='price-items'>" . $item['Price'] . "</span>";
                                }
                                ?>
                                
                                <div class='img-items'>
                                    <?php echo "<img src='admin/upload/avatar/" . $item['avatar'] ."' alt='' class='img-top'>";?>
                                </div>
                                
                            </div>
                            <div class="back">
                                <h3><a href='items.php?itemid=<?php echo $item['Item_ID']?>'> <?php echo $item['Name']?></a></h3>
                                <?php echo "<p class='text-items'>" . $item['type_item'] . "</p>";?>
                                
                            </div>
                        </div>
                    <?php }
               }
                
            }else{

                $itemsAll = getItems(' ', '', 'Item_ID', 'LIMIT 6');
                
                    foreach($itemsAll as $item){?>
                    
                    <div class="card-items">
                            <ul class='list-items'>
                                    <li><span><i class='fa fa-user'></i> <?php echo $item['FullName']?></span></li>
                                    <li><span><i class='fa fa-book'></i> <?php echo $item['Add_Date']?></span></li>
                                    <!-- <li>Numbers The comments: <span>
                                        <i class='fa fa-comment'></i>  
                                        <?php //echo countComment("item_id", "comments", $item['Item_ID'])?></span>
                                    </li> -->
                            </ul>
                            <div class="front">
                                <span class='price-items'><?php echo  $item['Price']?></span>
                                <div class='img-items'>
                                    <?php echo "<img src='admin/upload/avatar/" . $item['avatar'] ."' alt='' class='img-top'>";?>
                                </div>
                                
                            </div>
                            <div class="back">
                            <h3><a href='items.php?itemid=<?php echo $item['Item_ID']?>'> <?php echo $item['Name']?></a></h3>
                                
                                <p class='text-items'><?php echo $item['Description']?></p>
                            </div>
                        </div>
                    <?php }
               
            
            }?>
            

    </div>
</div> 

<?php
include $tepl . 'footer.php';
ob_end_flush();
?>