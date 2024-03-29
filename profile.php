<?php
require 'helpers/dbConnection.php';
require "helpers/paths.php";
require "helpers/functions.php";
require "./checklogin/checkloginnormal.php";
require "layout/header.php";

$id = $_SESSION['users']['id'];
//users image


$errorMessages = [];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sqlprofp = "select profile_pic from users_media where user_id = $id";
    $opprofp =  mysqli_query($con, $sqlprofp);
    $dataprofp = mysqli_fetch_assoc($opprofp);

    $profilePic = $_FILES['profilepic']['name'];

    if (Validator($profilePic, 1)) {

        $nameArray = explode('.', $profilePic);
        $fileExtension = strtolower($nameArray[1]);

        if (!Validator($fileExtension, 5)) {
            $errorMessages['imageExtension'] = 'Invalid Image Extension';
        }
    }

    if (count($errorMessages) > 0) {
        $_SESSION['errmessages'] = $errorMessages;
    } else {

        //profile pic edit
        if (Validator($profilePic, 1)) {


            $tmp_path = $_FILES['profilepic']['tmp_name'];
            $newProfPic = rand() . time() . '.' . $fileExtension;


            $disFolder = 'assests/images/usersMedia/profilePics/';
            $disPath  = $disFolder . $newProfPic;

            if (move_uploaded_file($tmp_path, $disPath)) {

                if (!Validator('assests/images/usersMedia/profilePics/' . trim($dataprofp['profile_pic']), 7)) {

                    $errorMessages['imageChange'] = "image is not deleted";
                }
            }
        }
        $_SESSION['errmessages'] = $errorMessages;


        if (count($errorMessages) == 0) {

            $sqlup = "update users_media set profile_pic= ' $newProfPic' where user_id =$id";

            $opup =  mysqli_query($con, $sqlup);


            if ($opup) {
                $_SESSION['errmessages'] = "Picture Updated";
                header("Location: " . project('profile.php'));
            } else {
                $_SESSION['errmessages'] = "Error in Your Sql Try Again";
            }
        }
        $_SESSION['errmessages'] = $errorMessages;
    }
}

if (isset($_SESSION['users'])) {

    $usertype = $_SESSION['users']['user_type'];

    if ($usertype == 2) {
        $_SESSION['usertype'] = 'Company';
    } else {
        $_SESSION['usertype'] = 'standard';
    }
}





?>

<head>
    <title>Knight's Profiles</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo css('profile.css'); ?>">
</head>

