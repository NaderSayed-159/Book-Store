<?php
require 'helpers/dbConnection.php';
require "helpers/paths.php";
require "helpers/functions.php";
require "./checklogin/checkloginnormal.php";
require "layout/header.php";

$sqlsearch = "select books.* ,bookscategory.* ,bookscategory.book_category AS bkCate from books join bookscategory ON books.book_category= bookscategory.id where book_name like '%" . $_SESSION['data'] . "%' or describtion like '%" . $_SESSION['data'] . "%' or bookscategory.book_category like '%" . $_SESSION['data'] . "%'";
$opsearch = mysqli_query($con, $sqlsearch);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search resaults</title>

    <link rel="stylesheet" href="<?php echo css('search.css') ?>">
</head>

<body>

    <h1 class="m-5"><span class="blue">&lt;</span>Search<span class="blue">&gt;</span> <span class="yellow">Reasults</span>

        <table class="table table-dark table-striped m-5 container">
            <thead>
                <th>
                    <h1>id</h1>
                </th>
                <th>
                    <h1>Book Name</h1>
                </th>
                <th>
                    <h1>Describtion</h1>
                </th>
                <th>
                    <h1>Category</h1>
                </th>
                <th>
                    <h1>Book Cover</h1>
                </th>

                <th>
                    <h1>Download Link</h1>
                </th>
            </thead>
            <tbody>

                <?php

                while ($data = mysqli_fetch_assoc($opsearch)) {  ?>
                    <tr>
                        <td class="id-AC"></td>
                        <td><?php echo $data['book_name'] ?></td>
                        <td><?php echo $data['describtion'] ?></td>
                        <td><?php echo $data['bkCate'] ?></td>
                        <td><img style="width: 100px;" src="<?php echo images('booksCovers/') . trim($data['coverPic'])  ?>" alt=""></td>
                        <td><a href="<?php echo $data['Download'] ?>" class="btn btn-danger"> Download</a></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>

        <script>
            let tr = document.querySelectorAll('.id-AC');

            let counter = 1;

            tr.forEach(el => {

                el.textContent = counter;
                counter++;

            });
        </script>

</body>

</html>