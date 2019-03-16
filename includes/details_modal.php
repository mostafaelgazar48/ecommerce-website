<?php
require $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/conn.php';
$id= $_POST['id'];
$id=(int)$id;
$sql= "select * from product where id ='$id'";
$query=$db->query($sql);
$product=mysqli_fetch_assoc($query);
$brand_id=$product['brand'];
$sql2="select brand from brand where id ='$brand_id'";
$query2=$db->query($sql2);
$brand= mysqli_fetch_assoc($query2);

$sizes = $product['sizes'];
$sizes=rtrim($sizes,',');
$size_array=explode(',',$sizes);

?>
<?php echo ob_start();?>
<!-- the pop up -->
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times;</span>
                </button>
                <h4 class="modal-title text-center"><?php echo $product['title']; ?></h4>
            </div>
            <span class="bg-danger" id="modal_errors"></span>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="center-block">
                                <div class="img-box">
                                    <img src="<?php echo $product['image']?>" class="img-responsive img-fluid detials" alt="">
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <h4> <?php  echo $product['description']?></h4>
                            <hr>
                            <p> <?php  echo $product['price']?></p>
                            <hr>
                            <p> <?php  echo $brand['brand']?></p>
                            <hr>

                            <form action="add_to_cart.php"method="post" id="add_product_form">
                                <input type="hidden" name="product_id" value="<?=$id?>">
                                <input type="hidden" name="available" id="available" value="">
                                <div class="form-group">

                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="0">


                                </div>

                                <div class="form-group">
                                    <hr>

                                    <label for="size" >Size:</label><br>
                                    <select name="size" id="size" class="form-control">
                                        <option value="" > </option>
                                       <?php

                                       foreach ($size_array as $string){
                                           $string_array=explode(':',$string);
                                           $size=$string_array[0];
                                           $available=$string_array[1];
                                           echo '<option   value="'.$size.'" data-available="'.$available.'">'.$size.' (Available'.$available.')</option>';
                                       }

                                       ?>



                                    </select>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"> Close</button>
                <button class="btn btn-success" onclick="addTocart();return false;" > Add to Cart <span class="glyphicon glyphicon-shopping-cart"></span></button>

            </div>

        </div>
    </div>
    <script>
    jQuery('#size').change(
        function () {
            var available=jQuery('#size option:selected').data("available");
            jQuery('#available').val(available);
        }
    );


    </script>

<?php echo ob_get_clean();?>