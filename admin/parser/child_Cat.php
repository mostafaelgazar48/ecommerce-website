<?php
/**
 * Created by PhpStorm.
 * User: mosta
 * Date: 12/17/18
 * Time: 8:07 PM
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/conn.php';
$parent_id=(int) $_POST['parentID'];
$selected= sanitize($_POST['selected']);
$childQuery="select * from categories where parent='$parent_id' order by category";
$res=$db->query($childQuery);
ob_start();?>
<?php while ($child=mysqli_fetch_assoc($res)):?>
    <option value="<?=$child['id']?>" <?=(($selected==$child['id'])?' selected':' ')?>><?=$child['category']?></option>
<?php endwhile;?>
<?php echo ob_get_clean();?>

