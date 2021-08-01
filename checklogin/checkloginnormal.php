
<?php
ob_start();
if (!isset($_SESSION['users'])) {

    header("Location: " . login('login.php'));
}


?>