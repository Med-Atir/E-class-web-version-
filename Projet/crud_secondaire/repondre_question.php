<?php
require_once "../config/connect.php";
session_start();
if (!isset($_SESSION['id'])) {
    die("Acces refuse.");
}

if(isset($_POST['id_question'], $_POST['reponse'])){
    $id_question = (int) $_POST['id_question'];
    $reponse = trim($_POST['reponse']);
    if(!empty($reponse)){
        $conn = connect_db();
        $sql = $conn->prepare("UPDATE questions SET reponse = ? WHERE id = ?");
        $sql->bind_param("si", $reponse, $id_question);

        if($sql->execute()){
            header("Location: ../prof/questions_prof.php?success=1");
        } else {
            echo "Erreur SQL : " . $conn->error;
        }
    } else {
        echo "La reponse ne peut pas etre vide.";
    }
} else {
    header("Location: ../prof/questions_prof.php");
}
?>