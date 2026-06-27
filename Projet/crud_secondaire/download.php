<?php
require_once "../config/connect.php";

if (isset($_GET['id']) && isset($_GET['context'])) {

    $conn = connect_db();
    $id = (int) $_GET['id'];
    $context = $_GET['context'];
    if ($context == "cours") {
        $sql = $conn->prepare("SELECT nom_fichier, type_mime, contenu_fichier FROM documents WHERE id = ?");
    } elseif ($context == "devoir") {
        $sql = $conn->prepare("SELECT nom_fichier, type_mime, contenu_fichier FROM devoirs WHERE id = ?");
    } else {
        die("Contexte invalide.");
    }
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    if ($row = $result->fetch_assoc()) {
        if($row['contenu_fichier'] != NULL) {
            header("Content-Type: " . $row['type_mime']);/* le mime type est pour
  indiquer au server comment interprer les donnes envoyer avant d'envoyer au client alors
  si les mime type n'existe pas le serveur le peut savoir pas si cette fichier est une image
  ou text ou pdf , meme si par exemple il sait qui est une image il ne sait pas si elle est jpg
  ou png etc... car dans la base des donnes on ne stock que le contenue binaire pas de quoi il s'agit */
            header("Content-Disposition: inline; filename=\"" . $row['nom_fichier'] . "\"");
            echo $row['contenu_fichier'];
            exit;
        } else {
            echo "Fichier vide ou un error lors du telechargement.";
        }
    } else {
        echo "Fichier introuvable.";
    }
} else {
    echo "ID manquant.";
}
?>