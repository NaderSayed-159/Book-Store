<?php
ob_start();


require "../../helpers/paths.php";
require "../../helpers/functions.php";
require '../../helpers/dbConnection.php';
require '../../layout/navAdmin.php';
require '../../checklogin/checkLoginadmin.php';


$sqlTypes = "select * from usersTypes";
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
            header("Location: " . users('index.php'));
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
    <title>Adding Data to database</title>
    <link rel="stylesheet" href="<?php echo css('create.css') ?>">


</head>

<body class="col-12">
    <h1 class="text-danger">Add a new data to Database
        <small>Create a new user </small>

    </h1>
    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo users('index.php') ?>">Users</a></li>
        <li class="breadcrumb-item active ">Add User</li>
    </ol>
    <h4 class="bg-gradient bg-dark p-2 mx-auto mt-5 w-50 text-danger">
        <?php
        if (isset($_SESSION['errmessages'])) {

            foreach ($_SESSION['errmessages'] as $key =>  $data) {

                echo '* ' . $key . ' : ' . $data . '<br>';
            }

            unset($_SESSION['errmessages']);
        } else {
            echo "Fill the inputs Please!";
        }
        ?>
    </h4>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" class="container mx-auto mt-5 d-flex flex-column  p-4 ps-0 ">
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="name">
                <label for="floatingInput">Enter Name</label>
            </div>
        </div>
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="e-mail" class="form-control" id="floatingInput" placeholder="E-mail" name="email">
                <label for="floatingInput">E-mail</label>
            </div>
        </div>
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="password" class="form-control" id="floatingInput" placeholder="Password" name="password">
                <label for="floatingInput">Password</label>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-around">
            <div class="col-lg-3 mt-3 mb-3 ">
                <div class=" form-floating">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Phone.." name="phone">
                    <label for="floatingInput">Phone</label>
                </div>
            </div>
            <div class="col-sm-3 mt-3 mb-3 ">
                <div class=" form-control p-2">
                    <label for="usertype" class="p-2">Users Types</label>
                    <select name="usertype" id="usertype" class="form-select" name="usertype">
                        <?php while ($data = mysqli_fetch_assoc($op2)) {
                        ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['user_type']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-3 mt-3 mb-3 ">
                <div class=" form-control p-2">
                    <label for="gender" class="p-2">gender</label>
                    <select name="gender" id="gender" class="form-select" name="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
        </div>


        <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Create">

    </form>


</body>

</html>