<?php
require_once "..\config\connect.php";
function auth($conn,$email,$password){
    $test = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $test -> bind_param("s", $email);
    $test->execute();
    $result = $test->get_result();
    if($row = $result->fetch_assoc()){
        if(password_verify($password ,$row['password'])){
            return $row;
        }
        else{
            return 0;
        }
    }
    else {
        return 0;
    }
}
function login($email,$password){
    $conn = connect_db();
    $verifier = auth($conn,$email,$password);
    if($verifier != 0 ) {
        if ($verifier['type'] == 'professeur') {
            mysqli_close($conn);
            return 1;
        }
        else{
            mysqli_close($conn);
            return 2;
        }
    }
    else{
        mysqli_close($conn);
        return 0;
    }
}
function getnom($email){
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $resultat = $stmt->get_result();
    $nom = null;
    if($tab = $resultat->fetch_assoc()){
        $nom = $tab['username'];
    }
    $stmt->close();
    $conn->close();
    return $nom;
}
function getid($email){
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $resultat = $stmt->get_result();
    $id = null;
    if($tab = $resultat->fetch_assoc()){
        $id = $tab['id'];
    }
    $stmt->close();
    $conn->close();
    return $id;
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $vi = login($email,$password);
    $nom = getnom($email);
    $id = getid($email);
    if ($vi == 1) {
        session_start();
        $_SESSION['username'] = $nom;
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $id;
        Header("Location: ../prof/dashboard_prof.php");
    }
    else if($vi == 2){
        session_start();
        $_SESSION['username'] = $nom;
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $id;
        Header("Location: ../etudiant/dashboard_etudiant.php");
    }
    else{
        session_start();
        $_SESSION['error'] = 'Email ou mot de passe faut!!!';
        Header("Location: ../login.php");
        exit();
    }
}
?>