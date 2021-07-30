<?php
ob_start();


require "../../helpers/paths.php";
require '../../helpers/dbConnection.php' ;
require '../../layout/navAdmin.php' ;
require '../../checklogin/checkLoginadmin.php';


$sqlTypes = "select * from usersTypes";
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
            header("Location: ".users('index.php'));
        } else {
            $errorMessages['sqlOperation'] = "Error in Your Sql Try Again";
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
    <title>Adding Data to database</title>
    <link rel="stylesheet" href="<?php echo css('create.css')?>">


</head>

<body class="col-12">
    <h1 class="text-danger">Add a new data to Database
        <small>Create a new user </small>
    </h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="container mx-auto mt-5 d-flex flex-column  p-4 ps-0 ">
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