

<?php
require_once 'core/conn.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/header.php';
include 'includes/left_side.php';


if (isset($_GET['category']) && $_GET['category']!=''){
    $id=sanitize($_GET['category']);

}
else{
    $id='';
}
$sql ="select * from product where categories='$id'";
$products=$db->query($sql);
$category=get_category($id);

?>
<!-- end of nav-->
<!-- header -->


<div class="col-md-8">
    <h2 class="text-center"><?=$category['parent'].' '.$category['child']?></h2>
    <div class="row">

        <?php while ($product=mysqli_fetch_assoc($products)) :?>
            <div class="col-sm-3">
                <div class="thumb-wrapper">
                    <div class="img-box">
                        <img src="<?php echo $product['image'];?>" class="img-responsive img-fluid" alt="">
                    </div>
                    <div class="thumb-content">
                        <h4><?php echo $product['title'];?></h4>

                        <p class="item-price"><strike><?php echo $product['list_price'];?></strike> <span><?php echo $product['price'];?></span></p>
                        <div class="star-rating">
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-sm btn-success" onclick="modaldetail(<?php echo $product['id'] ;?>)">Details</button>
                        <!--                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>-->

                    </div>
                </div>
            </div>

        <?php endwhile;?>

    </div>
</div>


<?php
include 'includes/right_side.php';

include 'includes/footer.php';
//include 'includes/details_modal.php';

?>