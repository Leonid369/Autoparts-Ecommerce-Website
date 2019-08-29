<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online_store/core/init.php';
if (!is_logged_in()) {
	header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/left-sidebar.php';
include 'includes/content.php';
include 'includes/footer.php';
?>