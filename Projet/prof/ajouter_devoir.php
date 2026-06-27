<?php
session_start();
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id_prof = $_SESSION['id'];
$conn = connect_db();

$sql = $conn->prepare("SELECT id, nom_classe FROM classes WHERE id_prof = ?");
$sql->bind_param("i", $id_prof);
$sql->execute();
$classes = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Donner un Devoir</title>
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
        <li><a href="upload_cours.php">Ajouter un cours</a></li>
        <li><a href="ajouter_devoir.php" class="active">Donner Devoir</a></li>
        <li><a href="parametreP.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Nouveau Devoir</h1>
    </header>

    <section>
        <form class="form-class" action="../crud_secondaire/add_devoir.php" method="POST" enctype="multipart/form-data">

            <label>Choisir la classe :</label>
            <select name="id_classe" required>
                <option value="">-- Sélectionner --</option>
                <?php while($row = $classes->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nom_classe']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Titre du devoir :</label>
            <input type="text" name="titre" placeholder="Ex: TP1 - Prog web 2" required>

            <label>Date limite de rendu :</label>
            <input type="datetime-local" name="date_limite" required>

            <label>Description / Instructions :</label>
            <textarea name="description" rows="5" placeholder="Détails du travail à faire..." required></textarea>

            <label>Fichier joint (Sujet PDF, img...) - Optionnel :</label>
            <input type="file" name="fichier_sujet">

            <button type="submit" class="btn">Publier le devoir</button>
        </form>
    </section>
</div>

</body>
</html>