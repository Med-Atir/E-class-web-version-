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
    SELECT d.*, c.nom_classe, u.username as nom_prof 
    FROM devoirs d
    INNER JOIN classes c ON d.id_classe = c.id
    INNER JOIN users u ON c.id_prof = u.id
    INNER JOIN classe_etudiants ce ON c.id = ce.classe_id
    WHERE ce.etudiant_id = ?
    ORDER BY d.date_limite ASC
");

$sql->bind_param("i", $id_etudiant);
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Devoirs</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>

<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_etudiant.php">Dashboard</a></li>
        <li><a href="annonces.php">Annonces</a></li>
        <li><a href="mes_classes.php">Mes classes</a></li>
        <li><a href="devoirs.php" class="active">Devoirs</a></li>
        <li><a href="poser_question.php">Poser une question</a></li>
        <li><a href="mes_questions.php">Mes questions</a></li>
        <li><a href="ParametreE.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Travail à faire</h1>
    </header>

    <section>
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()):
                $date_limite = new DateTime($row['date_limite']);
                $now = new DateTime();
                $is_late = ($now > $date_limite);
                ?>
                <div class="devoir-card" style="<?= $is_late ? 'opacity:0.6; border-left-color:grey;' : '' ?>">

                    <div class="header-devoir">
                        <div>
                            <h3 style="margin:0;"><?= htmlspecialchars($row['titre']) ?></h3>
                            <small style="color:#666;">
                                Cours : <strong><?= htmlspecialchars($row['nom_classe']) ?></strong>
                                (Prof. <?= htmlspecialchars($row['nom_prof']) ?>)
                            </small>
                        </div>
                        <div class="date-limite">
                            <?= $is_late ? "Terminé le" : "À rendre avant le" ?> :
                            <?= $date_limite->format('d/m/Y à H:i') ?>
                        </div>
                    </div>

                    <p><strong>Instructions :</strong><br> <?= nl2br(htmlspecialchars($row['description'])) ?></p>

                    <?php if(!empty($row['nom_fichier'])): ?>
                        <a href="../crud_secondaire/download.php?id=<?= $row['id'] ?>&context=devoir" class="btn-download">
                            Télécharger le sujet
                        </a>
                    <?php endif; ?>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align:center; padding: 40px; color:#777;">
                <h3>Aucun devoir à faire pour le moment.</h3>
            </div>
        <?php endif; ?>
    </section>
</div>

</body>
</html>