<?php
ob_start();
require "../../../helpers/paths.php";
require "../../../helpers/functions.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';

$id = $_GET['id'];
$id  = Sanitize($_GET['id'], 1);


if (!Validator($id, 3)) {
    $errorMessages['id'] = "Invalid ID";

    $_SESSION['message'] = $errorMessages;

    header("Location: " . resources('events/index.php'));
}



// events
$sqlevent = "select * from events where id =$id";
$opevents =  mysqli_query($con, $sqlevent);
$dataevent = mysqli_fetch_assoc($opevents);


$errorMessages = [];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name  = cleanInputs(Sanitize($_POST['name'], 2));
    $describtion = cleanInputs($_POST['describtion']);
    $adder = Sanitize($_POST['submiter'], 1);
    $edate = strtotime($_POST["Edate"]);

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

        $edate = $dataevent['eventDate'];
    } else {

        if ($edate < $validDate) {
            $errorMessages['Date'] =  "not valid date";
        } else {
            $edate = date('Y-m-d-H-i-s', $edate);
        }
    }

    // logo Validation 

    $sqllogo = "select event_logo from events where id = " . $id;
    $oplogo  = mysqli_query($con, $sqllogo);
    $dataLogo = mysqli_fetch_assoc($oplogo);



    $logooldName = $_FILES['logo']['name'];

    if (!Validator($logooldName, 1)) {
        $LogoName =  $dataLogo['event_logo'];
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
        //logo edit
        if (Validator($logooldName, 1)) {


            $tmp_path = $_FILES['logo']['tmp_name'];
            $LogoName = rand() . time() . '.' . $fileExtension;

            $disFolder = '../../../assests/images/eventsLogos/';
            $disPath  = $disFolder . $LogoName;

            if (move_uploaded_file($tmp_path, $disPath)) {

                if (!Validator('../../../assests/images/eventsLogos/' . trim($dataLogo['event_logo']), 7)) {

                    $errorMessages['imageChange'] = "image is not deleted";
                }
            }
        }
        $_SESSION['errmessages'] = $errorMessages;


        if (count($errorMessages) == 0) {


            $sql = "update events set event_name= ' $name', event_describtion = '$describtion' , eventDate = '$edate' , event_logo ='$LogoName', event_submiter = $adder where id =$id";

            $op =  mysqli_query($con, $sql);



            if ($op) {
                $_SESSION['message'] = "Data Updated";
                header("Location: " . resources('events/index.php'));
            } else {
                $_SESSION['errmessages'] = "Error in Your Sql Try Again";
            }
        }

        $_SESSION['errmessages'] = $errorMessages;
    }
}

//users
$sqlusers = "select * from users";
$opusers =  mysqli_query($con, $sqlusers);

//events
$sqlevent = "select * from events where id =$id";
$opevents =  mysqli_query($con, $sqlevent);
$dataevent = mysqli_fetch_assoc($opevents);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event to Accept it</title>
    <link rel="stylesheet" href="<?php echo css('edit.css') ?>">

</head>

<body class="col-12">
    <h1 class="text-danger">Update Event data
        <small>Update Book by Admin! </small>
    </h1>
    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50 ">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo resources('events/index.php') ?>">Events</a></li>
        <li class="breadcrumb-item active ">Edit Event Data</li>
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
    <div class="d-flex flex-column flex-lg-row col-12 justify-content-evenly align-items-center">
        <form action="edit.php?id=<?php echo $dataevent['id']; ?>" method="POST" class=" col-lg-7 col-10  d-flex flex-column  p-4 ps-0 " enctype="multipart/form-data">
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input value="<?php echo $dataevent['event_name']; ?>" type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="name">
                    <label for="floatingInput">Book Name</label>
                </div>
            </div>
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input value="<?php echo $dataevent['event_describtion']; ?>" type="text" class="form-control" id="floatingInput" placeholder="Describtion" name="describtion">
                    <label for="floatingInput">Describtion</label>
                </div>
            </div>
            <div class="d-flex align-items-center flex-column flex-lg-row justify-content-center">
                <div class="col-lg-5 col-12 m-3 ">
                    <div class=" form-floating">
                        <input value="<?php echo $dataevent['eventDate'] ?>" type="text" disabled class="form-control" id="floatingInput" placeholder="Download" name="download">
                        <label for="floatingInput">Current Event Date</label>
                    </div>
                </div>
                <div class="col-lg-5 col-12 m-3 ">
                    <div class=" form-control">
                        <label for="edate">Event Date</label>
                        <input type="datetime-local" class="form-control" id="edate" name="Edate">
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center flex-column flex-lg-row justify-content-center">
                <div class="col-lg-5 col-12 m-3 ">
                    <div class=" form-floating">
                        <input value="<?php echo $dataevent['event_logo'] ?>" type="text" disabled class="form-control" id="floatingInput" placeholder="Download" name="download">
                        <label for="floatingInput">Current Event Date</label>
                    </div>
                </div>
                <div class="col-lg-5 col-12 m-3 ">
                    <div class="col-sm-12 m-3 form-control">
                        <label for="floatingnput">Change Event Logo</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>
            </div>


            <div class="d-flex align-items-center justify-content-around ">


                <div class="col-sm-5 mt-3 mb-3 ">
                    <div class=" form-control p-2">
                        <label for="adder" class="p-2">Event Submiter</label>
                        <select id="adder" class="form-select" name="submiter">
                            <?php while ($datauser = mysqli_fetch_assoc($opusers)) {
                            ?>
                                <option value="<?php echo $datauser['id']; ?>" <?php if ($datauser['id'] == $dataevent['event_submiter']) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo $datauser['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

            </div>


            <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Update">

        </form>

        <div class="logoPic col-lg-2 align-self-center col-4">
            <div class="card-body bg-warning">
                <p class="card-text text-danger text-center fw-bold fs-4">Logo</p>
            </div>
            <img src="<?php echo images('eventsLogos/') . trim($dataevent['event_logo']) ?>" class="card-img-top" alt="logo">
        </div>
    </div>


</body>


</html>