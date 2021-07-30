<?php

require "dbConnection.php";


function CleanInputs($input)
{

    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}


$errorMessages = array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = CleanInputs($_POST['email']);
    $password = CleanInputs($_POST['pass']);

    // Email Validation ... 
    if (!empty($email)) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessages['email'] = "Invalid Email";
        }
    } else {
        $errorMessages['email'] = "Required";
    }


    // password Validation ... 
    if (!empty($password)) {

        if (strlen($password) < 6) {

            $errorMessages['Password'] = "password must be > 5 ";
        }
    } else {

        $errorMessages['Password'] = " is Required";
    }


    if (count($errorMessages) == 0) {


        $password = sha1($password);

        $sql = "select * from users where email = '$email' and password = '$password'";

        $op  = mysqli_query($con, $sql);


        if (mysqli_num_rows($op) == 1) {


            $data = mysqli_fetch_assoc($op);


            if ($data['user_type'] == 1) {
                $_SESSION['data'] = $data;
                header("Location: ./admin/users/index.php");
            } else {
                $_SESSION['data'] = $data;
                header("Location: index.php");
            }
        } else {

            echo 'Error in Login try again ';
        }
    } else {

        // print error messages 
        foreach ($errorMessages as $key => $value) {

            echo '* ' . $key . ' : ' . $value . '<br>';
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Hind:300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/login.css">


</head>

<body>
    <div id="login-button">
        <img src="https://dqcgrsy5v35b9.cloudfront.net/cruiseplanner/assets/img/icons/login-w-icon.png">
        </img>
    </div>
    <div id="container">
        <h1>Log In</h1>
        <span class="close-btn">
            <img src="https://cdn4.iconfinder.com/data/icons/miu/22/circle_close_delete_-128.png"></img>
        </span>

        <form method="POST" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' enctype="multipart/form-data">
            <input type="email" name="email" placeholder="E-mail">
            <input type="password" name="pass" placeholder="Password">
            <input type=submit value="Log in">
        </form>

        <a href="signUp.php" id="link">Sign UP</a>

    </div>

    <script src="js/login.js"></script>
</body>

</html>