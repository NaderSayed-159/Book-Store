<?php

require 'dbConnection.php';

$sqlTypes = "select * from usersTypes where id >1";
$op2 =  mysqli_query($con, $sqlTypes);



function cleanInputs($input)
{

    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}

$errorMessages = [];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name  = cleanInputs($_POST['name']);
    $email = cleanInputs($_POST['email']);
    $password = cleanInputs($_POST['password']);
    $phone = cleanInputs($_POST['phone']);
    $gender = $_POST['gender'];
    $usertype = $_POST['usertype'];



    //Name Validation
    if (!empty($name)) {

        if (strlen($name) < 3) {
            $errorMessages['name'] = "Name Length must be > 2 ";
        }
    } else {
        $errorMessages['name'] = "Required";
    }


    //Email Validation
    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessages['email'] = "Invalid Email";
        }
    } else {
        $errorMessages['email'] = "Required";
    }



    // Password Validation ... 
    if (!empty($password)) {
        // code ...   
        if (strlen($password) < 6) {

            $errorMessages['Password'] = "Password Length must be > 5 ";
        }
    } else {

        $errorMessages['Password'] = "Required";
    }
    // phone Validation ... 
    if (!empty($phone)) {
        // code ...   
        if (strlen($phone) < 11) {

            $errorMessages['phone'] = "Phone should be 11 numbers";
        }
    } else {

        $errorMessages['phone'] = "Required";
    }




    if (count($errorMessages) == 0) {

        $password = sha1($password);

        $sql = "insert into users (name,email,password,phone,gender,user_type) values ('$name','$email','$password','$phone','$gender',$usertype)";
        $op =  mysqli_query($con, $sql);



        if ($op) {
            $_SESSION['message'] = "User Added";
            header("Location: login.php");
        } else {
            $errorMessages['sqlOperation'] = "Try Again";
        }
    } else {

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
    <title>Sign UP</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Hind:300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/signup.css">
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

    <script src="js/login.js"></script>
</body>

</html>