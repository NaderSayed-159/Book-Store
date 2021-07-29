
<?php
ob_start();
if (!isset($_SESSION['data'])) {

    header("Location: login.php");
}


?>