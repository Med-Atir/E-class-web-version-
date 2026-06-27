<?php
session_start();
require_once "../config/connect.php";

// Vérification Professeur
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id_prof = $_SESSION['id'];
$conn = connect_db();

// Récupérer les classes du professeur pour le menu déroulant
$sql = $conn->prepare("SELECT id, nom_classe FROM classes WHERE id_prof = ?");
$sql->bind_param("i", $id_prof);
$sql->execute();
$classes = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un document</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>

<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_prof.php">Dashboard</a></li>
        <li><a href="gerer_classe.php">Mes Classes</a></li>
        <li><a href="creer_classe.php">Ajouter Classes</a></li>
        <li><a href="questions_prof.php">Questions Reçues</a></li>
        <li><a href="poster_annonce.php" >Poster Annonce</a></li>
        <li><a href="upload_cours.php" class="active">Ajouter un cours</a></li>
        <li><a href="ajouter_devoir.php">Donner Devoir</a></li>
        <li><a href="parametreP.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Mettre un cours en ligne</h1>
    </header>

    <section>
        <form class="form-class" action="../crud_secondaire/add_document.php" method="POST" enctype="multipart/form-data">

            <label>Choisir la classe :</label>
            <select name="id_classe" required>
                <option value="">-- Sélectionner une classe --</option>
                <?php while($row = $classes->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nom_classe']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Titre du document (ex: Chapitre 1 - Algèbre) :</label>
            <input type="text" name="titre" placeholder="Titre du fichier..." required>

            <label>Sélectionner le fichier (PDF, Word, PPT...) :</label>
            <input type="file" name="fichier_cours" required>

            <button type="submit" class="btn">Uploader le fichier</button>
        </form>

        <?php
        if(isset($_GET['msg'])){
            if($_GET['msg'] == 'ok') echo "<p style='color:green'>Fichier ajouté avec succès !</p>";
            if($_GET['msg'] == 'error') echo "<p style='color:red'>Une erreur est survenue lors de l'upload.</p>";
            if($_GET['msg'] == 'type') echo "<p style='color:red'>Type de fichier non autorisé.</p>";
        }
        ?>
    </section>
</div>

</body>
</html>