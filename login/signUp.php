<?php

require "../helpers/paths.php";
require "../helpers/functions.php";
require '../helpers/dbConnection.php';



$sqlTypes = "select * from usersTypes where id > 1";
$op2 =  mysqli_query($con, $sqlTypes);




$errorMessages = [];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name  = cleanInputs(Sanitize($_POST['name'], 2));
    $email = cleanInputs($_POST['email']);
    $password = cleanInputs($_POST['password']);
    $phone = cleanInputs($_POST['phone']);
    $gender = Sanitize($_POST['gender'], 1);
    $usertype = Sanitize($_POST['usertype'], 2);




    //Name Validation
    if (!Validator($name, 1)) {
        $errorMessages['name'] = "Required";
    }

    if (!Validator($name, 2)) {

        $errorMessages['name'] = "Name Length must be more than 3 ";
    }


    //Email Validation
    if (!Validator($email, 1)) {
        $errorMessages['email'] = "Required";
    }

    if (!Validator($email, 4)) {
        $errorMessages['email'] = "Invalid Email";
    }


    // Password Validation ... 
    if (!Validator($password, 2, 6)) {

        $errorMessages['Password'] = "Required";
    }


    if (!Validator($password, 2, 6)) {

        $errorMessages['Password'] = "Password Length must be more than 6 ";
    }




    // phone Validation ... 
    if (!Validator($phone, 1)) {
        $errorMessages['phone'] = "Required";
    }


    if (!Validator($phone, 2, 11)) {

        $errorMessages['phone'] = "Phone should be 11 numbers";
    }



    if (count($errorMessages) > 0) {

        $_SESSION['errmessages'] = $errorMessages;
    } else {

        // operations
        $password = sha1($password);

        $sql = "insert into users (name,email,password,phone,gender,user_type) values ('$name','$email','$password','$phone','$gender',$usertype)";
        $op =  mysqli_query($con, $sql);



        if ($op) {
            $_SESSION['message'] = "User Added";
            header("Location: " . login('login.php'));
        } else {
            $errorMessages['sqlOperation'] = "Error in Your Sql Try Again";
        }

        $_SESSION['errmessages'] = $errorMessages;
    }
}









?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign UP</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Hind:300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo css('signup.css') ?>">
    <style>

    </style>

</head>

<body>
    <div id="login-button">
        <img src="https://dqcgrsy5v35b9.cloudfront.net/cruiseplanner/assets/img/icons/login-w-icon.png">
        </img>
    </div>
    <div id="container">
        <h1>Sign Up</h1>
        <span class="close-btn">
            <img src="https://cdn4.iconfinder.com/data/icons/miu/22/circle_close_delete_-128.png"></img>
        </span>

        <form method="POST" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name">
            <input type="email" name="email" placeholder="E-mail">
            <input type="password" name="password" placeholder="Password">
            <input type="text" name="phone" placeholder="phone">
            <div class="selections">
                <div>
                    <label for="usertype" class="p-2">User Type</label>
                    <select name="usertype" id="usertype" class="form-select" name="usertype">
                        <?php while ($data = mysqli_fetch_assoc($op2)) {
                        ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['user_type']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="gender" class="p-2">gender</label>
                    <select name="gender" id="gender" class="form-select" name="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <input type=submit value="signup">
            <a href="login.php" id="link">Login</a>
        </form>
    </div>

    <script src="<?php js('login.js') ?>"></script>
</body>

</html>