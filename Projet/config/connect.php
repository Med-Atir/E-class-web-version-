<?php
function connect_db($dbname='pfm',$host='localhost',$password="",$user="root"){
    $conn = mysqli_connect($host,$user,$password,$dbname);
    if(!$conn){
        die("error!!" . mysqli_connect_error());
    }
    return $conn;
}
?>