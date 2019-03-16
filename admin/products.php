<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/conn.php';
if (!is_logged_in()){
    login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
$dbPath='';


// delete a product
if (isset($_GET['delete'])){
$id=(int)$_GET['delete'];
$db->query("update product set deleted =1 where id = '$id'");
header("Location:products.php");


}


// restore the product
if (isset($_GET['restore'])){
    $id=(int)$_GET['restore'];
    $db->query("update product set deleted =0 where id = '$id'");
    header("Location:products.php");


}
if (isset($_GET['add']) || isset($_GET['edit'])){

$brandQuery=$db->query("select * from brand order by brand");
$parentQuery=$db->query("select * from categories where parent=0 order by category ");
$title=((isset($_POST['title'])&&$_POST['title']!='')?sanitize($_POST['title']):'');
    $title=((isset($_POST['title'])&&$_POST['title']!='')?sanitize($_POST['title']):'');
    $brand=((isset($_POST['brand'])&&$_POST['brand']!='')?sanitize($_POST['brand']):'');
    $parent=((isset($_POST['parent'])&&$_POST['parent']!='')?sanitize($_POST['parent']):'');
    $category=((isset($_POST['child'])&&$_POST['child']!='')?sanitize($_POST['child']):'');
    $price=((isset($_POST['price'])&&$_POST['price']!='')?sanitize($_POST['price']):'');
    $list_price=((isset($_POST['list-price'])&&$_POST['list-price']!='')?sanitize($_POST['list-price']):'');
    $description=((isset($_POST['description'])&&$_POST['description']!='')?sanitize($_POST['description']):'');
    $sizes=((isset($_POST['sizes'])&&$_POST['sizes']!='')?sanitize($_POST['sizes']):'');
    $photo='';





    if (isset($_GET['edit'])){
    $edit_id=(int)$_GET['edit'];
    $p_query=$db->query("select * from product where id ='$edit_id'");
    $product=mysqli_fetch_assoc($p_query);
    $title=((isset($_POST['title'])&&$_POST['title']!='')?sanitize($_POST['title']):$product['title']);
    $brand=((isset($_POST['brand'])&&$_POST['brand']!='')?sanitize($_POST['brand']):$product['brand']);
    $category=((isset($_POST['child'])&&$_POST['child']!='')?sanitize($_POST['child']):$product['categories']);
    $price=((isset($_POST['price'])&&$_POST['price']!='')?sanitize($_POST['price']):$product['price']);
    $list_price=((isset($_POST['list-price'])&&$_POST['list-price']!='')?sanitize($_POST['list-price']):$product['list_price']);
    $description=((isset($_POST['description'])&&$_POST['description']!='')?sanitize($_POST['description']):$product['description']);
    $sizes=((isset($_POST['sizes'])&&$_POST['sizes']!='')?sanitize($_POST['sizes']):$product['sizes']);
    $sizes=rtrim($sizes,',');
    $photo=(($product['image'])?$product['image']:'');
    $dbPath=$photo;

    if (isset($_GET['delete_image'])){
    $img_url= $_SERVER['DOCUMENT_ROOT'].$product['image'];
    unlink($img_url);
    $db->query("update product set image='' where id='$edit_id'");
    header("Location:products.php?edit='$edit_id");

    }
        if (!empty($sizes)){
            $sizeString=sanitize($sizes);
            $sizeString=rtrim($sizeString,',');
            $sizeArray=explode(',',$sizeString);
            $sArray=array();
            $qArray=array();
            foreach ($sizeArray as $arr){
                $s=explode(':',$arr);
                $sArray[]=$s[0];
                $qArray[]=$s[1];
            }

        }else{$sizeArray=array();}




        $parentQ=$db->query("select * from categories where id ='$category'");
    $res=mysqli_fetch_assoc($parentQ);
        $parent=((isset($_POST['parent'])&&$_POST['parent']!='')?sanitize($_POST['parent']):$res['parent']);





    }

    // when submit the form
if ($_POST){
    $errors=array();



    $required_fields=array('title','brand','price','parent','child','sizes');
    foreach ($required_fields as $field){
        if ($_POST[$field]==''){
            $errors[]="All fields are required";
            break;
        }
    }
    if (!empty($_FILES)){
        var_dump($_FILES);
        $photo=$_FILES['photo'];
        $name=$photo['name'];
        $nameArray=explode('.',$name);
        $pName=$nameArray[0];
        $pExt=$nameArray[1];
        $mime=explode('/',$photo['type']);
        $mimeType =$mime[0];
        $mimeExt=$mime[1];
        $tmpLoc=$photo['tmp_name'];
        $fileSize=$photo['size'];
        $allowedExt=array('png','jpg','jpeg','gif');
        $upName=md5(microtime()).'.'.$pExt;
        $upLocation=$_SERVER['DOCUMENT_ROOT'].'/ecommerce/images/products/'.$upName;
        $dbPath='/ecommerce/images/products/'.$upName;

        if($mimeType!= 'image'){
$errors[]= "The File Must Be An Image";
        }
        if (!in_array($pExt,$allowedExt)){
            $errors[]='The Extention Is Not allowed';
        }
        if ($fileSize>1000000){
            $errors[]="the photo must not exceed 10 mb";
        }

    }
    if(!empty($errors)){
        echo error_dispaly($errors);
    }else{
        // the database insertion
        if (!empty($_FILES)) {
            move_uploaded_file($tmpLoc, $upLocation);

        }
        $sql="insert into product (`title`,`price`,`list_price`,`brand`,`categories`,`description`,`sizes`,`image`) values ('$title','$price','$list_price','$brand','$category','$description','$sizes','$dbPath')";
       if (isset($_GET['edit'])){
           $sql="UPDATE product SET title='$title' , price='$price' , list_price='$list_price',brand='$brand',categories='$category',sizes='$sizes',image='$dbPath',description='$description' where id ='$edit_id'";
       }
        $db->query($sql);
        header('Location:products.php');

    }

}
?>
<h2 class="text-center"> <?=((isset($_GET['edit']))?'Edit':'Add A New')?>  Product</h2>
    <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1')?>" method="post" enctype="multipart/form-data">
        <div class="form-group col-md-3">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $title?>">
        </div>

        <div class="form-group col-md-3">
            <label for="brand">Brand select</label>
            <select class="form-control" id="brand" name="brand">
                <option value="" <?=(($brand=='')?'selected':'')?>></option>

                <?php while ($b=mysqli_fetch_assoc($brandQuery)):?>
                   <option value="<?=$b['id'];?>" <?=(($brand==$b['id'])?'selected':'')?>><?=$b['brand'];?></option>
               <?php endwhile;?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="parent">Category select</label>
            <select class="form-control" id="parent" name="parent">
                <option value="" <?=(($parent=='')?'selected':'')?>></option>

                <?php while ($par=mysqli_fetch_assoc($parentQuery)):?>
                    <option value="<?=$par['id'];?>" <?=(($parent==$par['id'])?'selected':'')?>><?=$par['category'];?></option>
                <?php endwhile;?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="child">Child select</label>
            <select name="child" id="child" class="form-control"></select>

        </div>

        <div class="form-group col-md-3">
            <lable for="price">Price</lable>
            <input type="text" class="form-control" id="price"  name="price" value="<?= $price?>">
        </div>

        <div class="form-group col-md-3 col-md-6">
            <lable for="list-price">List Price</lable>
            <input type="text" class="form-control" id="list-price" name="list-price" value="<?= $list_price?>">

        </div>

        <div class="form-group col-md-3 col-md-6">
            <lable for="">Quantity & Sizes</lable>
            <button class="btn btn-default form-control" onclick="jQuery('#modalSizes').modal('toggle');return false">Quantity and sizes</button>

        </div>

        <div class="form-group col-md-3">
            <lable for="sizes">sizes and Quantity preview</lable>
            <input type="text" class="form-control" id="sizes" name="sizes" value="<?=$sizes?>" readonly>

        </div>
        <div class="form-group col-md-3">
            <?php if($photo!=''):?>
            <div>
                <img src="<?=$photo?>" alt="product photo" class="img-responsive img-circle img-thumbnail">
                <a href="products.php?delete_image=1&edit=<?=$edit_id?>" class="btn btn-danger"> Delete Image</a>
            </div>
            <?php else:;?>
            <lable for="photo"> Product Photo</lable>
            <input type="file" class="form-control" name="photo" id="photo">
    <?php endif;?>
        </div>
        
        <div class="form-group col-md-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?=$description?></textarea>
        </div>
        <a href="products.php" class="btn btn-danger" <?= ((isset($_GET['edit'])?'':'style="display: none;"'))?>>Cancel</a>
        <div class="form-group col-md-3">
            <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add A New')?>Product" class="btn btn-success pull-right">
        </div>
    </form>



    <!-- Modal -->
    <div class="modal fade " id="modalSizes" tabindex="-1" role="dialog" aria-labelledby="sizesModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sizesModalLongTitle">Sizes and Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                 <div class="container-fluid">
                     <?php for ($i=1;$i<=12;$i++):?>
                        <div class="form-group col-md-4">
                            <label for="size"> Size</label>
                            <input type="text" name="size<?=$i?>" id="size<?=$i?>" value="<?=(!empty($sArray[$i-1])?$sArray[$i-1]:'')?>" class="form-control">
                        </div>
                         <div class="form-group col-md-2">
                             <label for="qty"> Quantity</label>
                             <input type="number" name="qty<?=$i?>" id="qty<?=$i?>" class="form-control" min="0" value="<?=(!empty($qArray[$i-1])?$qArray[$i-1]:'')?>">
                         </div>

                     <?php endfor;?>
                 </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#modalSizes').modal('toggle');return false;">Save changes</button>
                </div>
            </div>
        </div>
    </div>



<?php }else{
$sql=" select * from product";
$presult=$db->query($sql);

if (isset($_GET['featured']) ){
    $id= (int)$_GET['id'];
    $featured=(int)$_GET['featured'];
    $update_feature= "update product set featured ='$featured' where id='$id'";
    $db->query($update_feature);
    header('Location:products.php');
}

?>
    <a href="products.php?add=1" class="btn btn-success" id="add-product">Add Product</a>
<div class="clearfix"></div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">product</th>
            <th scope="col">price</th>
            <th scope="col">category</th>
            <th scope="col">featured</th>
            <th scope="col">sold</th>


        </tr>
        </thead>
        <tbody>
        <?php while ($product=mysqli_fetch_assoc($presult)):
            $childId=$product['categories'];
            $sql2="select * from categories where id='$childId'";
            $res=$db->query($sql2);
            $category= mysqli_fetch_assoc($res);
            $p_id=$category['parent'];
            $sql3="select * from categories where id='$p_id'";
            $res2=$db->query($sql3);
            $parent=mysqli_fetch_assoc($res2);
            $full_Cat=$parent['category'].' / '.$category['category'];




            ?>
        <tr>
            <td>
                <a href="products.php?edit=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="products.php?delete=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
                <?php if ($product['deleted']==1):?>
                <a href="products.php?restore=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-refresh"></span></a>
                <?php endif;?>

            </td>
            <td><?=$product['title']?></td>
            <td><?=$product['price']?></td>
            <td><?=$full_Cat?></td>
            <td><a href="products.php?featured=<?=(($product['featured'] ==0)?'1':'0')?>&id=<?=$product['id']?>" ><span class="btn btn-xs btn-default glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus')?>"></span></a> <?=(($product['featured']==1)?'featured product':'')?> </td>
            <td></td>
        </tr>
        <?php endwhile;?>
        </tbody>
    </table>
<?php }include 'includes/footer.php'?>
<script>
    jQuery('document').ready(function () {
        getChilds('<?=$category?>');
    });
</script>
