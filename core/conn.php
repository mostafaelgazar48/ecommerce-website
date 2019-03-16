<?php
$db=mysqli_connect('127.0.0.1','root','','ec');
if (mysqli_connect_errno()){
    echo "connection error".mysqli_connect_error();
    die();
}
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/config.php';
require_once baseurl.'helpers/helpers.php';


if (isset($_SESSION['user'])){
    $user_id=$_SESSION['user'];
    $query= $db->query("select * from users where id ='$user_id'");
    $user_data=mysqli_fetch_assoc($query);
    $f_n=explode(' ',$user_data['full_name']);
    $user_data['first']=$f_n[0];
    $user_data['last']=$f_n[1];


}



if (isset($_SESSION['flash-msg'])){
    echo '<div class="bg-success"><p class="text-center text-success">'.$_SESSION['flash-msg'].'</p></div>';
    unset($_SESSION['flash-msg']);
}

if (isset($_SESSION['error_flash'])){
    echo '<div class="bg-danger"><p class="text-center text-danger">'.$_SESSION['error_flash'].'</p></div>';
    unset($_SESSION['error_flash']);
}
