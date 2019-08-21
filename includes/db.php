<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "functions.php";

$connection = mysqli_connect('localhost', 'root', 'root', 'cms');
show_error($connection);
mysqli_query($connection, "SET NAMES utf8");

show_error($connection);
?>