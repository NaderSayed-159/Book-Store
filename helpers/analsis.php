<?php


/************************************************************************************************* */

//number of users
$sqlusersNum = 'SELECT COUNT(id) AS usersCount FROM users';
$opusersNum =  mysqli_query($con, $sqlusersNum);
$datausersNum = mysqli_fetch_assoc($opusersNum);


//number of users cate
$sqluserscat = 'SELECT COUNT(users.id) AS userscate, users.user_type , userstypes.user_type as userType FROM users join userstypes on users.user_type = userstypes.id  group by user_type';
$opuserscat =  mysqli_query($con, $sqluserscat);


//number of users cate
$sqlusersgend = 'SELECT COUNT(id) AS usergender , gender FROM users GROUP BY gender';
$opusersgend =  mysqli_query($con, $sqlusersgend);
/*********************************************************************************************************************************************************** */

//number of books
$sqlbooksNum = 'SELECT COUNT(id) AS booksCount FROM books';
$opbooksNum =  mysqli_query($con, $sqlbooksNum);
$databooksNum = mysqli_fetch_assoc($opbooksNum);


//number of users cate
$sqlbookscat = 'SELECT COUNT(books.id) AS bookscate, books.book_category , bookscategory.book_category as bookcategory FROM books join bookscategory on books.book_category = bookscategory.id  group by book_category';
$opbookscat =  mysqli_query($con, $sqlbookscat);
/*********************************************************************************************************************************************************** */

//number of events
$sqleveNum = 'SELECT COUNT(id) AS eventsCount FROM events';
$opeveNum =  mysqli_query($con, $sqleveNum);
$dataeveNum = mysqli_fetch_assoc($opeveNum);


//function to define types of event 
$sqlevedate = 'SELECT eventDate FROM events';

function evnetType($sqlfun, $connection, $column = 'eventDate')
{
    $opevedate =  mysqli_query($connection, $sqlfun);
    $dateArray = [];
    $eventEnd = 0;
    $eventUpcomeing = 0;


    while ($dataevedate = mysqli_fetch_assoc($opevedate)) {
        if (strtotime($dataevedate[$column]) < time()) {

            $eventEnd = $eventEnd + 1;

            $dateArray['Ended'] = $eventEnd;
        } else {
            $eventUpcomeing = $eventUpcomeing + 1;
            $dateArray['Upcoming'] = $eventUpcomeing;
        }
    }


    return $dateArray;
}


$eventTypes = evnetType($sqlevedate, $con);

//events Check

$sqleveCheck = 'SELECT COUNT(id) AS eventChk FROM events_check';
$opeveCheck =  mysqli_query($con, $sqleveCheck);
$dataeveCheck = mysqli_fetch_assoc($opeveCheck);



//enrollers 

$sqlenroll = 'SELECT count(e_reservation.id)as reserve , events.event_name , events.eventDate FROM e_reservation join events on e_reservation.event_id = events.id GROUP by events.event_name ';

function enrollers($sqlroll, $connection, $eveDate = 'eventDate', $eveName = 'event_name', $counter = 'reserve')
{

    $oproll =  mysqli_query($connection, $sqlroll);

    $enrollsNum = [];
    // $counter = 1;
    while ($datarolls = mysqli_fetch_assoc($oproll)) {

        if (strtotime($datarolls[$eveDate]) > time()) {


            $enrollsNum[$datarolls[$eveName]]  = $datarolls[$counter];
        }
    }

    return  $enrollsNum;
}

$enrollDate = enrollers($sqlenroll, $con);

/*********************************************************************************************************************************************************** */



$sqlonCheck = 'SELECT events_check.* , users.name from events_check JOIN users on events_check.event_submiter = users.id  WHERE events_check.event_submiter = 67';
$oponCheck = mysqli_query($con, $sqlonCheck);
$dataonCheck = mysqli_fetch_assoc($oponCheck);
