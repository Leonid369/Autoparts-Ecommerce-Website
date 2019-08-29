<?php
require_once '../core/init.php';
if (!is_logged_in()) {
    header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

// Complete order
if (isset($_GET['complete']) && $_GET['complete'] == 1) {
    $cart_id = sanitize((int)$_GET['cart_id']);
    $db->query("UPDATE cart SET shipping = 1 WHERE id = '{$cart_id}'");
    $_SESSION['success_flash'] = "The Order Has Been Competed!";
    header('Location: index.php');
}

$txn_id = sanitize((int)$_GET['txn_id']);
$txnQuery = $db->query("SELECT * FROM transactions WHERE id = '{$txn_id}'");
$txn = mysqli_fetch_assoc($txnQuery);
$cart_id = $txn['cart_id'];
$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$cart = mysqli_fetch_assoc($cartQ);
$items = json_decode($cart['items'], true);
$idArray = array();
$products = array();
foreach ($items as $item) {
    $idArray[] = $item['id'];
}
$ids = implode(',', $idArray);
$productQ = $db->query("
    SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child', p.category as 'parent'
    FROM products i
    LEFT JOIN categories c ON i.categories = c.id
    LEFT JOIN categories p ON c.parent = p.id
    WHERE i.id IN ({$ids})
");
while ($p = mysqli_fetch_assoc($productQ)) {
    foreach ($items as $item) {
        if ($item['id'] == $p['id']) {
            $x = $item;
            continue;
        }
    }
    $products[] = array_merge($x, $p);
}
?>
<h2 class="text-center">Items Ordered</h2>
<table class="table table-condensed table-bordered table-striped">
    <thead>
        <th>Quantity</th>
        <th>Title</th>
        <th>Category</th>
        
    </thead>
    <tbody>
       <?php foreach ($products as $product) : ?>
        <tr>
            <td><?= $product['myquant']; ?></td>
            <td><?= $product['title']; ?></td>
            <td><?= $product['parent'].' / '.$product['child']; ?></td>
            
        </tr>
    </tbody>
    <?php endforeach; ?>
</table>

<div class="row">
    <div class="col-md-6">
        <h3 class="text-center">Order Details</h3>
        <table class="table table-condensed table-striped table-bordered">
            <tbody>
                <tr>
                    <td>Sub Total</td>
                    <td><?= money($txn['sub_total']); ?></td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td><?= money($txn['tax']); ?></td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td><?= money($txn['grand_total']); ?></td>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td><?= pretty_date($txn['txn_date']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Shipping Address</h3>
        <address>
            <b>Full Name : </b><?= $txn['full_name']; ?><br>
            <b>Street : </b><?= $txn['street']; ?><br>
            <b>Street 2 : </b><?= $txn['street2']; ?><br>
            <b>Zip Code : </b><?= $txn['zip_code']; ?><br>
            <b>City : </b><?= $txn['city'];$txn['zip_code']; ?><br>
            <b>State : </b><?= $txn['state']; ?><br>
            <b>Country : </b><?= $txn['country']; ?>
        </address>
    </div>
</div>
<div class="pull-right">
    <a href="index.php" class="btn btn-large btn-default">Cancel</a>
    <a href="orders.php?complete=1&cart_id=<?= $cart_id; ?>" class="btn btn-large btn-primary">Complete</a>
</div>

<?php include 'includes/footer.php'; ?>