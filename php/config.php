<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "e_commerec_mobiles";

$conn = mysqli_connect($hostname, $username, $password, $database);

if(!$conn){
    die(mysqli_connect_error());
}
else{
    // Connection successfully!
    echo "";
}

?>