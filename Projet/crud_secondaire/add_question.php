<?php
require_once "../config/connect.php";
function add_q($id_etudiant, $question, $id_prof){
    $conn = connect_db();
    $sql = $conn->prepare("
        INSERT INTO questions (id_etudiant, question, id_prof)
        VALUES (?, ?, ?)
    ");

    if(!$sql) {
        die("Erreur: " . $conn->error);
    }

    $sql->bind_param("isi", $id_etudiant, $question, $id_prof);

    if($sql->execute()){
        return true;
    } else {
        return false;
    }
}
if(!isset($_POST['id_etudiant'], $_POST['id_prof'], $_POST['question'])){
    die("Erreur : Données manquantes !");
}
$id_etudiant = (int) $_POST['id_etudiant'];
$id_prof = (int) $_POST['id_prof'];
$question = trim($_POST['question']);

if(empty($question)){
    die("Erreur : La question ne peut pas etre vide.");
}

if($id_etudiant <= 0 || $id_prof <= 0){
    die("Erreur : Identifiant etudiant ou professeur invalide.");
}
if(add_q($id_etudiant, $question, $id_prof)){
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Succès</title>
        <link rel="stylesheet" href="../assets/global.css">
    </head>
    <body class="centered-body">

    <div class="container-card">
        <div class="success-box">
            <h2>Question envoyee avec succes !</h2>
            <p>Le professeur recevra votre question.</p>
        </div>

        <a href="../etudiant/dashboard_etudiant.php" class="btn">Retour au Dashboard</a>
    </div>

    </body>
    </html>
    <?php
} else {
    echo "<div class='container-card'><h2 class='error-text'>Erreur lors de l'enregistrement de la question.</h2></div>";
}
?>