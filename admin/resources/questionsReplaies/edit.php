<?php
ob_start();
require '../../../dbConnection.php';
require "../headeradmin.php";



$id = $_GET['id'];
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$message = "";

if (!filter_var($id, FILTER_VALIDATE_INT)) {

    $_SESSION['message'] = "Invalid Id";

    header("Location: index.php");
}

//users
$sqlbook = "select * from books where id =$id";
$opbooks =  mysqli_query($con, $sqlbook);
$databook = mysqli_fetch_assoc($opbooks);


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

            $disFolder = './images/covers/';

            $disPath  = $disFolder . $CoverName;
            move_uploaded_file($tmp_path, $disPath);
        } else {
            $errorMessages['Cover'] = '* extension not allowed';
        }
    } else {
        $CoverName = $databook['coverPic'];
    }









    if (count($errorMessages) == 0) {


        $sql = "update books set book_name= ' $name', describtion = '$describtion' , book_category = $category , Download ='$download', coverPic = ' $CoverName', book_adder = $adder where id =$id";

        $op =  mysqli_query($con, $sql);



        if ($op) {
            $_SESSION['message'] = "Data Updated";
            header("Location: index.php");
        } else {
            echo "Error in Your Sql Try Again";
        }
    } else {

        foreach ($errorMessages as $key => $value) {

            echo '* ' . $key . ' : ' . $value . '<br>';
        }
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
    <link rel="stylesheet" href="../../../css/edit.css">

</head>

<body class="col-12">
    <h1 class="text-danger">Update Book data
        <small>Update Book by Admin! </small>
    </h1>
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
            <img src="<?php echo "./images/covers/" . trim($databook['coverPic']) ?>" class="card-img-top" alt="cover">
        </div>
    </div>
</body>


</html>