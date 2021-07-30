<?php
ob_start();

require "../../helpers/paths.php";
require '../../helpers/dbConnection.php' ;
require '../../layout/navAdmin.php' ;
require '../../checklogin/checkLoginadmin.php';


$id = $_GET['id'];
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$message = "";

if (!filter_var($id, FILTER_VALIDATE_INT)) {
    $_SESSION['message'] = "Invalid Id";

    header("Location: index.php");
}





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
    // $password = $_POST['password'];
    $phone = cleanInputs($_POST['phone']);
    $gender = cleanInputs($_POST['gender']);
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


        $sql22  = "update users set name = '$name' , email = '$email' , phone='$phone' , gender = '$gender' , user_type = '$usertype'  where id =$id ";

        $op   =  mysqli_query($con, $sql22);


        if ($op) {
            $_SESSION['message'] = "Data Updated";
            header("Location: ". users('index.php'));
        } else {
            $errorMessages['sqlOperation'] = "Error in Your Sql Try Again";
        }
    } else {

        foreach ($errorMessages as $key => $value) {

            echo '* ' . $key . ' : ' . $value . '<br>';
        }
    }
}



$sql = "select * from users where id = $id";
$op = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($op);





# Fetch dep Query .... 
$sqlTypes = "select * from usersTypes";
$op2 =  mysqli_query($con, $sqlTypes);






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo css('edit.css')?>">
</head>

<body>

    <div class="container">
        <h2 class="text-center h1 text-danger m-5">Update Users Data </h2>
        <form action="edit.php?id=<?php echo $data['id']; ?>" method="POST" class="container mx-auto mt-5 d-flex flex-column  p-4 ps-0 ">
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="name" value="<?php echo $data['name']; ?>">
                    <label for="floatingInput">Enter Name</label>
                </div>
            </div>
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input type="e-mail" class="form-control" id="floatingInput" placeholder="E-mail" name="email" value="<?php echo $data['email']; ?>">
                    <label for="floatingInput">E-mail</label>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-around">
                <div class="col-lg-3 mt-3 mb-3 ">
                    <div class=" form-floating">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Phone.." name="phone" value="<?php echo $data['phone']; ?>">
                        <label for="floatingInput">Phone</label>
                    </div>
                </div>
                <div class="col-sm-3 mt-3 mb-3 ">
                    <div class=" form-control p-2">
                        <label for="usertype" class="p-2">Users Types</label>
                        <select name="usertype" id="usertype" class="form-select" name="usertype">
                            <?php while ($datas = mysqli_fetch_assoc($op2)) {
                            ?>
                                <option value="<?php echo $datas['id']; ?>" <?php if ($datas['id'] == $data['user_type']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $datas['user_type']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-3 mt-3 mb-3 ">
                    <div class=" form-control p-2">
                        <label for="gender" class="p-2">gender</label>
                        <select name="gender" id="gender" class="form-select" name="gender">
                            <option value="male" <?php if ($data['gender'] == 'male') {
                                                        echo 'selected';
                                                    } ?>>Male</option>
                            <option value="female" <?php if ($data['gender'] == 'female') {
                                                        echo 'selected';
                                                    } ?>>Female</option>
                        </select>
                    </div>
                </div>
            </div>


            <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Update">

        </form>
    </div>

</body>

</html>