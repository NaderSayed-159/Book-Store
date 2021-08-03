<?php
ob_start();
require "helpers/paths.php";
require "helpers/functions.php";
require 'helpers/dbConnection.php';
require 'checklogin/checkloginnormal.php';
require 'layout/header.php';



//users


$errorMessages = [];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name  = cleanInputs(Sanitize($_POST['name'], 2));
    $describtion = cleanInputs($_POST['describtion']);
    $edate = strtotime($_POST["Edate"]);
    $adder = $_SESSION['users']['id'];



    //Name Validation
    if (!Validator($name, 1)) {
        $errorMessages['name'] = "Required";
    }

    if (!Validator($name, 2, 5)) {

        $errorMessages['name'] = "Book name Length must be more than 5 ";
    }

    //describtion Validation


    if (!Validator($describtion, 1)) {
        $errorMessages['Book describtion'] = "Required";
    }

    if (!Validator($describtion, 2, 10)) {

        $errorMessages['name'] = "Book name Length must be more than 10 ";
    }

    //date Validation
    $validDate = strtotime(date("m/d/y"));


    if (!Validator($edate, 1)) {

        $errorMessages['Date'] =  "Enter Event Date";
    } else {

        if ($edate < $validDate) {
            $errorMessages['Date'] =  "not valid date";
        } else {
            $edate = date('Y-m-d-H-i-s', $edate);
        }
    }




    // logo Validation 

    $logooldName = $_FILES['logo']['name'];

    if (!Validator($logooldName, 1)) {
        $errorMessages['logo'] = 'pls upload Logo';
    } else {

        $nameArray = explode('.', $logooldName);
        $fileExtension = strtolower($nameArray[1]);

        if (!Validator($fileExtension, 5)) {
            $errorMessages['imageExtension'] = 'Invalid Image Extension';
        }
    }


    if (count($errorMessages) > 0) {
        $_SESSION['errmessages'] = $errorMessages;
    } else {
        $tmp_path = $_FILES['logo']['tmp_name'];
        $LogoName = rand() . time() . '.' . $fileExtension;
        $disFolder = 'assests/images/eventsCheckLogos/';
        $disPath  = $disFolder . $LogoName;

        if (move_uploaded_file($tmp_path, $disPath)) {

            $describtion = str_replace("'", '_', $describtion);

            //database operation

            $sql = "insert into events_check (event_name,event_desc,e_date,e_logo,event_submiter) values ('$name','$describtion','$edate','$LogoName',$adder)";
            $ops =  mysqli_query($con, $sql);

            $messege = '';
            if ($ops) {
                $messege = "Event Details Sent";
                $_SESSION['message'] = $messege;
                header("Location: " . project("eventSubmit.php"));
            } else {
                $_SESSION['errmessages'] = "Error in Your Sql Try Again";
            }
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

    <h1 class="text-danger">Add a new Event to Database
        <small>Submit a new Event </small>
    </h1>

    <h4 class="bg-gradient bg-dark p-2 mx-auto mt-5 w-50 text-danger">
        <?php
        if (isset($_SESSION['errmessages'])) {

            foreach ($_SESSION['errmessages'] as $key =>  $data) {

                echo '* ' . $key . ' : ' . $data . '<br>';
            }

            unset($_SESSION['errmessages']);
        } else if (isset($_SESSION['message'])) {

            echo $_SESSION['message'];

            unset($_SESSION['message']);
        } else {
            echo "Fill the inputs Please!";
        }




        ?>
    </h4>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="container col-8 mx-auto mt-5 d-flex flex-column  p-4 ps-0 " enctype="multipart/form-data">
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="name">
                <label for="floatingInput">Event Name</label>
            </div>
        </div>
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Describtion" name="describtion">
                <label for="floatingInput"> Event Describtion</label>
            </div>
        </div>
        <div class="col-sm-12 m-3 ">
            <div class=" form-control">
                <label for="edate">Event Date</label>
                <input type="datetime-local" class="form-control" id="edate" name="Edate">
            </div>
        </div>





        <div class="col-sm-12 m-3 form-control">
            <label for="floatingInput">uploade Event Logo</label>
            <input type="file" name="logo" id="floatingInput" class="form-control">
        </div>



        <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Create">

    </form>


</body>

</html>