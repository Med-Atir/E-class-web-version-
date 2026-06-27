<?php
session_start();
require_once "../config/connect.php";

function accepte_demande($id_etudiant, $code_classe){
    $conn = connect_db();
    $sql_get_id = $conn->prepare("SELECT id FROM classes WHERE code_classe = ?");
    $sql_get_id->bind_param("s", $code_classe);
    $sql_get_id->execute();
    $result = $sql_get_id->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $real_class_id = $row['id'];

        $sql_existe = $conn->prepare("SELECT * FROM classe_etudiants WHERE etudiant_id = ? AND classe_id = ?");
        $sql_existe->bind_param("ii", $id_etudiant, $real_class_id);
        $sql_existe->execute();
        $existe = $sql_existe->get_result();

        if($existe->num_rows > 0){
            return false;
        }
        else{
            $sql_insert = $conn->prepare("INSERT INTO classe_etudiants (etudiant_id, classe_id) VALUES (?, ?)");
            $sql_insert->bind_param("ii", $id_etudiant, $real_class_id);

            if($sql_insert->execute()){
                $del = $conn->prepare("DELETE FROM demandes WHERE id_etudiant = ? AND code_classe = ?");
                $del->bind_param("is", $id_etudiant, $code_classe);
                $del->execute();

                $up = $conn->prepare("UPDATE classes SET nbr_etudiant = nbr_etudiant + 1 WHERE code_classe = ?");
                $up->bind_param("s", $code_classe);
                $up->execute();
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $code = $_POST['code'];
    $add = accepte_demande($id, $code);
    if($add){
        $_SESSION['message_action'] = "L'etudiant a été accepté avec succes.";
        $_SESSION['type_message'] = "green";
    } else {
        $_SESSION['message_action'] = "Erreur : Impossible d'ajouter l'étudiant.";
        $_SESSION['type_message'] = "red";
    }

    header("Location: ../prof/gerer_classe.php");
    exit();
}
?>