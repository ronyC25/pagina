<?php

function connection(){
    $host = "localhost";
    $user = "root";
    $pass = "";

    $db = "basecrudpagina";

    $connect = mysqli_connect($host, $user, $pass);

    mysqli_select_db($connect, $db);

    return $connect;
};

?>