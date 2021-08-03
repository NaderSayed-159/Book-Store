<?php
require "../helpers/paths.php";
require "../helpers/functions.php";
require '../helpers/dbConnection.php';
require '../checklogin/checkLoginadmin.php';
require '../layout/navAdmin.php';
require "../helpers/analsis.php";





?>


<title>Dashboard</title>
<link rel="stylesheet" href="<?php echo css('adminHome.css') ?>">


</head>

<body>


    <h1 class="m-5"> <span class="yellow">Welcome</span><span class="blue">&lt;</span><?php echo $_SESSION['users']['name']; ?><span class="blue">&gt;</span>
    </h1>



    <div class="m-3 d-flex flex-column flex-lg-row align-items-center justify-content-evenly ">

        <div class="col-lg-3 col-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Users Details</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <table class="table">
                        <tr>
                            <td class="text-dark">Num# of Users:</td>
                            <td class="text-white text-end"><?php echo $datausersNum['usersCount'] ?></td>
                        <tr>
                        <tr>
                            <td class="text-dark">Num# of Users Categories:</td>
                            <td class="text-white">
                                <ul class="list-unstyled">
                                    <?php while ($datauserscat = mysqli_fetch_assoc($opuserscat)) { ?>
                                        <li class="text-end"><span class="text-danger"><?php echo $datauserscat['userType'] ?></span> : <?php echo $datauserscat['userscate'] ?></li>
                                    <?php } ?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark">Count Of Users Genders:</td>
                            <td class="text-white">
                                <ul class="list-unstyled">
                                    <?php while ($datausersgend = mysqli_fetch_assoc($opusersgend)) { ?>
                                        <li class="text-end"><span class="text-danger"><?php echo strtoupper($datausersgend['gender']); ?></span> : <?php echo $datausersgend['usergender'] ?></li>
                                    <?php } ?>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-6">
            <div class="card text-white bg-danger mb-4">
                <div class="card-body">Books Details</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <table class="table">
                        <tr>
                            <td class="text-white">Num# of books:</td>
                            <td class="text-white text-end"><?php echo $databooksNum['booksCount'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-white">Num# of Books Categories:</td>
                            <td class="text-white">
                                <ul class="list-unstyled">
                                    <?php while ($databookscat = mysqli_fetch_assoc($opbookscat)) { ?>
                                        <li class="text-end"><span class="text-dark fw-bold"><?php echo $databookscat['bookcategory'] ?></span> : <?php echo $databookscat['bookscate'] ?></li>
                                    <?php } ?>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card text-white bg-success mb-4">
                <div class="card-body">Events Deatalis</div>
                <div class="card-footer">
                    <table class="table">
                        <tr>
                            <td class="text-white">Total Num# of Events (in DB):</td>
                            <td class="text-white text-end"><?php echo $dataeveNum['eventsCount'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-white">Events Date Types</td>
                            <td class="text-white text-end">
                                <ul class="list-unstyled">

                                    <?php foreach ($eventTypes as $key => $data) { ?>

                                        <li class="text-end"><span class="text-dark fw-bold"><?php echo $key ?></span> : <?php echo $data ?></li>

                                    <?php  } ?>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-white">Num# Events to Check</td>
                            <td class="text-white text-end"><?php echo $dataeveCheck['eventChk'] ?></td>
                        </tr>


                        <tr>
                            <td class="text-white">Events Enrollers</td>
                            <td class="text-white text-end" style="width :55%">
                                <ul class="list-unstyled">

                                    <?php foreach ($enrollDate as $key => $data) { ?>

                                        <li class="text-end"><span class="text-dark fw-bold "><?php echo strtoupper($key) ?></span> : <?php echo $data ?></li>

                                    <?php  } ?>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


    </div>









</body>

</html>