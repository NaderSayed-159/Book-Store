
<?php


if (!isset($_SESSION['data'])) {

    header("Location: ../../login.php");
} else if (!($_SESSION['data']['user_type'] == 1)) {

    header("Location: ".project('index.php'));
}





?>