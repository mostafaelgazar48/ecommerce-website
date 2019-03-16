<?php
$sql="SELECT * FROM categories WHERE parent = 0";
$query = $db->query($sql);
?>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a href="index.php" class="navbar-brand">ecommerce-site</a>
        <ul class="nav navbar-nav">
            <?php while ($parent=mysqli_fetch_assoc($query)):?>
            <?php $parent_id=$parent['id'];
            $sql2="select * from categories where parent ='$parent_id' ";
            $query2=$db->query($sql2);

            ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo $parent['category'];?> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <?php while ($list=mysqli_fetch_assoc($query2)) :?>
                    <li><a href="category.php?category=<?=$list['id']?>"> <?php echo $list['category']?></a></li>
                    <?php endwhile;?>
                </ul>
            </li>
            <?php endwhile ; ?>
        </ul>

    </div>
</nav>