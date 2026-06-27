<?php
session_start();
require_once "../config/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $code = $_POST['code'];

    $conn = connect_db();

    $sql = $conn->prepare("DELETE FROM demandes WHERE id_etudiant = ? AND code_classe = ?");
    $sql->bind_param("is", $id, $code);

    if ($sql->execute()) {
        $_SESSION['message_action'] = "La demande a ete refusee avec succes.";
        $_SESSION['type_message'] = "red";
    } else {
        $_SESSION['message_action'] = "Erreur lors du refus de la demande.";
        $_SESSION['type_message'] = "red";
    }

    header("Location: ../prof/gerer_classe.php");
    exit();
}
?>