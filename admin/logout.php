<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/conn.php';
unset($_SESSION['user']);
header("Location:login.php");
?>