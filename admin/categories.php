<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/conn.php';
include 'includes/head.php';
include 'includes/navigation.php';

$sql="select * from categories where parent = 0";
$result=$db->query($sql);
$errors=array();
// form submit
if ( isset($_POST)&&!empty($_POST)){
    $parent=sanitize($_POST['parent']);
    $category=sanitize($_POST['category']);
    $sqlForm="select * from categories where category='$category' and parent='$parent'";
    $fResult = $db->query($sqlForm);
    $count= mysqli_num_rows($fResult);

    // case of blank inputs
    if($category==''){
            $errors[].=" You Must Enter A Category";
        }

        if ($count>0){
            $errors[].=$category.' is already exists';
        }
        if (!empty($errors)){
            $display=error_dispaly($errors);?>
            <script>
                $('document').ready(function () {

                    $('#errors').html('<?= $display;?>')

                });
            </script>
            <?php
        }else {
            $insertSql="insert into categories (category,parent) values ('$category',$parent)";
            $db->query($insertSql);
            header('Location:categories.php');
        }
    }
?>
    <div id="errors"></div>
<h2 class="text-center">Categories</h2>

    <div class="row">
<!--        form of categories-->
        <div class="col-md-6">
            <form class="form" action="categories.php" method="post">
                <legend> Add A Category</legend>
                <div class="form-group">
                    <lable for="parents"> Parent</lable>
                    <select name="parent" id="parent" class="form-control">
                        <option value="0">parent</option>
                        <?php while ($parent=mysqli_fetch_assoc($result)):?>
                            <option value="<?= $parent['id']?>"><?= $parent['category']?></option>
                        <?php endwhile;?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" class="form-control" id="category" name="category">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Add Category">
                </div>
            </form>


        </div>



<!--   table of categories-->
    <div class="col-md-6">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">category</th>
                <th scope="col">parent</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php

            $sql="select * from categories where parent = 0";
            $result=$db->query($sql);

            while ($parent= mysqli_fetch_assoc($result)):
                $parent_id=$parent['id'];
                $sql="select * from categories where parent='$parent_id'";
                $result2=$db->query($sql);


                ?>

            <tr class="bg-info">

                <td><?= $parent['category'];?></td>
                <td>Parent</td>
                <td>
                    <a href="categories.php?edit=<?=$parent['id'];?>" class="btn btn-warning btn-md"> <span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="categories.php?delete=<?=$parent['id'];?>" class="btn btn-danger btn-md"> <span class="glyphicon glyphicon-remove"></span></a>

                </td>
            </tr>

            <?php while ($child=mysqli_fetch_assoc($result2)):?>
    <tr>

        <td><?= $child['category'];?></td>
        <td><?= $parent['category'];?></td>
        <td>
            <a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-warning btn-md"> <span class="glyphicon glyphicon-pencil"></span></a>
            <a href="categories.php?delete=<?=$child['id'];?>" class="btn btn-danger btn-md"> <span class="glyphicon glyphicon-remove"></span></a>

        </td>
    </tr>
<?php endwhile;?>

<?php endwhile;?>
            </tbody>
        </table>
    </div>

    </div>
<?php
include 'includes/footer.php';?>