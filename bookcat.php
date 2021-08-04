<?php
require 'helpers/dbConnection.php';
require "helpers/paths.php";
require "helpers/functions.php";
require "layout/header.php";
require "./checklogin/checkloginnormal.php";




$cat = $_GET['cat'];

$cat  = Sanitize($_GET['cat'], 1);

$_SESSION['cat'] = $cat;

$sqlbkCat = 'select * from bookscategory';
$opbkcat = mysqli_query($con, $sqlbkCat);

$sqlbooks = 'select books.* ,bookscategory.id as catId, bookscategory.book_category as bkcat from books join bookscategory on books.book_category = bookscategory.id WHERE bookscategory.id = ' . $cat . ' ORDER BY books.id DESC';
$opbooks = mysqli_query($con, $sqlbooks);


$sqlbklast = 'select * from book_rels order by id desc limit 1';
$opbklast = mysqli_query($con, $sqlbklast);
$databklast = mysqli_fetch_assoc($opbklast);
$_SESSION['bklast'] = $databklast;


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books </title>
    <link rel="stylesheet" href="<?php echo css('books.css') ?>">
</head>

<body>
    <div class="col-9 mx-auto mt-3 ">
        <div class="card mb-3 ">
            <img src="<?php echo images('bookRel/') . $_SESSION['bklast']['rels_ad']; ?>" class="card-img-top" alt="ads" style="height: 350px;">
            <div class="card-body">
                <h6>Latest Books</h6>
                <h5 class="card-title text-uppercase fw-bold"><?php echo $_SESSION['bookAd']['bookName'] ?></h5>
                <p class="card-text">Book Describtion: <?php echo $_SESSION['bookAd']['bookDesc'] ?>.</p>
                <a href="<?php echo $_SESSION['bookAd']['download']; ?>" class="btn btn-primary">Download Now</a>
            </div>
        </div>
    </div>



    <div class="d-flex justify-content-evenly mt-5 flex-column flex-lg-row ">

        <aside class="bg-dark text-white col-2 p-5 m-2 position-sticky top-50  " style="height: 300px;">

            <h3 class="">Categories</h3>
            <ul class="list-unstyled ms-3" style=" min-height: 300px">
                <a class="btn btn-warning m-3" href="<?php echo project('books.php'); ?>">Clear Filter</a>
                <?php while ($databkcat = mysqli_fetch_assoc($opbkcat)) { ?>
                    <li><a href="<?php echo project('bookcat.php') . '?cat=' . $databkcat['id']; ?>" class="text-decoration-none  <?php if ($databkcat['id'] == $_SESSION['cat']) {
                                                                                                                                        echo 'text-danger';
                                                                                                                                    } else {
                                                                                                                                        echo 'text-white';
                                                                                                                                    } ?>">-> <?php echo $databkcat['book_category'] ?></a></li>
                <?php } ?>
            </ul>
        </aside>




        <div id="shelf" class="conatiner col-8 row row-cols-1 row-cols-md-2 cols-rows-lg-2 g-4" style="min-height :1000px;background: url(assests/images/bg2.jpg) ;">

            <?php while ($databooks = mysqli_fetch_assoc($opbooks)) { ?>
                <div class="col book ">
                    <div class="card w-75 " style="height: 350px; background-color:transparent;">
                        <img src="<?php echo images('booksCovers/') . trim($databooks['coverPic']) ?>" class="card-img-top w-75 " alt="..." style="height:100%; ">
                        <div class=" card-body">
                            <h5 class="card-title text-white"><span class="text-danger">Title: </span><?php echo $databooks['book_name']; ?></h5>
                            <p class="card-text text-white" style="overflow: hidden;text-overflow: ellipsis;"><span class="text-danger">Describtion:</span> <?php echo $databooks['describtion']; ?></p>
                            <a href="<?php echo $databooks['Download']; ?>" class="btn btn-success">Download Now</a>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</body>


<footer>
    <marquee class="bg-primary" behavior="slider" direction="center">Copy Rights &copy; : Designed and develped by : Nader Sayed </marquee>
</footer>

<script>
    let num = document.querySelectorAll('.book').length;
    if (num == 1) {
        document.getElementById("shelf").style.minHeight = num * 600 + "px";
    } else {
        document.getElementById("shelf").style.minHeight = num * 350 + "px";

    }
</script>

</html>