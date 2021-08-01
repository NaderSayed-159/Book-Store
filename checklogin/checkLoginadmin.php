
<?php


if (!isset($_SESSION['users'])) {

    header("Location: ../../login.php");
} else if (!($_SESSION['users']['user_type'] == 1)) {

    header("Location: " . project('index.php'));
}





?>