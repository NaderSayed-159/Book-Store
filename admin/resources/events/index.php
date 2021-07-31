<?php
require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../layout/navAdmin.php';
require '../../../checklogin/checkLoginadmin.php';


$sql = "select events.* , users.id as userID , users.name as submiter from events join users on events.event_submiter = users.id order by events.id desc";
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
        .head {
            margin-top: 20px;
        }

        .add {
            text-align: center;
            position: absolute;
            left: 15%;
            transform: translateX(-50%) translateY(-125%);
        }
    </style>
</head>

<body>
    <h1 class="head"><span class="blue">&lt;</span>Submitted Events<span class="blue">&gt;</span> <span class="yellow">Data</pan>
    </h1>
    <h2>Admin Premission Only! <br><br>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        unset($_SESSION['message']);
        ?>

    </h2>


    <a href="<?php echo resources('events/create.php') ?>" class="btn btn-danger add" style="    color: #fff ;
    background-color: #dc3545;
    border-color: #dc3545;">Add New +</a>


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

                <tr class="text-center">
                    <td><?php echo $data['id']; ?></td>
                    <td><?php echo $data['event_name']; ?></td>
                    <td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis; width:8%"><?php echo $data['event_describtion']; ?></td>
                    <td style="text-align: center;"><?php echo $data['eventDate']; ?></td>
                    <td><?php echo $data['event_logo']; ?></td>
                    <td><?php echo $data['submiter']; ?></td>
                    <td>
                        <a href="delete.php?id=<?php echo $data['id'] ?>" class="btn btn-danger m-2 ">Delete</a>
                        <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-success m-2 ">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>


</html>