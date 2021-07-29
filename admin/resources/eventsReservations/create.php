<?php
ob_start();
require '../../../dbConnection.php';
require "../headeradmin.php";
require '../../../checklogin/checkLogin.php';



//users
$sqlusers = "select * from users";
$opusers =  mysqli_query($con, $sqlusers);

//events
$sqlevents = "select * from events";
$opevents =  mysqli_query($con, $sqlevents);



function cleanInputs($input)
{

    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}
$errorMessages = [];





if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $event  = cleanInputs($_POST['event']);
    $enroller = cleanInputs($_POST['enroller']);


    //event validation
    if (!empty($event)) {

        if (!filter_var($event, FILTER_VALIDATE_INT)) {

            $errorMessages['event'] = "Invalid department";
        }
    } else {
        $errorMessages['event'] = "Invalid department";
    }


    //enroller validation

    if (!empty($enroller)) {

        if (!filter_var($enroller, FILTER_VALIDATE_INT)) {

            $errorMessages['enroller'] = "Invalid department";
        }
    } else {
        $errorMessages['enroller'] = "Invalid department";
    }


    if (count($errorMessages) == 0) {


        $sql = "insert into e_reservation (event_id,enroller) values ($event,$enroller)";
        $ops =  mysqli_query($con, $sql);



        if ($ops) {
            echo 'data inserted';
            $_SESSION['message'] = "Reservation Done";
            header("Location: ./index.php");
        } else {
            echo "Error in Your Sql Try Again";
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

    <link rel="stylesheet" href="../../../css/create.css">
</head>

<body class="col-12">

    <h1 class="text-danger">Add a new Event to Database
        <small>Create a new Event </small>
    </h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="container  col-8 mx-auto mt-5 d-flex align-items-center flex-column  p-4 ps-0 " enctype="multipart/form-data">


        <div class="col-12 col-lg-7 m-3 mx-auto">
            <div class=" form-control p-2  ">
                <label for="adder" class="p-2">Event name </label>
                <select id="adder" class="form-select" name="event">
                    <?php while ($dataevent = mysqli_fetch_assoc($opevents)) {
                    ?>
                        <option value="<?php echo $dataevent['id']; ?>"><?php echo $dataevent['event_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-12 col-lg-7 m-3 mx-auto">
            <div class=" form-control p-2  ">
                <label for="adder" class="p-2">Event Submiter </label>
                <select id="adder" class="form-select" name="enroller">
                    <?php while ($datauser = mysqli_fetch_assoc($opusers)) {
                    ?>
                        <option value="<?php echo $datauser['id']; ?>"><?php echo $datauser['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>




        <input type="submit" class="btn btn-warning col-5 m-3 " value="Reseve">

    </form>


</body>

</html>