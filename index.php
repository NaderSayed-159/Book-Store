<?php

require 'helpers/dbConnection.php';
require "helpers/paths.php";
require "helpers/functions.php";
require "./checklogin/checkloginnormal.php";
require "layout/header.php";


$mysqlnews = 'SELECT * FROM `news` ORDER BY id DESC LIMIT 3';
$opNews = mysqli_query($con, $mysqlnews);


$mysqlbkAd = 'SELECT book_rels.rels_ad as adimg , books.book_name as bookName ,books.Download as download,books.describtion  as  bookDesc FROM book_rels JOIN books on book_rels.book_name = books.id ';
$opbkAd = mysqli_query($con, $mysqlbkAd);
$databkAd = mysqli_fetch_assoc($opbkAd);
$_SESSION['bookAd'] = $databkAd;


$sqlevent = "select * from events order by id desc limit 1 ";
$opevents =  mysqli_query($con, $sqlevent);
$dataevent = mysqli_fetch_assoc($opevents);
$_SESSION['event'] = $dataevent;




$errorMessages = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name  = cleanInputs(Sanitize($_POST['name'], 2));
    $email = cleanInputs($_POST['email']);
    $phone = cleanInputs($_POST['phone']);
    $subj = cleanInputs($_POST['subj']);
    $msg = cleanInputs($_POST['msg']);
    $sender = $_SESSION['users']['id'];




    //Name Validation
    if (!Validator($name, 1)) {
        $errorMessages['name'] = "Required";
    }

    if (!Validator($name, 2)) {

        $errorMessages['name'] = "Name Length must be more than 3 ";
    }


    //Email Validation
    if (!Validator($email, 1)) {
        $errorMessages['email'] = "Required";
    }

    if (!Validator($email, 4)) {
        $errorMessages['email'] = "Invalid Email";
    }

    // phone Validation ... 

    if (!Validator($phone, 1)) {
        $errorMessages['phone'] = "Required";
    }


    if (!Validator($phone, 2, 11)) {

        $errorMessages['phone'] = "Phone should be 11 numbers";
    }



    if (!Validator($subj, 1)) {
        $errorMessages['subject'] = "Required";
    }

    if (!Validator($subj, 2, 5)) {

        $errorMessages['subject'] = "subject Length must be more than 5";
    }

    if (!Validator($msg, 1)) {
        $errorMessages['message'] = "Required";
    }

    if (!Validator($subj, 2, 10)) {

        $errorMessages['message'] = "message Length must be more than 10 ";
    }



    if (count($errorMessages) > 0) {

        $_SESSION['errmessages'] = $errorMessages;
    } else {

        // operations
        $password = sha1($password);

        $sql = "insert into contact (name,email,phone,subj,msg,sender_id) values ('$name','$email','$phone','$subj','$msg',$sender)";
        $op =  mysqli_query($con, $sql);



        if ($op) {
            $_SESSION['message'] = "Sent ^^";
            header("Location: " . project('index.php'));
        } else {
            $errorMessages['sqlOperation'] = "Error in Your Sql Try Again";
        }

        $_SESSION['errmessages'] = $errorMessages;
    }
}

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
                        <img src="<?php echo images('bookRel/') . $_SESSION['bookAd']['adimg']; ?>" class="card-img-top" alt="ads" style="height: 350px;">
                        <div class="card-body">
                            <h6>Latest Books</h6>
                            <h5 class="card-title text-uppercase fw-bold"><?php echo $_SESSION['bookAd']['bookName'] ?></h5>
                            <p class="card-text">Book Describtion: <?php echo $_SESSION['bookAd']['bookDesc'] ?>.</p>
                            <p class="card-text"><a href="<?php echo project('books.php') ?>" class="text-decoration-none"><small class="text-muted">See more...</small></a></p>
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
        <p class="text-danger text-center m-3">You can join as activity user to get its benefits just contact us by this form </p>
        <p class="text-danger text-center m-3">contact us if u face a problem</p>
        <p class="text-warning text-center m-3">
            <?php
            if (isset($_SESSION['errmessages'])) {

                foreach ($_SESSION['errmessages'] as $key =>  $data) {

                    echo '* ' . $key . ' : ' . $data . '<br>';
                }

                unset($_SESSION['errmessages']);
            } else if (isset($_SESSION['message'])) {

                echo $_SESSION['message'];

                unset($_SESSION['message']);
            }
            ?>
        </p>
        <div class="blackboard">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form" enctype="multipart/form-data">
                <p>
                    <label>Name: </label>
                    <input type="text" name="name" />
                </p>
                <p>
                    <label>Email: </label>
                    <input type="text" name="email" />
                </p>
                <p>
                    <label>Phone: </label>
                    <input type="text" name="phone" />
                </p>
                <p>
                    <label>Subject: </label>
                    <input type="text" name="subj" />
                </p>
                <p>
                    <label>Message: </label>
                    <textarea name="msg"></textarea>
                </p>
                <p class="wipeout">
                    <input type="submit" value="Send" />
                </p>
            </form>
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