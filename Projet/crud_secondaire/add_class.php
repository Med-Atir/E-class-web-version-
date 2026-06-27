<?php
session_start();
require_once "../config/connect.php";

function creer_class($id, $nom, $descr){
    $conn = connect_db();

    do {
        $code = substr(uniqid(), -10);
        $sql_verif = $conn->prepare("SELECT code_classe FROM classes WHERE code_classe = ?");
        $sql_verif->bind_param("s", $code);
        $sql_verif->execute();
        $resultat = $sql_verif->get_result();
    } while($resultat->num_rows > 0);

    $sql = $conn->prepare("INSERT INTO classes (id_prof, nom_classe, description, code_classe) VALUES (?, ?, ?, ?)");
    $sql->bind_param("isss", $id, $nom, $descr, $code);

    if($sql->execute()){
        return $code;
    } else {
        return NULL;
    }
}

function afficher_class($id){
    $conn = connect_db();
    $sql = $conn->prepare("SELECT * FROM classes WHERE id_prof = ?");
    $sql->bind_param("i", $id);

    if($sql->execute()){
        $resultat = $sql->get_result();
        $classes = [];

        while($row = $resultat->fetch_assoc()){
            $classes[] = $row;
        }
        if(count($classes) > 0){
            return $classes;
        }
        else{
            return NULL;
        }
    } else {
        return NULL;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_prof'];

    if (isset($_POST['action']) && $_POST['action'] == 'creer') {
        $nom = $_POST['nom_class'];
        $desc = $_POST['description'];

        $code = creer_class($id, $nom, $desc);

        if ($code != NULL) {
            $_SESSION['cod'] = $code;
            $_SESSION['creation_class'] = "Votre classe a ete creer avec succes!";
        } else {
            $_SESSION['creation_class'] = "Erreur lors de la creation de la classe!";
        }

        header("Location: ../prof/creer_classe.php");
        exit();
    }
    else if(isset($_POST['action']) && $_POST['action'] == 'afficher'){
        $classes = afficher_class($id);
        if($classes != NULL){
            $_SESSION['mesclass'] = $classes;
        } else {
            $_SESSION['noclass'] = "Vous n'avez pas de classes";
        }

        header("Location: ../prof/gerer_classe.php");
        exit();
    }
}
?>