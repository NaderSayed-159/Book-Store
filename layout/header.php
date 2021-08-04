<?php

$id = $_SESSION['users']['id'];
$mysqlpp = 'select users_media.profile_pic as profPic , users.id as userID from users_media join users on users_media.user_id = ' . $id;
$op = mysqli_query($con, $mysqlpp);
$data = mysqli_fetch_assoc($op);

$_SESSION['profilePic'] = $data;

$searchErrors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $key = cleanInputs($_POST['searchKey']);


    //key Validation
    if (!Validator($key, 1)) {
        $searchErrors['Search Key'] = "Required";
    }


    if (count($searchErrors) > 0) {


        $_SESSION['searcherrors'] = $searchErrors;
    } else {

        $sqlsearch = "select books.* ,bookscategory.* ,bookscategory.book_category AS bkCate from books join bookscategory ON books.book_category= bookscategory.id where book_name like '%" . $_SESSION['data'] . "%' or describtion like '%" . $_SESSION['data'] . "%' or bookscategory.book_category like '%" . $_SESSION['data'] . "%'";

        $opsearch = mysqli_query($con, $sqlsearch);

        if (mysqli_num_rows($opsearch) > 0) {

            $_SESSION['data'] = $key;

            header("Location: " . project('search.php'));
        } else {

            $searchErrors['Search Key'] =  'NO Matched Data ';
        }
        $_SESSION['searcherrors'] = $searchErrors;
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo css('standHeader.css'); ?>">
</head>

<body>

    <header>
        <div class="logo">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary bg-gradient">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?php echo project('index.php') ?>">
                        <img src="<?php echo images('logo.png'); ?>" alt="" width="70" height="50" class="bg-dark rounded-pill">
                    </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon text-danger"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-dark">
                            <li class="nav-item ">
                                <a class="nav-link  text-dark fw-bold  me-2 <?php if (str_ends_with($_SERVER['PHP_SELF'], 'index.php')) {
                                                                                echo "active";
                                                                            } ?>" href="<?php echo project('index.php'); ?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark fw-bold me-2 <?php if (str_ends_with($_SERVER['PHP_SELF'], 'books.php')) {
                                                                                echo "active";
                                                                            } ?>" href="<?php echo project('books.php') ?>">Books</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link text-dark fw-bold  me-2 <?php if (str_ends_with($_SERVER['PHP_SELF'], 'events.php')) {
                                                                                echo 'active';
                                                                            } ?>' href='<?php echo project('events.php') ?>''>Evnets</a>
                            </li>


                            <?php if (isset($_SESSION['users']) && $_SESSION['users']['user_type'] == 2) { ?>

                                                   <li class=' nav-item'>
                                    <a class='nav-link text-dark fw-bold btn btn-primary me-2 <?php if (str_ends_with($_SERVER['PHP_SELF'], 'eventSubmit.php')) {
                                                                                                    echo 'active';
                                                                                                } ?>' href='<?php echo project('eventSubmit.php') ?>''>Submit Evnets</a>
                            </li>
                          <?php  } ?>

                        </ul>
       
                        <form method="post" class="d-flex" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class=" d-flex">
                                <input style="display: <?php if (str_ends_with($_SERVER['PHP_SELF'], 'books.php')) {
                                                            echo 'intial';
                                                        } else {
                                                            echo 'none';
                                                        }
                                                        ?>" class="form-control me-2 " type="search" placeholder="Search For Books" name="searchKey" >
                                <input  style="display: <?php if (str_ends_with($_SERVER['PHP_SELF'], 'books.php')) {
                                                            echo 'intial';
                                                        } else {
                                                            echo 'none';
                                                        }
                                                        ?>" class="btn btn-danger " type="submit" value="Search" style="font-family:Arial, Helvetica, sans-serif;">
                            </div>
                            
                        </form>

                 
                        <a href="<?php echo login('logout.php') ?>" class="btn btn-danger mx-2 col-1" type="submit">Log Out</a>
                        <div>
                         <a href="<?php echo project('profile.php') ?>">
                         <img class="profilePic" src="<?php if (isset($_SESSION['profilePic'])) {
                                                            echo images('usersMedia/profilePics/' . trim(($_SESSION['profilePic']['profPic'])));
                                                        } else {
                                                            echo images('usersMedia/defPP.png');
                                                        }  ?>" alt="profilePic">
                        </a>
                         </div>
                    </div>
                </div>
            </nav>

        </div>
    </header>
</body>

</html>