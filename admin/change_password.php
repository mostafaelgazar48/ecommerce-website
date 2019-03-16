<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/conn.php';
if (!is_logged_in()){
    login_error_redirect();
}
include 'includes/head.php';

$hashed_password=$user_data['password'];

$old_password=((isset($_POST['old_password']))?$_POST['old_password']:'');
$old_password=trim($old_password);

$password=((isset($_POST['password']))?$_POST['password']:'');
$password=trim($password);


$confirm_password=((isset($_POST['confirm_password']))?$_POST['confirm_password']:'');
$confirm_password=trim($confirm_password);


$new_Hashed_password=password_hash($password,PASSWORD_DEFAULT);
$errors=array();




?>
<style>
    body{
        background: #9CECFB;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #0052D4, #65C7F7, #9CECFB);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #0052D4, #65C7F7, #9CECFB);
    }
    #login-form{
        border: solid 1px #000000;
        width: 50%;
    }

</style>
<div class="container-fluid" id="login-form">


    <?php
    if ($_POST) {
        if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
            $errors[] = ' you must all fields';
        }


        // check the confirm between the poassword and the confirm_password
            if ($password!=$confirm_password){
                    $errors[]='the passwords don\'t match ';
            }




        // check the password
        if (!password_verify($old_password,$hashed_password)){
            $errors[]=' the Password you entered is incorrect';
        }




        if (!(empty($errors))) {
            echo error_dispaly($errors);
        }else{
            //change password
global $user_data;
$id=$user_data['id'];
            $db->query("update users set password='$new_Hashed_password' where id='$id'");
            $_SESSION['flash-msg']='Your Password Has Been Updated';
            header("Location:change_password.php");
        }
    }
    ?>
    <form action="change_password.php" method="post">
        <div class="form-group">
            <label for="old password" class="bmd-label-floating">old pssword </label>
            <input type="password" class="form-control" id="exampleInputEmail1" name="old_password">

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="bmd-label-floating">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>

        <div class="form-group">
            <label for="confirm" class="bmd-label-floating">confirm password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="confirm_password">
        </div>


        <div class="form-group">

            <input type="submit" class="btn btn-success form-control">
            <a href="index.php" class="btn btn-danger form-control"> Cancel</a>
        </div>
    </form>
</div>
<?php
include 'includes/footer.php';
?>


