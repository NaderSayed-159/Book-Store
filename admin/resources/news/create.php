<?php
ob_start();
require "../../../helpers/paths.php";
require "../../../helpers/functions.php";
require '../../../helpers/dbConnection.php';
require '../../../checklogin/checkLoginadmin.php';
require '../../../layout/navAdmin.php';



//users
$sqlusers = "select * from users where user_type = 1";
$opusers =  mysqli_query($con, $sqlusers);


$errorMessages = [];




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



    // media Validation 

    $newsMedia = $_FILES['media']['name'];



    if (!Validator($newsMedia, 1)) {
        $errorMessages['News Media'] = 'pls upload News Media';
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
        //media Uploading
        $tmp_path = $_FILES['media']['tmp_name'];
        $mediaName = rand() . time() . '.' . $fileExtension;
        $disFolder =  '../../../assests/images/newsPics/';

        $disPath  = $disFolder . $mediaName;

        if (move_uploaded_file($tmp_path, $disPath)) {


            $content = str_replace("'", '_', $content);


            //database operation

            // $sqlnews = "insert into news (title, content, image, adder) values ('$title',$content,'$mediaName',$adder)";
            $sqlnews = "INSERT INTO `news`( `title`, `content`, `image`, `adder`) VALUES ('$title','$content','$mediaName','$adder')";
            $opnews =  mysqli_query($con, $sqlnews);

            if ($opnews) {

                $_SESSION['message'] = "Data Inserted";
                header("Location: " . resources('news/index.php'));
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
    <h1 class="text-danger">Add a News to Database
        <small>Add News </small>
    </h1>
    <ol class="breadcrumb bg-gradient bg-dark p-2 mx-auto mt-5 w-50 ">
        <li class="breadcrumb-item"><a class="text-decoration-none text-danger" href="<?php echo resources('news/index.php') ?>">News</a></li>
        <li class="breadcrumb-item active ">Add News</li>
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
                <input type="text" class="form-control" id="floatingInput" placeholder="Enter Name" name="title">
                <label for="floatingInput">Title</label>
            </div>
        </div>
        <div class="col-sm-12 m-3 ">
            <div class=" form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Describtion" name="content">
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


        <input type="submit" class="btn btn-warning col-sm-12 m-3" value="Add">

    </form>


</body>

</html>