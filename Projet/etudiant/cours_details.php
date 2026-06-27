<?php
session_start();
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: mes_classes.php");
    exit();
}

$id_etudiant = $_SESSION['id'];
$id_classe = (int) $_GET['id'];
$conn = connect_db();
$check_sql = $conn->prepare("
    SELECT * FROM classe_etudiants 
    WHERE etudiant_id = ? AND classe_id = ?
");
$check_sql->bind_param("ii", $id_etudiant, $id_classe);
$check_sql->execute();
if ($check_sql->get_result()->num_rows === 0) {
    die("Acces refuse : Vous n'etes pas inscrit a ce cours.");
}
$sql_class = $conn->prepare("
    SELECT c.nom_classe, c.description, u.username as nom_prof 
    FROM classes c
    INNER JOIN users u ON c.id_prof = u.id
    WHERE c.id = ?
");
$sql_class->bind_param("i", $id_classe);
$sql_class->execute();
$info_classe = $sql_class->get_result()->fetch_assoc();
$sql_docs = $conn->prepare("SELECT id, titre, nom_fichier, date_upload FROM documents WHERE id_classe = ? ORDER BY date_upload DESC");
$sql_docs->bind_param("i", $id_classe);
$sql_docs->execute();
$documents = $sql_docs->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cours : <?= htmlspecialchars($info_classe['nom_classe']) ?></title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>

<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_etudiant.php">Dashboard</a></li>
        <li><a href="annonces.php">Annonces</a></li>
        <li><a href="mes_classes.php" class="active">Mes classes</a></li>
        <li><a href="devoirs.php">Devoirs</a></li>
        <li><a href="poser_question.php">Poser une question</a></li>
        <li><a href="mes_questions.php">Mes questions</a></li>
        <li><a href="ParametreE.php">Parametres</a></li>
    </ul>
</div>

<div class="main">

    <div class="course-header">
        <h1><?= htmlspecialchars($info_classe['nom_classe']) ?></h1>
        <div class="prof-name">Professeur : <?= htmlspecialchars($info_classe['nom_prof']) ?></div>
        <?php if(!empty($info_classe['description'])): ?>
            <p style="margin-top: 15px; color: #555;">
                <?= nl2br(htmlspecialchars($info_classe['description'])) ?>
            </p>
        <?php endif; ?>
        <br>
        <a href="mes_classes.php" style="color: #007bff; text-decoration: none;">&larr; Retour à mes classes</a>
    </div>

    <h2>Documents et Ressources</h2>

    <?php if($documents->num_rows > 0): ?>
        <div class="doc-list">
            <?php while($doc = $documents->fetch_assoc()): ?>
                <div class="doc-card">
                    <div class="doc-title" style="font-weight: bold; font-size: 1.1em;">
                        <?= htmlspecialchars($doc['titre']) ?>
                    </div>

                    <div style="font-size: 0.8em; color: #999; margin-bottom: 10px;">
                        Fichier : <?= htmlspecialchars($doc['nom_fichier']) ?> <br>
                        Ajouté le <?= isset($doc['date_upload']) ? date("d/m/Y", strtotime($doc['date_upload'])) : '-' ?>
                    </div>

                    <a href="../crud_secondaire/download.php?id=<?= $doc['id'] ?>&context=cours"
                       class="btn-download"
                       target="_blank">
                        Télécharger
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="notification notif-green">
            <p>Le professeur n'a pas encore ajouté de documents pour ce cours.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>