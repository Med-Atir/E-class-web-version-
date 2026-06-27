<?php
require_once "../config/connect.php";

function afficher_demande($id_prof){
    $conn = connect_db();
    $sql = mysqli_query($conn, "
        SELECT 
            u.id AS id_etudiant,
            u.username AS nom_etudiant,
            c.nom_classe AS nom_module,
            c.code_classe AS code_module,
            d.statut
        FROM demandes d
        INNER JOIN users u ON d.id_etudiant = u.id
        INNER JOIN classes c ON d.code_classe = c.code_classe
        WHERE c.id_prof = '$id_prof' AND d.statut = 'en_attente'
    ");

    $demandes = [];
    if(mysqli_num_rows($sql) > 0){
        while($row = mysqli_fetch_assoc($sql)){
            $demandes[] = $row;
        }
        return $demandes;
    } else {
        return NULL;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_prof = $_POST['id_prof'];
    $demandes = afficher_demande($id_prof);
    session_start();
    if ($demandes) {
        $_SESSION['demandes'] = $demandes;
    } else {
        $_SESSION['nodemande'] = 'Vous n\'avez pas de demandes pour le moment';
    }
    header("Location: ../prof/gerer_classe.php");
    exit();
}
?>