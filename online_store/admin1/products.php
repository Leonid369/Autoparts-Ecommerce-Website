<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online_store/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/left-sidebar.php';
include 'includes/content.php';

// Delete Product
if (isset($_GET['delete'])) {
  $id = sanitize($_GET['delete']);
  $db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
  header('Location: products.php');
}

$dbpath = '';
if (isset($_GET['add']) || isset($_GET['edit'])) {
    $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
    $title = ((isset($_POST['title']) && $_POST['title'] != '') ? sanitize($_POST['title']) : '');
    $brand = ((isset($_POST['brand']) && !empty($_POST['brand'])) ? sanitize($_POST['brand']) : '');
    $parent = ((isset($_POST['parent']) && !empty($_POST['parent'])) ? sanitize($_POST['parent']) : '');
    $category = ((isset($_POST['child'])) && !empty($_POST['child']) ? sanitize($_POST['child']) : '');
    $price = ((isset($_POST['price']) && $_POST['price'] != '') ? sanitize($_POST['price']) : '');
    $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '') ? sanitize($_POST['list_price']) : '');
    $description = ((isset($_POST['description']) && $_POST['description'] != '') ? sanitize($_POST['description']) : '');
    $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '') ? sanitize($_POST['sizes']) : '');
    $sizes = rtrim($sizes, ',');
    $saved_image = '';

    if (isset($_GET['edit'])) {
      $edit_id = (int)$_GET['edit'];
      $productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
      $product = mysqli_fetch_assoc($productResults);
      if (isset($_GET['delete_image'])) {
        $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];
        unlink($image_url);
        $db->query("UPDATE products SET image = '' WHERE id = '$edit_id'");
        header('Location: products.php?edit='.$edit_id);
      }
      $category = ((isset($_POST['child']) && $_POST['child'] != '') ? sanitize($_POST['child']) : $product['categories'] );
      $title = ((isset($_POST['title']) && !empty($_POST['title'])) ? sanitize($_POST['title']) : $product['title']);
      $brand = ((isset($_POST['brand']) && !empty($_POST['brand'])) ? sanitize($_POST['brand']) : $product['brand']);
      $parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
      $parentResult = mysqli_fetch_assoc($parentQ);
      $parent = ((isset($_POST['parent']) && !empty($_POST['parent'])) ? sanitize($_POST['parent']) : $parentResult['parent']);
      $price = ((isset($_POST['price']) && !empty($_POST['price'])) ? sanitize($_POST['price']) : $product['price']);
      $list_price = ((isset($_POST['list_price']) && !empty($_POST['list_price'])) ? sanitize($_POST['list_price']) : $product['list_price']);
      $description = ((isset($_POST['description']) && !empty($_POST['description'])) ? sanitize($_POST['description']) : $product['description']);
      $sizes = ((isset($_POST['sizes']) && !empty($_POST['sizes'])) ? sanitize($_POST['sizes']) : $product['sizes']);
      $sizes = rtrim($sizes, ',');
      $saved_image = (($product['image'] != '') ? $product['image'] : '');
      $dbpath = $saved_image;
    }
    if (!empty($sizes)) {
            $sizeString = sanitize($sizes);
            $sizeString = rtrim($sizeString, ',');
            $sizesArray = explode(',',$sizeString);
            $sArray = array();
            $qArray = array();
            foreach($sizesArray as $ss) {
                $s = explode(':', $ss);
                $sArray[] = $s[0];
                $qArray[] = $s[1];
            }
        } else {
            $sizesArray = array();
        }
    if ($_POST) {
      $errors = array();
        $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
        foreach ($required as $field) {
          if ($_POST[$field] == '') {
            $errors[] = 'All Fields With and Astrisk are required.';
            break;
          }
        }
        if (!empty($_FILES)) {
          $photo = $_FILES['photo'];
          $name = $photo['name'];
          $nameArray = explode('.', $name);
          $fileName = $nameArray[0];
          $fileExt = $nameArray[1];
          $mime = explode('/', $photo['type']);
          $mimeType = $mime[0];
          $mimeExt = $mime[1];
          $tmpLoc = $photo['tmp_name'];
          $fileSize = $photo['size'];
          $allowed = array('png', 'jpg', 'jpeg', 'gif');
          $uploadPath = BASEURL.'img/product/'.$uploadName;
          $uploadName = md5(microtime()).'.'.$fileExt;
          $dbpath = '/online_store/img/product/'.$uploadName;
          if ($mimeType != 'image') {
            $errors[] = 'The file must be an image.';
          }
          if (!in_array($fileExt, $allowed)) {
            $errors[] = 'The file extension must be a png, jpg, jpeg or gif.';
          }
          if ($fileSize > 15000000) {
            $errors[] = 'The files size must be under 15MB.';
          }
          if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
            $errors[] = 'File extension does not match the file.';
          }
        }
        if (!empty($errors)) {
          echo display_errors($errors);
        } else {
          // Upload file and insert into database
          if (!empty($_FILES)) {
            move_uploaded_file($tmpLoc,$uploadPath);
          }
           $insertSql = "INSERT INTO products (`title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES ('$title', '$price', '$list_price', '$brand', '$category', '$dbpath', '$description', '0', '$sizes', '0')";
           if (isset($_GET['edit'])) {
             $insertSql = "UPDATE products SET title = '$title', price = '$price', list_price = '$list_price', brand = '$brand', categories = '$category', sizes = '$sizes', image = '$dbpath', description = '$description' WHERE id = '$edit_id'";
           }

           $db->query($insertSql);
           header('Location: products.php');
        }
    }
