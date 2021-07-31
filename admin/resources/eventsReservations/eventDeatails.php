<?php
require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';



$id = $_GET['id'];

$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$message = '';

if (filter_var($id, FILTER_VALIDATE_INT)) {


    $sql = "select events.* , users.id as userID , users.name as submiter from events join users on events.event_submiter = users.id where events.id= $id ";
    $op = mysqli_query($con, $sql);
    // $fetched = mysqli_fetch_assoc($op);


    // $sqlimage = "select event_logo from events where id=" . $id;
    // $opimage =   mysqli_query($con, $sqlimage);

    // $dataimg =    mysqli_fetch_assoc($opimage);
}






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events details</title>
    <link rel="stylesheet" href="<?php echo css('display.css') ?>">
    <style>
        .head {
            margin-top: 20px;
        }

        .add {
            text-align: center;
            position: absolute;
            left: 15%;
            transform: translateX(-50%) translateY(-125%);
        }

        table {
            width: 100% !important;
        }


        th h1 {
            text-align: center !important;
        }

        td {
            text-align: center !important;
        }
    </style>
</head>

<body>
    <h1 class="head"><span class="blue">&lt;</span>Events <span class="blue">&gt;</span> <span class="yellow">Details</pan>
    </h1>
    <h2>Admin Premission Only! <br><br>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        unset($_SESSION['message']);
        ?>

    </h2>


    <a href="index.php" class="btn btn-danger add" style="    color: #fff ;
    background-color: #dc3545;
    border-color: #dc3545;">Back to reservations &gt;</a>
    <div class="d-flex flex-column justify-content-space-between">

        <table class="container">
            <thead>
                <tr>
                    <th>
                        <h1>ID</h1>
                    </th>
                    <th>
                        <h1>Event Name</h1>
                    </th>
                    <th>
                        <h1>Event Describition</h1>
                    </th>
                    <th>
                        <h1> Event Date</h1>
                    </th>
                    <th>
                        <h1> Event logo</h1>
                    </th>
                    <th>
                        <h1>Event Submiter</h1>
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($op)) { ?>

                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['event_name']; ?></td>
                        <td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis; width:8%"><?php echo $data['event_describtion']; ?></td>
                        <td style="text-align: center;"><?php echo $data['eventDate']; ?></td>
                        <td id="cellLogo"><?php echo $data['event_logo']; ?></td>
                        <td><?php echo $data['submiter']; ?></td>
                    </tr>


            </tbody>
        </table>

        <div class="logoPic col-lg-2 align-self-center col-4 mt-4">
            <div class="card-body  bg-gradient bg-dark">
                <p class="card-text text-success text-center fw-bold fs-4">Logo</p>
            </div>

            <img id="eventLogo" src=" <?php echo images('eventsLogos/') . $data['event_logo'] ?>" class="card-img-top" alt="logo">

        </div>

    <?php } ?>
    </div>

    <script>
        // document.getElementById("eventLogo").src = "../events/images/logos/" + document.getElementById("cellLogo").textContent
    </script>
</body>


</html>