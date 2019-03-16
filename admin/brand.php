<?php
require_once '../core/conn.php';
if (!is_logged_in()){
    login_error_redirect();
}
include "includes/head.php";
include "includes/navigation.php";

$sql= "select * from brand order by brand";
$result_all= $db->query($sql);

$errors= array();



// delete brands
if (isset($_GET['delete'])&&!empty($_GET['delete'])){
    $deleted_id=(int)$_GET['delete'];
    $deleted_id=sanitize($deleted_id);
    $sql="delete from brand where id='$deleted_id'";
    $db->query($sql);
    header('Location:brand.php');
}


// edit brands
if (isset($_GET['edit'])&&!empty($_GET['edit'])){
    $edited_id=(int)$_GET['edit'];
    $edited_id=sanitize($edited_id);

    $sql2="select * from brand where id='$edited_id'";
    $result=$db->query($sql2);
    $ebrand=mysqli_fetch_assoc($result);
}

 if (isset($_POST['add_submit'])){
     $brand=sanitize($_POST['brand']);
     if ($_POST ['brand']==''){
         $errors[].=" no brand entered";
     }
     // if the brand exists in database

     if (isset($_GET['edit'])){
         $sql="select * from brand where brand='$brand' and id !='$edited_id'";
     }
        $sql="select * from brand where brand='$brand'";
     $result= $db->query($sql);
     $numbers= mysqli_fetch_assoc($result);
     if ($numbers>0){
         $errors[].=$brand." is already exists you must enter a unique value";
     }


     if (!empty($errors)){
         echo error_dispaly($errors);
     }else{

      $sql="insert into brand (brand) values ('$brand')";
         if (isset($_GET['edit'])){
             $sql="update brand set brand ='$brand' where id ='$edited_id'";
         }
         $db->query($sql);
         header("Location:brand.php");
     }
 }
?>

<h2 class="center-block"> Brands</h2>

<form action="brand.php?<?= ((isset($_GET['edit'])))?'edit='.$edited_id:''?>" method="post" class="form-inline">
    <div class="form-group">

        <?php
        $value='';
        if (isset($_GET['edit'])){
            $value=$ebrand['brand'];
        }elseif (isset($_POST['brand'])){
            $value=$_POST['brand'];
        }
        ?>
        <label for="brand"><?= ((isset($_GET['edit'])))?'Edit A':'Add A'?> Brand:</label>
    <input type="text" name="brand" class="form-control" id="brand" value="<?= $value;?>">
        <button type="submit" class="btn btn-success" name ="add_submit"><?= ((isset($_GET['edit'])))?'Edit ':'Add '?> Brand</button>
      <?php if(isset($_GET['edit'])):?>
       <a href="brand.php" class="btn btn-danger">Cancel</a>
      <?php endif;?>
    </div>
</form>

<table class="table table-bordered table-striped btable">
    <thead>
    <th>edit</th>
    <th>brands</th>
    <th>Delete</th>
    </thead>

    <tbody>
    <?php while ($brands=mysqli_fetch_assoc($result_all)):?>

    <tr>
        <td><a href="brand.php?edit=<?php echo $brands['id']?>" class="btn btn-md btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td> <?php echo $brands['brand']?></td>
        <td><a href="brand.php?delete=<?php echo $brands['id']?>" class="btn btn-md btn-danger"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
    </tr>
    <?php endwhile;?>
    </tbody>
</table>

<?php include "includes/footer.php";?>