?>
   
   <h2 class="text-center"><?= ((isset($_GET['edit'])) ? 'Edit' : 'Add a New'); ?> Product</h2>
   <form class="add-product" action="products.php?<?= ((isset($_GET['edit'])) ? 'edit='.$edit_id : 'add=1'); ?>" method="POST" enctype="multipart/form-data">
       <div class="form-group">
           <label for="title">Title *:</label>
           <input type="text" name="title" id="title" class="form-control" value="<?= $title; ?>">
       </div>
       <div class="form-group">
           <label for="brand">Brand *:</label>
           <select name="brand" class="form-control" id="brand">
               <option value=""<?= (($brand == '') ? ' selected' : ''); ?>></option>
               <?php while ($b = mysqli_fetch_assoc($brandQuery)): ?>
                   <option value="<?= $b['id']; ?>"<?= (($brand == $b['id']) ? ' selected' : ''); ?>><?= $b['brand']; ?></option>
               <?php endwhile; ?>
           </select>
       </div>
       <div class="form-group">
           <label for="parent">Parent Category *:</label>
           <select name="parent" id="parent" class="form-control">
               <option value=""<?= (($parent == '') ? ' selected' : ''); ?>></option>
               <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
                   <option value="<?= $p['id']; ?>"<?= (($parent == $p['id']) ? ' selected' : ''); ?>><?= $p['category']; ?></option>
               <?php endwhile; ?>
           </select>
       </div>
       <div class="form-group">
           <label for="child">Child Category *:</label>
           <select name="child" id="child" class="form-control">
           </select>
       </div>
       <div class="form-group">
           <label for="price">Price *:</label>
           <input type="text" id="price" name="price" class="form-control" value="<?= $price; ?>">
       </div>
       <div class="form-group">
           <label for="list_price">List Price :</label>
           <input type="text" id="list_price" name="list_price" class="form-control" value="<?= $list_price; ?>">
       </div>
       <div class="form-group">
          <label for="">Quantity & Sizes *:</label>
           <button class="btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
       </div>
       <div class="form-group">
           <label for="sizes">Sizes & Quantity Preview</label>
           <input type="text" class="form-control" name="sizes" id="sizes" value="<?= $sizes; ?>" readonly>
       </div>
       <div class="form-group">
            <?php if ($saved_image != '') : ?>
                <div class="saved-image">
                  <img src="<?= $saved_image; ?>" alt="saved image"><br>
                  <a href="products.php?delete_image=1&edit=<?= $edit_id; ?>" class="text-danger">Delete Image</a>
                </div>
            <?php else : ?>
           <label for="photo">Product Photo:</label>
           <input type="file" name="photo" id="photo" class="form-control">
         <?php endif; ?>
       </div>
       <div class="form-group">
           <label for="description">Description:</label>
           <textarea name="description" id="description" class="form-control" rows="6"><?= $description; ?></textarea>
       </div>
       <div class="form-group">
        <a href="products.php" class="btn-cancel">Cancel</a>
           <input type="submit" value="<?= ((isset($_GET['edit'])) ? 'Edit' : 'Add'); ?> Product" id="add-product" class="btn-success">
       </div>
   </form>
   
   <!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Size & Quantity</h4>
      </div>
      <div class="modal-body">
       <div class="container-fluid">
        <?php for($i = 1; $i <= 12; $i++): ?>
            <div class="form-group col-md-4">
                <label for="size<?= $i; ?>">Size:</label>
                <input type="text" name="size<?= $i; ?>" id="size<?= $i; ?>" value="<?= ((!empty($sArray[$i-1])) ? $sArray[$i-1] : ''); ?>" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="qty<?= $i; ?>">Quantity:</label>
                <input type="number" name="qty<?= $i; ?>" id="qty<?= $i; ?>" value="<?= ((!empty($qArray[$i-1])) ? $qArray[$i-1] : ''); ?>" min="0" class="form-control">
            </div>
        <?php endfor; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
    
