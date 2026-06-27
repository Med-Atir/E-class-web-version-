<?php
session_start();
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_classe'])) {

    $id_classe = $_POST['id_classe'];
    $id_prof_session = $_SESSION['id'];

    $conn = connect_db();
    $veri = $conn->prepare("SELECT id, code_classe FROM classes WHERE id = ? AND id_prof = ?");
    $veri->bind_param("ii", $id_classe, $id_prof_session);
    $veri->execute();
    $result = $veri->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $code_classe = $row['code_classe'];
        $del_annonces = $conn->prepare("DELETE FROM annonces WHERE id_classe = ?");
        $del_annonces->bind_param("i", $id_classe);
        $del_annonces->execute();
        $del_devoirs = $conn->prepare("DELETE FROM devoirs WHERE id_classe = ?");
        $del_devoirs->bind_param("i", $id_classe);
        $del_devoirs->execute();
        $del_docs = $conn->prepare("DELETE FROM documents WHERE id_classe = ?");
        $del_docs->bind_param("i", $id_classe);
        $del_docs->execute();
        $del_eleves = $conn->prepare("DELETE FROM classe_etudiants WHERE classe_id = ?");
        $del_eleves->bind_param("i", $id_classe);
        $del_eleves->execute();
        $del_demandes = $conn->prepare("DELETE FROM demandes WHERE code_classe = ?");
        $del_demandes->bind_param("s", $code_classe);
        $del_demandes->execute();
        $del_class = $conn->prepare("DELETE FROM classes WHERE id = ?");
        $del_class->bind_param("i", $id_classe);

        if ($del_class->execute()) {
            $_SESSION['message_action'] = "La classe et tout son contenu ont ete supprimés avec succes.";
            $_SESSION['type_message'] = "green";
        } else {
            $_SESSION['message_action'] = "Erreur lors de la suppression de la classe.";
            $_SESSION['type_message'] = "red";
        }
    } else {
        $_SESSION['message_action'] = "Erreur : Cette classe ne vous appartient pas ou n'existe pas.";
        $_SESSION['type_message'] = "red";
    }
} else {
    $_SESSION['message_action'] = "Requete invalide.";
    $_SESSION['type_message'] = "red";
}
header("Location: ../prof/gerer_classe.php");
exit();
?>