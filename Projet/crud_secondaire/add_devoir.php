<?php
session_start();
require_once "../config/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['id_classe'], $_POST['titre'], $_POST['date_limite'])) {
        $conn = connect_db();
        $id_classe = (int) $_POST['id_classe'];
        $titre = trim($_POST['titre']);
        $description = trim($_POST['description']);
        $date_limite = $_POST['date_limite'];
        // make variables fichier NULL si le prof noo files
        $nom_fichier = NULL;
        $type_mime = NULL;
        $contenu_fichier = NULL;
        if (isset($_FILES['fichier_sujet']) && $_FILES['fichier_sujet']['error'] == 0) {
            $nom_fichier = $_FILES['fichier_sujet']['name'];
            $type_mime = $_FILES['fichier_sujet']['type'];
            $tmp_name = $_FILES['fichier_sujet']['tmp_name'];
            $contenu_fichier = file_get_contents($tmp_name);
        }
        $sql = $conn->prepare("
            INSERT INTO devoirs (titre, description, date_limite, id_classe, nom_fichier, type_mime, contenu_fichier) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $sql->bind_param("sssisss", $titre, $description, $date_limite, $id_classe, $nom_fichier, $type_mime, $contenu_fichier);
        if ($sql->execute()) {
            header("Location: ../prof/dashboard_prof.php?msg=devoir_ok");
        } else {
            echo "Erreur SQL : " . $conn->error;
        }

    } else {
        die("Champs manquants.");
    }
}
?>