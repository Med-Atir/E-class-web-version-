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
    <title>Poster une annonce</title>
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
        <li><a href="poster_annonce.php" class="active">Poster Annonce</a></li>
        <li><a href="upload_cours.php">Ajouter un cours</a></li>
        <li><a href="ajouter_devoir.php">Donner Devoir</a></li>
        <li><a href="parametreP.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Nouvelle Annonce</h1>
    </header>

    <section>
        <form class="form-class" action="../crud_secondaire/add_annonce.php" method="POST">

            <label>Choisir la classe cible :</label>
            <select name="id_classe" required>
                <option value="">-- Sélectionner une classe --</option>
                <?php while($row = $classes->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nom_classe']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Titre de l'annonce :</label>
            <input type="text" name="titre" placeholder="Ex: Examen reporté..." required>

            <label>Contenu :</label>
            <textarea name="contenu" rows="6" placeholder="Votre message..." required></textarea>

            <input type="hidden" name="id_prof" value="<?= $id_prof ?>">

            <button type="submit" class="btn">Publier l'annonce</button>
        </form>
    </section>
</div>

</body>
</html>