<body class="profile-page">

    <div class="page-header header-filter" data-parallax="true" style="background-image:url('http://wallpapere.org/wp-content/uploads/2012/02/black-and-white-city-night.png');"></div>
    <div class="main main-raised">
        <div class="profile-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 ml-auto mr-auto">

                        <div class="profile">

                            <div class="avatar">
                                <img src="<?php if (isset($_SESSION['profilePic']['profPic'])) {

                                                echo images('usersMedia/profilePics/' . trim($_SESSION['profilePic']['profPic']));
                                            } else {

                                                echo images('usersMedia/defPP.png');
                                            } ?>" alt="Circle Image" class="img-raised rounded-circle img-fluid">
                            </div>
                            <div class='change'>
                                <button data-bs-toggle="collapse" data-bs-target="#collapseOne" class=" btn btn-warning fs-5 p-2 px-3 bg-dark">Change profile pic</button>
                                <div id="collapseOne" class="collapse">
                                    <form class="form col-12 m-3 mx-auto" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                                        <input name="profilepic" type="file" class="form-control m-2">
                                        <input type="submit" class="btn btn-danger">
                                    </form>
                                </div>
                                <h3 class="p-2 mx-auto m-2 w-50 text-danger">
                                    <?php
                                    if (isset($_SESSION['errmessages'])) {

                                        foreach ($_SESSION['errmessages'] as $key =>  $data) {

                                            echo '* ' . $key . ' : ' . $data . '<br>';
                                        }

                                        unset($_SESSION['errmessages']);
                                    }
                                    ?>
                                </h3>
                            </div>

                            <div class="name">
                                <h3 class="title"><?php echo $_SESSION['users']['name'] ?></h3>
                                <h6><?php echo $_SESSION['usertype']; ?></h6>
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-dribbble"><i class="fa fa-dribbble"></i></a>
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-twitter"><i class="fa fa-twitter"></i></a>
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-pinterest"><i class="fa fa-pinterest"></i></a>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="description text-center">
                    <p>An artist of considerable range, Chet Faker — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music, giving it a warm, intimate feel with a solid groove structure. </p>
                </div>
                <div class="row">
                    <div class="col-md-6 ml-auto mr-auto">
                        <div class="profile-tabs">
                            <ul class="nav nav-pills nav-pills-icons justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#studio" role="tab" data-toggle="tab">
                                        <i class="material-icons">camera</i>
                                        Studio
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#works" role="tab" data-toggle="tab">
                                        <i class="material-icons">palette</i>
                                        Work
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#favorite" role="tab" data-toggle="tab">
                                        <i class="material-icons">favorite</i>
                                        Favorite
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-content tab-space">
                    <div class="tab-pane active text-center gallery" id="studio">
                        <div class="row">
                            <div class="col-md-3 ml-auto">
                                <img src="https://images.unsplash.com/photo-1524498250077-390f9e378fc0?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=83079913579babb9d2c94a5941b2e69d&auto=format&fit=crop&w=751&q=80" class="rounded">
                                <img src="https://images.unsplash.com/photo-1528249227670-9ba48616014f?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=66b8e7db17b83084f16fdeadfc93b95b&auto=format&fit=crop&w=357&q=80" class="rounded">
                            </div>
                            <div class="col-md-3 mr-auto">
                                <img src="https://images.unsplash.com/photo-1521341057461-6eb5f40b07ab?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=72da2f550f8cbd0ec252ad6fb89c96b2&auto=format&fit=crop&w=334&q=80" class="rounded">
                                <img src="https://images.unsplash.com/photo-1506667527953-22eca67dd919?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=6326214b7ce18d74dde5e88db4a12dd5&auto=format&fit=crop&w=750&q=80" class="rounded">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane text-center gallery" id="works">
                        <div class="row">
                            <div class="col-md-3 ml-auto">
                                <img src="https://images.unsplash.com/photo-1524498250077-390f9e378fc0?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=83079913579babb9d2c94a5941b2e69d&auto=format&fit=crop&w=751&q=80" class="rounded">
                                <img src="https://images.unsplash.com/photo-1506667527953-22eca67dd919?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=6326214b7ce18d74dde5e88db4a12dd5&auto=format&fit=crop&w=750&q=80" class="rounded">
                                <img src="https://images.unsplash.com/photo-1505784045224-1247b2b29cf3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=ec2bdc92a9687b6af5089b335691830e&auto=format&fit=crop&w=750&q=80" class="rounded">
                            </div>
                            <div class="col-md-3 mr-auto">
                                <img src="https://images.unsplash.com/photo-1504346466600-714572c4b726?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=6754ded479383b7e3144de310fa88277&auto=format&fit=crop&w=750&q=80" class="rounded">
                                <img src="https://images.unsplash.com/photo-1494028698538-2cd52a400b17?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=83bf0e71786922a80c420c17b664a1f5&auto=format&fit=crop&w=334&q=80" class="rounded">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane text-center gallery" id="favorite">
                        <div class="row">
                            <div class="col-md-3 ml-auto">
                                <img src="https://images.unsplash.com/photo-1504346466600-714572c4b726?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=6754ded479383b7e3144de310fa88277&auto=format&fit=crop&w=750&q=80" class="rounded">
                                <img src="https://images.unsplash.com/photo-1494028698538-2cd52a400b17?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=83bf0e71786922a80c420c17b664a1f5&auto=format&fit=crop&w=334&q=80" class="rounded">
                            </div>
                            <div class="col-md-3 mr-auto">
                                <img src="https://images.unsplash.com/photo-1505784045224-1247b2b29cf3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=ec2bdc92a9687b6af5089b335691830e&auto=format&fit=crop&w=750&q=80" class="rounded">
                                <img src="https://images.unsplash.com/photo-1524498250077-390f9e378fc0?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=83079913579babb9d2c94a5941b2e69d&auto=format&fit=crop&w=751&q=80" class="rounded">
                                <img src="https://images.unsplash.com/photo-1506667527953-22eca67dd919?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=6326214b7ce18d74dde5e88db4a12dd5&auto=format&fit=crop&w=750&q=80" class="rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo js('profile.js') ?>"></script>

    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>

</body>

</html>