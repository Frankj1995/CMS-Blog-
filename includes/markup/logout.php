<?php ob_start(); ?>
<?php session_start(); ?>

<?php 

$_SESSION['username'] = null;
$_SESSION['first_name'] = null;
$_SESSION['last_name'] = null;
$_SESSION['role'] = null;

header("Location: ../../index.php");

?>