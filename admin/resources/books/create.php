<?php
ob_start();
require "../../../helpers/paths.php";
require "../../../helpers/functions.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';




//category
$sqlcategory = "select * from bookscategory";
$op2 =  mysqli_query($con, $sqlcategory);

//users
$sqlusers = "select * from users";
$opusers =  mysqli_query($con, $sqlusers);


$errorMessages = [];




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

    $covername = $_FILES['cover']['name'];



    if (!Validator($covername, 1)) {
        $errorMessages['Cover'] = 'pls upload cover';
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
        //cover Uploading
        $tmp_path = $_FILES['cover']['tmp_name'];
        $CoverName = rand() . time() . '.' . $fileExtension;
        $disFolder =  '../../../assests/images/booksCovers/';

        $disPath  = $disFolder . $CoverName;
        if (move_uploaded_file($tmp_path, $disPath)) {

            $describtion = str_replace("'", '_', $describtion);


            //database operation

            $sql = "insert into books (book_name,book_category,describtion,download,coverPic,book_adder) values ('$name',$category,'$describtion','$download','$CoverName','$adder')";
            $op =  mysqli_query($con, $sql);

            if ($op) {
                $_SESSION['message'] = "Data Inserted";
                header("Location: " . resources('books/index.php'));
            } else {
                $_SESSION['errmessages'] = "Error in Your Sql Try Again";
            }
        }

        $_SESSION['errmessages'] = $errorMessages;
    }
}









?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding Data to database</title>
    <link rel="stylesheet" href="<?php echo css('create.css') ?>">

</head>

<body class="col-12">
    <h1 class="text-danger">Add a new Book to Database
        <small>Create a new book </small>
    </h1>
    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50 ">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo users('index.php') ?>">Books</a></li>
        <li class="breadcrumb-item active ">Add Book</li>
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
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="container col-8 mx-auto mt-5 d-flex flex-column  p-4 ps-0 " enctype="multipart/form-data">
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="name">
                <label for="floatingInput">Book Name</label>
            </div>
        </div>
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Describtion" name="describtion">
                <label for="floatingInput">Describtion</label>
            </div>
        </div>
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Download" name="download">
                <label for="floatingInput">Download Link</label>
            </div>
        </div>





        <div class="col-sm-12 m-3 form-control">
            <label for="floatingInput">uploade Book cover</label>
            <input type="file" name="cover" id="floatingInput" class="form-control">
        </div>





        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-around">

            <div class="col-lg-5 col-10 mt-3 mb-3 ">
                <div class=" form-control p-2">
                    <label for="category" class="p-2">Book Category</label>
                    <select id="category" class="form-select" name="category">
                        <?php while ($data = mysqli_fetch_assoc($op2)) {
                        ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['book_category']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-5 col-10 mt-3 mb-3 ">
                <div class=" form-control p-2">
                    <label for="adder" class="p-2">Book Adder</label>
                    <select id="adder" class="form-select" name="adder">
                        <?php while ($datauser = mysqli_fetch_assoc($opusers)) {
                        ?>
                            <option value="<?php echo $datauser['id']; ?>"><?php echo $datauser['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

        </div>


        <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Create">

    </form>


</body>

</html>