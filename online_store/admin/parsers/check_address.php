<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online_store/core/init.php';
$name = isset($_POST['full_name'])? sanitize($_POST['full_name']):'';
$email = isset($_POST['email'])? sanitize($_POST['email']):'';
$street = isset($_POST['street'])? sanitize($_POST['street']):'';
$street2 = isset($_POST['street2'])? sanitize($_POST['street2']):'';
$city = isset($_POST['city'])? sanitize($_POST['city']):'';
$state = isset($_POST['state'])? sanitize($_POST['state']):'';
$zip_code = isset($_POST['zip_code'])? sanitize($_POST['zip_code']):'';
$country = isset($_POST['country'])? sanitize($_POST['country']):'';
$errors = array();
$required = array(
    'full_name' => 'Full Name',
    'email'     => 'Email',
    'street'    => 'Street Address',
    'city'      => 'City',
    'state'     => 'State',
    'zip_code'  => 'Zip Code',
    'country'   => 'Country',
);

// Check if all required fields are field out
foreach($required as $f => $d) {
    if(empty($_POST[$f]) || $_POST[$f] == '') {
        $errors[] = $d.' is required.';
    }
}

// Check if valid email address
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email.';
}

if(!empty($errors)) {
    echo display_errors($errors);
} else {
    echo 'passed';
}
?>