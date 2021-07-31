<?php
ob_start();
require "../../../helpers/paths.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';




//category
$sqlcategory = "select * from bookscategory";
$op2 =  mysqli_query($con, $sqlcategory);

//users
$sqlusers = "select * from users";
$opusers =  mysqli_query($con, $sqlusers);



function cleanInputs($input)
{

    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}
$errorMessages = [];




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name  = cleanInputs($_POST['name']);
    $describtion = cleanInputs($_POST['describtion']);
    $download = cleanInputs($_POST['download']);
    $category = $_POST['category'];
    $adder = $_POST['adder'];



    //Name Validation
    if (!empty($name)) {

        if (strlen($name) < 5) {
            $errorMessages['Book name'] = "Name Length must be > 5 ";
        }
    } else {
        $errorMessages['Book name'] = "Required";
    }


    //describtion Validation

    if (!empty($describtion)) {

        if (strlen($describtion) < 10) {
            $errorMessages['Book describtion'] = "Name Length must be > 10 ";
        }
    } else {
        $errorMessages['Book describtion'] = "Required";
    }


    // download Validation  
    if (!empty($download)) {

        if (!filter_var($download, FILTER_VALIDATE_URL)) {

            $errorMessages['URL'] = "Invalid URL ";
        }
    } else {

        $errorMessages[' Download URL'] = "Required";
    }






    // cover Validation 
    if (!empty($_FILES['cover']['name']) && isset($_FILES['cover']['name'])) {


        $tmp_path = $_FILES['cover']['tmp_name'];
        $covername = $_FILES['cover']['name'];


        $nameArray = explode('.', $covername);
        $fileExtension = strtolower($nameArray[1]);

        $CoverName = rand() . time() . '.' . $fileExtension;

        $allowedExtensions = ['png', 'jpg'];

        if (in_array($fileExtension, $allowedExtensions)) {

            $disFolder =  '../../../assests/images/booksCovers/';

            $disPath  = $disFolder . $CoverName;
            move_uploaded_file($tmp_path, $disPath);
        } else {
            $errorMessages['Cover'] = '* extension not allowed';
        }
    } else {
        $errorMessages['Cover'] = 'pls upload cover';
    }







    if (count($errorMessages) == 0) {



        $sql = "insert into books (book_name,book_category,describtion,download,coverPic,book_adder) values ('$name',$category,'$describtion','$download','$CoverName','$adder')";
        $op =  mysqli_query($con, $sql);



        if ($op) {
            $_SESSION['message'] = "Data Inserted";
            header("Location: " . resources('books/index.php'));
        } else {
            echo "Error in Your Sql Try Again";
        }
    } else {

        foreach ($errorMessages as $key => $value) {

            echo '* ' . $key . ' : ' . $value . '<br>';
        }
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
    <style>
        .shows {
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%) translateY(-125%);
        }
    </style>
</head>

<body class="col-12">
    <h1 class="text-danger">Add a new Book to Database
        <small>Create a new book </small>
    </h1>
    <a href="<?php echo resources('books/index.php') ?>" class="btn btn-success shows">Show Books</a>
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