<?php
session_start();

$server = 'localhost';
$dbName = 'g2p22';
$dbUser = 'root';
$dbPassword = '';


$con =  mysqli_connect($server, $dbUser, $dbPassword, $dbName);

if (!$con) {

    die('Error Message ' . mysqli_connect_error());
}
