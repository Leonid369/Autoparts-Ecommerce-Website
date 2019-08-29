<?php
    // require_once 'C:/xampp/htdocs/online_store/core/init.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/online_store/core/init.php';
    if(isset($_POST["id"])){
        $id = $_POST["id"];
    }else{
        $id = NULL;
    }
    $id = (int)$id;
    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = $db->query($sql);
    $product = mysqli_fetch_assoc($result);
    $brand_id = $product['brand'];
    $sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
    $brand_query = $db->query($sql);
    $brand = mysqli_fetch_assoc($brand_query);
    $available= $product['myquant'];
    // $sizestring = $product['sizes'];
    // $sizestring = rtrim($sizestring, ',');
    // $size_array = explode(',', $sizestring);

?>

<!--Details modal -->
<?php ob_start(); ?>
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><?= $product['title']; ?></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <span class="bg-danger" id="modal_errors"></span>
                        <div class="col-sm-6 fotorama">
                           <?php $photos = explode(',', $product['image']);
                            foreach($photos as $photo) :
                            ?>
                                <img src="<?= $photo; ?>" alt="<?= $product['title']; ?>" class="details img-responsive">
                            <?php endforeach; ?>
                        </div>
                        <div class="col-sm-6">
                            <h4>Details</h4>
                            <p><?= nl2br($product['description']); ?></p>
                            <hr>
                            <p>Price: $<?= $product['price']; ?></p>
                            <p>Brand: <?= $brand['brand']; ?></p>
                            <p>Available: <?= $product['myquant']; ?></p>


                            <!-- Details Form -->
                            <form action="add_cart.php" method="POST" id="add_product_form">
                                <input type="hidden" name="product_id" value="<?= $id; ?>">
                                <input type="hidden" name="available" id="available" value="<?=$available ?>">
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" class="form-control" name="quantity" min="0" id="quantity" name="quantity">
                                    </div>
                                    <div class="col-xs-9">&nbsp;</div>
                                </div>
                                <br>
                                <br>
                                <!-- <div class="form-group">
                                    <label for="size">Size:</label>
                                    <select name="size" id="size" class="form-control">
                                        <option value=""></option>
                                        <?php foreach($size_array as $string) {
                                            $string_array = explode(':', $string);
                                            $size = $string_array[0];
                                            $available = $string_array[1];
                                            if($available > 0) {
                                                echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.' Available)</option>';
                                            }
                                        } ?>

                                    </select>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" onclick="closeModal()">Close</button>
                <button class="btn btn-warning" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add Cart</button>
            </div>
        </div>
    </div>
</div>
<script>
    // jQuery('#size').change(function() {
    //     var available = jQuery('#size option:selected').data("available");
    //     jQuery('#available').val(available);
    // });

    $(function () {
      $('.fotorama').fotorama({'loop' : true, 'autoplay' : true});
    });

    function closeModal() {
        jQuery('#details-modal').modal('hide');
        setTimeout(function () {
            jQuery('#details-modal').remove();
            jQuery('.modal-backdrop').remove();
        }, 500);
    }
</script>
<?php echo ob_get_clean(); ?>
