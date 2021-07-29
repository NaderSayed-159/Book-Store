<?php
require '../../dbConnection.php';
require "../headeradmin.php";

$sql = "select  users.* ,usersTypes.id as userID , usersTypes.user_type as role from users inner join usersTypes on users.user_type = usersTypes.id  order by usersTypes.id asc ";
$op = mysqli_query($con, $sql);





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Display</title>
    <link rel="stylesheet" href="../../css/display.css">
    <style>
        .head {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1 class="head"><span class="blue">&lt;</span>Users<span class="blue">&gt;</span> <span class="yellow">Data</pan>
    </h1>
    <h2>Admin Premission Only! <br><br>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        unset($_SESSION['message']);
        ?>

    </h2>

    <table class="container">
        <thead>
            <tr>
                <th>
                    <h1>ID</h1>
                </th>
                <th>
                    <h1>Name</h1>
                </th>
                <th>
                    <h1>Email</h1>
                </th>
                <th>
                    <h1>Phone</h1>
                </th>
                <th>
                    <h1>Gender</h1>
                </th>
                <th>
                    <h1>User type</h1>
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
                    <td><?php echo $data['name']; ?></td>
                    <td><?php echo $data['email']; ?></td>
                    <td><?php echo $data['phone']; ?></td>
                    <td><?php echo $data['gender']; ?></td>
                    <td><?php echo $data['role']; ?></td>
                    <td>
                        <a href="delete.php?id=<?php echo $data['id'] ?>" class="btn btn-danger ">Delete</a>
                        <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-success ">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>


</html>