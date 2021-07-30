<?php
session_start();

// require "http://". $_SERVER['SERVER_NAME']. "/g2p/helpers/paths.php";



$server = 'localhost';
$dbName = 'g2p22';
$dbUser = 'root';
$dbPassword = '';


$con =  mysqli_connect($server, $dbUser, $dbPassword, $dbName);

if (!$con) {

    die('Error Message ' . mysqli_connect_error());
}
