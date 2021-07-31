<?php
ob_start();
require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';



$id = $_GET['id'];
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$message = "";

if (!filter_var($id, FILTER_VALIDATE_INT)) {

    $_SESSION['message'] = "Invalid Id";

    header("Locattion: index.php");
}

// events
$sqlevent = "select * from events where id =$id";
$opevents =  mysqli_query($con, $sqlevent);
$dataevent = mysqli_fetch_assoc($opevents);


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
    $describtion = cleanInputs($_POST['describtion']);
    $adder = $_POST['submiter'];
    $edate = strtotime($_POST["Edate"]);

    //Name Validation
    if (!empty($name)) {

        if (strlen($name) < 5) {
            $errorMessages['event name'] = "Name Length must be > 5 ";
        }
    } else {
        $errorMessages['event name'] = "Required";
    }

    //describtion Validation

    if (!empty($describtion)) {

        if (strlen($describtion) < 10) {
            $errorMessages['event describtion'] = "describtion Length must be > 10 ";
        }
    } else {
        $errorMessages['event describtion'] = "Required";
    }


    $sqllogo = "select event_logo from events where id = " . $id;
    $oplogo  = mysqli_query($con, $sqllogo);
    $dataLogo = mysqli_fetch_assoc($oplogo);

    // logo Validation 
    if (!empty($_FILES['logo']['name']) && isset($_FILES['logo']['name'])) {


        $tmp_path = $_FILES['logo']['tmp_name'];
        $logoOldname = $_FILES['logo']['name'];


        $nameArray = explode('.', $logoOldname);
        $fileExtension = strtolower($nameArray[1]);

        $LogoName = rand() . time() . '.' . $fileExtension;

        $allowedExtensions = ['png', 'jpg'];

        if (in_array($fileExtension, $allowedExtensions)) {

            $disFolder = '../../../assests/images/eventsLogos/';

            $disPath  = $disFolder . $LogoName;

            if (move_uploaded_file($tmp_path, $disPath)) {

                if (file_exists('../../../assests/images/eventsLogos/' . trim($dataLogo['event_logo']))) {

                    unlink('../../../assests/images/eventsLogos/' . trim($dataLogo['event_logo']));
                }
            }
        } else {
            $errorMessages['logo'] = '* extension not allowed';
        }
    } else {
        $LogoName =  $dataLogo['event_logo'];
    }


    //date Validation
    $validDate = strtotime(date("m/d/y"));


    if (!empty($edate)) {

        if ($edate < $validDate) {
            $errorMessages['Date'] =  "not valid date";
        } else {
            $edate = date('Y-m-d-H-i-s', $edate);
        }
    } else {

        $edate = $dataevent['eventDate'];
    }



    if (count($errorMessages) == 0) {


        $sql = "update events set event_name= ' $name', event_describtion = '$describtion' , eventDate = '$edate' , event_logo ='$LogoName', event_submiter = $adder where id =$id";

        $op =  mysqli_query($con, $sql);



        if ($op) {
            $_SESSION['message'] = "Data Updated";
            header("Location: " . resources('events/index.php'));
        } else {
            echo "Error in Your Sql Try Again";
        }
    } else {

        foreach ($errorMessages as $key => $value) {

            echo '* ' . $key . ' : ' . $value . '<br>';
        }
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
                        <input type="file" name="logo   " class="form-control">
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