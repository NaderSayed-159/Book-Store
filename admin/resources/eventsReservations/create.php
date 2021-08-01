<?php
ob_start();
require "../../../helpers/paths.php";
require "../../../helpers/functions.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';



//users
$sqlusers = "select * from users where user_type > 1";
$opusers =  mysqli_query($con, $sqlusers);

//events
$sqlevents = "select * from events";
$opevents =  mysqli_query($con, $sqlevents);



$errorMessages = [];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $event  = cleanInputs(Sanitize($_POST['event'], 1));
    $enroller = cleanInputs(Sanitize($_POST['enroller'], 1));


    //event validation

    if (!Validator($event, 1)) {

        $errorMessages['event'] = "Choose Event";
    }
    if (!Validator($event, 3)) {

        $errorMessages['event'] = "Invalid Event";
    }


    //enroller validation

    if (!Validator($enroller, 1)) {

        $errorMessages['event'] = "Choose enroller";
    }
    if (!Validator($enroller, 3)) {

        $errorMessages['event'] = "Invalid enroller";
    }



    if (count($errorMessages) > 0) {

        $_SESSION['errmessages'] = $errorMessages;
    } else {

        $sql = "insert into e_reservation (event_id,enroller) values ($event,$enroller)";
        $ops =  mysqli_query($con, $sql);



        if ($ops) {

            $_SESSION['message'] = "Reservation Done";
            header("Location: " . resources('eventsReservations/index.php'));
        } else {
            $errorMessages = "Error in Your Sql Try Again";
        }


        $_SESSION['errmessages'] = $errorMessages;
    }
}




$sqllogo =  'select event_logo from events';
$oplogo = mysqli_query($con, $sqllogo);
$dataevent = mysqli_fetch_assoc($oplogo);




?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding Event Reservation </title>
    <link rel="stylesheet" href="<?php echo css('create.css') ?>">
</head>

<body class="col-12">

    <h1 class="text-danger">Add a new Event to Database
        <small>Create a new Event </small>
    </h1>

    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50 ">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo resources('eventsReservations/index.php') ?>">Events Reservations</a></li>
        <li class="breadcrumb-item active ">Add Event Reservation</li>
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
    <div class=" mx-5 d-flex flex-column flex-lg-row col-lg-8 col-12 justify-content-between align-items-center">

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="  col-8 mx-auto mt-5 d-flex align-items-center flex-column  p-4 ps-0 " enctype="multipart/form-data">


            <div class="col-12 col-lg-7 m-3 mx-auto">
                <div class=" form-control p-2  ">
                    <label for="event" class="p-2">Event name </label>
                    <select id="event" class="form-select" name="event">
                        <option value=""></option>
                        <?php while ($dataevent = mysqli_fetch_assoc($opevents)) {
                        ?>
                            <option <?php echo "data-logo='" . $dataevent['event_logo'] . "'"; ?> value="<?php echo $dataevent['id']; ?>"><?php echo $dataevent['event_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-12 col-lg-7 m-3 mx-auto">
                <div class=" form-control p-2  ">
                    <label for="adder" class="p-2">Event Submiter </label>
                    <select id="adder" class="form-select" name="enroller">
                        <option value=""></option>
                        <?php while ($datauser = mysqli_fetch_assoc($opusers)) {
                        ?>
                            <option value="<?php echo $datauser['id']; ?>"><?php echo $datauser['name']; ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <input type="submit" class="btn btn-warning col-5 m-3 " value="Reseve">

        </form>
        <div class="col-lg-3 align-self-center col-6">
            <div class="card-body bg-warning">
                <p class="card-text text-danger text-center fw-bold fs-4">Logo</p>
            </div>
            <img id="logoViewer" src="<?php echo images('eventsLogos/template.png') ?>" class="card-img-top" alt="logo">
        </div>

    </div>

    <script>
        let eventLogo = document.getElementById('event'),
            logoViewer = document.getElementById('logoViewer');
        eventLogo.addEventListener('change', () => {
            var option = eventLogo.options[eventLogo.selectedIndex];
            var logoName = option.getAttribute('data-logo');

            if (!option.value == '') {
                logoViewer.src = "<?php echo images('eventsLogos/') ?>" + logoName;

            } else {

                logoViewer.src = "<?php echo images('eventsLogos/') ?>" + "template.png";

            }
        });
    </script>
</body>

</html>