<?php
require "../helpers/paths.php";
require "../helpers/functions.php";
require '../helpers/dbConnection.php';
require '../checklogin/checkLoginadmin.php';
require '../layout/navAdmin.php';

?>


<title>Dashboard</title>
<link rel="stylesheet" href="<?php echo css('adminHome.css') ?>">
</head>

<body>


    <h1 class="m-5"> <span class="yellow">Welcome</span><span class="blue">&lt;</span><?php echo $_SESSION['users']['name']; ?><span class="blue">&gt;</span>
    </h1>


    <div id="users">
        <div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Warning Card</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="#">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>