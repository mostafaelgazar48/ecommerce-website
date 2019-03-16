<?php
require_once '../core/conn.php';
if (!is_logged_in()){
    login_error_redirect();
}

if (!has_permision('admin')){
    permision_error_redirect('index.php');
}
include "includes/head.php";
include "includes/navigation.php";
$query=$db->query("select * from users order by full_name");


// to delete a user

if (isset($_GET['delete'])){
    $delete_id=(int)$_GET['delete'];
    $db->query("delete from users where id ='$delete_id'");
    $_SESSION['flash-msg']='user deleted successfully';
    header("Location:users.php");
}

// wheen click add button

if (isset($_GET['add'])){
    $name=((isset($_POST['name'])?sanitize($_POST['name']):''));
    $email=((isset($_POST['email'])?sanitize($_POST['email']):''));
    $password=((isset($_POST['password'])?sanitize($_POST['password']):''));
    $confirm_password=((isset($_POST['confirm_password'])?sanitize($_POST['confirm_password']):''));
    $permission=((isset($_POST['permission'])?sanitize($_POST['permission']):''));
    $errors= array();

    if ($_POST){

        $email_query=$db->query("select * from users where email='$email'");
        $c_email=mysqli_num_rows($email_query);
        if ($c_email !=0){
            $errors[]= ' the email is already exists in database';
        }

        $required_fields=array('name','email','password','confirm_password','permission');
        foreach ($required_fields as $f){
            if (empty($_POST[$f])){
                $errors[]=' All fields are Required';
                break;
            }
        }


        if ($password !=$confirm_password){
            $errors[]=' the passwords dosen\'t match';
        }

        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors[]=' You must enter a valid email';
        }
        if(!empty($errors)){
            echo error_dispaly($errors);
        }else{
            $hashed_password=password_hash($password,PASSWORD_DEFAULT);
            $db->query("insert into users(full_name,email,password,permisson) values ('$name','$email','$hashed_password','$permission')");
            $_SESSION['flash-msg']=' users added successfully  to database . ';
            header("Location:users.php");

        }
    }

    ?>
    <h2 class="text-center">Add New user</h2>
    <form action="users.php?add=1" method="post">
        <div class="form-group">
            <label for="name"> Full name:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?=$name?>">
        </div>

        <div class="form-group">
            <label for="email"> email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?=$email?>">
        </div>

        <div class="form-group">
            <label for="password"> Password:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password?>">
        </div>
        <div class="form-group">
            <label for="confirm password"> Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm password" class="form-control" value="<?=$confirm_password?>">
        </div>
        <div class="form-group">
            <label for="permision"> Permissions:</label>
            <select name="permission" class="form-control">
                <option value="" <?=(($permission == '')?'selected':'')?>></option>
                <option value="editor" <?=(($permission == 'editor')?'selected':'')?>> Editor</option>
                <option value="admin,editor" <?=(($permission == 'admin,editor')?'selected':'')?>>Admin</option>

            </select>
        </div>
        <div class="form-group">
            <a href="users.php" class="btn btn-danger">Cancel</a>
            <input type="submit" value="Add User" class="btn btn-success">
        </div>
    </form>
    <?php
}else{

?>

<h2> Users Data</h2>
<a href="users.php?add=1" class="btn btn-success" id="add-user"> Add New user <span class="glyphicon glyphicon-plus"></span></a>
<table class="table table-bordered table-striped table-condensed">
    <thead>
    <th></th>
    <th> Name</th>
    <th>Email</th>
    <th>Join Date</th>
    <th>Last Login</th>
    <th>Permissions</th>
    </thead>
    <tbody>
    <?php while($user=mysqli_fetch_assoc($query)):?>

    <tr>
        <td>
            <?php if ($user['id']!=$user_data['id']):?>
            <a href="users.php?delete=<?=$user['id']?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a>
            <?php endif;?>
        </td>
        <td><?=$user['full_name']?></td>
        <td><?=$user['email']?></td>
        <td><?=date_clear($user['join_date'])?></td>
        <td><?=(($user['last_login']=='0000-00-00 00:00:00')?'Never Logged':date_clear($user['last_login']))?></td>
        <td><?=$user['permisson']?></td>

    </tr>
    <?php endwhile;?>
    </tbody>
</table>

<?php }include "includes/footer.php";?>
