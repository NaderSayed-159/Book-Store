<?php
ob_start();
require '../../../dbConnection.php';
require "../headeradmin.php";
require '../../../checklogin/checkLogin.php';



//users
$sqlusers = "select * from users";
$opusers =  mysqli_query($con, $sqlusers);



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
            $errorMessages['evnet name'] = "Name Length must be > 5 ";
        }
    } else {
        $errorMessages['event name'] = "Required";
    }

    //describtion Validation

    if (!empty($describtion)) {

        if (strlen($describtion) < 10) {
            $errorMessages['event describtion'] = "Name Length must be > 10 ";
        }
    } else {
        $errorMessages['event describtion'] = "Required";
    }

    // logo Validation 
    if (!empty($_FILES['logo']['name']) && isset($_FILES['logo']['name'])) {


        $tmp_path = $_FILES['logo']['tmp_name'];
        $covername = $_FILES['logo']['name'];


        $nameArray = explode('.', $covername);
        $fileExtension = strtolower($nameArray[1]);

        $LogoName = rand() . time() . '.' . $fileExtension;

        $allowedExtensions = ['png', 'jpg'];

        if (in_array($fileExtension, $allowedExtensions)) {

            $disFolder = './images/logos/';

            $disPath  = $disFolder . $LogoName;
            move_uploaded_file($tmp_path, $disPath);
        } else {
            $errorMessages['logo'] = '* extension not allowed';
        }
    } else {
        $errorMessages['logo'] = 'pls upload cover';
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

        $errorMessages['Date'] =  "Enter Event Date";
    }



    if (count($errorMessages) == 0) {


        $sql = "insert into events (event_name,event_describtion,eventDate,event_logo,event_submiter) values ('$name','$describtion','$edate','$LogoName',$adder)";
        $ops =  mysqli_query($con, $sql);



        if ($ops) {
            echo 'data inserted';
            $_SESSION['message'] = "Data Inserted";
            header("Location: index.php");
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


        <div class="col-sm-7 m-3 mx-auto">
            <div class=" form-control p-2  ">
                <label for="adder" class="p-2">Event Submiter </label>
                <select id="adder" class="form-select" name="submiter">
                    <?php while ($datauser = mysqli_fetch_assoc($opusers)) {
                    ?>
                        <option value="<?php echo $datauser['id']; ?>"><?php echo $datauser['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>




        <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Create">

    </form>


</body>

</html>