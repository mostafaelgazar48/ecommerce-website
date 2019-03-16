<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/conn.php';
include 'includes/head.php';
$email=((isset($_POST['email']))?$_POST['email']:'');
$email=trim($email);
$password=((isset($_POST['password']))?$_POST['password']:'');
$password=trim($password);
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
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $errors[] = ' you must enter email and password';
        }


        //check the email
        $q = $db->query("select * from users where email='$email'");
        $user = mysqli_fetch_assoc($q);
        $count = mysqli_num_rows($q);
        echo $count;
        if ($count<1){
            $errors[]=' The email not exist in database';
        }


        // check the password
        if (!password_verify($password,$user['password'])){
            $errors[]=' the Password does not math the email';
        }else{
            // if correctly login
            $user_id=$user['id'];
            login($user_id);
        }



        if (!(empty($errors))) {
           echo error_dispaly($errors);
        }
    }
    ?>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1" class="bmd-label-floating">Email address </label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email">

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="bmd-label-floating">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>
        <div class="form-group">

            <input type="submit" class="btn btn-success form-control">
        </div>
    </form>
</div>
<?php
include 'includes/footer.php';
?>


