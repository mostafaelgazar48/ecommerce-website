<?php
/**
 * Created by PhpStorm.
 * User: mosta
 * Date: 12/21/18
 * Time: 7:00 PM
 */
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/conn.php';


session_start();

if(isset($_POST["add_to_cart"]))
{
    if(isset($_SESSION["shopping_cart"]))
    {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($_GET["id"], $item_array_id))
        {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id'			=>	$_GET["id"],
                'item_name'			=>	$_POST["hidden_name"],
                'item_price'		=>	$_POST["hidden_price"],
                'item_quantity'		=>	$_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        }
        else
        {
            echo '<script>alert("Item Already Added")</script>';
        }
    }
    else
    {
        $item_array = array(
            'item_id'			=>	$_GET["id"],
            'item_name'			=>	$_POST["hidden_name"],
            'item_price'		=>	$_POST["hidden_price"],
            'item_quantity'		=>	$_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["shopping_cart"] as $keys => $values)
        {
            if($values["item_id"] == $_GET["id"])
            {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="index.php"</script>';
            }
        }
    }
}

//$cart_id='';
//
//if (isset($_SESSION[CART_COOKIE])){
//    $cart_id=sanitize($_SESSION[CART_COOKIE]);
//}
//$product_id=sanitize($_POST['product_id']);
//$size=sanitize($_POST['size']);
//$available=sanitize($_POST['available']);
//$quantity=sanitize($_POST['quantity']);
//$item=array();
//$item[]=array(
//  'id' => $product_id,
//  'size'  => $size,
//  'quantity' =>$quantity,
//);
//
//
//
//$domain = ($_SERVER['HTTP_HOST'] !='localhost')?'.'.$_SERVER['HTTP_HOST']:false;
//
//$sql=$db->query(" select * from product where id='{$product_id}'");
//$product=mysqli_fetch_assoc($sql);
//$_SESSION['flash-msg']=$product['title'].' was added successfully to Cart';
//
//if ($cart_id !=''){
//    $cartQ=$db->query("select * from cart where id ='{$cart_id}'");
//    $cart= mysqli_fetch_assoc($cartQ);
//    $previous_items=json_decode($cart['items'],true);
//    $item_match=0;
//    $new_item=array();
//    foreach ($previous_items as $pitem){
//        if($item[0]['id']==$pitem['id'] &&$item[0]['size']==$pitem['size']){
//            $pitem['quantity']=$pitem['quantity']+$item[0]['quantity'];
//            if($pitem['quantity'] >$available){
//                $pitem['quantity']=$available;
//            }
//            $item_match=1;
//        }
//        $new_item[]=$pitem;
//    }
//
//
//
//if ($item_match!=1){
//    $new_item= array_merge($item,$previous_items);
//}
//$item_json=json_encode($new_item);
//    $cart_expire=date("Y-m-d H:i:s",strtotime("+30 days"));
//    $db->query("update cart set items='{$item_json}'),expire_date='{$cart_expire}' where id='{$cart_id}'");
//    setcookie(CART_COOKIE,'',1,'/',$domain,false);
//    setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
//
//
//
//}else{
//    $_SESSION['flash-msg']=$product['title'].' was added successfully to database';
//    $item_json=json_encode($item);
//    $cart_expire=date("Y-m-d H:i:s",strtotime("+30 days"));
//    $db->query(" insert into cart (`items`,`expire_date`) values ('$item_json','$cart_expire')");
//    //$cart_id=$db->insert_id;
//    setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
//
//}
//?>