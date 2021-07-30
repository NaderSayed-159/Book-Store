<?php 
function project($dis){
    return "http://" . $_SERVER['SERVER_NAME'] . "/g2p/" . $dis;
}

function users($dis){
    return "http://" . $_SERVER['SERVER_NAME'] . "/g2p/admin/users/" . $dis;
}


function resources($dis){
    return "http://" . $_SERVER['SERVER_NAME'] . "/g2p/admin/resources/" . $dis;
}

function login($dis){
    return "http://" . $_SERVER['SERVER_NAME'] . "/g2p/login/" . $dis;
}


function layouts($dis){

    return "http://" . $_SERVER['SERVER_NAME'] . "/g2p/layout/" . $dis;
}

function css($dis){

    return "http://" . $_SERVER['SERVER_NAME'] . "/g2p/assests/css/" . $dis;
}

function js($dis){

    return "http://" . $_SERVER['SERVER_NAME'] . "/g2p/assests/js/" . $dis;
}

function images($dis){

    return "http://" . $_SERVER['SERVER_NAME'] . "/g2p/assests/images/" . $dis;
}

?>