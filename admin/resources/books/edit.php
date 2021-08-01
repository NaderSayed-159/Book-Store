<?php
ob_start();
require "../../../helpers/paths.php";
require "../../../helpers/functions.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';




$errorMessages = [];

$id = $_GET['id'];
$id  = Sanitize($_GET['id'], 1);


if (!Validator($id, 3)) {
    $errorMessages['id'] = "Invalid ID";

    $_SESSION['message'] = $errorMessages;

    header("Location: " . resources('books/index.php'));
}




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name  = cleanInputs(Sanitize($_POST['name'], 2));
    $describtion = cleanInputs($_POST['describtion']);
    $download = cleanInputs($_POST['download']);
    $category = Sanitize($_POST['category'], 1);
    $adder = Sanitize($_POST['adder'], 1);




    //Name Validation
    if (!Validator($name, 1)) {
        $errorMessages['name'] = "Required";
    }

    if (!Validator($name, 2, 5)) {

        $errorMessages['name'] = "Book name Length must be more than 5 ";
    }

    //describtion Validation


    if (!Validator($describtion, 1)) {
        $errorMessages['Book describtion'] = "Required";
    }

    if (!Validator($describtion, 2, 10)) {

        $errorMessages['name'] = "Book name Length must be more than 10 ";
    }



    // download Validation  
    if (!Validator($download, 1)) {

        $errorMessages[' Download URL'] = "Required";
    }


    if (!Validator($download, 6)) {

        $errorMessages['URL'] = "Invalid URL ";
    }


    // cover Validation 

    $sqlimg = "select coverPic from books where id = " . $id;
    $opimg  = mysqli_query($con, $sqlimg);
    $dataimg = mysqli_fetch_assoc($opimg);



    $covername  = $_FILES['cover']['name'];

    if (!Validator($covername, 1)) {
        $CoverName = $dataimg['coverPic'];
    } else {
        $nameArray = explode('.', $covername);
        $fileExtension = strtolower($nameArray[1]);
        if (!Validator($fileExtension, 5)) {
            $errorMessages['imageExtension'] = 'Invalid Image Extension';
        }
    }





    if (count($errorMessages) > 0) {
        $_SESSION['errmessages'] = $errorMessages;
    } else {
        //cover edit
        if (Validator($covername, 1)) {


            $tmp_path = $_FILES['cover']['tmp_name'];
            $CoverName = rand() . time() . '.' . $fileExtension;

            $disFolder =  '../../../assests/images/booksCovers/';
            $disPath  = $disFolder . $CoverName;

            if (move_uploaded_file($tmp_path, $disPath)) {

                if (!Validator('../../../assests/images/booksCovers/' . trim($dataimg['coverPic']), 7)) {

                    $errorMessages['imageChange'] = "image is not deleted";
                }
            }
        }


        if (count($errorMessages) == 0) {

            $sql = "update books set book_name= ' $name', describtion = '$describtion' , book_category = $category , Download ='$download', coverPic = ' $CoverName', book_adder = $adder where id =$id";

            $op =  mysqli_query($con, $sql);



            if ($op) {
                $_SESSION['message'] = "Data Updated";
                header("Location: " . resources('books/index.php'));
            } else {
                $errorMessages['SQL Errror'] = "Error in Your Sql Try Again";
            }
        }

        $_SESSION['errmessages'] = $errorMessages;
    }
}



//category
$sqlcategory = "select * from bookscategory";
$op2 =  mysqli_query($con, $sqlcategory);


//users
$sqlusers = "select * from users";
$opusers =  mysqli_query($con, $sqlusers);

//users
$sqlbook = "select * from books where id =$id";
$opbooks =  mysqli_query($con, $sqlbook);
$databook = mysqli_fetch_assoc($opbooks);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book data</title>
    <link rel="stylesheet" href="<?php echo css('edit.css') ?>">

</head>

<body class="col-12">
    <h1 class="text-danger">Update Book data
        <small>Update Book by Admin! </small>
    </h1>
    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50 ">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo resources('books/index.php') ?>">Books</a></li>
        <li class="breadcrumb-item active ">Edit Book Data</li>
    </ol>

    <h4 class="bg-gradient bg-dark p-2 mx-auto mt-5 w-50 text-danger">
        <?php
        if (isset($_SESSION['errmessages'])) {

            foreach ($_SESSION['errmessages'] as $key =>  $data) {

                echo '* ' . $key . ' : ' . $data . '<br>';
            }

            unset($_SESSION['errmessages']);
        } else {
            echo "Fill the inputs Please!";
        }
        ?>
    </h4>
    <div class="d-flex flex-column flex-lg-row col-12 justify-content-evenly align-items-center">
        <form action="edit.php?id=<?php echo $databook['id']; ?>" method="POST" class=" col-lg-7 col-10  d-flex flex-column  p-4 ps-0 " enctype="multipart/form-data">
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input value="<?php echo $databook['book_name'] ?>" type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="name">
                    <label for="floatingInput">Book Name</label>
                </div>
            </div>
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input value="<?php echo $databook['describtion'] ?>" type="text" class="form-control" id="floatingInput" placeholder="Describtion" name="describtion">
                    <label for="floatingInput">Describtion</label>
                </div>
            </div>
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input value="<?php echo $databook['Download'] ?>" type="text" class="form-control" id="floatingInput" placeholder="Download" name="download">
                    <label for="floatingInput">Download Link</label>
                </div>
            </div>
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input disabled value="<?php echo $databook['coverPic'] ?>" type="text" class="form-control" id="floatingInput" placeholder="Download" name="currentcover">
                    <label for="floatingInput">Current Book cover</label>
                </div>
            </div>

            <div class="col-sm-12 m-3 form-control">
                <label for="floatingInput">uploade new Book cover</label>
                <input type="file" name="cover" class="form-control">
            </div>


            <div class="d-flex align-items-center justify-content-around ">

                <div class="col-sm-5 mt-3 mb-3 rounded ">
                    <div class=" form-control p-2">
                        <label for="category" class="p-2">Book Category</label>
                        <select id="category" class="form-select" name="category">
                            <?php while ($datacats = mysqli_fetch_assoc($op2)) {
                            ?>
                                <option value="<?php echo $datacats['id']; ?>" <?php if ($datacats['id'] == $databook['book_category']) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo $datacats['book_category']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>

                <div class="col-sm-5 mt-3 mb-3 ">
                    <div class=" form-control p-2">
                        <label for="adder" class="p-2">Book Adder</label>
                        <select id="adder" class="form-select" name="adder">
                            <?php while ($datauser = mysqli_fetch_assoc($opusers)) {
                            ?>
                                <option value="<?php echo $datauser['id']; ?>" <?php if ($datauser['id'] == $databook['book_adder']) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo $datauser['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

            </div>


            <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Update">

        </form>

        <div class="coverpic col-lg-2 align-self-center col-4">
            <div class="card-body bg-warning">
                <p class="card-text text-danger text-center fw-bold fs-4">Cover</p>
            </div>
            <img src="<?php echo images('booksCovers/') . trim($databook['coverPic']) ?>" class="card-img-top" alt="cover">
        </div>
    </div>
</body>


</html>