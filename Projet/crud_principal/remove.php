<?php
session_start();
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete_account'){

    $id_user = $_SESSION['id'];
    $conn = connect_db();

    $req = $conn->prepare("DELETE FROM demandes WHERE id_etudiant = ?");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $req = $conn->prepare("DELETE FROM classe_etudiants WHERE etudiant_id = ?");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $req = $conn->prepare("DELETE FROM questions WHERE id_etudiant = ?");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    // Correction ici : supprimer aussi les questions reçues par le prof
    $req = $conn->prepare("DELETE FROM questions WHERE id_prof = ?");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $req = $conn->prepare("DELETE FROM annonces WHERE id_prof = ?");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $req = $conn->prepare("
        DELETE documents FROM documents 
        INNER JOIN classes ON documents.id_classe = classes.id 
        WHERE classes.id_prof = ?
    ");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $req = $conn->prepare("
        DELETE devoirs FROM devoirs 
        INNER JOIN classes ON devoirs.id_classe = classes.id 
        WHERE classes.id_prof = ?
    ");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $req = $conn->prepare("
        DELETE classe_etudiants FROM classe_etudiants 
        INNER JOIN classes ON classe_etudiants.classe_id = classes.id 
        WHERE classes.id_prof = ?
    ");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $req = $conn->prepare("
        DELETE demandes FROM demandes 
        INNER JOIN classes ON demandes.code_classe = classes.code_classe 
        WHERE classes.id_prof = ?
    ");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $req = $conn->prepare("DELETE FROM classes WHERE id_prof = ?");
    $req->bind_param("i", $id_user);
    $req->execute();
    $req->close();

    $user = $conn->prepare("DELETE FROM users WHERE id = ?");
    $user->bind_param("i", $id_user);

    if($user->execute()){
        session_unset();
        session_destroy();
        header("Location: ../login.php?msg=compte_supprime");
        exit();
    } else {
        echo "Erreur lors de la suppression du compte : " . $conn->error;
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>