<?php
require_once "..\config\connect.php";
function signup($nom,$email,$password,$type)
{
    $conn = connect_db();
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO users (username,email,password,type) VALUES (?,?,?,?)");
    $sql -> bind_param("ssss",$nom,$email,$hash,$type);
    if($sql->execute()){
        return 1;
    }
    else{
        return 0;
    }
    mysqli_close($conn);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $ve = signup($nom,$email,$password,$type);
    if ($ve == 1) {
        Header("Location: ..\login.php");
    }
    else{
        echo"error"." veuillez reessayer plus tard";
        die();
    }
}
?>