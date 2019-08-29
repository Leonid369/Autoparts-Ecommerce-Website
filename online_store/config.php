<?php

define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/online_store/');
define('CART_COOKIE', 'SBwi72UCklwiqzz2');
define('CART_COOKIE_EXPIRE', time() + (86400 * 30));
define('TAXRATE', 0.087); // Sales tax rate. Set to 0 if you arn't charging tax.

define('CURRENCY', 'usd');
define('CHECKOUTMODE', 'TEST'); // Change TEST to LIVE when you are ready to go LIVE

if(CHECKOUTMODE == 'TEST') {
    define('STRIPE_PRIVATE', 'sk_test_alT02SrXmtErkTgrn6u09LjT006Pg1qO6e');
    define('STRIPE_PUBLIC', 'pk_test_1CupQ8DRI7TdA8zJTaKJh2sp00U2oedPEq');
}
