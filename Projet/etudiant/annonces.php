<?php
session_start();
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id_etudiant = $_SESSION['id'];
$conn = connect_db();
$sql = $conn->prepare("
    SELECT a.titre, a.contenu, a.date_creation, u.username as nom_prof, c.nom_classe as nom_classe
    FROM annonces a
    INNER JOIN classes c ON a.id_classe = c.id
    INNER JOIN users u ON a.id_prof = u.id
    INNER JOIN classe_etudiants ce ON c.id = ce.classe_id
    WHERE ce.etudiant_id = ?
    ORDER BY a.date_creation DESC
");

$sql->bind_param("i", $id_etudiant);
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annonces</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>

<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_etudiant.php">Dashboard</a></li>
        <li><a href="annonces.php" class="active">Annonces</a></li>
        <li><a href="mes_classes.php">Mes classes</a></li>
        <li><a href="devoirs.php">Devoirs</a></li>
        <li><a href="poser_question.php">Poser une question</a></li>
        <li><a href="mes_questions.php">Mes questions</a></li>
        <li><a href="ParametreE.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Annonces de vos classes</h1>
    </header>

    <section>
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="annonce-card">
                    <h3 class="annonce-titre"><?= htmlspecialchars($row['titre']) ?></h3>
                    <div class="annonce-meta">
                        <strong>Classe :</strong> <?= htmlspecialchars($row['nom_classe']) ?> |
                        <strong>Prof :</strong> <?= htmlspecialchars($row['nom_prof']) ?> |
                        <em>Le <?= date("d/m/Y à H:i", strtotime($row['date_creation'])) ?></em>
                    </div>

                    <p><?= nl2br(htmlspecialchars($row['contenu'])) ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucune annonce pour le moment.</p>
        <?php endif; ?>
    </section>
</div>

</body>
</html>