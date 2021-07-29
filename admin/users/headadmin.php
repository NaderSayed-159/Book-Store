<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style>
        header {
            position: sticky;
            top: 0;
            width: 100%;
        }

        ul {
            z-index: 9999 !important;
        }
    </style>
</head>

<body>

    <header style="z-index: 9999;">
        <div class="logo">
            <nav class="navbar navbar-expand-lg navbar-light bg-dark bg-gradient ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#home">
                        <img src="images/sup_logo.PNG" alt="" width="70" height="50">
                    </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon text-danger"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-warning">
                            <li class="nav-item dropdown ">
                                <a class="nav-link dropdown-toggle text-warning fw-bold" href="#" id="navbarDropdown" data-bs-toggle="dropdown">Users</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="./index.php">Show Users </a></li>
                                    <li><a class="dropdown-item" href="./create.php">Appand New</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-warning fw-bold" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
                                    Resources
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="../resources/books/index.php">Books </a></li>
                                    <li><a class="dropdown-item" href="#">News</a></li>
                                    <li><a class="dropdown-item" href="#">Posts</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Question Hub</a>
                                        <ul class="list-unstyled ps-3">
                                            <li><a class="dropdown-item " href="#">Question Replays</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="../resources/events/index.php">Events</a>
                                        <ul class="list-unstyled ps-3">
                                            <li><a class="dropdown-item " href="../resources/eventsCheck/index.php">Events Check</a></li>
                                            <li><a class="dropdown-item " href="../resources/eventsReservations/index.php">Events Reservations</a></li>
                                        </ul>
                                    </li>
                            </li>

                        </ul>
                        </li>

                        </ul>
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-danger" type="submit">Search</button>
                            <a href="../../logout.php" class="btn btn-danger" type="submit">Log Out</a>

                        </form>
                    </div>
                </div>
            </nav>

        </div>
    </header>
</body>

</html>