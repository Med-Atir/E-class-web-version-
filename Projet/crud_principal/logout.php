<?php
function deconnect(){
    session_start();
    unset($_SESSION['username']);
    session_destroy();
    unset($_SESSION);
    header("Location: ../login.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['deconnection'])){
        deconnect();
    }
}
?>