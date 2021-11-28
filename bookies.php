<?php
ob_start();
session_start();

$pageTitle = 'HomePage';

include 'init.php';



?>

<div class="container view-item">
    <div class="row col-items">
        <?php 

            if(isset($_SESSION['user'])){
            
                $itemsAll = getItems("", "", 'Item_ID');
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

                $itemsAll = getItems(' ', '', 'Item_ID');
                
                    foreach($itemsAll as $item){?>
                    
                    <div class="card-items">
                            <ul class='list-items'>
                                    <li><span><i class='fa fa-user'></i> <?php echo $item['FullName']?></span></li>
                                    <li><span><i class='fa fa-book'></i> <?php echo $item['Add_Date']?></span></li>
                                    <li>Numbers The comments: <span>
                                        <i class='fa fa-comment'></i>  
                                        <?php echo countComment("item_id", "comments", $item['Item_ID'])?></span>
                                    </li>
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