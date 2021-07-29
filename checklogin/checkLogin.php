
<?php
ob_start();
if (!isset($_SESSION['data'])) {

    header("Location: ../../../login.php");
} else if (($_SESSION['data']['user_type'] == 1)) {


    header("Location: http://localhost:81/g2p/admin/users/index.php");
} else if (($_SESSION['data']['user_type'] == 2)) {


    header("Location: ../../company.php");
}
?>