<?php
require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../layout/navAdmin.php';
require '../../../checklogin/checkLoginadmin.php';


$sqlnews = "select  users.* , news.* from news join users on news.adder = users.id ORDER by news.id DESC ";
$opnews = mysqli_query($con, $sqlnews);





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Display</title>
    <link rel="stylesheet" href="<?php echo css('news.css') ?>">
    <style>

    </style>
</head>

<body>
    <h1 class="m-2"><span class="blue">&lt;</span>News<span class="blue">&gt;</span> <span class="yellow">Data</pan>
    </h1>
    <h2>Admin Premission Only! <br><br>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        unset($_SESSION['message']);
        ?>

    </h2>
    <div class="mx-auto  m-3">
        <div class="mx-auto  m-3">
            <a href="<?php echo resources('news/create.php') ?>" class="btn btn-danger d-block mx-auto w-25 ">Add New +</a>
        </div>
        <table class="container">
            <thead>
                <tr>
                    <th>
                        <h1>ID</h1>
                    </th>
                    <th>
                        <h1>Title</h1>
                    </th>
                    <th style="width: 65%;" class="w-75">
                        <h1>Content</h1>
                    </th>

                    <th>
                        <h1>Image</h1>
                    </th>
                    <th>
                        <h1>adder</h1>
                    </th>
                    <th>
                        <h1>Actions</h1>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($datanews = mysqli_fetch_assoc($opnews)) { ?>

                    <tr>
                        <td><?php echo $datanews['id']; ?></td>
                        <td><?php echo $datanews['title']; ?></td>
                        <td style="overflow: hidden;text-overflow: ellipsis; "><?php echo $datanews['content']; ?></td>
                        <td><?php echo $datanews['image']; ?></td>
                        <td><?php echo $datanews['name']; ?></td>
                        <td style="padding: 60% 10px ">
                            <a href="delete.php?id=<?php echo $datanews['id'] ?>" class="btn btn-danger m-2 ">Delete</a>
                            <a href="edit.php?id=<?php echo $datanews['id']; ?>" class="btn btn-success m-2">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
</body>


</html>