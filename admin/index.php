<?php
require_once '../core/conn.php';
if (!is_logged_in()){
    header("Location:login.php");
}


include "includes/head.php";
include "includes/navigation.php";
?>


<?php include "includes/footer.php";?>
