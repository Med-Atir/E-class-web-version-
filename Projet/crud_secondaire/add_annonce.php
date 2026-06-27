<?php
require_once "../config/connect.php";
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['id_prof'], $_POST['id_classe'], $_POST['titre'], $_POST['contenu'])){

        $id_prof = (int) $_POST['id_prof'];
        $id_classe = (int) $_POST['id_classe'];
        $titre = trim($_POST['titre']);
        $contenu = trim($_POST['contenu']);//on utilise trim pour espace

        if(!empty($titre) && !empty($contenu) && $id_classe > 0){
            $conn = connect_db();

            $sql = $conn->prepare("INSERT INTO annonces (titre, contenu, id_prof, id_classe) VALUES (?, ?, ?, ?)");
            $sql->bind_param("ssii", $titre, $contenu, $id_prof, $id_classe);

            if($sql->execute()){
                header("Location: ../prof/dashboard_prof.php?msg=annonce_ok");
                exit();
            } else {
                die("Erreur SQL : " . $conn->error);
            }
        } else {
            die("Erreur : Tous les champs sont obligatoires.");
        }
    }
}
?>