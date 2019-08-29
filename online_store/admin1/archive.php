<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online_store/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/left-sidebar.php';
include 'includes/content.php';

//Restore Product

if(isset($_GET['restore'])) {
 
 $idz = sanitize($_GET['restore']);
 $db->query("UPDATE `products` SET `deleted`=0 WHERE `id`='$idz'");
 header('Location: archive.php');
 
}

?>

<?php

$sqlw = "SELECT * FROM `products` WHERE `deleted`=1";
$p_result = $db->query($sqlw);


?>

<h2 class="text-center">Archived Products</h2>
<div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed talbe-striped">
 <thead>
   <th>Restore</th>
   <th>Product</th>
   <th>Price</th>
   <th>Parent - Category</th>
   <th>Featured</th>
   <th>Sold</th>
 </thead>
 
 <tbody>
   
    <?php while($product = mysqli_fetch_assoc($p_result)) : 
   
   $childID = $product['categories'];
   $catsql = "SELECT * FROM `categories` WHERE `id`='$childID'";
   $cat_result = $db->query($catsql);
   $child = mysqli_fetch_assoc($cat_result);
   $parentID = $child['parent'];
   $p_sql = "SELECT * FROM `categories` WHERE `id`='$parentID'";
   $presult = $db->query($p_sql);
   $parent = mysqli_fetch_assoc($presult);
   $category = $parent['category'].' - '.$child['category'];
   
   ?>
    
    
    <tr>
    
     <td>
      <a href="archive.php?restore=<?php echo $product['id']; ?>"><i class="fa fa-refresh" aria-hidden="true"></i></a>
     </td>

     <td><?php echo $product['title']; ?></td> <!-- TITLE -->
     
     <td><?php echo money($product['price']); ?></td> <!-- PRICE -->
     
     <td><?php echo $category; ?></td> <!-- Categories -->
     
     <td><a href="products.php?featured=<?php echo (($product['featured'] == 0)?'1':'0'); ?>&id=<?php echo $product['id']; ?>" class="<?php echo (($product['featured'] == 1)?'warning':'success'); ?>">
     <i class="fa fa-<?= (($product['featured'] == 1) ? 'minus' : 'plus'); ?>" aria-hidden="true"></i>
     </a>&nbsp; <?php echo (($product['featured'] == 1)?'Remove Featured':'Add Featured'); ?></td> <!-- FEATURED PRODUCT -->
     
     <td>0</td> <!-- SOLD -->

    </tr>
   <?php endwhile; ?>
 </tbody>
 
</table>



<?php include 'includes/footer.php'; ?>