<?php
require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php' ;
require '../../../layout/navAdmin.php' ;
require '../../../checklogin/checkLoginadmin.php';



$sql = "select books.* , bookscategory.id as bookId , bookscategory.book_category as category , users.id as userID ,users.name as adder from books join bookscategory on books.book_category = bookscategory.id join users on books.book_adder = users.id  order by books.id asc";
$op = mysqli_query($con, $sql);





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Data</title>
    <link rel="stylesheet" href="<?php echo css('display.css')?>">
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
    </style>
</head>

<body>
    <h1 class="head"><span class="blue">&lt;</span>Books<span class="blue">&gt;</span> <span class="yellow">Data</pan>
    </h1>
    <h2>Admin Premission Only! <br><br>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        unset($_SESSION['message']);
        ?>

    </h2>
    <a href="<?php echo resources('books/create.php')?>" class="btn btn-danger add" style="    color: #fff ;
    background-color: #dc3545;
    border-color: #dc3545;">Add New +</a>


    <table class="container">
        <thead>
            <tr>
                <th>
                    <h1>ID</h1>
                </th>
                <th>
                    <h1>Book Name</h1>
                </th>
                <th>
                    <h1>Book Catogry</h1>
                </th>
                <th>
                    <h1>Describtion</h1>
                </th>
                <th>
                    <h1>Download Link</h1>
                </th>
                <th>
                    <h1>cover Pic</h1>
                </th>
                <th>
                    <h1>Book Adder</h1>
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
                    <td><?php echo $data['book_name']; ?></td>
                    <td><?php echo $data['category']; ?></td>
                    <td style=" text-align: center; "><?php echo $data['describtion']; ?></td>
                    <td style="overflow: hidden;text-overflow: ellipsis;"  ><?php echo $data['Download']; ?></td>
                    <td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $data['coverPic']; ?></td>
                    <td><?php echo $data['adder']; ?></td>
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