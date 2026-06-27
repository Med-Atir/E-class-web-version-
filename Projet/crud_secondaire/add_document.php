<?php
session_start();
require_once "../config/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES['fichier_cours']) && $_FILES['fichier_cours']['error'] == 0) {

        $id_classe = (int) $_POST['id_classe'];
        $titre = trim($_POST['titre']);

        $nom_fichier = $_FILES['fichier_cours']['name'];
        $type_mime = $_FILES['fichier_cours']['type'];//c'est pour indiquer au serveur qu'il va revoie un fichier d'un type specifique
        $tmp_name = $_FILES['fichier_cours']['tmp_name'];

        $ext = pathinfo($nom_fichier, PATHINFO_EXTENSION);
        $autorise = array("pdf", "doc", "docx", "ppt", "pptx", "zip", "rar", "txt", "jpg", "png");

        if (!in_array(strtolower($ext), $autorise)) {
            header("Location: ../prof/upload_cours.php?msg=type");
            exit();
        }

        $contenu_binaire = file_get_contents($tmp_name);

        $conn = connect_db();
        $sql = $conn->prepare("INSERT INTO documents (titre, nom_fichier, type_mime, contenu_fichier, id_classe) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("ssssi", $titre, $nom_fichier, $type_mime, $contenu_binaire, $id_classe);

        if ($sql->execute()) {
            header("Location: ../prof/upload_cours.php?msg=ok");
        } else {
            header("Location: ../prof/upload_cours.php?msg=error");
        }

    } else {
        header("Location: ../prof/upload_cours.php?msg=error");
    }
}
?>