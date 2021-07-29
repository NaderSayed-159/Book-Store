<?php
require '../../../dbConnection.php';
require "../headeradmin.php";
require '../../../checklogin/checkLogin.php';


$sql = "select events_check.* , users.id as userID , users.name as submiter from events_check join users on events_check.event_submiter = users.id order by events_check.id asc";
$op = mysqli_query($con, $sql);





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Data</title>
    <link rel="stylesheet" href="../../../css/display.css">
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
    <h1 class="head"><span class="blue">&lt;</span>Events<span class="blue">&gt;</span> <span class="yellow">Checking</pan>
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
                        <a href="accept.php?id=<?php echo $data['id']; ?>" class="btn btn-success ">Accept</a>
                        <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-primary ">Edit</a>
                        <a href="delete.php?id=<?php echo $data['id'] ?>" class="btn btn-danger ">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>


</html>