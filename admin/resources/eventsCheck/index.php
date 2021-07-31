<?php
require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../layout/navAdmin.php';
require '../../../checklogin/checkLoginadmin.php';


$sql = "select events_check.* , users.id as userID , users.name as submiter , users.email as userEmail from events_check join users on events_check.event_submiter = users.id order by events_check.id asc";
$op = mysqli_query($con, $sql);





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Data</title>
    <link rel="stylesheet" href="<?php echo css('display.css') ?>">
    <style>
        .add {
            text-align: center;
            position: absolute;
            left: 15%;
            transform: translateX(-50%) translateY(-125%);
        }
    </style>
</head>

<body>
    <h1 class="m-5"><span class="blue">&lt;</span>Events<span class="blue">&gt;</span> <span class="yellow">Checking</pan>
    </h1>
    <h2>Admin Premission Only! <br><br>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        unset($_SESSION['message']);
        ?>

    </h2>


    <a href="create.php" title="Avaliable only for Company Users to add Events to checked" class="btn btn-secondary add" style="color: #fff ;
    background-color: gray;
    border-color: black;">Add New +</a>


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
                    <h1>Event Logo</h1>
                </th>
                <th>
                    <h1>Event Submiter</h1>
                </th>



                <th>
                    <h1>Actions</h1>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($data = mysqli_fetch_assoc($op)) { ?>

                <tr>
                    <td><?php echo $data['id']; ?></td>
                    <td><?php echo $data['event_name']; ?></td>
                    <td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis; width:8%"><?php echo $data['event_desc']; ?></td>
                    <td style="text-align: center;"><?php echo $data['e_date']; ?></td>
                    <td><?php echo $data['e_logo']; ?></td>
                    <td><?php echo $data['submiter']; ?></td>
                    <td>
                        <a href="accept.php?id=<?php echo $data['id']; ?>" class="btn btn-success m-1 ">Accept</a>
                        <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-primary m-1 ">Edit</a>
                        <a href="delete.php?id=<?php echo $data['id'] ?>" class="btn btn-danger m-1 " style="pointer-events: none;">Delete</a>
                        <a href="mailto:<?php echo $data['userEmail'] ?>?subject=Knights Refused Event!&body=Event Refused!" class="btn btn-dark m-1 ">Refuse</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>


</html>