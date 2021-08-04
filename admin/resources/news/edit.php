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

    $title  = cleanInputs(Sanitize($_POST['title'], 2));
    $content = cleanInputs($_POST['content']);
    $adder = Sanitize($_POST['adder'], 1);


    //Name Validation
    if (!Validator($title, 1)) {
        $errorMessages['Title'] = "Required";
    }

    if (!Validator($title, 2, 5)) {

        $errorMessages['Title'] = "title Length must be more than 5 ";
    }

    //describtion Validation


    if (!Validator($content, 1)) {
        $errorMessages['News Content'] = "Required";
    }

    if (!Validator($content, 2, 10)) {

        $errorMessages['News Content'] = " News Content Length must be more than 10 ";
    }



    $sqlimg = "select image from news where id = " . $id;
    $opimg  = mysqli_query($con, $sqlimg);
    $dataimg = mysqli_fetch_assoc($opimg);

    $newsMedia = $_FILES['media']['name'];

    if (!Validator($newsMedia, 1)) {
        $mediaName = $dataimg['image'];
    } else {
        $nameArray = explode('.', $newsMedia);

        $fileExtension = strtolower($nameArray[1]);

        if (!Validator($fileExtension, 5)) {
            $errorMessages['imageExtension'] = 'Invalid Image Extension';
        }
    }

    if (count($errorMessages) > 0) {
        $_SESSION['errmessages'] = $errorMessages;
    } else {

        if (Validator($newsMedia, 1)) {

            $tmp_path = $_FILES['media']['tmp_name'];
            $mediaName = rand() . time() . '.' . $fileExtension;
            $disFolder =  '../../../assests/images/newsPics/';

            $disPath  = $disFolder . $mediaName;


            if (move_uploaded_file($tmp_path, $disPath)) {

                if (!Validator('../../../assests/images/newsPics/' . trim($dataimg['image']), 7)) {

                    $errorMessages['imageChange'] = "image is not deleted";
                }
            }
        }







        if (count($errorMessages) == 0) {


            $sql  = "update news set title = '$title' , content = '$content' , image='$mediaName' where id =$id ";

            $op   =  mysqli_query($con, $sql);


            if ($op) {
                $_SESSION['message'] = "Data Updated";
                header("Location: " . resources('news/index.php'));
            } else {
                $errorMessages['sqlOperation'] = "Error in Your Sql Try Again";
                echo "Error in Your Sql Try Again";
            }
        }

        $_SESSION['errmessages'] = $errorMessages;
    }
}
//news

$sql = "select * from users where user_type = 1 ";
$opusers = mysqli_query($con, $sql);


//news
$sqlnews = "select * from news where id =$id";
$opnews =  mysqli_query($con, $sqlnews);
$datanews = mysqli_fetch_assoc($opnews);






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo css('edit.css') ?>">

</head>

<body class="col-12">
    <h1 class="text-danger">Edit News from Database
        <small>Edit News </small>
    </h1>
    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50 ">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo resources('news/index.php') ?>">News</a></li>
        <li class="breadcrumb-item active ">Edit News</li>
    </ol>

    <h4 class="bg-gradient bg-dark p-2 mx-auto mt-5 w-50 text-danger">
        <?php
        if (isset($_SESSION['errmessages'])) {

            foreach ($_SESSION['errmessages'] as $key =>  $data) {

                echo '* ' . $key . ' : ' . $data . '<br>';
            }

            unset($_SESSION['errmessages']);
        } else {
            echo "Change inputs !";
        }
        ?>
    </h4>
    <div class="d-flex flex-column flex-lg-row col-12 justify-content-evenly align-items-center">
        <form action="edit.php?id=<?php echo $datanews['id']; ?>" method="POST" class=" col-lg-7 col-10  d-flex flex-column  p-4 ps-0" enctype="multipart/form-data">
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input value=" <?php echo $datanews['title'] ?>" type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="title">
                    <label for="floatingInput">Title</label>
                </div>
            </div>
            <div class="col-sm-12 m-3 ">
                <div class=" form-floating">
                    <input value=" <?php echo $datanews['content'] ?>" type="text" class="form-control" id="floatingInput" placeholder="Describtion" name="content">
                    <label for="floatingInput">News Content</label>
                </div>
            </div>


            <div class="col-sm-12 m-3 form-control">
                <label for="floatingInput">uploade News Media</label>
                <input type="file" name="media" id="floatingInput" class="form-control">
            </div>





            <div class="d-flex flex-column flex-lg-row align-items-center justify-content-around">

                <div class="col-lg-5 col-10 mt-3 mb-3 ">
                    <div class=" form-control p-2">
                        <label for="category" class="p-2">News adder</label>
                        <select id="category" class="form-select" name="adder">
                            <?php while ($data = mysqli_fetch_assoc($opusers)) {
                            ?>
                                <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
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
            <img src="<?php echo images('newsPics/') . trim($datanews['image']) ?>" class="card-img-top" alt="cover">
        </div>
    </div>
</body>


</html>