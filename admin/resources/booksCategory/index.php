<?php
require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../layout/navAdmin.php';
require '../../../checklogin/checkLoginadmin.php';


$sql1 = "select * from bookscategory order by id desc";
$op = mysqli_query($con, $sql1);







?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Data</title>
    <link rel="stylesheet" href="<?php echo css('display.css') ?>">
</head>

<body>
    <h1 class="m-5"><span class="blue">&lt;</span>Books <span class="blue">&gt;</span> <span class="yellow">Categories</pan>
    </h1>
    <h2>Admin Premission Only! <br><br>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        unset($_SESSION['message']);
        ?>

    </h2>


    <a href="create.php" title="Avaliable only for Company Users to add Events to checked" class="btn btn-danger btn btn-danger d-block m-3 mx-auto w-25">Add New +</a>


    <table class="container mb-5">
        <thead>
            <tr>
                <th>
                    <h1>ID</h1>
                </th>
                <th>
                    <h1>Books Categories</h1>
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
                    <td><?php echo $data['book_category']; ?></td>
                    <td style="padding: 2% 3px;">
                        <a href="delet.php?id=<?php echo $data['id']; ?>" class="btn btn-danger m-2">Delete</a>
                        <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-success m-2">Edit</a>
                    </td>
                </tr>
            <?php } ?>




        </tbody>
    </table>
</body>


</html>