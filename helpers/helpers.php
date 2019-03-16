<?php
function error_dispaly($errors){

    $display='<ul class="alert alert-danger">';
    foreach ($errors as $error){
        $display.='<li class="text-danger">'.$error.'</li>';
    }
    $display.='</ul>';
    return $display;
}

function sanitize($x){
    return htmlentities($x,ENT_QUOTES,"UTF-8");
}

function login($user_id){
    $_SESSION['user']=$user_id;
    global $db;
    $date= date("Y-m-d :H-i-s");
    $db->query("update users set last_login ='$date' where id ='$user_id'");
    $_SESSION['flash-msg']='Your are now logged in :)';
    header("Location:index.php");
}

function is_logged_in(){
    if (isset($_SESSION['user'])&& $_SESSION['user']>0){
        return true;
    }
    return false;
}

function login_error_redirect($url='login.php'){
    $_SESSION['error_flash']='you must login to access this page';
    header("Location: ".$url);
}


function has_permision($permision='admin'){
    global $user_data;
    $permisions=explode(',',$user_data['permisson']);


    if (in_array($permision,$permisions,true)){
        return true;
    }else{ return false;}

}


function permision_error_redirect($url='login.php'){
    $_SESSION['error_flash']='permision denied';
    header("Location: ".$url);
}


function date_clear($date){
    return date("M d ,H:i A",strtotime($date));
}

function get_category($id){
    global $db;
    $id=sanitize($id);
    $sql="select p.id as 'pid',p.category as 'parent',c.id as 'cid',c.category as 'child'
          from categories c 
          inner join categories p
          on c.parent= p.id 
          where c.id='$id'
    ";
    $cat=$db->query($sql);
    $category=mysqli_fetch_assoc($cat);
    return $category;

}