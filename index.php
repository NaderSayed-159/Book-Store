<?php

require 'helpers/dbConnection.php';
require "helpers/paths.php";
require "helpers/functions.php";
require "layout/header.php";
require "./checklogin/checkloginnormal.php";


$mysqlnews = 'SELECT * FROM `news` ORDER BY id DESC LIMIT 3';
$opNews = mysqli_query($con, $mysqlnews);


$mysqlbkAd = 'SELECT book_rels.rels_ad as adimg , books.book_name as bookName ,books.describtion as  bookDesc FROM book_rels JOIN books on book_rels.book_name = books.id ';
$opbkAd = mysqli_query($con, $mysqlbkAd);
$databkAd = mysqli_fetch_assoc($opbkAd);

$_SESSION['bookAd'] = $databkAd;


$sqlevent = "select * from events order by id desc limit 1 ";
$opevents =  mysqli_query($con, $sqlevent);
$dataevent = mysqli_fetch_assoc($opevents);
$_SESSION['event'] = $dataevent;
?>




<head>

    <title>Geo to People</title>
    <link href='https://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo css('home.css') ?>">
</head>

<body>
    <div class="body container mx-auto mt-5">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner" style="height: 600px;">
                <?php while ($datanews = mysqli_fetch_assoc($opNews)) {
                ?>
                    <div class="carousel-item position-relative " data-bs-interval="3000">
                        <img src="<?php echo $datanews['image'] ?>" class="d-block w-100 h-100" alt="newsimg">
                        <div class="carousel-caption d-none d-md-block position-absolute bottom-50 start-50">
                            <h5><?php echo $datanews['title'] ?></h5>
                            <p><?php echo $datanews['content'] ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="m-5 d-flex flex-column">

            <h1 class="text-danger text-center m-5 text-decoration-underline">Latest Updates</h1>
            <div class="d-flex col-12 justify-content-evenly">
                <div class="col-8">
                    <div class="card mb-3 ">
                        <img src="<?php echo $_SESSION['bookAd']['adimg'] ?>" class="card-img-top" alt="ads" style="height: 350px;">
                        <div class="card-body">
                            <h6>Latest Books</h6>
                            <h5 class="card-title text-uppercase fw-bold"><?php echo $_SESSION['bookAd']['bookName'] ?></h5>
                            <p class="card-text">Book Describtion: <?php echo $_SESSION['bookAd']['bookDesc'] ?>.</p>
                            <p class="card-text"><a href="" class="text-decoration-none"><small class="text-muted">See more...</small></a></p>
                        </div>
                    </div>
                </div>


                <div class="card col-3">
                    <img src="<?php echo images('eventsLogos/' . trim($_SESSION['event']['event_logo'])) ?>" class="card-img-top" alt="">
                    <div class="card-body">
                        <h6 class="text-muted">latest Event</h6>

                        <h5 class="card-title"><?php echo $_SESSION['event']['event_name'] ?></h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Show Events ></a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="shade">
        <h1 class="text-danger text-center m-5">Join Us as Activity user</h1>
        <div class="blackboard">
            <div class="form">
                <p>
                    <label>Name: </label>
                    <input type="text" />
                </p>
                <p>
                    <label>Email: </label>
                    <input type="text" />
                </p>
                <p>
                    <label>Phone: </label>
                    <input type="tel" />
                </p>
                <p>
                    <label>Subject: </label>
                    <input type="text" />
                </p>
                <p>
                    <label>Message: </label>
                    <textarea></textarea>
                </p>
                <p class="wipeout">
                    <input type="submit" value="Send" />
                </p>
            </div>
        </div>
    </div>


    <script>
        document.querySelectorAll('.carousel-item')[0].classList.add('active');
    </script>

</body>

<footer>
    <marquee class="bg-primary" behavior="slider" direction="center">Copy Rights &copy; : Designed and develped by : Nader Sayed </marquee>
</footer>

</html>