<?php } else {
    
    $sql = "SELECT * FROM products WHERE deleted = 0";
    $presults = $db->query($sql);
    if (isset($_GET['featured'])) {
        $id = (int)$_GET['id'];
        $featured = (int)$_GET['featured'];
        $featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
        $db->query($featuredSql);
        header('Location: products.php');
    }
    ?>
    <h2 class="text-center">Products</h2>
    <a href="products.php?add=1" class="btn-success" id="add-product-btn">Add Product</a>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
            <th class="parent-category"></th>
            <th class="parent-category">Product</th>
            <th class="parent-category">Price</th>
            <th class="parent-category">Category</th>
            <th class="parent-category">Featured</th>
            <th class="parent-category">Sold</th>
        </thead>
        <tbody>
            <?php while ($product = mysqli_fetch_assoc($presults)) : 
            $childID = $product['categories'];
            $catSql = "SELECT * FROM categories WHERE id = '$childID'";
            $result = $db->query($catSql);
            $child = mysqli_fetch_assoc($result);
            $parentID = $child['parent'];
            $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
            $presult = $db->query($pSql);
            $parent = mysqli_fetch_assoc($presult);
            $category = $parent['category'].'-'.$child['category'];
            ?>
                <tr>
                    <td>
                        <a href="products.php?edit=<?= $product['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="products.php?delete=<?= $product['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </td>
                    <td>
                        <?= $product['title']; ?>
                    </td>
                    <td>
                        <?= money($product['price']); ?>
                    </td>
                    <td>
                        <?= $category; ?>
                    </td>
                    <td><a href="products.php?featured=<?= (($product['featured'] == 0) ? '1' : '0'); ?>&id=<?= $product['id']; ?>">
                    <i class="fa fa-<?= (($product['featured'] == 1) ? 'minus' : 'plus'); ?>" aria-hidden="true"></i>
                    
                    </a> &nbsp
                        <?= (($product['featured'] == 1) ? 'Featured Product' : ''); ?>
                    </td>
                    <td>0</td>
                </tr>
                <?php endwhile; ?>
        </tbody>
    </table>

    <?php } include 'includes/footer.php'; ?>
    <script>
      jQuery('document').ready(function() {
        get_child_options('<?= $category; ?>');
      });
    </script>